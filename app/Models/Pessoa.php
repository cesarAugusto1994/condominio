<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Pessoa extends Model
{
    use Uuids;

    protected $fillable = ['nome', 'email', 'condominio_id'];

    public function condominio()
    {
        return $this->belongsTo('App\Models\Condominio');
    }
}
