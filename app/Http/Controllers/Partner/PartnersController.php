<?php
namespace App\Http\Controllers\Partner;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class PartnersController extends  Controller
{
    protected $template;
    protected $keywords;
    protected $meta_desc;
    protected $title;
    protected $vars;
    protected $page;
    protected $u_rep;
    protected $j_rep;
    protected $alert;
    public function __construct(UserRepository $userRepository)
    {
        $this->u_rep = $userRepository;

    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars,'title',$this->title);
        $this->vars = array_add($this->vars,'page',$this->page);
        $this->alert = $this->alert();
        $menu = $this->getMenu();
        $userInfo = $this->userInfo(Auth::user()->id);
        $userMenu = $this->userMenuBar();
        $userNavigate = view(config('settings.theme').'.admin.partner.userNavigation')->with(['userInfo' =>  $userInfo,'userMenu' => $userMenu,'alert'=>$this->alert])->render();
        $this->vars = array_add($this->vars,'userNavigation',$userNavigate );
        $navigation = view(config('settings.theme').'.admin.partner.indexBar')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars,'navigation',$navigation);
        return view($this->template)->with($this->vars);

    }
    public function getMenu()
    {
        return
            [
                ['title'=>'Главная','route'=> 'home' ,'class' => 'fa fa-home'],
                ['title'=>'Мои вакансии','route'=> 'jobs' ,'class' => 'fa fa-newspaper-o' ,  'l-access' =>  (!empty($this->alert) && property_exists($this->alert,'l-access')) ?  'data-l-access="true"': 'data-l-access="false"'],
                ['title'=>'Зачеты и экзамены','route'=> 'examinations' ,'class' => 'fa fa-calendar' ,'l-access' =>  (!empty($this->alert) && property_exists($this->alert,'l-access')) ?  'data-l-access="true"': 'data-l-access="false"']
            ];
    }
    public function userMenuBar()
    {
        return
            [
                ['title'=>'Мой профиль','route'=> 'profile' ,'class' => 'fa fa-user'],
            ];
    }
    public function userInfo($id)
    {
        $user_role = $this->u_rep->getNameRole($id,true);
        if(!empty($user_role))
        {
            return $user_role;
        }
        return false;
    }
    public  function alert()
    {
     $alert = [];
     if(Session::has('l-access'))
     {
         $alert['l-access'] = (object)session('l-access');
         if(is_object((object)$alert))
         {
             return (object)$alert;
         }
     }
        $this->alert = false;

    }
}