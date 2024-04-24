<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', "%name%");
            })->when($request->description, function ($query, $description) {
                return $query->where('description', 'like', "%description%");
            });
    }
}
