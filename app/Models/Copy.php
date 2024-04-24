<?php

namespace App\Models;

use App\Traits\StoresFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Copy extends Model
{
    use HasFactory, SoftDeletes;
    use StoresFile;

    protected $fillable = [
        'book_id',
        'status',
        'quantivy',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
