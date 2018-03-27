<?php

namespace App\Http\Controllers;

use \App\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $menu = 'Notificaciones';
        $actual_date = $this->actual_date;
        $customers = User::where('role_id', 2)->where('status', 1)->get();
        $deliverers = User::where('role_id', 3)->where('status', 1)->get();
        return view('notifications.index', ['menu' => $menu, 'title' => $title, 'customers' => $customers, 'deliverers' => $deliverers, 'start_date' => $actual_date]);
    }

    /**
    * Get the notifications parameters, so, we can decide if send an individual or a general notification. 
    * @return $this->send_notification
    */
    public function get_notification_parameters(Request $req) 
    {
    	$type = $req->type;
		$app_id = $req->applicacion == 1 ? $this->app_customer_id : $this->app_delivery_id;
        $app_key = $req->applicacion == 1 ? $this->app_customer_key : $this->app_delivery_key;
        $app_icon = $req->applicacion == 1 ? $this->app_customer_icon : $this->app_delivery_icon;
		$title = $req->title;
		$content = $req->content;
		$date = $req->date;
		$time = $req->time;
		$data = array("origin" => "api_system");
    	$users_id = $req->users_id;

        return $this->send_notification($type, $app_id, $app_key, $app_icon, $title, $content, $date, $time, $data, $users_id);
    }
}
