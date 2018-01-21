<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends ManagerController
{

    public function __construct()
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->template = config('settings.theme').'.admin.manager.index';
    }
    public function index()
    {
        $this->title = 'Панель менеджера';
        $this->page = 'Главная';
        $content = view(config('settings.theme').'.admin.manager.contentIndex')->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }


}
