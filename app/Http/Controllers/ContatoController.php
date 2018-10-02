<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Okipa\LaravelBootstrapTableList\TableList;

class ContatoController extends Controller
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

        $contatos = Contato::where('condominio_id', $condominio->id)->paginate();

        return view('admin.contatos.index', compact('contatos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        return view('admin.contatos.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        $user = $request->user();

        $condominio = $user->pessoa->condominio;

        $data['ativo'] = (boolean)$request->has('ativo');
        $data['condominio_id'] = $condominio->id;

        $contato = Contato::create($data);

        flash('Contato adicionado com sucesso!')->success()->important();

        return redirect()->route('contatos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function show(Contato $contato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder, $id)
    {
        $contato = Contato::findOrFail($id);
        return view('admin.contatos.edit', compact('contato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contato = Contato::findOrFail($id);

        $data = $request->request->all();

        if(!empty($data['aniversario'])) {
          $data['aniversario'] = \DateTime::createFromFormat('d/m/Y', $data['aniversario']);
        }

        if($data['ativo'] != true) {
          $data['ativo'] = false;
        }

        $contato->update($data);

        flash('Contato atualizado com sucesso.')->success()->important();

        return redirect()->route('contatos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contato = Contato::findOrFail($id);
        $contato->delete();

        flash('Contato removido com sucesso.')->success()->important();

        return redirect()->route('contatos.index');
    }
}
