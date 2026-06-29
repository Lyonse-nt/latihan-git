<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'member_id',
        'name',
        'description',
        'thumbnail',
        'repository_url',
        'demo_url',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
