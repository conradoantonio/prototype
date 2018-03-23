<?php

namespace App\Http\Controllers;

use App\Traits\GeneralFunctions;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
	#Declare a middleware in the construct, so we can access to the current user!
	function __construct() {
        date_default_timezone_set('America/Mexico_City');
        $this->summer = date('I');
        $this->app_customer_id = "fd0924a2-30e5-4498-9e0f-76b93a4e6487";
        $this->app_delivery_id = "4aa0dfbf-a53d-4ed8-ac09-94ef906aed6b";
        $this->app_customer_key = "ODAwMjZlM2QtNDNhYy00YTRhLWI1YWUtMGQyOWFkMjcwNDY4";
        $this->app_delivery_key = "NTJjN2RiOTMtYjBjMy00OGY2LWJmMjEtMzk4OTYyMzdjMmVh";
        $this->app_customer_icon = asset("img/icono_cliente.png");
        $this->app_delivery_icon = asset("img/icono_repartidor.png");
        $this->middleware(function ($request, $next) {
            $this->current_user = auth()->user();

            return $next($request);
        });
	}
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, GeneralFunctions;
}
