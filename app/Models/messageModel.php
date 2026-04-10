<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['message', 'groupchat_id', 'user_id'])]
class messageModel extends Model
{
    protected $table = 'message';
    protected $primaryKey = 'id';

    public function group()
    {
        return $this->belongsTo(groupModel::class, 'groupchat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
