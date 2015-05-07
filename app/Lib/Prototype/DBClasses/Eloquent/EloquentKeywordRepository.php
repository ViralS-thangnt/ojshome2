<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\KeywordInterface;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Keyword;
use Input;
use Session;
use Constant;


class EloquentKeywordRepository extends AbstractEloquentRepository implements KeywordInterface
{
    public function __construct(Keyword $model, Guard $auth)
    {
        $this->model = $model;
        $this->auth = $auth;
        $this->user = $this->auth->user();
    }

    public function getAll()
    {
     
        $col_header = Constant::$keywordAll['col_header'];
        $col        = Constant::$keywordAll['col'];
        $col_db     = Constant::$keywordAll['col_db'];
   
        $keywords = Keyword::select($col)->get();
        
        $keywords->each(function ($keyword){
            $keyword->lang_code = Constant::$keyword_type[$keyword->lang_code];
        });
                            
        return array('data' => $keywords, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public function formModify($data, $id = null)
    {
        
        if ($id) {
            $keyword = $this->model->find($id);
        } 
        else {
            $keyword = $this->model;
        }
        $keyword->fill($data);
        $keyword->save();
        
        return $keyword;
    }

    public function deleteKeyword($id)
    {   
        // if(in_array(CHIEF_EDITOR, explode(',', $this->user->actor_no)))
        // dd((string)CHIEF_EDITOR, strpos($this->user->actor_no, (string)CHIEF_EDITOR), $this->user->actor_no);
        if(strpos($this->user->actor_no, (string)CHIEF_EDITOR) >= 0)
        {
            $this->model->withTrashed()->where('id', $id)->delete();

            Session::flash(SUCCESS_MESSAGE, 'Delete keyword successfully');
        }
        else
        {

            return view('manuscripts.permission_denied')->withMessage('You can not access this site');
        }

    }
}
