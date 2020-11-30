<?php

namespace App\Models\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    public $table = 'products';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $fillable = ['id'];
    public $incrementing = false;

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }



    public static function getAllData($id){
        $people = People::where('people_id', $people_id)->first();
        $user = User::find($people->id);
        $people['user'] = $user;
        return $people;
    }
}
