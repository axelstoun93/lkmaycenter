<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Menu;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    protected $template;
    protected $keywords;
    protected $meta_desc;
    protected $title;
    protected $vars;
    protected $page;
    protected $u_rep;
    protected $c_rep;

    public function __construct(UserRepository $userRepository)
    {
            $this->u_rep = $userRepository;
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars,'title',$this->title);
        $this->vars = array_add($this->vars,'page',$this->page);
        $menu = $this->getMenu();
        $userInfo = $this->userInfo(Auth::user()->id);
        $userNavigate = view(config('settings.theme').'.admin.manager.userNavigation')->with('userInfo' , $userInfo)->render();
        $this->vars = array_add($this->vars,'userNavigation',$userNavigate );
        $navigation = view(config('settings.theme').'.admin.indexBar')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars,'navigation',$navigation);
        return view($this->template)->with($this->vars);

    }
    public function getMenu()
    {
        return
            [
                ['title'=>'Главная','route'=> 'home' ,'class' => 'fa fa-home'],
                ['title'=>'Партнеры','route'=> 'partners' ,'class' => 'fa fa-users'],
                ['title'=>'Расписание','route'=> 'schedule' ,'class' => 'fa fa-desktop'],
                ['title'=>'Зачеты и экзамены','route'=> 'offsets' ,'class' => 'fa fa-calendar']
            ];
    }
    public function userMenuBar()
    {
        return
            [

            ];
    }
    public function userInfo($id)
    {
        $user_role = $this->u_rep->getNameRole($id);
        if(!empty($user_role))
        {
            return $user_role;
        }
        return false;
    }

}
