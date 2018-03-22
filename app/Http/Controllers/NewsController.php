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

        return response(['msg' => 'Nueva noticia registrada correctamente', 'status' => 'success', 'url' => url('admin/noticias')], 200);
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
            event(new PusherEvent(['url' => url('admin/noticias'), 'user_id' => auth()->user()->id, 'message' => 'Refresh that table bro!']));
	        return response(['msg' => 'noticia actualizada correctamente', 'status' => 'success', 'url' => url('admin/noticias')], 200);
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
        ->delete();

        if ($news) {
            event(new PusherEvent(['url' => url('admin/noticias'), 'user_id' => auth()->user()->id, 'message' => 'Refresh that table bro!']));
            return response(['msg' => 'Éxito cambiando el status de '.$msg, 'status' => 'success', 'url' => url('admin/noticias')], 200);
        } else {
            return response(['msg' => 'Error al cambiar el status de '.$msg, 'status' => 'error', 'url' => url('admin/noticias')], 404);
        }
    }
}
