<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //To avoid getting the mass assignment error which Laravel will throw by default
    protected $fillable = ['user_id', 'title', 'description'];

    /*Defining relationships between models
    *A user can add as many books as they wish, but a book can only belong to one user
    *the relationship between the User model and Book model is a one-to-many relationship. 
    */
    public function user()
    {
      return $this->belongsTo(User::class);
    }


    /*
    *a book can be rated by various users, 
    *hence a book can have many ratings. 
    *A rating can only belong to one book.
    */
    public function ratings()
    {
      return $this->hasMany(Rating::class);
    }

}
