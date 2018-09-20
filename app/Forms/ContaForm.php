<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ContaForm extends Form
{
    public function buildForm()
    {
        $arrayBancos=$arrayTipos=[];

        $bancos = \App\Models\Banco::all();

        $arrayBancos[0]='Não possui vinculo com bancos';

        foreach ($bancos as $key => $banco) {
          $arrayBancos[$banco->id]=$banco->nome;
        }

        $tipos = \App\Models\Conta\Tipo::all();

        foreach ($tipos as $key => $tipo) {
          $arrayTipos[$tipo->id]=$tipo->nome;
        }

        $this
            ->add('conta_tipo_id', 'select',[
              'choices' => $arrayTipos,
              'label' => 'Tipo',
            ])
            ->add('banco_id', 'select',[
              'choices' => $arrayBancos,
              'label' => 'Banco',
            ])
            ->add('numero', 'text')
            ->add('agencia', 'text')
            ->add('conta', 'text')
            /*->add('saldo', 'text',[
              'wrapper' => ['class' => 'form-group'],
              'attr' => ['class' => 'form-control money'],
            ])*/
            ->add('limite', 'text',[
              'wrapper' => ['class' => 'form-group'],
              'attr' => ['class' => 'form-control money'],
            ])
            ->add('ativo', 'checkbox',[
              'checked' => true
            ])
            ->add('submit', 'submit', [
              'label' => 'Salvar',
              'attr' => ['class' => 'btn btn-success']
            ]);
    }
}
