<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['visitor_id', 'user_id', 'app_uuid', 'visit_number', 'unread_number', 'name', 'age', 'sex', 'company', 'qq', 'wechat', 'mobile', 'email', 'address', 'remark', 'region', 'ip', 'user_agent', 'lasted_message', 'lasted_at'];
}
