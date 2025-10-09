<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    const CACHE_KEY_CATEGORY = 'app:select:category';

    public static function getCachedCategories()
    {
        return Cache::remember(static::CACHE_KEY_CATEGORY, 1440, function(){
            return Category::select('description', 'id')
                ->orderBy('description')
                ->pluck('description', 'id');
        });
    }
}
