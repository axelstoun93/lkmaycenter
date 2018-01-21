<?php
namespace App\Repositories;
use Config;
abstract class Repository
{
    protected $model = FALSE;

    public function get($select = '*', $plaginate = false,$where = false)
    {
        $builder = $this->model->select($select);
        if($where)
        {
            $builder->where($where);
        }
        return $builder->get();
    }
    public function one($id)
    {
        $builder = $this->model->find($id);
        return $builder;
    }
}