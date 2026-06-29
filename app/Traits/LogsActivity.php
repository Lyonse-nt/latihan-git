<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity('create', $model);
        });

        static::updated(function ($model) {
            self::logActivity('update', $model);
        });

        static::deleted(function ($model) {
            self::logActivity('delete', $model);
        });
    }

    protected static function logActivity(string $action, $model)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $username = $user ? $user->email : 'System';

        $modelName = class_basename($model);

        // Find a suitable display name for the model
        $displayName = $model->name ?? $model->title ?? $model->quote ?? $model->id;

        // Truncate display name if it is long
        if (strlen($displayName) > 50) {
            $displayName = substr($displayName, 0, 47).'...';
        }

        ActivityLog::create([
            'user_id' => $userId,
            'username' => $username,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'description' => "{$action} {$modelName} '{$displayName}'",
        ]);
    }
}
