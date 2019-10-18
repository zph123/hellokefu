<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    /**
     * 来源客服
     */
    const AGENT_USER = 'user';

    /**
     * 来源访问者
     */
    const AGENT_VISITOR = 'visitor';

}
