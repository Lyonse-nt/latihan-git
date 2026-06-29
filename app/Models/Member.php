<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'nickname',
        'role',
        'bio',
        'date_of_birth',
        'photo',
        'instagram',
        'github',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function hallOfFames()
    {
        return $this->hasMany(HallOfFame::class);
    }
}
