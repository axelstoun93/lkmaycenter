<?php
namespace App\Repositories\Assistants;
class DataAssistants
{
  //Метод готовит данные для сохранения в базе данных

    // Метод возврощяет текущую дату
    static function getDate($month = false,$years = false)
    {
        $date = date('t',mktime(0, 0, 0, (!empty($month)) ? $month : date('n'), 1, (!empty($years)) ? $years: date('Y')));
        return $date;
    }
    static function transFrontDate($str)
    {
        $date = explode('-',$str);
        $fdate = $date[2].'/'.$date[1].'/'.$date[0];
        return $fdate;
    }
    static function transBackDate($str,$sim = '/')
    {
        if (!is_array($str) || !is_object($str)) {
            $date = explode($sim,$str);
            $fdate = $date[2].'-'.$date[1].'-'.$date[0];
            return $fdate;
        }
        throw new \Exception('Произошла ошибка в '.__METHOD__);
    }
    static function renderingDate($data,$month,$years)
    {
        $years = (!empty($years)) ? $years : date('Y');
        $month = (!empty($month)) ?  (10 > $month) ? '0'.$month  : $month  : date('m');
        $data  = (10 > $data) ? '0'.$data : $data;
        $res = $data.'/'.$month.'/'.$years;
        return $res;
    }

    static function navigateDate($month = false,$years = false)
    {
        $nav = [];
        $years = (!empty($years)) ? $years : date('Y');
        $month = (!empty($month)) ? $month : date('n');
        $m_arr = [1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель', 5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август', 9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'];
        $nextDate = ($month == 12) ? '1/'.($years + 1).'/' : ($month + 1).'/'.$years.'/';
        $previousDate = ($month == 1) ? '12/'.($years - 1).'/' : ($month-1).'/'.$years.'/';
        $nav = ['month' => $m_arr[$month],'years'=> $years,'nextDate' => $nextDate,'previousDate'=> $previousDate];
        return (object)$nav;
    }
    static function oneDay($str)
    {
        $changeDate =  explode('-',$str);
        $res = (!empty($changeDate[2])) ? $changeDate[2] : '';
        return $res;
    }
    static function getDayMonth($month,$years)
    {

        $years = (!empty($years)) ? $years : date('Y');
        $month = (!empty($month)) ?  (10 > $month) ? '0'.$month  : $month  : date('m');
        $number = cal_days_in_month(CAL_GREGORIAN, $month,$years);
        return $number;
    }
    #ScheduleController Function
    static function renderingDateSchedule($data,$month,$years,$monthPluse = false)
    {
        $years = (!empty($years)) ? $years : date('Y');
        $month = (!empty($month)) ?  (10 > $month) ? '0'.$month  : $month  : date('m');
        if(!empty($monthPluse))
        {
            $month= (int)$month + 1;
            if(10 > $month)
            {
                $month = '0'.$month;
            }
        }
        if($month > 12)
        {
            $month = 1;
            $years =+ 1;
        }
        $data  = (10 > $data) ? '0'.$data : $data;
        $res = $data.'-'.$month.'-'.$years;
        return $res;
    }
    static function getOldMonth($month,$years,$monthMinus = false)
    {
        $years = (!empty($years)) ? $years : date('Y');
        $month = (!empty($month)) ?  (10 > $month) ? '0'.$month  : $month  : date('m');
        if(!empty($monthMinus))
        {
            $month = (int)$month - 1;
            if(10 > $month)
            {
                $month = '0'.$month;
            }
        }
        if($month == 0)
        {
            $month = 12;
            $years = $years - 1;
        }
        function x_week_range($date) {
            $ts =    strtotime($date);
            $start = strtotime('last monday', $ts);
            return date('d-m-Y', $start);
        }
        $allDay = cal_days_in_month (CAL_GREGORIAN, $month , $years);
        $readyStr = $years.'-'.$month.'-'.$allDay;
        $res =  x_week_range($readyStr);
        return $res;
    }
    static function navigateDateSchedule($str)
    {
        $exp = explode('+',$str);
        if(!empty($exp) and !empty($exp[0]) and !empty($exp[1]))
        {
            $dateOne = explode('-',$exp[0]);
            $dateTwo = explode('-',$exp[1]);
            $m_arr = ['01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь'];
            $str =  $dateOne[0].'.'.$dateOne[1].'.'.$dateOne[2].' - '.$dateTwo[0].'.'.$dateTwo[1].'.'.$dateTwo[2];
            return $str;
        }
        return false;
    }
    static function tv_range($date,$str) {
        $ts =    strtotime($date);
        $start = strtotime($str, $ts);
        return date('d-m-Y', $start);
    }
   static function weekNavigate($id=false)
    {
        $array = [];
        $dataOne = '';
        $dataTwo = '';
        $now = '';
        if(empty($id))
        {
            $data = date('d-m-Y');
            $dataOne = self::tv_range($data,'last monday');
            $dateTwo = self::tv_range($data,'next sunday');
            $backward = self::tvBackward($dataOne);
            $next = self::tvNext($dateTwo);
            $now = $dataOne.'+'.$dateTwo;
            $array = ['now'=>$now,'backward' => $backward,'next' => $next];
        }
        else
            {
                $data = explode('+',$id);
                $backward = self::tvBackward($data[0]);
                $next = self::tvNext($data[1]);
                $array = ['backward' => $backward,'next' => $next];
            }
            return $array;
    }

   static function tvBackward($data)
    {
        $date = new \DateTime($data);
        $date->sub(new \DateInterval('P1D'));
        $dataTwo = $date->format('d-m-Y');
        $date->sub(new \DateInterval('P6D'));
        $dataOne = $date->format('d-m-Y');;
        $res = $dataOne.'+'. $dataTwo;
        return $res;
    }
    static function tvNext($data)
    {
        $date = new \DateTime($data);
        $date->add(new \DateInterval('P1D'));
        $dataOne = $date->format('d-m-Y');
        $date->add(new \DateInterval('P6D'));
        $dataTwo = $date->format('d-m-Y');;
        $res = $dataOne.'+'. $dataTwo;
        return $res;
    }
}
