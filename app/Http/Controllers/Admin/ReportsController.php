<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Lib\Prototype\Interfaces\ReportInterface;
use Input;
use Constant;


class ReportsController extends Controller {

	protected $repo;

	public function __construct(ReportInterface $repo)
	{
		$this->middleware('auth');
		$this->repo = $repo;
		$this->user = \Auth::user();
	}

	public function showReport($status)
	{
		if(!in_array(ADMIN, explode(',', $this->user->actor_no)))

			abort(333);

		$data = $this->repo->getDataReport(Input::get('start'), Input::get('end'), $status);
		
		if($status != REPORT_RATIO_REJECT)
			return view('reports.report')
					->withData($data)	// Example: $count->count();
					->withUrl(Constant::$report_url[$status])
					->withReport(Constant::$report[$status])
					->withPermissions(array($this->repo->getPermission()));

		return view('reports.report')
					->withData(['start' => $data['start'], 'end' => $data['end'], 'count_manu' => $data['count_manu']['data']])
					->withScreen($data['count_manu']['screen'])
					->withReview($data['count_manu']['review'])
					->withUrl(Constant::$report_url[$status])
					->withReport(Constant::$report[$status])
					->withPermissions(array($this->repo->getPermission()));
	}

	// Reports
	public function showReportRejected()
	{

		return $this->showReport(REPORT_REJECTED);
	}

	public function showReportSubmited()
	{

		return $this->showReport(REPORT_SUBMITED);
	}

	public function showReportPublishInYear()
	{

		return $this->showReport(REPORT_PUBLISH_IN_YEAR);
	}

	public function showReportReviewLoop()
	{

		return $this->showReport(REPORT_REVIEW_LOOP);
	}

	public function showReportWithdrawn()
	{

		return $this->showReport(REPORT_WITHDRAWN);
	}
	
	public function showReportRatioReject()
	{

		return $this->showReport(REPORT_RATIO_REJECT);
	}

	public function showReportPublishedDelinquent()
	{

		return $this->showReport(REPORT_PUBLISHED_DELINQUENT);
	}

	public function showReportJournalInYear()
	{

		return $this->showReport(REPORT_JOURNAL_IN_YEAR);
	}

	public function showReportReviewTime()
	{

		return $this->showReport(REPORT_REVIEW_TIME);
	}

}
