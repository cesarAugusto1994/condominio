<?php

namespace App\Models\Conta;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'conta_tipos';
    
    protected $fillable = ['nome'];
}
