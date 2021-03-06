<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\Categoria\Grupo;

class CategoriaForm extends Form
{
    public function buildForm()
    {
        $itens = [];
        $grupos = Grupo::all();

        foreach ($grupos as $key => $grupo) {
          $itens[$grupo->id]=$grupo->nome;
        }

        $this
            ->add('nome', 'text',[
              'attr' => ['class' => 'form-control'],
              'rules' => 'required|max:255',
            ])
            ->add('grupo_id', 'select',[
              'choices' => $itens,
              'label' => 'Grupo',
            ])
            ->add('ativo', 'select',[
              'choices' => ['1' => 'Sim', '0' => 'Não'],
            ])
            ->add('submit', 'submit', [
              'label' => 'Salvar',
              'attr' => ['class' => 'btn btn-success']
            ]);
    }
}
