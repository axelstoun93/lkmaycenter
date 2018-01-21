<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Validator;
use Config;
class ClientsController extends ManagerController
{
    public function __construct()
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->template = config('settings.theme').'.admin.manager.clients';
    }
    public function index(Request $request)
    {
        $this->title = 'Клиенты';
        $this->page = 'Клиенты';
        $clientsArray = $this->getAllClient();
        if($request->get('search'))
        {
            $clientsArray = $this->searchClient($request->get('search'));
        }
        else
        {
            $clientsArray = $this->getAllClient();
        }
        $clients= $this->paginate($clientsArray);
        $content = view(config('settings.theme').'.admin.manager.tableClients')->with('clients',$clients)->render();
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
        $content = view(config('settings.theme').'.admin.manager.addEditClients')->render();
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
                return redirect(route('clients.create'))->withErrors($validate);
            }

            $result = $this->addClient($request);
            if(is_array($result) && !empty($result['error'])) {
                return back(route('clients.create'))->with($result);
            }
            return redirect()->route('clients')->with($result);
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
        $user = $this->u_rep->getOneClient($id,true);
        $this->title = 'Информация о клиенте';
        $this->page = 'Клиенты / Вся информация о клиенте - '. $user->name;
        $content = view(config('settings.theme').'.admin.manager.showClients')->with(['user'=>$user,'count' => ''])->render();
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
        $user = $this->u_rep->getOneClient($id);
        $this->title = 'Клиенты';
        $this->page = 'Клиенты / Редактирование Клиента - '. $user->name;
        $content = view(config('settings.theme').'.admin.manager.addEditClients')->with('user',$user)->render();
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

           $user = $this->u_rep->getOneClient($id);
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
                return redirect(route('clients.edit',['id'=> $id]))->withErrors($validate);
            }
            $result = $this->updateClient($request,$user);

            if(is_array($result) && !empty($result['error'])) {
                return back(route('clients.update',['id'=> $id ]))->with($result);
            }
            return redirect()->route('clients')->with($result);
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
        $result = $this->u_rep->deleteClient($id);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('clients')->with($result);

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
        $res =  $this->u_rep->deleteClient($id);
        return $res;
    }
    public function getAllClient()
    {
        $res =  $this->u_rep->getAllClient();
        return $res;
    }
    public function searchClient($search)
    {
        $res =  $this->u_rep->searchClient($search);
        return $res;
    }
    public function addClient(Request $request)
    {
        return $this->u_rep->addClient($request);
    }
    public function updateClient($request,$id)
    {
        $res = $this->u_rep->updateClient($request,$id);
        
        return $res;
    }


}
