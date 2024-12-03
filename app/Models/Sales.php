<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory;
    protected $table = "Sales";
    public $timestamps = false;
    protected $fillable = ['id','Products_Id', 'ProductBought', 'Amount', 'users_Id'];
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'Products_Id', 'Id');
    }
}
