<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'group_id',
        'created_user_id',
        'assignee_id',
        'status_id',
        'title',
        'description',
    ];

    public function assignee()
    {
        return $this->hasOne('App\Models\User', 'id', 'assignee_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }
}
