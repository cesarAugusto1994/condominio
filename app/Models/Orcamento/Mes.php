<?php

namespace App\Models\Orcamento;

use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    protected $table = 'orcamento_mensal';
    
    protected $fillable = ['mes','saldo', 'gasto', 'resultado', 'orcamento_id'];
}
