<?php namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;
use Validator;
use App\Lib\Prototype\DbClasses\Eloquent\EloquentBookRepository;
use App\Book;
use App\Lib\Prototype\Interfaces\BookInterface;
class BooksController extends Controller {

protected $bookRepo;

    public function __construct(BookInterface $bookRepo)
    {
        $this->middleware('auth');
        $this->bookRepo = $bookRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $books = $this->bookRepo->all();

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function form($id = null)
    {
        if ($id) 
        {
            $book = $this->bookRepo->getById($id);
        } 
        else 
        {
            $book = $this->bookRepo;
        }

        return view('books.form', compact('book','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(BookRequest $request, $id = null)
    {
        $request->validate();
        $this->bookRepo->formModify(Input::all(), $id);

        return redirect('/book');
    }


}
