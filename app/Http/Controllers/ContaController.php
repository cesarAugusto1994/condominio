<?php

namespace App\Http\Controllers;

use App\Models\{Conta,Contato,Categoria};
use App\Models\Conta\Movimento;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ContaController extends Controller
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

        $contas = Conta::where('condominio_id', $condominio->id)->get();
        return view('admin.contas.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        return view('admin.contas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->request->all();

        $data['condominio_id'] = $user->pessoa->condominio->id;
        $data['ativo'] = (boolean)$request->has('ativo');

        //$data['limite'] = floatval($data['limite']);
        #$data['saldo'] = floatval($data['saldo']);

        /*
        $categoria = Categoria::where('nome','Saldo Inicial')->get();

        if($categoria->isEmpty()) {
          $categoria = Categoria::create(['nome'=>'Saldo Inicial']);
        } else {
          $categoria = $categoria->first();
        }
        */

        $limite = floatval(str_replace(['.',','],['','.'],$request->get('limite')));
        $limite = number_format($limite,2,'.','');

        $data['limite'] = $limite;

        $conta = Conta::create($data);
        /*
        Movimento::create([
            'conta_id' => $conta->id,
            'movimento_tipo_id' => 1,
            'valor' => floatval($data['saldo']),
            'descricao' => 'Saldo Inicial',
            'categoria_id' => $categoria->id
        ]);
        */

        flash('Conta adicionada com sucesso!')->success()->important();

        return redirect()->route('contas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $conta = Conta::uuid($id);

        $user = \Auth::user();
        $condominio = $user->pessoa->condominio->id;

        $movimentosDespesas = Movimento::where('conta_id', $conta->id)
        ->where('movimento_tipo_id', 2)
        ->where('condominio_id',$condominio)
        ->orderBy('data_pagamento')
        ->get();

        $movimentosReceitas = Movimento::where('conta_id', $conta->id)
        ->where('movimento_tipo_id', 1)
        ->where('condominio_id',$condominio)
        ->orderBy('data_pagamento')
        ->get();

        $contatos=Contato::all();

        return view('admin.contas.show', compact('conta','movimentosDespesas','movimentosReceitas','contatos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conta = Conta::uuid($id);

        return view('admin.contas.edit', compact('conta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $conta = Conta::uuid($id);

        $data = $request->request->all();

        $data['ativo'] = !empty($data['ativo']) ? (boolean)$data['ativo'] : false;

        $limite = floatval(str_replace(['.',','],['','.'],$request->get('limite')));
        $limite = number_format($limite,2,'.','');

        $data['limite'] = $limite;

        $conta->update($data);

        flash('Conta atualizada com sucesso.')->success()->important();

        return redirect()->route('contas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conta = Conta::findOrFail($id);

        if($conta->movimentos->isNotEmpty()) {
          return response()->json([
            'code'=>404,
            'message'=>'Não é possivel remover o registro, A conta possui movimentações.',
          ]);
        }

        $conta->delete();

        return response()->json([
          'code'=>200,
          'message'=>'Conta removida com sucesso.',
        ]);
    }
}
