<?php

namespace App\Models\Categoria;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupo_categorias';

    protected $fillable = ['nome', 'ativo', 'condominio_id'];
}
