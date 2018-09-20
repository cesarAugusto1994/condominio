<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ContatoForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('nome', 'text',[
              'attr' => ['class' => 'form-control'],
              'rules' => 'required|max:255',
            ])
            ->add('tipo_pessoa', 'select', [
              'label' => 'Tipo',
              'choices' => ['Pessoa Física' => 'Pessoa Física', 'Pessoa Jurídica' => 'Pessoa Jurídica']
            ])
            ->add('categoria', 'select', [
              'label' => 'Categoria',
              'choices' => ['Cliente' => 'Cliente', 'Fornecedor' => 'Fornecedor', 'Funcionário' => 'Funcionário']
            ])
            ->add('cpf_cnpj', 'text', [
              'label' => 'CPF / CNPJ',
            ])
            ->add('email', 'email')
            ->add('telefone', 'text')
            ->add('celular', 'text')
            ->add('endereco', 'text')
            ->add('numero', 'text')
            ->add('complemento', 'text')
            ->add('bairro', 'text')
            ->add('cep', 'text')
            ->add('estado', 'text')
            ->add('cidade', 'text')
            ->add('aniversario', 'text')
            ->add('descricao', 'textarea')
            ->add('ativo', 'checkbox',[
              'checked' => true
            ])
            ->add('submit', 'submit', [
              'label' => 'Salvar',
              'attr' => ['class' => 'btn btn-success']
            ]);
    }
}
