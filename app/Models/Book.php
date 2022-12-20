<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'year', 'author_id', 'created_at'];

    public function author()
    {
        return $this->belongsTo(Author::class)->withDefault([
            'name' => 'NOT FOUND',
            'birthday' => '1111-01-01',
            'genre' => 'NOT FOUND',
        ]);
    }

    public function libraries()
    {
        return $this->belongsToMany(Library::class, 'book_libraries')->using(
            BookLibrary::class
        );
    }
}