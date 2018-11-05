<?php

use Illuminate\Database\Seeder;
use App\Models\Categoria\Grupo;
use App\Models\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = [
          'DESPESAS ADMINISTRATIVAS', 'CONSERVAÇÃO E LIMPEZA', 'SEGURANÇA','CONTAS DE CONSUMO',
          'MANUTENÇÃO PREDIAL','ATIVO IMOBILIZADO','PROJETOS DE MELHORIAS','LAZER & BEM ESTAR'
        ];

        foreach ($itens as $key => $item) {
            $grupo = Grupo::create([
              'nome'=>$item,
            ]);
        }

        $itens = [
          'Salários, encargos e benef.','PPRA / PCMSO','Salários Síndico','Auditoria 2018',
          'Caixa pequeno','Taxa administração','Taxa de assembleia','Taxa emissão de boletos',
          'Localweb domínio', 'Zenia - sms','Site portaria (mens +impl)','Assessoria jurídica',
          'Custas Judiciais','Material de Escritório','Despesas bancárias','Sindicato Patronal',
          'xerox / impressos','Correios','Seguro e ramos','Locação rádios','Rescisões Trabalhistas'
        ];

        foreach ($itens as $key => $item) {
            Categoria::create([
              'nome'=>$item,
              'grupo_id'=>1,
            ]);
        }

        $itens = ['Contrato Cunha','contrato Manolo','Consumo materiais limpeza','Contrato jardinagem','Materiais piscina','Materiais jardins','Dedetização'];

        foreach ($itens as $key => $item) {
            Categoria::create([
              'nome'=>$item,
              'grupo_id'=>2,
            ]);
        }

        $itens = ['CFTV MANUT. INTERSAFE','INFRA CONTROLE DE ACESSO','blindagem guarita','Contrato Protec'];

        foreach ($itens as $key => $item) {
            Categoria::create([
              'nome'=>$item,
              'grupo_id'=>3,
            ]);
        }

        $itens = ['TV assinatura','Energia','Telefone Vivo','Gás','Internet'];

        foreach ($itens as $key => $item) {
            Categoria::create([
              'nome'=>$item,
              'grupo_id'=>4,
            ]);
        }

        $itens = [
          'Rescisões Trabalhistas','Vip System - Sistemas','First Connetion TI',
          'Cabine primária','thyssen','gestway','Veman Manutenção','Gerador',
          'Materiais alvenaria, pintura','Reparos gerais / Equipam.',
          'Material elétrico','Materias Hidraulico'
        ];

        foreach ($itens as $key => $item) {
            Categoria::create([
              'nome'=>$item,
              'grupo_id'=>5,
            ]);
        }

        $itens = ['blindagem portarias'];

        foreach ($itens as $key => $item) {
            Categoria::create([
              'nome'=>$item,
              'grupo_id'=>7,
            ]);
        }

        $itens = [
          'Academia','Academia eventuais',
          'Manut. Salão de festas',
          'Manut. Spas / saunas',
          'Manut. Quadras esportivas',
          'Manut. Churrasqueiras',
          'Manut. Brinquedotecas',
          'Manut.  Play ground'
        ];

        foreach ($itens as $key => $item) {
            Categoria::create([
              'nome'=>$item,
              'grupo_id'=>8,
            ]);
        }
    }
}
