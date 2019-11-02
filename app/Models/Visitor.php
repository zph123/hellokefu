<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['visitor_id', 'user_id', 'app_uuid', 'visit_number', 'unread_number', 'name', 'age', 'sex', 'company', 'qq', 'wechat', 'mobile', 'email', 'address', 'remark', 'region', 'ip', 'user_agent', 'lasted_message', 'lasted_at'];


    protected $appends = ['avatar', 'lasted_at', 'lasted_message'];


    public function getAvatarAttribute()
    {
        return 'https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png';
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
