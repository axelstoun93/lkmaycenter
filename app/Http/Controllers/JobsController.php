<?php

namespace App\Http\Controllers;

use App\Repositories\JobRepository;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    protected  $vars;
    protected  $page;
    protected  $title;
    protected  $template;
    protected  $j_rep;
    public function __construct(JobRepository $job)
    {
        $this->j_rep = $job;
        $this->template = config('settings.theme_jobs').'.index';
    }
    public function index()
    {
        $this->title = 'Вакансии';
        $this->page = 'Вакансии партнеров Академии май';
        $jobs = $this->j_rep->getAllJobs();
        $content = view(config('settings.theme_jobs').'.indexContent')->with('jobs',$jobs)->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }
    public function show($id)
    {
        $this->title = 'Вакансии';
        $this->page = 'Вакансии партнеров Академии май';
        $job = $this->j_rep->getOneJobs($id);
          if(empty($job))
        {
            abort(404);
        }
        $content = view(config('settings.theme_jobs').'.indexShow')->with('job',$job)->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }
    public function renderOutput()
    {
        $this->vars = array_add($this->vars,'title',$this->title);
        $this->vars = array_add($this->vars,'page',$this->page);
        return view($this->template)->with($this->vars);
    }
}
