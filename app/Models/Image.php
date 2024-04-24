<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    const IMG_EXT = ['pg', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp'];
    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'path',
        'name',
        'extension',
        'description',
    ];

    public function getPathAttribute()
    {
        $path = str_replace('public', 'storage', $this->attributes['path']);
        return  $path;
    }

    public function getTypeAttribute()
    {
        return in_array($this->attributes['extension'], self::IMG_EXT) ? 'image' : 'file';
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
