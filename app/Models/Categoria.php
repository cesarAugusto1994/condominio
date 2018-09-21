<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Categoria extends Model
{
    use Uuids;

    protected $fillable = ['nome', 'ativo', 'condominio_id','grupo_id'];

    public function movimentos()
    {
        return $this->hasMany('App\Models\Conta\Movimento');
    }
}
