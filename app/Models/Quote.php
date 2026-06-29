<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'quote',
        'author',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
