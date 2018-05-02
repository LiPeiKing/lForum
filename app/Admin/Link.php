<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //自定义关联表名称
	public $table = 'link';
	    // 主键非自增时正确显示
	public $incrementing=false;
	    // 不添加update_at字段
	public $timestamps = false;
	    // 指定主键名字
	public $primaryKey = 'sLinkID';
}
