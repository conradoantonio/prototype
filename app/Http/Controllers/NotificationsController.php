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
    * Get the notifications parameters, so, we can decide if send a individual or general notification. 
    * @return $response
    */
    public function get_notification_parameters(Request $req) 
    {
        $mensaje = $req->mensaje;
        $titulo = $req->titulo;
        $dia = $req->fecha;
        $hora = $req->hora;
        $app_id = $req->aplicacion == 1 ? $this->app_customer_id : $this->app_delivery_id;
        $app_key = $req->aplicacion == 1 ? $this->app_customer_key : $this->app_delivery_key;
        $icon = $req->aplicacion == 1 ? $this->app_customer_icon : $this->app_delivery_icon;
        $content = array(
            "en" => $mensaje
        );

        $header = array(
            "en" => $titulo
        );
        
        $fields = array(
            'app_id' => $app_id,
            'included_segments' => array('All'),
            'data' => array("type" => "general"),
            'headings' => $header,
            'contents' => $content,
            'large_icon' => $icon
        );

        if ($dia && $hora) {
            $time_zone = $dia.' '.$hora;
            $time_zone = $this->summer ? $time_zone.' '.'UTC-0500' : $time_zone.' '.'UTC-0600';
            $fields['send_after'] = $time_zone;
        }
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   "Authorization: Basic $app_key"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    /**
    * Envía una notificación a todos los usuarios de la aplicación
    * @return $response
    */
    public function enviar_notificacion_individual(Request $req) 
    {
        $player_ids = array();
        foreach($req->usuarios_id as $id) {
            $row = Usuario::where('id', $id)->first();
            $player_ids [] = $row->player_id;
        }

        $mensaje = $req->mensaje;
        $titulo = $req->titulo;
        $dia = $req->fecha;
        $hora = $req->hora;
        $app_id = $req->aplicacion == 1 ? $this->app_customer_id : $this->app_delivery_id;
        $app_key = $req->aplicacion == 1 ? $this->app_customer_key : $this->app_delivery_key;
        $icon = $req->aplicacion == 1 ? $this->app_customer_icon : $this->app_delivery_icon;

        $content = array(
            "en" => $mensaje
        );

        $header = array(
            "en" => $titulo
        );
        
        $fields = array(
            'app_id' => $app_id,
            'include_player_ids' => $player_ids,
            'data' => array('type' => 'individual'),
            'headings' => $header,
            'contents' => $content,
            'large_icon' => $icon
        );

        if ($dia && $hora) {
            $time_zone = $dia.' '.$hora;
            $time_zone = $this->summer ? $time_zone.' '.'UTC-0500' : $time_zone.' '.'UTC-0600';
            $fields['send_after'] = $time_zone;
        }

        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   "Authorization: Basic $app_key"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}
