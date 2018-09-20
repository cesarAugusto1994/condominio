<?php

namespace App\Models\Movimento;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Documento extends Model
{
    use Uuids;

    protected $fillable = ['nome','path','movimento_id'];
}
