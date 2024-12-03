<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incluye extends Model
{
    protected $table = "Incluye";
    public $timestamps = false;
    protected $fillable = ['Sales_id', 'Total', 'Amount', 'WhenBought'];
}
