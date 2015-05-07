<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use App\Lib\Prototype\Interfaces\ReportInterface;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;

use App\Manuscript;
use App\Journal;
use Input;


class EloquentReportRepository extends AbstractEloquentRepository implements ReportInterface
{
	public function __construct(Manuscript $model, UserInterface $user_repo) 
    {
        $this->model = $model;
        $this->user_repo = $user_repo;
        $this->user = \Auth::user();
    }

    public function getByStatus($status)
    {

    }

    public function checkDateTime($datetime, $input, $range_time)
    {
        if(empty($datetime))
        {
            $datetime = date('d/m/Y', $range_time);
            $obj_time = date_create_from_format("Y/m/d", date('Y/m/d', $range_time));
        }
        else
        {
            $obj_time = date_create_from_format("d/m/Y", $input);
        }

        return ['datetime' => $datetime, 'obj_time' => $obj_time];
    }

    public function getDataReport($start, $end, $status)
    {
        $now = time();
        $in_month = $now - 24*3600*30;   // default: 1 month

        $arr_time = $this->checkDateTime($start, Input::get('start'), $in_month, $now);
        $start = $arr_time['datetime'];
        $obj_start = $arr_time['obj_time'];

        $arr_time = $this->checkDateTime($end, Input::get('end'), $now, $now);
        $end = $arr_time['datetime'];
        $obj_end = $arr_time['obj_time'];

        $permissions = explode(',', \Auth::user()->actor_no);

        switch ($status) {
            case REPORT_REJECTED:  //admin/report/rejected
                $count_manu = $this->getDataReportRejected($obj_start, $obj_end, $permissions);

                break;
            
            case REPORT_SUBMITED: //admin/report/submited
                $count_manu = $this->getDataReportSubmited($obj_start, $obj_end, $permissions, SCREENING);

                break;

            case REPORT_PUBLISH_IN_YEAR: //admin/report/publish
                $arr_time = $this->checkDateTime(Input::get('start'), Input::get('start'), $now - 24*3600*365);
                $start = $arr_time['datetime'];
                $obj_start = $arr_time['obj_time'];

                $count_manu = $this->getDataReportPublishInYear($obj_start, $obj_end, $permissions, SCREENING);

                break;

            case REPORT_REVIEW_LOOP:  //admin/report/rejected
                $count_manu = $this->getDataReportReviewLoop($obj_start, $obj_end, $permissions);

                break;

            case REPORT_WITHDRAWN:  //admin/report/withdraw
                $count_manu = $this->getDataReportWithDrawn($obj_start, $obj_end, $permissions);

                break;

            case REPORT_RATIO_REJECT:  //admin/report/ratio_rejected
                $count_manu = $this->getDataReportRatioRejected($obj_start, $obj_end, $permissions);

                break;

            case REPORT_PUBLISHED_DELINQUENT:  //admin/report/published_delinquent
                $count_manu = $this->getDataJournalPublishedDelinquent($obj_start, $obj_end, $permissions);

                break;

            case REPORT_JOURNAL_IN_YEAR:  //admin/report/published_delinquent
                $arr_time = $this->checkDateTime(Input::get('start'), Input::get('start'), $now - 24*3600*365);
                $start = $arr_time['datetime'];
                $obj_start = $arr_time['obj_time'];

                $count_manu = $this->showJournalPublishInYear($obj_start, $obj_end, $permissions);

                break;

            case REPORT_REVIEW_TIME:  //admin/report/published_delinquent
                $count_manu = $this->showReportReviewTime($obj_start, $obj_end, $permissions);

                break;

            default:
                
                break;
        }
        
        $data = ['start' => $start, 'end' => $end, 'count_manu' => $count_manu];

        return $data;
    }

    public function whereHasUserId($query)
    {
        if(!$query)    

            return null;

        return $query = $query
                    ->whereHas('author', function($q)
                    {
                        $q->orWhere('id', \Auth::user()->id);
                    });
    }

    public function orWhereQuery($query, $field_name, $where_array)
    {
        if(!$query)    

            return null;
        
        return $query = $query->where(function($q) use($field_name, $where_array)
                        {
                            $total = count($where_array);
                            if ($total > 0) 
                            {
                                // $q = $q->where($field_name, $where_array[0]);
                                // for($i = 1; $i < $total; $i++){ 
                                //     $q = $q->orWhere($field_name, $where_array[$i]);
                                // }
                                $q->orWhereIn($field_name, $where_array);
                            }
                            // ($total > 0) ? $q = $q->where($field_name, $where_array[0]) : null;
                        });
    }

    public function relationEditorManuscriptByStage($query, $stage)
    {
        $query = $query->whereHas('editorManuscripts', function($q) use($stage)
        {
            $q->where('stage', $stage);
        });
        
        return $query;
    }

    public function whereBetweenDatetime($query, $field_name, $start_time, $end_time)
    {
        if(!$query)

            return null;

        return $query->where($field_name, '>=', $start_time)
                    ->where($field_name, '<=', $end_time);
    }

    public function getCountRejectedManuscript($start, $end, $status = array(IN_SCREENING_REFUSE), $stage = null)
    {
        $query = Manuscript::with('editorManuscripts');

        // $count = DB::table('manuscripts');
        if ($stage) {
            $query = $this->relationEditorManuscriptByStage($query, $stage);
        }

        $query = $this->whereBetweenDatetime($query, 'updated_at', $start, $end );

        $query = $this->orWhereQuery($query, 'status', $status);

        return $query;
    }

    public function getCountWithdrawnManuscript($start, $end, $status = array(WITHDRAWN), $stage = null)
    {
        $query = Manuscript::with('editorManuscripts');

        if($stage)
           $query = $this->relationEditorManuscriptByStage($query, $stage);
        
        $query = $this->whereBetweenDatetime($query, 'updated_at', $start, $end );

        $query = $this->orWhereQuery($query, 'status', $status);

        return $query;
    }

    public function getCountSubmitedManuscript($start, $end)
    {
        $query = Manuscript::where('status', '<>', UNSUBMIT);
        $query = $this->whereBetweenDatetime($query, 'created_at', $start, $end);
        
        return $query;
    }

    public function getDataReportRejected($start, $end, $permissions, $status = array(IN_SCREENING_REFUSE, IN_REVIEW_REFUSE))//array(REJECT, REVIEW_REJECT))
    {
        // Bản thảo bị từ chối
        // Manuscript Table
        // date_base = created_at  (between $start -> $end)
        // status = REJECT
        // user_id = $user->id (optional)

        $count = $this->getCountRejectedManuscript($start, $end, $status, null);
        
        if(in_array(AUTHOR, $permissions) and $count != null)
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportSubmited($start, $end, $permissions, $stage)
    {
        // Tổng số bản thảo đã gửi
        // Mỗi bản thảo được tạo là 1 lần gửi, gửi nhiều lần 1 bản thảo vẫn chỉ là 1 lần gửi
        // Manuscript Table
        // date_base = created_at  (between $start -> $end)
        // status != UNSUBMIT
        // user_id = $user->id (optional)

        $count = $this->getCountSubmitedManuscript($start, $end);

        if(in_array(AUTHOR, $permissions) and $count != null)
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportPublishInYear($start, $end, $permissions, $stage)
    {   
        // Số bản thảo xuất bản trong vòng 1 năm
        // Manuscript Table
        // status = PUBLISHED(Xuất bản)
        // date_base = updated_at (between $start -> $end)
        // user_id = $user->id (optional)

        $count = Manuscript::whereStatus(PUBLISHED);
        $count = $this->whereBetweenDatetime($count, 'updated_at', $start, $end);
                        
        if(in_array(AUTHOR, $permissions))
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportReviewLoop($start, $end, $permissions)
    {
        // Số vòng phản biện bình quân
        // Tổng Số vòng bình duyệt có phản biện / (Tổng Số bản thảo đang trong tiến trình bình duyệt + đã qua tiến trình bình duyệt)
        $count_has_review = Manuscript::with('editorManuscripts')
                        ->whereHas('editorManuscripts', function($q) use($start, $end)
                        {
                            $q->where('stage', REVIEWING)
                                ->where('decide', REVIEW_ACCEPT);
                            $q = $this->whereBetweenDatetime($q, 'created_at', $start, $end);
                        });

        $count_total = Manuscript::with('editorManuscript')
                        ->whereHas('editorManuscript', function($q) use($start, $end)
                        {
                            $q = $this->orWhereQuery($q, 'stage', [PUBLISHING, EDITING, REVIEWING]);
                            $q = $this->whereBetweenDatetime($q, 'created_at', $start, $end);
                        });

        if(in_array(AUTHOR, $permissions))
        {
            $count_has_review = $this->whereHasUserId($count_has_review);
            $count_total = $this->whereHasUserId($count_total);
        }

        $total = ($count_total) ? $count_total->count() : 0 ;
        $ratio = ($total > 0) ? $count_has_review->count()/$total : 0;

        return (number_format($ratio, 3, '.', ''));
    }

    public function getDataReportWithDrawn($start, $end, $permissions)
    {   
        // Số bản thảo rút nộp
        // Manuscript Table
        // status = WITHDRAWN 
        // date_base = updated_at (between $start -> $end)
        // user_id = $user->id (optional)

        $count = $this->getCountWithdrawnManuscript($start, $end);

        if(in_array(AUTHOR, $permissions))
            $count = $this->whereHasUserId($count);

        return ($count) ? $count->count() : '0';
    }

    public function getDataReportRatioRejected($start, $end, $permissions)
    {   
        // Tỷ lệ từ chối vòng sơ loại = 
        // Tổng bản thảo nhận bị “Từ chối” vòng sơ loại / (Tổng bản thảo gửi - Tổng bản thảo xin rút nộp vòng sơ loại)
        // Tổng bản thảo nhận bị “Từ chối” vòng bình duyệt / (Tổng bản thảo gửi - Tổng bản thảo xin rút nộp vòng bình duyệt)

        // Limit time: $start -> $end
        // Tổng bản thảo gửi trong khoảng thời gian
        // Tổng bản thảo nhận bị “Từ chối” vòng sơ loại 
        // Tổng bản thảo nhận bị “Từ chối" vòng Bình duyệt 
        // Tổng bản thảo xin rút nộp vòng sơ loại
        // Tổng bản thảo xin rút nộp vòng bình duyệt

        // Tổng bản thảo gửi trong khoảng thời gian
        $total_submited = $this->getCountSubmitedManuscript($start, $end);

        // Từ chối sơ loại
        $rejected_screen = $this->getCountRejectedManuscript($start, $end, [IN_SCREENING_REFUSE], [SCREENING]);

        // Từ chối bình duyệt
        $rejected_review = $this->getCountRejectedManuscript($start, $end, [IN_REVIEW_REFUSE], [REVIEWING]);

        // Tổng bản thảo xin rút nộp vòng bình duyệt
        $withdrawn_review = $this->getCountWithdrawnManuscript($start, $end, [WITHDRAWN],[REVIEWING]);

        // Tổng bản thảo xin rút nộp vòng bình duyệt
        $withdrawn_screen = $this->getCountWithdrawnManuscript($start, $end, [WITHDRAWN],[SCREENING]);

        if(in_array(AUTHOR, $permissions))
        {
            $total_submited = ($total_submited) ? $this->whereHasUserId($total_submited) : 0;
            $rejected_review = ($rejected_review) ? $this->whereHasUserId($rejected_review) : 0;
            $rejected_screen = ($rejected_screen) ? $this->whereHasUserId($rejected_screen) : 0;
            $withdrawn_review = ($withdrawn_review) ? $this->whereHasUserId($withdrawn_review) : 0;
            $withdrawn_screen = ($withdrawn_screen) ? $this->whereHasUserId($withdrawn_screen) : 0;
        }

        // number of manuscripts
        $count_total = $total_submited->count();
        $count_rejected_review = $rejected_review->count();
        $count_rejected_screen = $rejected_screen->count();
        $count_withdrawn_review = $withdrawn_review->count();
        $count_withdrawn_screen = $withdrawn_screen->count();

        // check null 
        $actual_total_screen = ($count_total - $count_withdrawn_screen);
        $actual_total_review = ($count_total - $count_withdrawn_review);
        $actual_total = ($count_total - $count_withdrawn_review - $count_withdrawn_review);

        $ratio_reject_review = ($actual_total_review == 0) ? 0 : ($count_rejected_review) / $actual_total_review;
        $ratio_reject_screen = ($actual_total_screen == 0) ? 0 : ($count_rejected_review) / $actual_total_screen;
        $ratio_total = ($actual_total == 0) ? 0 : ($count_rejected_screen + $count_rejected_review) / $actual_total;

        // combine data
        $arr_data = [
                        'data'      => number_format($ratio_total, 3, '.', ''), 
                        'screen'    => number_format($ratio_reject_screen, 3, '.', ''), 
                        'review'    => number_format($ratio_reject_review, 3, '.', '')
                    ];

        return $arr_data;
    }

    public function getDataJournalPublishedDelinquent($start, $end)
    {   
        // Tổng số tạp chí xuất bản không đúng kỳ hạn theo năm
        // Journal Table
        // publish_at < expect_publish_at
        // date_base = created_at (between $start -> $end)

        $count = Journal::whereRaw(' (publish_at < expect_publish_at) ')
                    ->where(function($q) use($start, $end){
                        $q = $this->whereBetweenDatetime($q, 'updated_at', $start, $end);
                    });

        return $count->count();
    }

    public function showJournalPublishInYear($start, $end, $permissions)
    {   
        // Số tạp chí xuất bản trong năm
        // Journal Table
        // date_base = publish_at (between $start -> $end)

        $count = Journal::where(function($q) use($start, $end){
                        $q = $this->whereBetweenDatetime($q, 'publish_at', $start, $end);
                    });
        
        return ($count) ? $count->count() : '0';
    }

    public function showReportReviewTime($start, $end, $permissions)
    {   
        // Thời gian phản biện bình quân
        // Editor Manuscript Table
        // stage = REVIEWING 
        // date_base = updated_at (between $start -> $end)
        // user_id = $user->id (optional)

        $review_time = Manuscript::selectColumns('*')
                        ->with('editorManuscripts')
                        ->whereHas('editorManuscripts', function($q) use($start, $end)
                        {
                            $q->where('stage', REVIEWING);
                            $q = $this->whereBetweenDatetime($q, 'created_at', $start, $end);
                        })
                        ->get();

        $count = 0;
        $total_time = 0;
        foreach ($review_time as $value) {
            foreach ($value->editorManuscripts as $editor_value) {
                $count ++;
                $total_time += strtotime($editor_value['deadline_at']) - strtotime($editor_value['delivery_at']);
            }
        }

        $ratio = ($count != 0) ? $total_time / $count : 0;
        $ratio = $ratio / (3600*24);
        $ratio = number_format($ratio, 2, '.', '');

        return $ratio;
    }

    public function formModify($data, $id = null)
    {
        
    }

}
