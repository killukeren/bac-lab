<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'created_by'])]
class groupModel extends Model
{
    protected $table = 'groupschat';
    protected $primaryKey = 'id';

    public function member()
    {
        return $this->belongsToMany(User::class, 'group_members', 'groupchat_id', 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(messageModel::class, 'groupchat_id');
    }
}
