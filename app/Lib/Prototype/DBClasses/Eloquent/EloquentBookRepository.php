<?php
namespace App\Lib\Prototype\DBClasses\Eloquent;

use App\Lib\Prototype\Interfaces\BookInterface;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Book;

class EloquentBookRepository extends AbstractEloquentRepository implements BookInterface
{
    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function formModify($data, $id = null)
    {
        if($id)
        {
            $book = $this->model->find($id);
        }
        else 
        {
            $book = $this->model;
        }

        $book->fill($data);
        $book->save();

        return $book;
    }
}
