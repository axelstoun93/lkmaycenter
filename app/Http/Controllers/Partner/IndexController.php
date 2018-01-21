<?php
namespace App\Http\Controllers\Partner;
class IndexController extends PartnersController
{

    public function __construct()
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->template = config('settings.theme').'.admin.partner.index';
    }
    public function index()
    {
        
        $this->title = 'Панель партнера';
        $this->page = 'Главная';
        $content = view(config('settings.theme').'.admin.partner.contentIndex')->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }

}