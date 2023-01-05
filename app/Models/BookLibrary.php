<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookLibrary extends Pivot
{
    use HasFactory;

    protected $fillable = ['book_id', 'library_id', 'created_at'];
    protected $table = 'book_libraries';
}