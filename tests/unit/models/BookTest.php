<?php

// use App\Book;
// use App\Lib\Prototype\DbClasses\Eloquent\EloquentBookRepository;
// class BookTest extends TestCase {

//     /**
//      * A basic functional test example.
//      *
//      * @return void
//      */
//     protected $bookRepo;

//     public function __construct()
//     {
//         $this->input = ['name' => 'test', 'description' => 'test'];
//     }
//     /*
//     Case False

//     public function testFalse()
//     {
//         $this->input = ['nameFalse' => 'test', 'description' => 'test'];
//         $this->testCreateBook();
//     }
//     */

//     public function testCreateBook()
//     {
//         $this->bookRepo = new EloquentBookRepository(new Book);
//         $book = $this->bookRepo->formModify($this->input);
//         $bookOutput = array_only($book->toArray(), array('name','description'));
//         $this->assertEquals($bookOutput, $this->input);
//     }

//     public function testEditBook()
//     {
//         $this->bookRepo = new EloquentBookRepository(new Book);
//         $book = $this->bookRepo->formModify($this->input, 1);
//         $bookOutput = array_only($book->toArray(), array('name','description'));
//         $this->assertEquals($bookOutput, $this->input);
//     }
// }
