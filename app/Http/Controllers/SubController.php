<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;

class SubController extends Controller
{
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|email|unique:subscriptions'
        ]);
        $sub=Subscription::add($request->get('email'));
        $sub->generateToken();
        Subscription::sendToken($sub);
        return redirect()->back()->with('status','проверьте вашу почту');
    }
    public function verify($token)
    {
       $sub=Subscription::where('token', $token)->first();
        if ($sub) {
            $sub->subscribe();
            return redirect()->route('index')->with('status','email подтвержден');
        }
        return redirect()->route('index')->with('status','email не подтвержден');
    }
}
