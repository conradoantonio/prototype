<?php

namespace App\Http\Controllers;

use \App\News;
use \App\Events\PusherEvent;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {
        $title = $menu = "Noticias";
        $news = News::orderBy('id', 'desc')->get();

        if ($req->ajax()) {
            return view('news.table', ['news' => $news]);
        }
        return view('news.index', ['news' => $news, 'menu' => $menu , 'title' => $title]);
    }

    /**
     * Show the form for creating/editing a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($id = 0)
    {
        $title = "Formulario";
        $menu = "Noticias";
        $new = null;
        if ($id) {
            $new = News::find($id);
        }
        return view('news.form', ['new' => $new, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
        $new = New News;

        $img = $this->upload_file($req->file('img'), 'img/news', true);

        $new->title = $req->title;
        $new->content = $req->content;
        $new->img = $img;

        $new->save();

        $data = ['url' => url('admin/noticias'), 'user_id' => $this->current_user->id, 'status' => 'success' ,'msg' => 'Noticia registrada correctamente'];
        event(new PusherEvent($data));
        return response($data, 200);
    }

    /**
     * Edit a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        $new = News::find($req->id);
        if ($new) {
        	$img = $this->upload_file($req->file('img'), 'img/news', true);

	        $new->title = $req->title;
	        $new->content = $req->content;
	        $img ? $new->img = $img : '';

	        $new->save();
            $data = ['url' => url('admin/noticias'), 'user_id' => $this->current_user->id, 'status' => 'success' ,'msg' => 'noticia actualizada correctamente'];
            event(new PusherEvent($data));
	        return response($data, 200);
        }

	    return response(['msg' => 'No se encontró la noticia a editar', 'status' => 'error', 'url' => url('admin/noticias')], 404);
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $req)
    {
        $msg = count($req->ids) > 1 ? 'las noticias' : 'la noticia';
        $news = News::whereIn('id', $req->ids)
        ->get();
        #->delete();
        if ($news) {
            $data = ['url' => url('admin/noticias'), 'user_id' => $this->current_user->id, 'status' => 'success' ,'msg' => 'Éxito cambiando el status de '.$msg];
            event(new PusherEvent($data));
            return response($data, 200);
        } else {
            return response(['msg' => 'Error al cambiar el status de '.$msg, 'status' => 'error', 'url' => url('admin/noticias')], 404);
        }
    }
}
