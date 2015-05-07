<?php
use App\Journal;
use App\User;
use App\Lib\Prototype\DBClasses\Eloquent\EloquentJournalRepository;

class JournalTest extends TestCase {

	protected $repo;
	protected $data;
	protected $edit;

	public function __construct ()
	{	

       	$this->data = [
       		"name" => "this is journal title 1",
			"num" => "12",
			"publish_at" => "2015/05/26",
			"expect_publish_at" => "2015/05/15",
       	];
       	$this->edit = [
       		"publish_at" => "2015/05/26",
			"num" => "12",
       	];

	}
	/**
     *  test journal modify ( create / edit)
     */
    //ADMIN
	//AUTHOR
	//MANAGING_EDITOR
	//SCREENING_EDITOR
	//SECTION_EDITOR
	//REVIEWER
	//CHIEF_EDITOR
	//COPY_EDITOR
	//LAYOUT_EDITOR
	//PRODUCTION_EDITOR
	public function testJournalModify1()
    {
        $user = User::where('actor_no',PRODUCTION_EDITOR)->first();
        $this->be($user);    	
        $this->repo   = new EloquentJournalRepository(new Journal);

    	$result = $this->repo->formModify($this->data);

        $this->assertEquals($this->data['name'], $result->name);
        $this->assertEquals($this->data['num'], $result->num);
    }

	public function testJournalModify2()
    {
        $user = User::where('actor_no',PRODUCTION_EDITOR)->first();
        $this->be($user);    	
        $this->repo   = new EloquentJournalRepository(new Journal);

    	$result = $this->repo->formModify($this->edit, 20);

        $this->assertEquals($this->data['num'], $result->num);
    }


    /**
     *  test journal delete
     */
    //ADMIN
	//AUTHOR
	//MANAGING_EDITOR
	//SCREENING_EDITOR
	//SECTION_EDITOR
	//REVIEWER
	//CHIEF_EDITOR
	//COPY_EDITOR
	//LAYOUT_EDITOR
	//PRODUCTION_EDITOR
	public function testJournalDelete()
    {
        
    	$user = User::where('actor_no',PRODUCTION_EDITOR)->first();
        $this->be($user);    	
        $this->repo   = new EloquentJournalRepository(new Journal);
        $id = Journal::get()->random()->id;
    	$result = $this->repo->delete($id);
        $this->assertEquals($result, 1);
    }


}