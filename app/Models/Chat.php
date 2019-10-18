<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    /**
     * 来源客服
     */
    const AGENT_SERVICER = 'servicer';

    /**
     * 来源访问者
     */
    const AGENT_VISITOR = 'visitor';

}
