<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //To avoid getting the mass assignment error which Laravel will throw by default
    protected $fillable = ['book_id', 'user_id', 'rating'];

    /*
    *a book can be rated by various users, 
    *hence a book can have many ratings. 
    *A rating can only belong to one book.
    */
    public function book()
    {
      return $this->belongsTo(Book::class);
    }
}
