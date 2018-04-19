<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Post;

class Reply extends Model
{
    //自定义关联表名称
    protected $table = 'reply';
    // 主键非自增时正确显示
    public $incrementing=false;
    // 不添加update_at字段
    public $timestamps = false;
    // 可以自定义主键
    public $primaryKey = 'sReplyID';

    // 定义级联post
    
}
