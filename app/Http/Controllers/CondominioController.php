<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Condominio;

class CondominioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        $user = \Auth::user();

        $id = $user->pessoa->condominio->id;

        $condominio = Condominio::findOrFail($id);

        $form = $formBuilder->create(\App\Forms\CondominioForm::class, [
            'method' => 'POST',
            'model' => $condominio,
            'url' => route('condominio.update', $condominio->id)
        ]);

        $form->add('_method', 'hidden', ['value' => 'PUT']);

        return view('admin.condominio.edit', compact('form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Request $request, $id)
    {
        $form = $formBuilder->create(\App\Forms\CondominioForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $condominio = Condominio::findOrFail($id);

        $data = $form->getFieldValues();

        $condominio->update($data);

        flash('Informações atualizadas com sucesso.')->success()->important();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
