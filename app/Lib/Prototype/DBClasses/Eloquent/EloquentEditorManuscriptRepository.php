<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Lib\Prototype\Interfaces\EditorManuscriptInterface;
use App\EditorManuscript;
use Input;

class EloquentEditorManuscriptRepository extends AbstractEloquentRepository implements EditorManuscriptInterface
{
    public function __construct(EditorManuscript $model)
    {
        $this->model = $model;
        $this->user = \Auth::user();
    }

    public function formModify($data, $id = null)
    {
        if ($id) {
            $editor_manuscript = $this->model->find($id);
        } else {
            $editor_manuscript = $this->model;
        }

        $editor_manuscript->fill($data);     
        $editor_manuscript->save();

        return $editor_manuscript;
    }
}
