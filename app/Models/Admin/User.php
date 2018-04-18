<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class User extends Model
{
   	protected $table = 'user';
   	protected $fillable = ['name'];
   	
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}

