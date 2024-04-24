<?php

namespace App\Models;

use App\Traits\StoresFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory, SoftDeletes;
    use StoresFile;

    protected $fillable = [
        'name',
        'biography',
        'birthdate',
        'country_id'
    ];

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', "%name%");
            })
            ->when($request->biography, function ($query, $biography) {
                return $query->where('biography', $biography);
            });
    }
}
