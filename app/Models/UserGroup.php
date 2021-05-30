<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'is_active',
        'created_by',
        'updated_by'
    ];

    /**
     * Find out which group user are in.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_group_members');
    }
}
