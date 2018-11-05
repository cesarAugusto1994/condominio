<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Kris\LaravelFormBuilder\FormBuilder;

class CategoriasController extends Controller
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

        $categorias = Categoria::where('condominio_id', $condominio->id)->orWhere('condominio_id', null)->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\CategoriaForm::class, [
            'method' => 'POST',
            'url' => route('categorias.store')
        ]);

        return view('admin.categorias.create', compact('form'));
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

        $form = $formBuilder->create(\App\Forms\CategoriaForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $form->getFieldValues();

        if($data['ativo'] != true) {
          $data['ativo'] = false;
        }

        $user = $request->user();
        $condominio = $user->pessoa->condominio;
        $data['condominio_id'] = $condominio->id;

        $categoria = Categoria::create($data);

        flash('Categoria adicionada com sucesso!')->success()->important();

        return redirect()->route('categorias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $form = $formBuilder->create(\App\Forms\CategoriaForm::class, [
            'method' => 'POST',
            'model' => $categoria,
            'url' => route('categorias.update', $id),
        ]);

        $form->add('_method', 'hidden', ['value' => 'PUT']);

        return view('admin.categorias.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, Request $request, $id)
    {
        $form = $formBuilder->create(\App\Forms\CategoriaForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $categoria = Categoria::findOrFail($id);

        $data = $form->getFieldValues();

        if($data['ativo'] != true) {
          $data['ativo'] = false;
        }

        $categoria->update($data);

        flash('Categoria atualizada com sucesso.')->success()->important();

        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if($categoria->movimentos->isNotEmpty()) {
          return response()->json([
            'code'=>404,
            'message'=>'Não é possivel remover o registro, Esta categoria possui movimentações.',
          ]);
        }

        $categoria->delete();

        return response()->json([
          'code'=>200,
          'message'=>'Categoria removida com sucesso.',
        ]);
    }
}
