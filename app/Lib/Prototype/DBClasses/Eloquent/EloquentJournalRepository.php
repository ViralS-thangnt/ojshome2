<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\JournalInterface;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Journal;
use App\Manuscript;
use Input;
use Session;
use Constant;
use App\Lib\Prototype\Common\traitJournal;
use App\Lib\Prototype\Common\traitManuscript;
use DateTime;

class EloquentJournalRepository extends AbstractEloquentRepository implements JournalInterface
{
    use traitJournal, traitManuscript;

    public function __construct(Journal $model)
    {
        $this->model = $model;
        $this->user = \Auth::user();
    }

    public function getAll($where = false)
    {
    
        $col_header = Constant::$journalAll['col_header'];
        $col        = Constant::$journalAll['col'];
        $col_db     = Constant::$journalAll['col_db'];
        
        if ($where) {
            $journals = $this->model->whereRaw($where)->select($col)->get();
        } else {
            $journals = $this->model->select($col)->get();
        }
                 
         $journals->each(function ($journal) {

            $journal->publish_at = is_null($journal->publish_at) ? '-' : date("Y/m/d", strtotime($journal->publish_at));
            $journal->expect_publish_at = is_null($journal->expect_publish_at) ? '-' : date('Y/m/d', strtotime($journal->expect_publish_at));

            // if(!is_null($journal->expect_publish_at))
            // {
            //     $journal->expect_publish_at = date('Y/m/d', strtotime($journal->expect_publish_at));
            // }
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
        
        $data['publish_at'] = empty($data['publish_at']) ? null : date('Y-m-d H:i:s', strtotime($data['publish_at'])) ;

        if(!empty($data['cover']))
        {
            // $fileName = empty($data['cover']) ? '' : doUpload($data['cover']);
            $data['cover'] = doUpload($data['cover']);
        }
        
        $journal->fill($data);
        $journal->save();

        return $journal;
    }

    public function getPublished()
    {

        return $this->getAll('publish_at IS NOT NULL');
    }

    public function getUnpublish()
    {
        
        return $this->getAll('publish_at IS NULL');
    }

    public function getManuscriptsById($id)
    {
        $data = Manuscript::where('pre_journal_id', $id)
                            ->orderBy('order', 'asc')
                            ->with(['manuscriptFiles' => function($query) {
            $query->ofTypes([PRE_PRINT_FILE, OFFICIAL_FILE]);
        }])->get();


        foreach ($data as $value) {
           $file_beta = getFileByType($value->manuscriptFiles, PRE_PRINT_FILE);
           $file_official = getFileByType($value->manuscriptFiles, OFFICIAL_FILE);
           $value->file_beta = $file_beta ? $file_beta->file_info : '-';
           $value->file_official = $file_official ? $file_official->info : '-';
        }

        return [
            'data'             =>  $data,
            'col_header'       =>  Constant::$tableColumns[PUBLISHED][JOURNALIST]['col_header'],
            'col_db'           =>  Constant::$tableColumns[PUBLISHED][JOURNALIST]['col_result'],
        ];
    }

    public function getUnOrderManuscript()
    {
        //get relate information: author full name
        $relate_data = $this->getRelate('relateUnOrder');
        $data = $this->getDataTable('unOrder', $relate_data, 'queryUnOrderManuscript');

        return $this->getColumnTable('unOrder', $data);
    }

    public function orderManuscript($id, $manuscript_id, $order)
    {
        $manuscript = Manuscript::find($manuscript_id);

        if ($order == 'up') {
            //swap order of this manuscript with prev manuscript
            $this->swapOrderManuscript($id, $manuscript->order - 1, $manuscript->order);
            $manuscript->order = ($manuscript->order > 1) ? $manuscript->order - 1 : $manuscript->order;

        } else {
            //swap order of this manuscript with next manuscript
            $this->swapOrderManuscript($id, $manuscript->order + 1, $manuscript->order);
            $manuscript->order = ($manuscript->order < $this->countManuscripts($id)) ? $manuscript->order + 1 : $manuscript->order;
        }

        $manuscript->save();

        return $manuscript;
    }

    public function removeManuscript($id, $manuscript_id)
    {
        $manuscript = Manuscript::find($manuscript_id);
        //reorder manuscripts after this manuscript
        $this->reOrderManuscript($id, $manuscript->order + 1);
        $manuscript->pre_journal_id = null;
        $manuscript->order = null;
        $manuscript->save();

        return $manuscript;
    }

    public function addManuscript($id, $manuscript_id)
    {
        $manuscript = Manuscript::find($manuscript_id);
        $manuscript->pre_journal_id = $id;
        $manuscript->order = $this->countManuscripts($id) + 1;
        $manuscript->save();

        return $manuscript;
    }
    
    public function deleteJournal($id)
    {
        // if(in_array(CHIEF_EDITOR, explode(',', $this->user->actor_no)))
        if(strpos($this->user->actor_no, (string)CHIEF_EDITOR) >= 0)
        {
            $this->model->withTrashed()->where('id', $id)->delete();

            Session::flash(SUCCESS_MESSAGE, 'Delete journal successfully');
        }
        else
        {

            return view('manuscripts.permission_denied')->withMessage('You can not access this site');
        }
    }
}
