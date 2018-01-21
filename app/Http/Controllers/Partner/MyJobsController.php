<?php

namespace App\Http\Controllers\Partner;

use App\Repositories\Api\Vkontakte;
use App\Repositories\Assistants\MailAssistants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\JobRepository;
use Illuminate\Support\Facades\Auth;
use Validator;
class MyJobsController extends PartnersController
{
    protected $vk_api;
    public function __construct(JobRepository $job,Vkontakte $vk)
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->j_rep = $job;
        $this->vk_api = $vk;
        $this->template = config('settings.theme').'.admin.partner.jobs';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Панель партнера';
        $this->page = 'Мой вакансии';
        $jobs = $this->j_rep->getMyJobs();
        $count = 0;
        $content = view(config('settings.theme').'.admin.partner.tableJobs')->with(['jobs'=>$jobs,'count' => $count])->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->title = 'Панель партнера';
        $this->page = 'Мой вакансии / Добавить вакансию';
        $content = view(config('settings.theme').'.admin.partner.addEditJobs')->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')) {
            $validate = Validator::make($request->all(),
                [
                    'title' => 'required',
                    'experience' => 'required',
                    'category' => 'required',
                    'salary' => 'required',
                    'schedule' => 'required',
                    'duties' => 'required',
                    'demand' => 'required',
                    'condition' => 'required',
                ]);
            if($validate->fails())
            {
                $request->flash();
                return back()->withErrors($validate);
            }
            $id = $this->j_rep->getEndJobs() + 1;
            (!empty($id)) ? $link = route('jobs.readmore',$id) : $link = route('jobs');
            $request = $this->sendVkontakte($request,'Вакансия',$link);
            $result = $this->j_rep->addJob($request);
            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
                return redirect()->route('jobs')->with($result);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = $this->j_rep->getOneMyJobs($id);
        $this->title = 'Панель партнера';
        $this->page = 'Мой вакансии / Редактирование вакансии';
        $content = view(config('settings.theme').'.admin.partner.addEditJobs')->with('job',$job)->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->isMethod('put')) {
            $validate = Validator::make($request->all(),
                [
                    'title' => 'required',
                    'experience' => 'required',
                    'category' => 'required',
                    'salary' => 'required',
                    'schedule' => 'required',
                    'duties' => 'required',
                    'demand' => 'required',
                    'condition' => 'required',
                ]);
            if($validate->fails())
            {
                $request->flash();
                return back()->withErrors($validate);
            }
            (!empty($id)) ? $link = route('jobs.readmore',$id) : $link = route('jobs');
            $request = $this->sendVkontakte($request,'Вакансия обновлена',$link);
            $result = $this->j_rep->updateJob($request,$id);
            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }

            return redirect()->route('jobs')->with($result);


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($res = $this->j_rep->postIdJob($id)) {$this->vk_api->postToDelete($res);}
        $result = $this->j_rep->deleteJob($id);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return back()->with($result);
    }

    public function sendVkontakte(Request $request,$text,$link)
    {
        $userInfo = $this->u_rep->one(Auth::id());
        $userInfo->load('getPartnerInfo');
        $infoArray =
            [
                'title' =>  $request->title,
                'company' => $userInfo->getPartnerInfo->company_name,
                'experience' => $request->experience,
                'phone' => $userInfo->getPartnerInfo->phone,
                'email' => $userInfo->email,
                'salary' => $request->salary,
                'site' => $request->site,
                'working_schedule' => $request->schedule,
                'address' => $request->address,
                'duties' => $this->replaceHtml($request->duties),
                'demand' => $this->replaceHtml($request->demand),
                'condition' => $this->replaceHtml($request->condition)
            ];
        $views = view('vk.job')->with($infoArray)->render();
        if($res = $this->vk_api->postToPublic($views,(!empty($request->post_id) ? $request->post_id : false),$link))
        {
            if($res){
                $request->merge(['post_id' => $this->vk_api->post_id]);
            }
            return $request;
        }
        else
        {
            $this->sendMail($request,$text);
            return $request;
        }
    }
    public  function sendMail($request,$text)
    {
        $userInfo = $this->u_rep->one(Auth::id());
        $userInfo->load('getPartnerInfo');
        $mailArray =
            [
                'title' =>  $request->title,
                'company' => $userInfo->getPartnerInfo->company_name,
                'experience' => $request->experience,
                'phone' => $userInfo->getPartnerInfo->phone,
                'email' => $userInfo->email,
                'salary' => $request->salary,
                'site' => $request->site,
                'working_schedule' => $request->schedule,
                'address' => $request->address,
                'duties' => $request->duties,
                'demand' => $request->demand,
                'condition' => $request->condition
            ];
        $mail = new MailAssistants('mail.job',$mailArray,'Академия "Май"',$text);
        $mail->sendAllManager();
        return $request;
    }
    function replaceHtml($string)
    {
     $res = str_replace(['<br>','<p>','<ul>','<li>'],"\r\n",$string);
     return $res;
    }
}
