<?php

namespace App\Models\Conta;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Movimento extends Model
{
    use Uuids;

    protected $table = 'conta_movimentos';

    protected $dates=['data_pagamento'];

    protected $fillable = ['conta_id', 'movimento_tipo_id', 'valor', 'descricao', 'contato_id', 'pago','data_pagamento','categoria_id','condominio_id'];

    public function tipo()
    {
        return $this->belongsTo('App\Models\Movimento\Tipo', 'movimento_tipo_id');
    }

    public function conta()
    {
        return $this->belongsTo('App\Models\Conta', 'conta_id');
    }

    public function contato()
    {
        return $this->belongsTo('App\Models\Contato', 'contato_id');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }

    public function documentos()
    {
        return $this->hasMany('App\Models\Movimento\Documento', 'movimento_id');
    }
}
