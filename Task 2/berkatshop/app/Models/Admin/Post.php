<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $keyType = 'string';
    public $fillable = ['post_id'];
    public $incrementing = false;
}
