<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Contato extends Model
{
    use Uuids;

    protected $fillable = ['nome', 'tipo_pessoa', 'categoria', 'cpf_cnpj', 'email', 'telefone', 'celular', 'endereco', 'numero',
        'complemento', 'bairro', 'cep', 'estado', 'cidade', 'aniversario', 'descricao', 'ativo', 'condominio_id'
    ];
}
