<?php

namespace App\Models;

use App\Traits\StoresFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Editorial extends Model
{
    use HasFactory, SoftDeletes;
    use StoresFile;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
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
            ->when($request->address, function ($query, $address) {
                return $query->where('address', $address);
            })
            ->when($request->email, function ($query, $email) {
                return $query->where('email', $email);
            });
    }
}
