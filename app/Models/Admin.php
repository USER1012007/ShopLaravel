<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "Products";
    public $timestamps = false;
    protected $fillable = ['Id', 'Name', 'Price', 'AmountAvailable', 'Picture'];
    public function sales()
    {
        return $this->hasMany(Sale::class, 'Products_Id', 'Id');
    }
}
