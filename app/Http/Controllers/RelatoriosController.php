<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta\Movimento;
use App\Models\Categoria\Grupo;
use App\Models\{Conta};
use Auth;

class RelatoriosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $condominio = $user->pessoa->condominio;
        $contas = Conta::where('condominio_id', $condominio->id)->get();
        $conta = (int)$request->get('conta');

        $header = $resultadoFooter = $saldoDiario = $resultado = [];
        $movimentoAnterior = $saldoMovimentoAnterior = 0;

        if($request->has('generate')) {

          $first = new \DateTime('first day of this month');
          $last = new \DateTime('last day of this month');

          if($request->filled('start') && $request->filled('end')) {
            $first = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
            $last = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
          }

          $movimentos = Movimento::where('condominio_id', $condominio->id)
          ->where('data_pagamento','<=', $last->format('Y-m-d') . ' 00:00:00')
          ->where('data_pagamento','>=', $first->format('Y-m-d') . ' 23:59:59');

          if($request->filled('conta')) {
              $movimentos->where('conta_id', $conta);
          }

          $movimentos = $movimentos->get();

          $movimentosAnteriorDespesa = Movimento::where('condominio_id', $condominio->id)
          ->where('data_pagamento','<=', $first->format('Y-m-d') . ' 00:00:00')
          ->where('movimento_tipo_id', 2);
          if($request->filled('conta')) {
              $movimentosAnteriorDespesa->where('conta_id', $conta);
          }
          $movimentosAnteriorDespesa = $movimentosAnteriorDespesa->sum('valor');

          $movimentosAnteriorReceita = Movimento::where('condominio_id', $condominio->id)
          ->where('data_pagamento','<=', $first->format('Y-m-d') . ' 00:00:00')
          ->where('movimento_tipo_id', 1);
          if($request->filled('conta')) {
              $movimentosAnteriorReceita->where('conta_id', $conta);
          }
          $movimentosAnteriorReceita = $movimentosAnteriorReceita->sum('valor');

          $movimentoAnterior = $movimentosAnteriorReceita - $movimentosAnteriorDespesa;

          $dias = $first->diff($last)->days;

          $grupos = Grupo::all();

          foreach ($grupos as $key => $grupo) {

            foreach ($grupo->categorias as $key2 => $categoria) {

                $date = $first;

                $header = [];

                foreach (range(0, $dias) as $key3 => $dia) {

                    $total = 0;

                    if($dia > 0) {
                        $date = (new \DateTime($date->format('Y-m-d')))->modify('+1 day');
                    }

                    $dateA = $date->format('d/m/Y');
                    $dateB = $date->format('Ymd');

                    if(!empty($conta)) {

                      $valorReceitas = $categoria->movimentos->filter(function($movimento) use($dateB, $conta) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->conta_id == $conta
                          && $movimento->movimento_tipo_id == 1
                          && $movimento->pago == true;
                      })->sum('valor');

                      $valorDespesas = $categoria->movimentos->filter(function($movimento) use($dateB, $conta) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->conta_id == $conta
                          && $movimento->movimento_tipo_id == 2
                          && $movimento->pago == true;
                      })->sum('valor') * (-1);

                    } else {

                      $valorReceitas = $categoria->movimentos->filter(function($movimento) use($dateB) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->movimento_tipo_id == 1
                          && $movimento->pago == true;
                      })->sum('valor');

                      $valorDespesas = $categoria->movimentos->filter(function($movimento) use($dateB) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->movimento_tipo_id == 2
                          && $movimento->pago == true;
                      })->sum('valor') * (-1);

                    }

                    $valor = $valorReceitas + $valorDespesas;

                    $resultado[$grupo->nome][$categoria->nome][$dateA] = number_format((float)$valor,2,',','.');
                    $header[] = $dateA;

                    $total += $valor;
                    //$saldo = $movimentoAnterior+$valor;

                    $resultadoFooter[$dateA][] = (float)$total;

                    if(isset($saldoDiario[$dateA][$dia])) {
                        //continue;
                    }

                    //$saldoDiario[$dateA][$dia] = (float)$saldo;

                }

            }

          }

          $total = 0;
          $conta = (int)$request->get('conta');
          $date = $first;

          $saldoMovimentoAnterior = $movimentoAnterior;

          foreach (range(0, $dias) as $dia) {

              $saldo = 0;

              if($dia > 0) {
                  $date = (new \DateTime($date->format('Y-m-d')))->modify('+1 day');
              }

              $dateA = $date->format('d/m/Y');
              $dateB = $date->format('Ymd');

              foreach ($grupos as $key => $grupo) {

                foreach ($grupo->categorias as $key2 => $categoria) {

                    if(!empty($conta)) {

                      $valorReceitas = $categoria->movimentos->filter(function($movimento) use($dateB, $conta) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->conta_id == $conta
                          && $movimento->movimento_tipo_id == 1
                          && $movimento->pago == true;
                      })->sum('valor');

                      $valorDespesas = $categoria->movimentos->filter(function($movimento) use($dateB, $conta) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->conta_id == $conta
                          && $movimento->movimento_tipo_id == 2
                          && $movimento->pago == true;
                      })->sum('valor') * (-1);

                    } else {//exit;

                      $valorReceitas = $categoria->movimentos->filter(function($movimento) use($dateB) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->movimento_tipo_id == 1
                          && $movimento->pago == true;
                      })->sum('valor');

                      $valorDespesas = $categoria->movimentos->filter(function($movimento) use($dateB) {
                          return $dateB == $movimento->data_pagamento->format('Ymd')
                          && $movimento->movimento_tipo_id == 2
                          && $movimento->pago == true;
                      })->sum('valor') * (-1);

                    }

                    $saldo += ($valorReceitas + $valorDespesas);

                }

            }

            $saldoMovimentoAnterior = $saldoMovimentoAnterior+$saldo;
            $saldoDiario[$dateA] = number_format((float)$saldoMovimentoAnterior,2,',','.');

          }

        }

        $footer = [];

        foreach ($resultadoFooter as $key => $item) {
            $footer[$key] = number_format((float)array_sum($item),2,',','.');
        }

        $movimentoAnterior = number_format($movimentoAnterior,2,',','.');
        $saldoAtual = number_format($saldoMovimentoAnterior,2,',','.');;

        return view('admin.relatorios.index',compact('contas','resultado', 'header', 'footer', 'saldoDiario','movimentoAnterior','saldoAtual'));
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
    public function update(Request $request, $id)
    {
        //
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
