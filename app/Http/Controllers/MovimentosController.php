<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta\Movimento;
use App\Models\Movimento\Documento;
use App\Models\{Conta,Contato,Categoria};

class MovimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data=$request->request->all();

        $valor = floatval(str_replace(['.',','],['','.'],$request->get('valor')));
        $valor = number_format($valor,2,'.','');
        $data['valor']=$valor;

        if($request->has('data')) {
          $data['data_pagamento']=\DateTime::createFromFormat('d/m/Y',$data['data']);
        }

        $user = \Auth::user();
        $data['condominio_id'] = $user->pessoa->condominio->id;

        $movimento = Movimento::create($data);

        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid())
        {
            $nome = $request->arquivo->getClientOriginalName();
            $path = $request->arquivo->store('documentos');

            Documento::create([
              'nome'=>$nome,
              'path'=>$path,
              'movimento_id'=>$movimento->id
            ]);

        }

        flash('Movimentação adicionada com sucesso!')->success()->important();

        return redirect()->route('financeiro.index');
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
        $movimento = Movimento::findOrFail($id);

        $contatos=Contato::all();
        $contas=Conta::all();
        $categorias=Categoria::all();

        return view('admin.financeiro.edit',compact('movimento','contatos','contas','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->request->all();

        $valor = floatval(str_replace(['.',','],['','.'],$request->get('valor')));
        $valor = number_format($valor,2,'.','');
        $data['valor']=$valor;

        if($request->has('data')) {
          $data['data_pagamento']=\DateTime::createFromFormat('d/m/Y',$data['data']);
        }

        $movimento = Movimento::findOrFail($id);
        $movimento->update($data);

        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid())
        {
            $nome = $request->arquivo->getClientOriginalName();
            $path = $request->arquivo->store('documentos');

            Documento::create([
              'nome'=>$nome,
              'path'=>$path,
              'movimento_id'=>$movimento->id
            ]);

        }

        flash('Movimentação atualizada com sucesso!')->success()->important();

        return redirect()->route('financeiro.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movimento = Movimento::findOrFail($id);

        foreach ($movimento->documentos as $key => $documento) {
            if(\Storage::exists($documento->path)) {
                \Storage::delete($documento->path);
            }
            $documento->delete();
        }

        $movimento->delete();

        return response()->json([
          'code'=>200,
          'message'=>'Registro removido com sucesso.'
        ]);

    }

    public function images(Request $request)
    {
        $link = $request->get('link');

        $image = \Storage::exists($link) ? \Storage::get($link) : false;

        if(!$image) {
          return null;
        }

        $mimetype = \Storage::disk('local')->mimeType($link);

        return response($image, 200)->header('Content-Type', $mimetype);
    }

    public function pagar($id)
    {
        $movimento = Movimento::findOrFail($id);

        $movimento->pago = !$movimento->pago;
        $movimento->save();

        return response()->json([
          'code'=>200,
          'message'=>'Registro atualizado com sucesso.'
        ]);
    }

    public function recebimentos()
    {

    }

    public function despesas()
    {

    }
}
