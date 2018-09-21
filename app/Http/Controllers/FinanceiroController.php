<?php

namespace App\Http\Controllers;

use App\Financeiro;
use App\Models\{Conta,Contato,Categoria};
use App\Models\Conta\Movimento;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $first=new \DateTime('first day of this month');
        $last=new \DateTime('last day of this month');

        if($request->has('start') && $request->has('end')) {
          $first = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
          $last = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
        }

        $user = \Auth::user();
        $condominio = $user->pessoa->condominio->id;

        $movimentosDespesas = Movimento::where('movimento_tipo_id', 2)
        ->where('data_pagamento','>=',$first)
        ->where('data_pagamento','<=',$last)
        ->where('condominio_id',$condominio)
        ->orderBy('data_pagamento')
        ->get();

        $movimentosReceitas = Movimento::where('movimento_tipo_id', 1)
        ->where('data_pagamento','>=',$first)
        ->where('data_pagamento','<=',$last)
        ->where('condominio_id',$condominio)
        ->orderBy('data_pagamento')
        ->get();

        if($request->has('conta') && !empty($request->get('conta'))) {

            $conta = $request->get('conta');

            $movimentosDespesas = $movimentosDespesas->filter(function($item) use($conta) {
                return $item->conta_id == $conta;
            });

            $movimentosReceitas = $movimentosReceitas->filter(function($item) use($conta) {
                return $item->conta_id == $conta;
            });
        }

        $movimentosDespesasPago = $movimentosDespesas->filter(function($movimento) {
            return $movimento->pago == true;
        });

        $movimentosReceitasPago = $movimentosReceitas->filter(function($movimento) {
            return $movimento->pago == true;
        });

        $recebimento = $movimentosReceitas->sum('valor');
        $recebimento = number_format($recebimento, 2,',','.');

        $despesas = $movimentosDespesas->sum('valor');
        $despesas = number_format($despesas, 2,',','.');

        $previsto=$movimentosReceitas->sum('valor')-$movimentosDespesas->sum('valor');
        $previsto = number_format($previsto, 2,',','.');

        $total=$movimentosReceitasPago->sum('valor')-$movimentosDespesasPago->sum('valor');
        $total = number_format($total, 2,',','.');

        $user=\Auth::user();
        $condominio = $user->pessoa->condominio;

        $contatos=Contato::where('condominio_id', $condominio->id)->get();
        $contas=Conta::where('condominio_id', $condominio->id)->get();
        $categorias=Categoria::where('condominio_id', $condominio->id)->get();

        return view('admin.financeiro.index', compact('contas','movimentosDespesas','movimentosReceitas','contatos','recebimento','despesas','previsto','categorias','total'));
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
     * @param  \App\Financeiro  $financeiro
     * @return \Illuminate\Http\Response
     */
    public function show(Financeiro $financeiro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Financeiro  $financeiro
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.financeiro.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Financeiro  $financeiro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Financeiro $financeiro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Financeiro  $financeiro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Financeiro $financeiro)
    {
        //
    }

    public function info(Request $request)
    {
        $first=new \DateTime('first day of this month');
        $last=new \DateTime('last day of this month');

        if($request->has('start') && $request->has('end')) {
          $first = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
          $last = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
        }

        $user = \Auth::user();
        $condominio = $user->pessoa->condominio->id;

        $movimentosDespesas = Movimento::where('movimento_tipo_id', 2)
        ->where('data_pagamento','>=',$first)
        ->where('data_pagamento','<=',$last)
        ->where('condominio_id',$condominio)
        ->orderBy('data_pagamento')
        ->get();

        $movimentosReceitas = Movimento::where('movimento_tipo_id', 1)
        ->where('data_pagamento','>=',$first)
        ->where('data_pagamento','<=',$last)
        ->where('condominio_id',$condominio)
        ->orderBy('data_pagamento')
        ->get();

        if($request->has('conta') && !empty($request->get('conta'))) {

            $conta = $request->get('conta');

            $movimentosDespesas = $movimentosDespesas->filter(function($item) use($conta) {
                return $item->conta_id == $conta;
            });

            $movimentosReceitas = $movimentosReceitas->filter(function($item) use($conta) {
                return $item->conta_id == $conta;
            });
        }

        $movimentosDespesasPago = $movimentosDespesas->filter(function($movimento) {
            return $movimento->pago == true;
        });

        $movimentosReceitasPago = $movimentosReceitas->filter(function($movimento) {
            return $movimento->pago == true;
        });

        $recebimento = $movimentosReceitas->sum('valor');
        $recebimento = number_format($recebimento, 2,',','.');

        $despesas = $movimentosDespesas->sum('valor');
        $despesas = number_format($despesas, 2,',','.');

        $previsto=$movimentosReceitas->sum('valor')-$movimentosDespesas->sum('valor');
        $previsto = number_format($previsto, 2,',','.');

        $total=$movimentosReceitasPago->sum('valor')-$movimentosDespesasPago->sum('valor');
        $total = number_format($total, 2,',','.');

        return json_encode([
          'recebimento'=>$recebimento,
          'despesas'=>$despesas,
          'previsto'=>$previsto,
          'total'=>$total
        ]);

    }

    public function grafico()
    {
        $resultado=[];

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        foreach (range(0,5) as $key => $item) {

            $start = new \DateTime('first day of this month', new \DateTimeZone( 'America/Sao_Paulo'));
            $end = new \DateTime('last day of this month', new \DateTimeZone( 'America/Sao_Paulo'));

            $start->modify('-'.$item.' month');
            $end->modify('-'.$item.' month');

            $user = \Auth::user();
            $condominio = $user->pessoa->condominio->id;

            $movimentosDespesas = Movimento::where('movimento_tipo_id', 2)
            ->where('data_pagamento','>=',$start)
            ->where('data_pagamento','<=',$end)
            ->where('condominio_id',$condominio)
            ->orderBy('data_pagamento')
            ->get();

            $movimentosReceitas = Movimento::where('movimento_tipo_id', 1)
            ->where('data_pagamento','>=',$start)
            ->where('data_pagamento','<=',$end)
            ->where('condominio_id',$condominio)
            ->orderBy('data_pagamento')
            ->get();

            $recebimento = $movimentosReceitas->sum('valor');
            $recebimento = number_format($recebimento, 2,'.','');

            $despesas = $movimentosDespesas->sum('valor');
            $despesas = number_format($despesas, 2,'.','');

            $resultado[] = [
              'month' => $start->format('M') . ' ' . $start->format('Y'),
              'receitas' => $recebimento,
              'despesas' => $despesas
            ];

        }

        return json_encode(array_reverse($resultado));
    }
}
