<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['visitor_id','user_id','agent','content','received_at'];

    /**
     * 来源客服
     */
    const AGENT_USER = 'user';

    /**
     * 来源访问者
     */
    const AGENT_VISITOR = 'visitor';

    protected $appends = [];

    /**
     * 关联客服
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 关联访客
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitor()
    {
        return $this->belongsTo('App\Models\Visitor','visitor_id','visitor_id');
    }

}
