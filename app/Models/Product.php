<?php

namespace App\Models;

use App\Traits\CanbeRated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, CanbeRated;

    protected $table = 'products';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    // public function rate(User $user, int $value)
    // {
    //     return $this->rates()->syncWithPivotValues([$user->id], ['value' => $value]);
    // }
}
