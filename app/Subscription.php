<?php

namespace App;

use App\Mail\SubscribeMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public static function add($email){
        $sub=new static;
        $sub->email=$email;
        
        $sub->save();
        
        return $sub;
    }
    public function generateToken()
    {
        $this->token=Str::random(100);
        $this->save();
    }
    public static function sendToken($sub)
    {
        Mail::to($sub)->send(new SubscribeMail($sub));
    }
    public function subscribe()
    {
        $this->token=null;
        $this->save();
    }
    public function remove(){
        $this->delete();
    }
}
