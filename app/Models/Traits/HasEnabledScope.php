<?php

namespace App\Models\Traits;

trait HasEnabledScope
{
    /**
     * Enabled scope
     */
    public function scopeEnabled($query): void {
        $query->where('is_enabled', true);
    }
}
