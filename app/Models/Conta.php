<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Conta extends Model
{
    use Uuids;

    protected $fillable = ['nome','conta_tipo_id', 'banco_id', 'numero', 'agencia', 'conta', 'condominio_id', 'limite', 'ativo'];

    public function tipo()
    {
        return $this->belongsTo('App\Models\Conta\Tipo', 'conta_tipo_id');
    }

    public function banco()
    {
        return $this->belongsTo('App\Models\Banco');
    }

    public function movimentos()
    {
        return $this->hasMany('App\Models\Conta\Movimento');
    }
}
