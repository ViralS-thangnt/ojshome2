<?php namespace App\Lib\Prototype\Common;

use App\Manuscript;
use Constant;

trait traitManuscript
{
    //return data rows and columns heading for display  table in view
    public function getColumnTable($table, $data)
    {
        $config = Constant::$$table;

        return [
            'data'             =>  $data,
            'col_header'       =>  $config['col_header'],
            'col_db'           =>  $config['col_result'],
        ];
    }

    //get data rows for table
    public function getDataTable($table, $relates, $callback = '')
    {
        $config = Constant::$$table;
        $col = $config['col_select'];
        $relate_cols = $config['col_relate'];

        $query = Manuscript::select($col)
                             ->with($relates);
        //check if has query condition
        $query = ($callback == '') ? $query : $this->$callback($query);

        $data = $this->mergeRelateCol($relate_cols, $query->get());

        return $data;

    }

    //merge data from relate table
    public function mergeRelateCol($relate_cols, $data)
    {
        foreach ($data as $value) {
            foreach ($relate_cols as $relate => $col) {
                $property = $relate.'_'.$col;
                $value->$property = is_object($value->$relate) ? $value->$relate->$col : '';
            }
        }

        return $data;
    }

    //get data from relate table
    public function getRelate($relateTable, $callback = '')
    {
        $relates = Constant::$$relateTable;

        $result = array();
        foreach ($relates as $key => $value) {
            $result[$key] = function($query) use ($value, $callback) {
                $query = ($callback == '') ? $query->select($value) : $this->$callback($query);
            };
        }

        return $result;
    }
}