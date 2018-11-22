<?php

namespace App\Models\Orcamento;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'orcamento_categorias';

    protected $fillable = ['meta','saldo', 'categoria_id', 'orcamento_id'];

    public function meses()
    {
        return $this->hasMany('App\Models\Orcamento\Mes', 'orcamento_id');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }
}
