<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria\Grupo;
use Kris\LaravelFormBuilder\FormBuilder;
use Okipa\LaravelBootstrapTableList\TableList;

class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $condominio = $user->pessoa->condominio;

        $grupos = Grupo::where('condominio_id', $condominio->id)->orWhere('condominio_id', null)->paginate();

        return view('admin.grupos.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\GrupoForm::class, [
            'method' => 'POST',
            'url' => route('grupos.store')
        ]);

        return view('admin.grupos.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder, Request $request)
    {
        $user = $request->user();

        $form = $formBuilder->create(\App\Forms\GrupoForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();

        $data['condominio_id'] = $user->pessoa->condominio->id;
        $data['ativo'] = (boolean)$request->get('ativo');

        $grupo = Grupo::create($data);

        flash('Grupo adicionado com sucesso!')->success()->important();

        return redirect()->route('grupos.index');
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
    public function edit(FormBuilder $formBuilder, $id)
    {
        $grupo = Grupo::findOrFail($id);

        $form = $formBuilder->create(\App\Forms\GrupoForm::class, [
            'method' => 'POST',
            'model' => $grupo,
            'url' => route('grupos.update', $id),
        ]);

        $form->add('_method', 'hidden', ['value' => 'PUT']);

        return view('admin.grupos.edit', compact('form'));
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
        $form = $formBuilder->create(\App\Forms\GrupoForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $grupo = Grupo::findOrFail($id);

        $data = $form->getFieldValues();

        if($data['ativo'] != true) {
          $data['ativo'] = false;
        }

        $grupo->update($data);

        flash('Grupo atualizado com sucesso.')->success()->important();

        return redirect()->route('grupos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->delete();

        flash('Grupo removido com sucesso.')->success()->important();

        return redirect()->route('grupos.index');
    }
}
