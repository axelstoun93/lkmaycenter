<?php
namespace App\Repositories;
use App\CourseCategory;
use App\Repositories\Assistants\DataAssistants;
use App\Schedule;

class ScheduleRepository extends Repository
{
    public function __construct(Schedule $schedule)
    {
        $this->model = $schedule;
    }
    public  function getCurs($month = false,$years = false)
    {
        $strYears = (!empty($years)) ? $years : date('Y');
        $strYears.= '-';
        $strYears.= (!empty($month)) ? (10 > $month) ? '0'.$month  : $month  : date('m');
        $strYears.= '-%';
        $res = $this->model->where('date','LIKE',$strYears)->orderBy('start_time','asc')->get();
        foreach($res as  $val)
        {
            if($val->date)
            {
                $val->date = DataAssistants::oneDay($val->date);;
            }
        }
        return $res;
    }

    public function renderingCalendar($month = false,$years = false)
    {
        $date = DataAssistants::getDate($month, $years);
        $arrayWeek = [];
        $week = [];
        // Вычисляем число дней в текущем месяце
        $dayofmonth = $date;

        // Счётчик для дней месяца
        $day_count = 1;
        // 1. Первая неделя
        $num = 0;
        // Счетчик для расписания рецепции
        $count = 1;
        for ($i = 0; $i < 7; $i++) {
            $dayofweek = date('w', mktime(0, 0, 0, (!empty($month)) ? $month : date('m'), $day_count, (!empty($years)) ? $years : date('Y')));

            $dayofweek = $dayofweek - 1;

            if ($dayofweek == -1) $dayofweek = 6;

            if ($dayofweek == $i) {
                // Если дни недели совпадают,
                // заполняем массив $week
                // числами месяца
                if($i == 0 or $i == 6)
                {

                    $week[$num][($i == 0) ? 'first' : 'last'] =  DataAssistants::renderingDateSchedule($day_count,$month,$years);
                    $day_count++;
                }
                else
                {
                    $day_count++;
                }
            }
        }
        if(empty($week[0]['first']))
        {
            $week[$num]['first'] = DataAssistants::getOldMonth($month,$years,true);
        }

        // 2. Последующие недели месяца
        while (true) {
            $num++;
            for ($i = 0; $i < 7; $i++) {

                if($day_count > DataAssistants::getDayMonth($month,$years))
                {
                    if($i == 0 or $i == 6)
                    {
                        $week[$num][($i == 0) ? 'first' : 'last'] =  DataAssistants::renderingDateSchedule($count,$month,$years,true);
                        $count++;
                        continue;
                    }
                    else
                    {
                        $count++;
                    }
                }
                if($i == 0 or $i == 6)
                {
                    $week[$num][($i == 0) ? 'first' : 'last'] = DataAssistants::renderingDateSchedule($day_count,$month,$years) ;
                    $day_count++;
                }
                else
                {
                    $day_count++;
                }
                // Если достигли конца месяца - выходим
                // из цикла
                //if ($day_count > $dayofmonth) break;
            }
            // Если достигли конца месяца - выходим
            // из цикла
            if ($day_count > $dayofmonth) break;
        }
        return $week;
    }
    public  function getCategory()
    {
        $cat = new CourseCategory();
        $res = CourseCategory::all();
        return $res;
    }
    public  function getWeekEvent($getWeek)
    {
        $week = explode('+',$getWeek);
        $dataOne = DataAssistants::transBackDate($week[0],'-');
        $dataTwo = DataAssistants::transBackDate($week[1],'-');
        $res = $this->model->where('date','>=',$dataOne)->where('date','<=',$dataTwo)->orderBy('start_time','asc')->get();
        foreach($res as  $val)
        {
            if($val->date)
            {
                $val->date = DataAssistants::transFrontDate($val->date);
            }
        }
        return $res;
    }
    public function saveEvent($data)
    {
        if(!empty($data['date']))
        {
            $data['date'] = DataAssistants::transBackDate($data['date']);
        }
        $events =  $this->model->create([
            'title' => $data['title'],
            'place' => $data['place'],
            'note' => $data['note'],
            'schedule_css' => $this->getCategoryCss($data['category']),
            'category_id' => $data['category'],
            'date' => $data['date'],
            'start_time' => $data['start'],
            'end_time' => $data['end']
        ]);
        if($events)
        {
            return ['status' => 'Событие было успешно добавлено'];
        }
    }
    public function updateEvent($request,$id)
    {
        $shedule = $this->one($id);
        if(!empty($request)){

            $request['date'] = DataAssistants::transBackDate($request['date']);
            if(count($request) == 1)
            {
                $array =
                    [
                        'date' => $request['date'],
                    ];
            }else
            {
                $array =
                    [
                        'title' => $request['title'],
                        'place' => $request['place'],
                        'note' => $request['note'],
                        'schedule_css' => $this->getCategoryCss($request['category']),
                        'category_id' => $request['category'],
                        'date' => $request['date'],
                        'start_time' => $request['start'],
                        'end_time' => $request['end']
                    ];
            }
            $res = $shedule->fill($array)->update();
            return $res;
        }
        return false;
    }
    public function getEvent($id)
    {
        $res = $this->one($id);
        $res->date = DataAssistants::transFrontDate($res->date);
        $res->all();
        json_encode($res);
        return $res;
    }
    public function deleteEvent($id)
    {
        if(!empty($id))
        {
            $res = $this->model->find($id);
            $res->delete();
            return $res;
        }
    }
    public function getNavigate($month = false,$years = false)
    {
        return  $res = DataAssistants::navigateDate($month,$years);
    }
    public function  getCategoryCss($id)
    {
        switch ($id)
        {
            case 2:
             return 'fc-event-success';
            case 3:
             return 'fc-event-warning';
            case 4:
             return 'fc-event-primary';
            case 5:
                return 'fc-event-info';
            case 6:
                return 'fc-event-default';
            default:
            return false;
        }
    }

}