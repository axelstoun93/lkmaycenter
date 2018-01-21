<?php
namespace App\Repositories;
use App\Job;
use App\Partner;
use App\User;
use App\Role;
use Config;
use Image;
class UserRepository extends Repository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function  getRole($id)
    {
        if(!empty($id))
        {
            return $this->model->find($id)->roles()->first()->name;
        }
        return false;
    }
    public function  getName($id)
    {
        if(!empty($id))
        {
            return $this->model->find($id)->fio->first()->name;
        }
        return false;
    }
    public function getNameRole($id,$partner = false)
    {
        $array = '';
        if(!empty($id))
        {

            $user = $this->model->find($id);
            if(!empty($user->fio))
            {
                $fio = explode(' ',$user->fio);
                $name = (!empty($fio[0])) ? $fio[0]: '';
                $fam = (!empty($fio[1]))  ? mb_substr($fio[1],0,1,'utf-8')  : '';
                $otch = (!empty($fio[2])) ? mb_substr($fio[2],0,1,'utf-8') : '';
                $user->fio = $name.' '.$fam.'.'.$otch;
            }
            if($partner)
            {
                $partner = Partner::where('user_id',$id)->select('days_left')->first();
                $partner->days_left = $this->getDay($partner->days_left);
                if(!empty($partner->days_left))
                {
                    $array = ['day' => $partner->days_left];
                }

            }
            $array['name'] = (!empty($user->fio)) ? $user->fio : $user->name;
            $array['role'] = $user->roles()->first()->name;
            return (object)$array;
        }
    }
    public function  getAllPartner()
    {
        $user =  $this->model->all();
        $user->load('roles');
        $user->load('getPartnerInfo');
        $userCollection = [];
        foreach($user as  $key => $value)
        {
            if(!empty($value->getPartnerInfo)){$value->getPartnerInfo->days_left =  $this->getDay($value->getPartnerInfo->days_left );}
            foreach ($value->roles as $val)
            {
                if($val->id == 3)
                {
                    $userCollection[$key] = $value;
                }
            }
        }
        return $userCollection;
    }
    public function  getOnePartner($id,$infoCount = false)
    {
        $user = $this->model->find($id);
        $user->load('getPartnerInfo');
        $user->getPartnerInfo->days_left = $this->getDay($user->getPartnerInfo->days_left);
        if($infoCount)
        {
            $user['countInfo'] =  $this->countShowArrayClient($user);
        }

        return $user;
    }
    public function  searchPartner($search)
    {
        $user = '';
        $userCollection = [];
        $user =  $this->model->where('name','LIKE','%'.$search.'%')->get();
        if(count($user) < 1)
        {
            $user =  $this->model->where('fio','LIKE','%'.$search.'%')->get();
        }
        if(!empty($user))
        {
            $user->load('roles');

             foreach ($user as  $i => $value)
             {
                     foreach ($value->roles as $key => $val)
                     {
                               if($val->id == 3)
                               {
                                   $userCollection[$i] = $value->load('getPartnerInfo');
                                   if(!empty($userCollection[$i]->getPartnerInfo->days_left))
                                   {
                                       $userCollection[$i]->getPartnerInfo->days_left = $this->getDay($userCollection[$i]->getPartnerInfo->days_left);
                                   }
                               }
                     }
             }
        }
        if(!empty($userCollection))
        {
            return $userCollection;
        }
        else
        {

            return redirect()->route('partners')->with('status','По вашему запросу ничего не найдено');
        }
    }
    public function  addPartner($request)
    {
        $data = $request->all();

        $client = $this->model->create([
            'name' => $data['name'],
            'fio'  => preg_replace('|[\s]+|s', ' ', $data['fio']),
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        if($client) {
            $client->roles()->attach(3);
            $clientInfo =  new Partner(['days_left' => $this->setYearsTime(),'status'=>'1']);
            $client->getPartnerInfo()->save($clientInfo);
        }

        return ['status' => 'Партнер был успешно добавлен'];
    }

    public function getDay($time)
    {
        $nowTime = time();
        if(time() < $time)
        {
            $res = $time - $nowTime;
            $day = $res/60/60/24;
            return (int)floor($day);
        }
        return "0";
    }
    public function setYearsTime($time = 0)
    {
        $nowTime = time();
        if (!empty($time))
            {  if($nowTime > $time)
            {
                $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", $nowTime). " + 366 day"));
                $unixTime = strtotime($oneYearOn);
                return $unixTime;
            }
            $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", $time). " + 366 day"));
            $unixTime = strtotime($oneYearOn);
            return $unixTime;
        }
        else
        {
            $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", $nowTime) . " + 366 day"));
            $unixTime = strtotime($oneYearOn);
            return $unixTime;
        }
    }

    public function deletePartner($id)
    {
        $user = $this->model->find($id);

        $user->roles()->detach();
        $user->getPartnerInfo()->delete();
        $user->jobs()->delete();
        if($user->delete()) {
            return ['status' => "Партнер {$user->name} успешно удален."];
        }
    }

    public function updatePartner($request,$user)
    {
        //return $request;
        $data = $request->all();
        $userArray =
            (!empty($data['password']))
            ?
            [
                'name' => $data['name'],
                'fio' => preg_replace('|[\s]+|s', ' ', $data['fio']),
                'email'=> $data['email'],
                'password'=> bcrypt($data['password'])
            ]
            :
            [
                'name' => $data['name'],
                'fio' => $data['fio'],
                'email'=> $data['email']
            ]
        ;
        $infoUser =(!empty($data['extend'])) ?
            [
                'status' => $data['status'],
                'days_left' => $this->setYearsTime()
            ]:
            [
                'status' => $data['status']
            ];
        $user->fill($userArray)->update();
        $user->getPartnerInfo()->update($infoUser);
        return ['status' => 'Партнер был успешно обновлен'];
    }
    public function updatePartners($request,$user)
    {

        $image = $request->file('logo');
        if(!empty($image))
        {

            $img = Image::make($request->file('logo'))->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
            });
            $path = $user->name.'-logo-'.time().'.png';
            $img->save(env('THEME')."/images/partners/logo/".$path);
            $infoUser['logo'] = $path;

        }
        $data = $request->all();
        $userArray = ['fio' => preg_replace('|[\s]+|s', ' ', $data['fio']),'email'=> $data['email']];
        $infoUser['company_name'] = $data['company_name'];
        $infoUser['address'] = $data['address'];
        $infoUser['phone'] = $data['phone'];
        $infoUser['site'] = $data['site'];
        $infoUser['company_info'] = $data['company_info'];
        $user->fill($userArray)->update();
        $user->getPartnerInfo()->update($infoUser);
        return ['status' => 'Вы успешно редактировали данные'];
    }
    public function countShowArrayClient($array)
    {
        $count = 0;
        if(!empty($array->fio)) $count+=1;
        if(!empty($array->email)) $count+=1;
        if(!empty($array->getPartnerInfo->company_name)) $count+=1;
        if(!empty($array->getPartnerInfo->logo)) $count+=1;
        if(!empty($array->getPartnerInfo->address)) $count+=1;
        if(!empty($array->getPartnerInfo->phone)) $count+=1;
        if(!empty($array->getPartnerInfo->company_info)) $count+=1;
        return $count;
    }
    public function getAllManager()
    {
       $res = Role::find(2);
       $res->load('users');
       return $res;
    }
    public function getAllUsers()
    {
        $user =  $this->model->orderBy('created_at', 'desc')->get();
        $user->load('roles');
        $user->load('getPartnerInfo');
        $userCollection = [];
        foreach($user as  $key => $value)
        {
           if(!empty($value->getPartnerInfo)){$value->getPartnerInfo->days_left =  $this->getDay($value->getPartnerInfo->days_left );}
           foreach ($value->roles as $val)
           {
                if($val->id == 2 or $val->id == 3)
                {
                    $userCollection[$key] = $value;
                }
           }
        }
        return $userCollection;
    }
    public function  searchUsers($search)
    {
        $user = '';
        $userCollection = [];
        $user =  $this->model->where('name','LIKE','%'.$search.'%')->get();
        if(count($user) < 1)
        {
           $user =  $this->model->where('fio','LIKE','%'.$search.'%')->get();
        }
        if(count($user) < 1)
        {
            $user =  $this->model->where('email','LIKE','%'.$search.'%')->get();
        }
        if(!empty($user))
        {
            $user->load('roles');
            $user->load('getPartnerInfo');
            foreach($user as  $key => $value)
            {
                if(!empty($value->getPartnerInfo)){$value->getPartnerInfo->days_left =  $this->getDay($value->getPartnerInfo->days_left );}
                foreach ($value->roles as $val)
                {
                    if($val->id == 2 or $val->id == 3)
                    {
                        $userCollection[$key] = $value;
                    }
                }
            }
        }
        if(!empty($userCollection))
        {
            return $userCollection;
        }
        else
        {

            return redirect()->route('partners')->with('status','По вашему запросу ничего не найдено');
        }
    }
    public function deleteUsers($id)
    {
        $user = $this->model->find($id);

        $user->roles()->detach();
        $user->getPartnerInfo()->delete();
        $user->jobs()->delete();
        if($user->delete()) {
            return ['status' => "Пользователь {$user->name} успешно удален."];
        }
    }
    public function  getOneUser($id,$infoCount = false)
    {
        $user = $this->model->find($id);
        $user->load('getPartnerInfo');
        $user->load('roles');
        if(!empty($user->getPartnerInfo))
        {
            $user->getPartnerInfo->days_left = $this->getDay($user->getPartnerInfo->days_left);
        }
        if($infoCount)
        {
            $user['countInfo'] =  $this->countShowArrayClient($user);
        }

        return $user;
    }
    public function  addUser($request)
    {
        $data = $request->all();

        $user = $this->model->create([
            'name' => $data['name'],
            'fio'  => preg_replace('|[\s]+|s', ' ', $data['fio']),
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

            $user->roles()->attach($data['roles']);
            if($data['roles'] == 3)
            {
                $clientInfo =  new Partner(['days_left' => $this->setYearsTime(),'status'=>'1']);
                $user->getPartnerInfo()->save($clientInfo);
            }
        return ['status' => 'Пользователь был успешно добавлен'];
    }
    public function updateUser($request,$user)
    {

         $data = $request->all();
         $userArray =
            (!empty($data['password']))
                ?
                [
                    'name' => $data['name'],
                    'fio' => preg_replace('|[\s]+|s', ' ', $data['fio']),
                    'email'=> $data['email'],
                    'password'=> bcrypt($data['password'])
                ]
                :
                [
                    'name' => $data['name'],
                    'fio' => $data['fio'],
                    'email'=> $data['email']
                ];
        if ($user->roles[0]->id == 3 and $data['roles'] == 2)
        {
            $user->roles()->detach();
            $user->roles()->attach($data['roles']);
            $user->fill($userArray)->update();
            $user->getPartnerInfo()->delete();
            $user->jobs()->delete();
            return ['status' => 'Пользователь был успешно обновлен.'];
        }
        if($user->roles[0]->id == 2 and  $data['roles'] == 3) {
            $user->roles()->detach();
            $user->roles()->attach($data['roles']);
            $user->fill($userArray)->update();
            $infoUser =  new Partner(['days_left' => $this->setYearsTime(),'status'=>'1']);
            $user->getPartnerInfo()->save($infoUser);
            return ['status' => 'Пользователь был успешно обновлен.'];
        }
        if($user->roles[0]->id == 3)
        {
            $user->fill($userArray)->update();
            $infoUser =(!empty($data['extend'])) ?
                [
                    'status' => $data['status'],
                    'days_left' => $this->setYearsTime()
                ]:
                [
                    'status' => $data['status']
                ];
            $user->getPartnerInfo()->update($infoUser);
            return ['status' => '3'];
        }

            $user->fill($userArray)->update();


        return ['status' => 'Пользователь был успешно обновлен.'];
    }
}