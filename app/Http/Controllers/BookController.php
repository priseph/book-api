<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * fetches and returns a list of the books that have been added
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return BookResource::collection(Book::with('ratings')->paginate(25));
    }

    /**
     * creates a new book with the ID of the currently authenticated user along with the details of the book, 
     * and persists it to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $book = Book::create([
        'user_id' => $request->user()->id,
        'title' => $request->title,
        'description' => $request->description,
      ]);

      return new BookResource($book);
    }

    /**
     * accepts a Book model and simply returns a book resource based on the specified book.
     *
     * @param  int  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
      return new BookResource($book);
    }

    /**
     * First checks to make sure the user trying to update a book is the owner of the book 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
      // check if currently authenticated user is the owner of the book
      if ($request->user()->id !== $book->user_id) {
        return response()->json(['error' => 'You can only edit your own books.'], 403);
      }

      $book->update($request->only(['title', 'description']));

      return new BookResource($book);
    }

    /**
     * deletes a specified book from the database. 
     *
     * @param  int  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
      $book->delete();

      return response()->json(null, 204);
    }

    //securing the API endpoints
    /*
    *we are exempting the index() and show() methods from using the middleware. 
    *That way, users will be able to see a list of all books and a particular book without needing to be authenticated.
    */
    public function __construct()
    {
      $this->middleware('auth:api')->except(['index', 'show']);
    }
}
