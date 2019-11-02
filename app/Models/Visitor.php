<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['visitor_id', 'user_id', 'app_uuid', 'avatar', 'visit_number', 'unread_number', 'name', 'age', 'sex', 'company', 'qq', 'wechat', 'mobile', 'email', 'address', 'remark', 'region', 'ip', 'user_agent', 'lasted_message', 'lasted_at'];


    protected $appends = ['lasted_at', 'lasted_message'];

    public function getLastedAtAttribute()
    {
        return '1 hour ago';
    }

    public function getLastedMessageAttribute()
    {
        return 'lasted message';
    }

    /**
     * 关联客服
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
