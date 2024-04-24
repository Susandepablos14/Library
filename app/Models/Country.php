<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'nationality',
    ];

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function editorials()
    {
        return $this->hasMany(Editorial::class);
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', "%name%");
            })->when($request->nationality, function ($query, $nationality) {
                return $query->where('nationality', 'like', "%nationality%");
            });
    }
}
