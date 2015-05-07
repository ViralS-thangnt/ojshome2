<?php namespace App\Lib\Prototype\Common;

use App\Journal;
use App\Manuscript;
use DB;

trait traitJournal
{

    public function getUnpublishJournal()
    {
         $journals = Journal::where('publish_at', null)->select('id', 'name', 'num')->get();

         if ($journals->isEmpty()){
            return false;
         }

         $result = array();
         foreach ($journals as $value) {
             $result[$value['id']] = $value['name'].' '.$value['num'];
         }

         return $result;
    }

    public function countManuscripts($journal_id)
    {
        return Manuscript::where('pre_journal_id', $journal_id)->count('id');
    }

    public function swapOrderManuscript($id, $order, $new_order)
    {
        $manuscript = Manuscript::where(['pre_journal_id' => $id, 'order' => $order], '=')->get();
        if ($manuscript->isEmpty()) {
            return false;
        }
        $manuscript = $manuscript->first();
        $manuscript->order = $new_order;
        $manuscript->save();

        return $manuscript;
    }

    public function reOrderManuscript($id, $order)
    { 
        return DB::statement("UPDATE `manuscripts` 
                            SET `manuscripts`.`order` = `manuscripts`.`order`-1 
                            WHERE `manuscripts`.`order` >= $order AND `manuscripts`.`pre_journal_id` = $id");
    }

    public function queryUnOrderManuscript($query)
    {
        return $query->whereNull('pre_journal_id');
    }
}