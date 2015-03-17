<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;
use App\Manuscript;
use Input;
use Session;


class EloquentManuscriptRepository extends AbstractEloquentRepository implements ManuscriptInterface
{

	public function __construct(Manuscript $model, Guard $auth)
	{
		$this->model = $model;
		$this->auth = $auth;
		$this->user = $this->auth->user();
	}

	public function formModify($data, $id = null)
	{
		if($id){
			$manuscript = $this->model->find($id);
		}
		else 
		{
			$manuscript = $this->model;
		}
		
		$data['author_id'] = $this->user->id;
		$manuscript->fill($data);

		if(Session::has('FILE_UPLOAD_SESSION'))

			$manuscript->file = Session::get('FILE_UPLOAD_SESSION');

		$manuscript->save();
		
		return $manuscript;
	}

	public function getById($id, array $with = array()){

		return $this->model->find($id);
	}


	public function getByStatus($status = null){
		switch ($status) {
			case IN_REVIEW:
				
				$data = Manuscript::getDataInReview($this->user);
				break;
			case UNSUBMIT:
				
				break;
			default:
				$data = Manuscript::getDataPublished($this->user, $status);
				break;
		}

		$data['data']->each(function ($manuscript) {
			$manuscript->fullname = $manuscript->last_name .' '. $manuscript->first_name;
			$manuscript->send_at = date("d/m/Y", strtotime($manuscript->send_at));
			$manuscript->process = $manuscript->status;
		});
		// dd($data);
		return $data;
	}

	public function uploadFile(){
		if(doUploadDocument()){
			
			return $_FILES["file"]["name"] . '/' . basename($_FILES["file"]["name"]);
		}

		return '';
	}
}
