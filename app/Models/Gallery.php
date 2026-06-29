<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'member_id',
        'photos',
        'category',
        'caption',
        'date',
        'visibility',
    ];

    protected $casts = [
        'photos' => 'array',
        'date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
