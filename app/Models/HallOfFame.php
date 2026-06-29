<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HallOfFame extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'hall_of_fames';

    protected $fillable = [
        'member_id',
        'category',
        'winner_name',
        'year',
        'photo',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
