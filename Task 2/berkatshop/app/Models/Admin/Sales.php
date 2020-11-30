<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    public $table = 'sales';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $fillable = ['id'];
    public $incrementing = false;
}
