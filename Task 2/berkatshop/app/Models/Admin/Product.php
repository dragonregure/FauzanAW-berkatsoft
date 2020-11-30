<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $fillable = ['id'];
    public $incrementing = false;
}
