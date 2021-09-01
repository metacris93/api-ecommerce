<?php

namespace App\Traits;

trait CanbeRated
{
    public function qualifiers($model = null)
    {
        $modelClass = $model ? $model : $this->getMorphClass();
        $morphToMany = $this->morphToMany(
            $modelClass,
            'rateable',
            'ratings',
            'rateable_id',
            'qualifier_id'
        );
        $morphToMany->as('rating')->withTimestamps()->withPivot('score', 'qualifier_type')
            ->wherePivot('qualifier_type', $modelClass)
            ->wherePivot('rateable_type', $this->getMorphClass());
        return $morphToMany;
    }
    public function averageRating($model = null)
    {
        return $this->qualifiers($model)->avg('score') ?: 0.0;
    }
}