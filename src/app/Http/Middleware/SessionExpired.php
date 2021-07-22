<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;

class SessionExpired
{
    protected $session;
    protected $timeout = 300;
     
    public function __construct(Store $session){
        $this->session = $session;
    }
    public function handle($request, Closure $next){
        if(! session('lastActivityTime'))
            $this->session->put('lastActivityTime', time());
        elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
            $this->session->forget('lastActivityTime');
            Auth::logout();
        }
        $this->session->put('lastActivityTime', time());
        return $next($request);
    }
}
