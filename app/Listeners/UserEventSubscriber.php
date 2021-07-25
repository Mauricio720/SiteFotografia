<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;


class UserEventSubscriber
{
    
    public function onUserLogin($event)
    {
        $tokenAccess = bcrypt(date('YmdHms'));
 
        $user = auth()->user();
        $user->token = $tokenAccess;
        $user->save();
 
        session()->put('access_token', $tokenAccess);
    }
 
    
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
  
      
    }


}    



