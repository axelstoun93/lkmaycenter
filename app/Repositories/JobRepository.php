<?php
namespace App\Repositories;
use App\Job;
use Illuminate\Support\Facades\Auth;

class JobRepository extends  Repository
{
    public function __construct(Job $job)
    {
        $this->model = $job;
    }
    public function addJob($request)
    {
        $userId = Auth::id();
        if($this->model->where('user_id',$userId)->count() >= config('settings.jobs-partners'))
        {
            return ['status' => 'Вы превысили максимальное количество вакансии '.config('settings.jobs-partners').'.','alert'=> 'alert-info'];
        }
        config('setting.jobs-partners');
        $data = $request->all();
        $job = $this->model->create([
            'user_id' => $userId,
            'post_id' => $data['post_id'],
            'job_title' => $data['title'],
            'job_category'  => $data['category'],
            'duties' => $data['duties'],
            'demand' => $data['demand'],
            'address' => $data['address'],
            'work_experience' => $data['experience'],
            'condition' => $data['condition'],
            'salary' => $data['salary'],
            'working_schedule' => $data['schedule']
        ]);
        if($job) {
            return ['status' => 'Вакансия была успешно добавлена','alert'=> 'alert-success'];
        }
    }
    public function getMyJobs()
    {
        $builder = $this->model->select('id','job_title','created_at','updated_at');
        $userId = Auth::id();
        $builder->where('user_id','=',$userId);
        return $builder->get();
    }
    public function getOneMyJobs($id)
    {
        $builder = $this->model->find($id);
        return $builder;
    }
    public function updateJob($request,$id)
    {
        $data = $request->all();
        $array = [
        'post_id' => $data['post_id'],
        'job_title' => $data['title'],
        'job_category'  => $data['category'],
        'duties' => $data['duties'],
        'demand' => $data['demand'],
        'address' => $data['address'],
        'work_experience' => $data['experience'],
        'condition' => $data['condition'],
        'salary' => $data['salary'],
        'working_schedule' => $data['schedule'],
        'updated_at' => date('Y-m-d G:i:s')
    ];
        $job = $this->model->find($id)->fill($array)->update();
        if($job) {
            return ['status' => 'Вакансия была успешно обновлена.','alert'=> 'alert-success'];
        }
    }
    public  function deleteJob($id)
    {
        $job = $this->model->find($id);
        if($job->delete()) {
            return ['status' => "Вакансия {$job->job_title} успешна удалена.",'alert'=> 'alert-success'];
        }
    }
    public  function postIdJob($id)
    {
        $job = $this->model->find($id);
        if(!empty($job->post_id)) {
            return $job->post_id;
        }
        return false;
    }
    public function getAllJobs()
    {
        $job = $this->model->orderBy('id', 'desc')->paginate(config('settings.paginate-jobs'));
        $job->load('info');
        return $job;
    }
    public  function getOneJobs($id)
    {
        $job = $this->model->find($id);
        return $job;
    }
    public function getEndJobs()
    {
        $job = $this->model->select('id')->orderby('id', 'desc')->first();;
        if(empty($job->id))
        {
            return false;
        }
        return $job->id;
    }
}