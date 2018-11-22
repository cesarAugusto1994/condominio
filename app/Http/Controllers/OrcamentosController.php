<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Orcamento,Categoria};
use App\Models\Orcamento\{Mes, Categoria as OrcamentoCategoria};

class OrcamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orcamentos = Orcamento::paginate(60);
        return view('admin.orcamentos.index',compact('orcamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.orcamentos.create',compact('categorias'));
    }

    public function finish(Request $request)
    {
        $data = $request->request->all();

        $meses = [];
        $mesesString = $request->get('meses');

        if($request->has('meses')) {

          $mesesArray = explode(', ', $request->get('meses'));

          foreach ($mesesArray as $key => $item) {

              $datetime = \DateTime::createFromFormat('m/Y', $item);

              $hasOrcamento = Orcamento::wherehas('categorias', function($query) use ($datetime) {
                  $query->whereHas('meses', function($query) use ($datetime) {
                      $query->where('mes',$datetime->format('m/Y'));
                  });
              })->get();

              if($hasOrcamento->isNotEmpty()) {
                  continue;
              }

              $meses[] = $datetime;
          }

        }

        if(empty($meses)) {
            return redirect()->back();
        }

        $categorias = Categoria::all();

        return view('admin.orcamentos.finish',compact('categorias','meses', 'mesesString'));
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

        if($request->has('meses')) {

          $mesesArray = explode(', ', $request->get('meses'));

          foreach ($mesesArray as $key => $item) {
              $meses[] = \DateTime::createFromFormat('m/Y', $item);
          }

        }

        $categorias = Categoria::all();

        $user = \Auth::user();

        $orcamento = Orcamento::create([
          'user_id'=>$user->id,
          'condominio_id'=>$user->pessoa->condominio->id
        ]);

        foreach ($categorias as $key2 => $categoria) {

            $slugSaldo = 'saldo-'.$categoria->id;
            $slugMeta = 'meta-'.$categoria->id;

            $saldo = floatval(str_replace(['.',','],['','.'],$data[$slugSaldo]));
            $saldo = number_format($saldo,2,'.','');

            $meta = floatval(str_replace(['.',','],['','.'],$data[$slugMeta]));
            $meta = number_format($meta,2,'.','');

            $orcamentoCategoria = OrcamentoCategoria::create([
              'orcamento_id'=>$orcamento->id,
              'saldo'=>$saldo,
              'meta'=>$meta,
              'categoria_id'=>$categoria->id,
            ]);

            foreach ($meses as $key => $mes) {

                $mesFormat = $mes->format('m/Y');
                $slugMes = 'mes-'.$categoria->id .'-'.$mesFormat;

                $mes2 = floatval(str_replace(['.',','],['','.'],$data[$slugMes]));
                $mes2 = number_format($mes2,2,'.','');

                Mes::create([
                  'mes'=>$mesFormat,
                  'saldo'=>$mes2,
                  'orcamento_id'=>$orcamentoCategoria->id
                ]);

            }

        }

        return redirect()->route('orcamentos.index');
    }

    public function categorias($id)
    {
        $orcamento = Orcamento::findOrFail($id);

        //$categorias = $orcamento->categorias;

        return view('admin.orcamentos.categorias',compact('orcamento'));
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
