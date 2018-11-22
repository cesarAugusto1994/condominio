<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    protected $table = 'orcamentos';

    protected $fillable = ['inicio','fim', 'ativo', 'user_id', 'condominio_id','ativo'];

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }

    public function categorias()
    {
        return $this->hasMany('App\Models\Orcamento\Categoria');
    }
}
