<?php

namespace App\Http\Controllers\Manager;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\Request;
use App\Repositories\CourseRepository;
use App\Repositories\Assistants\DataAssistants;
class ScheduleController extends ManagerController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected  $s_rep;
    public function __construct(CourseRepository $course,ScheduleRepository $schedule)
    {
        parent::__construct(new \App\Repositories\UserRepository(new \App\User));
        $this->c_rep = $course;
        $this->s_rep = $schedule;
        $this->template = config('settings.theme').'.admin.manager.schedule';
    }

    public function index()
    {
        $this->title = 'Расписание академии Май';
        $this->page = 'Расписание академии Май';
        $week = $this->getWeek();
        $navigate = $this->ControllerGetNavigate();
        $content = view(config('settings.theme').'.admin.manager.tableSchedule')->with(['week' => $week,'navigate'=> $navigate])->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }

    public function getMonthYears(Request $request)
    {
        if(!empty($request->years) && !empty($request->month))
        {

            $this->title = 'Расписание академии Май';
            $this->page = 'Расписание академии Май';
            $week = $this->getWeek($request->month,$request->years);
            $navigate = $this->ControllerGetNavigate($request->month,$request->years);
            $content = view(config('settings.theme').'.admin.manager.tableSchedule')->with(['week' => $week,'navigate'=> $navigate])->render();
            $this->vars = array_add($this->vars,'content',$content);
            return $this->renderOutput();
        }
        else
        {
            return back();
        }
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
        $this->title = 'Создать расписание';
        $this->page = 'Расписание академии Май / Создать расписание';
        $res = $this->getWeekNavigate($id);
        $week = $this->getWeekArray($id);
        $weekEvent = $this->getWeekEvent($id);
        $category = $this->getCategory();
		$weekNavigate = DataAssistants::weekNavigate($id);
        $content = view(config('settings.theme').'.admin.manager.showSchedule')->with(['navigate' => $res,'week' => $week,'category' => $category,'weekEvent' => $weekEvent,'weekNavigate' => $weekNavigate])->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res =  $this->deleteWeekEvent($id);
        if($res)
        {
            return json_encode(['status'=> 'success']);
        }
    }
    public function getWeek($years = false ,$month = false)
    {
        $res = $this->renderingCalendar($years,$month);
        return $res;
    }
    public function ControllerGetNavigate($month = false,$years = false)
    {
        $res = $this->getNavigate($month ,$years);
        return $res;
    }
    public function renderingCalendar($month = false,$years = false)
    {
        $res = $this->s_rep->renderingCalendar($month,$years);
        return $res;
    }
    public function getNavigate($month = false,$years = false)
    {
        return  $res = DataAssistants::navigateDate($month,$years);
    }
    public function getWeekNavigate($str)
    {
        return  $res = DataAssistants::navigateDateSchedule($str);
    }
    public function getWeekArray($date)
    {
        $readyArr = [];
        if(!empty($date))
        {
            $res = explode('+',$date);
            $date = new \DateTime($res[0]);
            $readyArr[0]['date'] = $date->format('d/m');
            $readyArr[0]['fullDate'] = $date->format('d/m/Y');
            for($i=1;7>$i;$i++)
            {
                $date->add(new \DateInterval('P1D'));
                $readyArr[$i]['date'] = $date->format('d/m');
                $readyArr[$i]['fullDate'] = $date->format('d/m/Y');
            }
        }
        return $readyArr;
    }
    public function getCategory()
    {
        $res = $this->c_rep->getCategory();
        return $res;
    }
    public function saveEvent($array)
    {
        $res = $this->s_rep->saveEvent($array);
        return $res;
    }
    public function getWeekEvent($id)
    {
        $res = $this->s_rep->getWeekEvent($id);
        return $res;
    }
    public function deleteWeekEvent($id)
    {
        $res = $this->s_rep->deleteEvent($id);
        return $res;
    }
    public function getEvent($id)
    {
        $res = $this->s_rep->getEvent($id);
        return $res;
    }
    public function updateEvent($request,$id)
    {
        $res = $this->s_rep->updateEvent($request,$id);
        return $res;
    }
}
