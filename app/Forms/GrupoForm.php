<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class GrupoForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('nome', 'text',[
              'attr' => ['class' => 'form-control'],
              'rules' => 'required|max:255',
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
