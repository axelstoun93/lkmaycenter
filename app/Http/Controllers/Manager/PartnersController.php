<?php

namespace App\Http\Controllers\Manager;

use App\Repositories\Assistants\MailAssistants;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Validator;
use Config;
class PartnersController extends ManagerController
{
    public function __construct()
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->template = config('settings.theme').'.admin.manager.partners';
    }
    public function index(Request $request)
    {
        $this->title = 'Партнеры';
        $this->page = 'Партнеры';
        $clientsArray = $this->getAllPartner();
        if($request->get('search'))
        {
            $clientsArray = $this->searchPartner($request->get('search'));
        }
        else
        {
            $clientsArray = $this->getAllPartner();
        }
        $clients= $this->paginate($clientsArray);
        $content = view(config('settings.theme').'.admin.manager.tablePartners')->with('clients',$clients)->render();
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
        $this->title = 'Добавить клиента';
        $this->page = 'Клиенты / Добавить клиента';
        $content = view(config('settings.theme').'.admin.manager.addEditPartners')->render();
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
            $message =
                [
                    'name.unique' => 'Логин с таким именем уже существует в базе данных.',
                    'email.unique' => 'Такой Email уже существует в базе данных.',
                    'password.min' => 'Слишком короткий пароль минимум 4 символа.',
                    'fio.min' => 'Слишком короткая строка для Фио.'
                ];
            $validate = Validator::make($request->all(),
                [
                    'name' => 'required|unique:users',
                    'email' => 'required|unique:users',
                    'password' => 'required|min:4',
                    'fio' => 'required|min:6'
                ],$message);
            if($validate->fails())
            {
                $request->flash();
                return redirect(route('partners.create'))->withErrors($validate);
            }

            $result = $this->addPartner($request);
            if(is_array($result) && !empty($result['error'])) {
                return back(route('partners.create'))->with($result);
            }
            
            $mail = $this->mailNotification($request);
            return redirect()->route('partners')->with($result);
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
        $user = $this->u_rep->getOnePartner($id,true);
        $this->title = 'Информация о клиенте';
        $this->page = 'Клиенты / Вся информация о клиенте - '. $user->name;
        $content = view(config('settings.theme').'.admin.manager.showPartners')->with(['user'=>$user,'count' => ''])->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->u_rep->getOnePartner($id);
        $this->title = 'Клиенты';
        $this->page = 'Клиенты / Редактирование Клиента - '. $user->name;
        $content = view(config('settings.theme').'.admin.manager.addEditPartners')->with('user',$user)->render();
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

        $validatorArray =
            [
                'name' => 'required|unique:users',
                'email' => 'required|unique:users',
                'fio' => 'required|min:6',
                'status' => 'required'
            ];
        if($request->isMethod('put')) {

            $user = $this->u_rep->getOnePartner($id);
            $validatorArray =
                [
                    'name' => ($user->name == $request->name) ? 'required' : 'required|unique:users' ,
                    'email' => ($user->email == $request->email) ? 'required' : 'required|unique:users',
                    'fio' => 'required|min:6',
                    'status' => 'required'
                ];
            $message =
                [
                    'name.unique' => 'Логин с таким именем уже существует в базе данных.',
                    'email.unique' => 'Такой Email уже существует в базе данных.',
                    'password.min' => 'Слишком короткий пароль минимум 4 символа.',
                ];
            $validate = Validator::make($request->all(),$validatorArray,$message);
            if($validate->fails())
            {
                $request->flash();
                return redirect(route('partners.edit',['id'=> $id]))->withErrors($validate);
            }
            $result = $this->updatePartner($request,$user);

            if(is_array($result) && !empty($result['error'])) {
                return back(route('partners.update',['id'=> $id ]))->with($result);
            }
            return redirect()->route('partners')->with($result);
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
        $result = $this->u_rep->deletePartner($id);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('partners')->with($result);

    }

    public function paginate($items)
    {
        if(!empty($items) && is_array($items))
        {
            $pageStart = \Request::get('page', 1);
            $perPage = config::get('settings.paginate-clients');
            // Start displaying items from this number;
            $offSet = ($pageStart * $perPage) - $perPage;

            // Get only the items you need using array_slice
            $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);
            return new LengthAwarePaginator($itemsForCurrentPage, count($items), $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
        }
        return false;
    }
    public function deleteClient($id)
    {
        $res =  $this->u_rep->deletePartner($id);
        return $res;
    }
    public function getAllPartner()
    {
        $res =  $this->u_rep->getAllPartner();
        return $res;
    }
    public function searchPartner($search)
    {
        $res =  $this->u_rep->searchPartner($search);
        return $res;
    }
    public function addPartner(Request $request)
    {
        return $this->u_rep->addPartner($request);
    }
    public function updatePartner($request,$id)
    {
        $res = $this->u_rep->updatePartner($request,$id);
        
        return $res;
    }
    public function mailNotification($request)
    {
        $array  = 
            [
                'login' => $request->name,
                'password' => $request->password,
                'links' =>  url('/')
            ];
        $client = new MailAssistants('mail.access',$array,'Академия "МАЙ"','Доступ');
        $client->send($request->email);
    }

}
