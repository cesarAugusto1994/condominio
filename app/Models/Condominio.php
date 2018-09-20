<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Condominio extends Model
{
    use Uuids;
    
    protected $fillable = ['nome', 'endereco', 'cidade', 'estado', 'cep'];
}
