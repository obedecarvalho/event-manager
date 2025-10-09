<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOwner
{
    public static function bootHasOwner()
    {
        static::creating(function ($model) {
            if (!$model->isDirty('owner_id')) {
                $model->owner_id = auth()->user()->id;
            }
        });
    }

     public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
