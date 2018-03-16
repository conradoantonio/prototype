<?php

namespace App\Http\Controllers;

use \App\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
	/**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {
        $title = $menu = "Faqs";
        $faqs = Faq::orderBy('id', 'desc')->get();

        if ($req->ajax()) {
            return view('faqs.table', ['faqs' => $faqs]);
        }
        return view('faqs.index', ['faqs' => $faqs, 'menu' => $menu , 'title' => $title]);
    }

    /**
     * Show the form for creating/editing a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($id = 0)
    {
        $title = "Formulario";
        $menu = "Faqs";
        $faq = null;
        if ($id) {
            $faq = Faq::find($id);
        }
        return view('faqs.form', ['faq' => $faq, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
        $faq = New Faq;

        $img = $this->upload_file($req->file('img'), 'img/faqs', true);

        $faq->question = $req->question;
        $faq->answer = $req->answer;
        $faq->img = $img;

        $faq->save();

        return response(['msg' => 'Nueva pregunta frecuente registrada correctamente', 'status' => 'success', 'url' => url('admin/faqs')], 200);
    }

    /**
     * Edit a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        $faq = Faq::find($req->id);
        if ($faq) {
        	$img = $this->upload_file($req->file('img'), 'img/faqs', true);

	        $faq->question = $req->question;
	        $faq->answer = $req->answer;
	        $img ? $faq->img = $img : '';

	        $faq->save();

	        return response(['msg' => 'Pregunta frecuente actualizada correctamente', 'status' => 'success', 'url' => url('admin/faqs')], 200);
        }

	    return response(['msg' => 'No se encontró la pregunta frecuente a editar', 'status' => 'error', 'url' => url('admin/faqs')], 404);
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $req)
    {
        $msg = count($req->ids) > 1 ? 'las preguntas' : 'la pregunta';
        $faqs = Faq::whereIn('id', $req->ids)
        ->get();
        //->delete();
        //->update(['status' => $req->status]);

        if ($faqs) {
            return response(['msg' => 'Éxito cambiando el status de '.$msg, 'status' => 'success', 'url' => url('admin/faqs')], 200);
        } else {
            return response(['msg' => 'Error al cambiar el status de '.$msg, 'status' => 'error', 'url' => url('admin/faqs')], 404);
        }
    }
}
