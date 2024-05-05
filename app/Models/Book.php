<?php

namespace App\Models;

use App\Traits\StoresFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    use StoresFile;

    protected $fillable = [
        'title',
        'description',
        'author_id',
        'editorial_id',
        'category_id',
        'publication_date',
    ];

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }


    public function copies()
    {
        return $this->hasMany(Copy::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->title, function ($query, $title) {
                return $query->where('title', 'like', "%title%");
            })
            ->when($request->description, function ($query, $description) {
                return $query->where('description', $description);
            });
    }
}
