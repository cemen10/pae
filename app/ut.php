<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ut extends Model
{
    use Notifiable;
    protected $table = 'ut';
    protected $fillable = ['id', 'ut', 'nit', 'ano', 'contrato'];

}
