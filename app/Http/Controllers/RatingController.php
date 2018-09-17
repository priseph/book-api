<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Rating;
use App\Http\Resources\RatingResource;

class RatingController extends Controller
{
    //This is used to rate a specified book
    /*
    *firstOrCreate() which checks if a user has already rated a specified book. 
    *If the user has, we simply return a rating resource based on the rating.
    *if not we add the user rating to the specified book and persist it to the database
    */
    public function store(Request $request, Book $book)
    {
      $rating = Rating::firstOrCreate(
        [
          'user_id' => $request->user()->id,
          'book_id' => $book->id,
        ],
        ['rating' => $request->rating]
      );

      return new RatingResource($rating);
    }
//securing the Rating Endpoint
    public function __construct()
    {
      $this->middleware('auth:api');
    }
}
