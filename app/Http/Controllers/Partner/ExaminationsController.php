<?php

namespace App\Http\Controllers\Partner;

use App\Partner;
use App\Repositories\Assistants\MailAssistants;
use Illuminate\Http\Request;
use App\Repositories\CourseRepository;
use Illuminate\Support\Facades\Auth;

class ExaminationsController extends PartnersController
{
    public function __construct(CourseRepository $course)
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->c_rep = $course;
        $this->template = config('settings.theme').'.admin.partner.examinations';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $this->title = 'Зачеты и экзамены';
        $this->page = 'Зачеты и экзамены';
        $month = $this->c_rep->renderingCalendar();
        $navigate = $this->c_rep->getNavigate();
        $category = $this->c_rep->getCategory();
        $content = view(config('settings.theme').'.admin.partner.tableExaminations')->with(['month'=>$month,'navigate'=> $navigate,'category' => $category])->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }
    public function getMonthYears(Request $request)
    {
        if(!empty($request->years) && !empty($request->month))
        {

            $this->title = 'Зачеты и экзамены';
            $this->page = 'Зачеты и экзамены';
            $month = $this->c_rep->renderingCalendar($request->month,$request->years);
            $navigate = $this->c_rep->getNavigate($request->month,$request->years);
            $category = $this->c_rep->getCategory();
            $content = view(config('settings.theme').'.admin.partner.tableExaminations')->with(['month'=>$month,'navigate'=> $navigate,'category' => $category])->render();
            $this->vars = array_add($this->vars,'content',$content);
            return $this->renderOutput();
        }
        else
        {
            return back();
        }
    }
    public  function show($id)
    {
        $res = $this->c_rep->getEvent($id);
        echo $res;
    }
    public function store(Request $request)
    {

        $user = $this->u_rep->one(Auth::id());
        $user->load('getPartnerInfo');
        $manager = $this->u_rep->getAllManager();
        $res = false;

        $array =
            [
                'name' =>  (!empty($request->title)) ? $request->title : '',
                'date' =>  (!empty($request->date)) ? $request->date : '',
                'time' =>  (!empty($request->start_time) and !empty($request->end_time) ) ? 'c '.$request->start_time.' до '. $request->end_time : '',
                'login' => (!empty($user->name)) ? $user->name : '',
                'email' => (!empty($user->email)) ? $user->email : '',
                'phone' => (!empty($user->getPartnerInfo->phone)) ? $user->getPartnerInfo->phone : ''
            ];

        $mail = new MailAssistants('mail.examination',$array,'Академия "Май"','Зачеты и экзамены');
        foreach ($manager->users as $value)
        {

            $res =  $mail->send($value->email);
        }
        echo  json_encode($res);

    }
}
