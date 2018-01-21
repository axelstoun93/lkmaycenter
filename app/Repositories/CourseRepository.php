<?php
namespace App\Repositories;
use App\Course;
use App\CourseCategory;
use App\Repositories\Assistants\DataAssistants;
class CourseRepository extends Repository
{
    public function __construct(Course $course)
    {
        $this->model = $course;
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
        $date = DataAssistants::getDate($month,$years);
        $arrayCourse = $this->getCurs($month,$years);
        $week = [];
        // Вычисляем число дней в текущем месяце
        $dayofmonth = $date;

        // Счётчик для дней месяца
        $day_count = 1;
        // 1. Первая неделя
        $num = 0;
            foreach($arrayCourse as $key => $v) {
                $num = 0;
                $day_count = 1;
                for ($i = 0; $i < 7; $i++) {


                    $dayofweek = date('w', mktime(0, 0, 0, (!empty($month)) ? $month : date('m'), $day_count, (!empty($years)) ? $years: date('Y')));

                    $dayofweek = $dayofweek - 1;

                    if($dayofweek == -1) $dayofweek = 6;

                    if ($dayofweek == $i) {
                        // Если дни недели совпадают,
                        // заполняем массив $week
                        // числами месяца
                        $week[$num][$i]['day'] = $day_count;
                        $week[$num][$i]['fullDate'] = DataAssistants::renderingDate($day_count,$month,$years);
                        if($v->date == $day_count)
                        {
                            $week[$num][$i]['events'][] = $v;
                        }
                        $day_count++;
                    } else {
                        $week[$num][$i]['day'] = "";
                    }
                }
                    // 2. Последующие недели месяца
                    while (true) {
                        $num++;
                        for ($i = 0; $i < 7; $i++) {
                            $week[$num][$i]['day'] =  $day_count;
                            $week[$num][$i]['fullDate'] = DataAssistants::renderingDate($day_count,$month,$years);
                            if($v->date == $day_count)
                            {
                                $week[$num][$i]['events'][] = $v;
                            }
                            $day_count++;
                            // Если достигли конца месяца - выходим
                            // из цикла
                            if ($day_count > $dayofmonth) break;
                        }
                        // Если достигли конца месяца - выходим
                        // из цикла
                        if ($day_count > $dayofmonth) break;
                    }
            }
        if(!empty($week))
        {
            return $week;
        }else
        {
            for ($i = 0; $i < 7; $i++) {
                $dayofweek = date('w', mktime(0, 0, 0, (!empty($month)) ? $month : date('m'), $day_count, (!empty($years)) ? $years: date('Y')));

                $dayofweek = $dayofweek - 1;

                if($dayofweek == -1) $dayofweek = 6;

                if ($dayofweek == $i) {
                    // Если дни недели совпадают,
                    // заполняем массив $week
                    // числами месяца
                    $week[$num][$i]['day'] = $day_count;
                    $week[$num][$i]['fullDate'] = DataAssistants::renderingDate($day_count,$month,$years);
                    $day_count++;
                } else {
                    $week[$num][$i]['day'] = "";
                }
            }
            // 2. Последующие недели месяца
            while (true) {
                $num++;
                for ($i = 0; $i < 7; $i++) {
                    $week[$num][$i]['day'] =  $day_count;
                    $week[$num][$i]['fullDate'] = DataAssistants::renderingDate($day_count,$month,$years);
                    $day_count++;
                    // Если достигли конца месяца - выходим
                    // из цикла
                    if ($day_count > $dayofmonth) break;
                }
                // Если достигли конца месяца - выходим
                // из цикла
                if ($day_count > $dayofmonth) break;
            }
            return $week;
        }


    }
    public  function getCategory()
    {
         $cat = new CourseCategory();
         $res = CourseCategory::all();
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
        'course_note' => $data['note'],
        'course_css' => $data['css'],
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
        $curs = $this->one($id);
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
                     'course_note' => $request['note'],
                     'course_css' => $request['css'],
                     'category_id' => $request['category'],
                     'date' => $request['date'],
                     'start_time' => $request['start'],
                     'end_time' => $request['end']
                 ];
         }
         $res = $curs->fill($array)->update();
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
    
}