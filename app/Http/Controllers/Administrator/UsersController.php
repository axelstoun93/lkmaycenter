<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Assistants\MailAssistants;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Validator;
use Config;
class UsersController extends AdministratorController
{
    public function __construct()
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->template = config('settings.theme').'.admin.administrator.users';
    }
    public function index(Request $request)
    {
        $this->title = 'Пользователи';
        $this->page = 'Пользователи';
        if($request->get('search'))
        {
            $usersArray = $this->u_rep->searchUsers($request->get('search'));
        }
        else
        {
            $usersArray = $this->u_rep->getAllUsers();
        }
        $users = $this->paginate($usersArray);
        $content = view(config('settings.theme').'.admin.administrator.tableUsers')->with('users', $users)->render();
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
        $this->title = 'Добавить пользователя';
        $this->page = 'Пользователи / Добавить пользователя';
        $content = view(config('settings.theme').'.admin.administrator.addEditUsers')->render();
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
                    'fio' => 'required|min:6',
                    'roles' => 'required|integer'
                ],$message);
            if($validate->fails())
            {
                $request->flash();
                return redirect(route('users.create'))->withErrors($validate);
            }

            $result = $this->u_rep->addUser($request);
            if(is_array($result) && !empty($result['error'])) {
                return back(route('users.create'))->with($result);
            }
            
            $mail = $this->mailNotification($request);
            return redirect()->route('users')->with($result);
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
        $user = $this->u_rep->getOneUser($id,true);
        $this->title = 'Информация о пользователе';
        $this->page = 'Клиенты / Вся информация о пользователе - '. $user->name;
        $content = view(config('settings.theme').'.admin.administrator.showUsers')->with(['user'=>$user,'count' => ''])->render();
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
        $user = $this->u_rep->getOneUser($id);
        $this->title = 'Клиенты';
        $this->page = 'Клиенты / Редактирование Клиента - '. $user->name;
        $content = view(config('settings.theme').'.admin.administrator.addEditUsers')->with('user',$user)->render();
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


            $user = $this->u_rep->getOneUser($id);
            $validatorArray =
                [
                    'name' => ($user->name == $request->name) ? 'required' : 'required|unique:users' ,
                    'email' => ($user->email == $request->email) ? 'required' : 'required|unique:users',
                    'fio' => 'required|min:6',
                    'roles' => 'required|integer'
                ];
            $message =
                [
                    'name.unique' => 'Логин с таким именем уже существует в базе данных.',
                    'email.unique' => 'Такой Email уже существует в базе данных.',
                    'password.min' => 'Слишком короткий пароль минимум 4 символа.'
                ];
            $validate = Validator::make($request->all(),$validatorArray,$message);
            if($validate->fails())
            {
                $request->flash();
                return redirect(route('users.edit',['id'=> $id]))->withErrors($validate);
            }

            $result = $this->u_rep->updateUser($request,$user);

            if(is_array($result) && !empty($result['error'])) {
                return back(route('users.update',['id'=> $id ]))->with($result);
            }
            return redirect()->route('users')->with($result);

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
        $result = $this->u_rep->deleteUsers($id);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('users')->with($result);

    }

    public function paginate($items)
    {
        if(!empty($items) && is_array($items))
        {
            $pageStart = \Request::get('page', 1);
            $perPage = config::get('settings.paginate-users');
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
