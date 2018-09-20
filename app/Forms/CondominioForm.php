<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CondominioForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('nome', 'text',[
              'attr' => ['class' => 'form-control'],
              'rules' => 'required|max:255',
            ])

            ->add('endereco', 'text',[
              'attr' => ['class' => 'form-control'],
            ])
            ->add('cidade', 'text',[
              'attr' => ['class' => 'form-control'],
            ])
            ->add('estado', 'text',[
              'attr' => ['class' => 'form-control'],
            ])
            ->add('cep', 'text',[
              'attr' => ['class' => 'form-control'],
            ])

            ->add('submit', 'submit', [
              'label' => 'Salvar',
              'attr' => ['class' => 'btn btn-success']
            ]);
    }
}
