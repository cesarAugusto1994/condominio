<?php

namespace App\Models\Movimento;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'movimento_tipos';

    protected $fillable = ['nome'];
}
