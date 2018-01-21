<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\Request;
use App\Repositories\Assistants\DataAssistants;
class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected  $vars;
    protected  $page;
    protected  $title;
    protected  $template;
    protected  $j_rep;
    protected  $c_rep;
    public function __construct(ScheduleRepository $schedule,CourseRepository $course)
    {
        $this->s_rep = $schedule;
        $this->c_rep = $course;
        $this->template = config('settings.tv').'.index';
    }
    public function index()
    {

        $navigate = DataAssistants::weekNavigate();
        $id = $navigate['now'];
        $this->title = 'Расписание — Академии "Май"';
        $this->page = 'Расписание Академии "Май"';
        $res = $this->getWeekNavigate($id);
        $week = $this->getWeekArray($id);
        $weekEvent = $this->getWeekEvent($id);
        $category = $this->getCategory();
        $content = view(config('settings.tv').'.weekTable')->with(['navigate' => $res,'weekNavigate' => $navigate,'category' => $category,'week'=>$week,'weekEvent' => $weekEvent])->render();
        $this->vars = array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }
    public function getNextAndOldWeek(Request $request)
    {
        if(!empty($request->date))
        {
            $navigate = DataAssistants::weekNavigate($request->date);
            $this->title = 'Расписание — Академии "Май"';
            $this->page = 'Расписание Академии "Май"';
            $res = $this->getWeekNavigate($request->date);
            $week = $this->getWeekArray($request->date);
            $category = $this->getCategory();
            $weekEvent = $this->getWeekEvent($request->date);
            $content = view(config('settings.tv').'.weekTable')->with(['navigate' => $res,'weekNavigate' => $navigate,'category' => $category,'week'=>$week,'weekEvent' => $weekEvent])->render();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!empty($id))
        {
            $navigate = DataAssistants::weekNavigate($id);
            $this->title = 'Расписание — Академии "Май"';
            $this->page = 'Расписание Академии "Май"';
            $res = $this->getWeekNavigate($id);
            $week = $this->getWeekArray($id);
            $weekEvent = $this->getWeekEvent($id);
            $category = $this->getCategory();
            $content = view(config('settings.tv').'.weekTable')->with(['navigate' => $res,'weekNavigate' => $navigate,'category' => $category,'week'=>$week,'weekEvent' => $weekEvent])->render();
            $this->vars = array_add($this->vars,'content',$content);
            return $this->renderOutput();
        }
        else
        {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function renderOutput()
    {
        $this->vars = array_add($this->vars,'title',$this->title);
        $this->vars = array_add($this->vars,'page',$this->page);
        return view($this->template)->with($this->vars);
    }
    public function getWeekEvent($id)
    {
        $res = $this->s_rep->getWeekEvent($id);
        return $res;
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
}
