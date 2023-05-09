<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'admin_id',
        'name',
        'description',
    ];

    public function todos()
    {
        return $this->hasMany('App\Models\Todo', 'group_id', 'id');
    }

    public function members()
    {
        return $this->hasMany('App\Models\MemberGroup', 'group_id', 'id');
    }
}
