<?php

namespace App\Http\Controllers\Administrator;
use Illuminate\Http\Request;
use App\Repositories\CourseRepository;
use Mockery\CountValidator\Exception;

class OffsetsController extends AdministratorController
{
    public function __construct(CourseRepository $course)
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->c_rep = $course;
        $this->template = config('settings.theme').'.admin.administrator.offsets';
    }

    public function index()
    {
        $this->title = 'Зачеты и экзамены';
        $this->page = 'Зачеты и экзамены';
        $month = $this->getMonth();
        $navigate = $this->getNavigate();
        $category = $this->getCategory();
        $content = view(config('settings.theme').'.admin.administrator.tableOffsets')->with(['month'=>$month,'navigate'=> $navigate,'category' => $category])->render();
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
        $data = $request->all();
        $res = $this->saveEvent($data);
        if(!empty($res))
        {
            return back()->with($res);
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
       $res = $this->getEvent($id);
       echo $res;
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

        if(is_object($request) && !empty($request->all()))
        {
            $data = $request->all();
            $res =  $this->updateEvent($data, $id);
            if($res)
            {
              return json_encode(['status'=> 'success']);
            }
        }
       }
    public function getMonthYears(Request $request)
    {
       if(!empty($request->years) && !empty($request->month))
       {

           $this->title = 'Зачеты и экзамены';
           $this->page = 'Зачеты и экзамены';
           $month = $this->getMonth($request->month,$request->years);
           $navigate = $this->getNavigate($request->month,$request->years);
           $category = $this->getCategory();
           $content = view(config('settings.theme').'.admin.administrator.tableOffsets')->with(['month'=>$month,'navigate'=> $navigate,'category' => $category])->render();
           $this->vars = array_add($this->vars,'content',$content);
           return $this->renderOutput();
       }
       else
       {
           return back();
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
       $res =  $this->deleteEvent($id);
        if($res)
        {
            return json_encode(['status'=> 'success']);
        }
    }
    public function getMonth($years = false ,$month = false)
    {
        $res = $this->c_rep->renderingCalendar($years,$month);
        return $res;
    }
    public function  getCategory()
    {
        $res = $this->c_rep->getCategory();
        return $res;
    }
    public function saveEvent($array)
    {
        $res = $this->c_rep->saveEvent($array);
        return $res;
    }
    public function deleteEvent($id)
    {
        $res = $this->c_rep->deleteEvent($id);
        return $res;
    }
    public function getEvent($id)
    {
        $res = $this->c_rep->getEvent($id);
        return $res;
    }
    public function updateEvent($request,$id)
    {
        $res = $this->c_rep->updateEvent($request,$id);
        return $res;
    }
    public function getNavigate($month = false,$years = false)
    {
        $res = $this->c_rep->getNavigate($month ,$years);
        return $res;
    }
}
