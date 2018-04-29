<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class UserNum extends Model
{
    //自定义关联表名称
    protected $table = 'usernum';

    public $primaryKey = 'id';

    public $timestamps = false;

}
