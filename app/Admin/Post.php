<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    	//自定义关联表名称
	    public $table = 'post';
	    // 主键非自增时正确显示
	    public $incrementing=false;
	    // 不添加update_at字段
	    public $timestamps = false;
	    // 指定主键名字
	    public $primaryKey = 'sPostID';

	    // 定义级联
	    public function postType(){
	    	return $this->hasOne('App\Admin\PostType','id','sPostTypeID');
	    }
    
}
