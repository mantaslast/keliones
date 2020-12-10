<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['email', 'title', 'body', 'order_id', 'send_at', 'sent'];
}
