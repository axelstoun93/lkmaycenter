<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends AdministratorController
{

    public function __construct()
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->template = config('settings.theme').'.admin.administrator.index';
    }
    public function index()
    {
        $this->title = 'Панель менеджера';
        $this->page = 'Главная';
        $content = view(config('settings.theme').'.admin.administrator.contentIndex')->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }


}
