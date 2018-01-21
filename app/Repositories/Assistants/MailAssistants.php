<?php
namespace App\Repositories\Assistants;
use App\Repositories\UserRepository;
use App\User;
use Mail;
use Auth;
class MailAssistants
{
    protected  $template;
    protected  $array;
    protected  $name;
    protected  $to;
    protected  $theme;
    function __construct($temp,$array,$name,$theme = false)
    {
         $this->template = $temp;
         $this->array = $array;
         $this->name = $name;
         $this->theme = $theme;
    }
    public function send($to)
    {
       $this->to = $to;
       $res = Mail::send($this->template, $this->array, function ($message) {
            $message->from(config('settings.mail-send'), $this->name);
            $message->to($this->to)->subject($this->theme);
        });
        return ['status' => 'success'];
    }
    public function sendAllManager()
    {
        $manager =  new UserRepository(new User);
        $managers = $manager->getAllManager();
        foreach ($managers->users as $value)
        {
           $this->send($value->email);
        }
    }
}