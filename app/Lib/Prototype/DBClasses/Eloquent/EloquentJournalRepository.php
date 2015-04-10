<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\JournalInterface;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Journal;
use Input;
use Session;
use Constant;


class EloquentJournalRepository extends AbstractEloquentRepository implements JournalInterface
{
    public function __construct(Journal $model, Guard $auth)
    {
        $this->model = $model;
        $this->auth = $auth;
        $this->user = $this->auth->user();
    }

    public function getAll()
    {
     
        $col_header = Constant::$journalAll['col_header'];
        $col        = Constant::$journalAll['col'];
        $col_db     = Constant::$journalAll['col_db'];
   
        $journals = Journal::select($col)->get();
                            
         $journals->each(function ($journal) {

            $journal->publish_at = date("Y/m/d", strtotime($journal->publish_at));
            if(!is_null($journal->expect_publish_at))
            {
                $journal->expect_publish_at = date('Y/m/d', strtotime($journal->expect_publish_at));
            }
            
        });
        return array('data' => $journals, 'col_header' => $col_header, 'col_db' => $col_db);
    }

    public function formModify($data, $id = null)
    {
        
        if ($id) {
            $journal = $this->model->find($id);
        } 
        else {
            $journal = $this->model;
        }
        $data['publish_at'] = date('Y-m-d H:i:s', strtotime($data['publish_at']));
        $fileName = isset($data['cover'])? doUpload($data['cover']): '';
        $data['cover'] = $fileName;
        $journal->fill($data);
        $journal->save();
        return $journal;
    }
}
