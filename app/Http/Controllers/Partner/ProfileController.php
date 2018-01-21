<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
class ProfileController extends PartnersController
{

    public function __construct()
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->template = config('settings.theme').'.admin.partner.profile';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Панель партнера';
        $this->page = 'Профиль';
        $user = $this->u_rep->getOnePartner(Auth::id(),true);
        $content = view(config('settings.theme').'.admin.partner.addEditProfile')->with('user',$user)->render();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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

            $user = $this->u_rep->getOnePartner($id);
            $validatorArray =
                [
                    'fio' => 'required|min:6',
                    'email' => ($user->email == $request->email) ? 'required' : 'required|unique:users',
                    'company_name' => 'required',
                    'address' => 'required',
                    'phone' => ($user->getPartnerInfo->phone == $user->getPartnerInfo->phone) ? 'required' : 'required|unique:clients_info',
                ];
            $message =
                [
                    'email.unique' => 'Такой Email уже существует в базе данных.',
                    'phone.unique' => 'Такой номер телефона уже используется'
                ];
            $validate = Validator::make($request->all(),$validatorArray,$message);
            if($validate->fails())
            {
                $request->flash();
                return redirect(route('profile'))->withErrors($validate);
            }
            $result = $this->u_rep->updatePartners($request,$user);

            if(is_array($result) && !empty($result['error'])) {
                return back(route('profile'))->with($result);
            }
            return redirect()->route('profile')->with($result);
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
        //
    }

}
