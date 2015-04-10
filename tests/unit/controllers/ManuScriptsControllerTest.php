<?php
/** 
*		created : 1/4/2015
*	    author  : Lanpt
**/

use App\User;
use App\Manuscript;
use App\Lib\Prototype\Interfaces\ManuscriptInterface;
use App\EditorManuscript;
use App\Lib\Prototype\Interfaces\UserInterface as UserReopsitory;

class ManuScriptsControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		$this->mock = \Mockery::mock('App\Lib\Prototype\Interfaces\ManuscriptInterface')->makePartial();	  
		
	}

  	public function tearDown()
	{
		\Mockery::close();
	}


	//*==================== Test ban thao chưa gửi(unsubmit)===========================*/
	/** 
	*	url    : admin/manuscript/unsubmit 
	*	method : GET
	**/

	//author: có quyền truy cập url này
	public function testUnsubmit_Author()
	{
		$user = User::where('actor_no', AUTHOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getColumnTable')->with(UNSUBMIT, AUTHOR);
		$this->call('get', 'admin/manuscript/unsubmit');
		$this->assertResponseOk();
		$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}

	/*screening_editor, managing_editor, chief_editor, section_editor,
	 reviewer_editor, copy_editor, layout_editor, production_editor 
	 không có quyền truy cập url này */

	public function testUnsubmit_ScreeningEditor()
	{
		$user = User::where('actor_no', SCREENING_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getColumnTable')->with(UNSUBMIT, AUTHOR);
		$this->call('get', 'admin/manuscript/unsubmit');
		$this->assertViewHas('message');
	}

	/**
	 * manuscript in-screening
	 */
	
	//author, screening_editor, managing_editor, chief_editor có quyền truy cập url này
	//author
	public function testInScreeningAuthor()
	{
		$user = User::where('actor_no', AUTHOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertResponseOk();
		$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}

	//Screening_editor
	public function testInScreening_ScreeningEditor()
	{
		$user = User::where('actor_no', SCREENING_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertResponseOk();
		$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}

	//Managing_editor
	public function testInScreening_ManagingEditor()
	{
		$user = User::where('actor_no', MANAGING_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertResponseOk();
		$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}

	//Chief_editor
	public function testInScreening_ChiefEditor()
	{
		$user = User::where('actor_no', CHIEF_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertResponseOk();
		$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}

	//section_editor, reviewer_editor, copy_editor, layout_editor, production_editor: không có quyền truy cập url này
	//SECTION_EDITOR
	public function testInScreening_SectionEditor()
	{
		$user = User::where('actor_no', SECTION_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertViewHas('message');
	}

	//REVIEWER
	public function testInScreening_Reviewer()
	{
		$user = User::where('actor_no', REVIEWER)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertViewHas('message');
	}

	//COPY_EDITOR
	public function testInScreening_CopyEditor()
	{
		$user = User::where('actor_no', COPY_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertViewHas('message');
	}

	//LAYOUT_EDITOR
	public function testInScreening_LayoutEditor()
	{
		$user = User::where('actor_no', LAYOUT_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertViewHas('message');
	}

	//PRODUCTION_EDITOR
	public function testInScreening_ProductionEditor()
	{
		$user = User::where('actor_no', PRODUCTION_EDITOR)->first();
		$this->be($user);
		$this->mock->shouldReceive('getByStatus')->with(IN_SCREENING);
		$this->call('get', 'admin/manuscript/in-screening');
		$this->assertViewHas('message');
	}

	// //* =====================================================================================

	/**
	 * manuscript wait-review
	 */
	
	
	//REVIEWER
	public function testWaitReview1()
    {
		$user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertResponseOk();
		$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}
	//AUTHOR
	public function testWaitReview2()
    {
		$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertViewHas('message');	
	}
	//MANAGING_EDITOR
	public function testWaitReview3()
    {
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertViewHas('message');	
	}
	//CHIEF_EDITOR
	public function testWaitReview4()
    {
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertViewHas('message');	
	}
	//SECTION_EDITOR
	public function testWaitReview5()
    {
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertViewHas('message');	
	}
	//ADMIN
	public function testWaitReview6()
    {
		$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertViewHas('message');	
	}
	//COPY_EDITOR
	public function testWaitReview7()
    {
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertViewHas('message');	
	}
	//LAYOUT_EDITOR
	public function testWaitReviewLayoutEditor()
    {
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);

	    $this->mock
			->shouldReceive('waitReview')
			->andReturn();
        $this->call('get', 'admin/manuscript/wait-review');
        $this->assertViewHas('message');	
	}


	/**
	 * manuscript in review
	 */
	//ADMIN
	public function testInReviewAdmin()
    {
		$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('message');
	}
	//AUTHOR
	public function testInReviewAuthor()
    {
		$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);

	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}	
	//MANAGING_EDITOR
	public function testInReviewManagingEditor()
    {		
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}
	//SCREENING_EDITOR
	public function testInReviewScreengEditor()
    {
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('message');  
	}
	//SECTION_EDITOR
	public function testInReviewSectionEditor() 
	{
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}
	//REVIEWER chua lam xong view
	/*public function testInReviewReviewer () {
		$user = User::where('actor_no',REVIEWER)->first();
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}*/
	//CHIEF_EDITOR
	public function testInReviewChiefEditor()
    {
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('result');
		$this->assertViewHas('permissions');
	}
	//COPY_EDITOR
	public function testInReviewCopyEditor()
    {
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('message');  
	}
	//LAYOUT_EDITOR
	public function testInReviewLayoutEditor()
    {
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('message');  
	}
	//PRODUCTION_EDITOR
	public function testInReviewProductionEditor()
    {
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('inReview');
        $this->call('get', 'admin/manuscript/in-review');
       	$this->assertViewHas('message');  
	}
	
	/**
	* report publish 
	* 1 year
	*/
	
	//ADMIN
	public function testReportPublicYear1()
    {
		$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//AUTHOR
	public function testReportPublicYear2()
    {
		$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//MANAGING_EDITOR
	public function testReportPublicYear3()
    {
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//SCREENING_EDITOR
	public function testReportPublicYear4()
    {
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//SECTION_EDITOR
	public function testReportPublicYear5()
    {
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//REVIEWER
	public function testReportPublicYear6()
    {
		$user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//CHIEF_EDITOR
	public function testReportPublicYear7()
    {
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//COPY_EDITOR
	public function testReportPublicYear8()
    {
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//LAYOUT_EDITOR
	public function testReportPublicYear9()
    {
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}
	//PRODUCTION_EDITOR
	public function testReportPublicYear11()
    {
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('showReportPublishInYear');
        $this->call('get', 'admin/report/rejected');
       	$this->assertViewHas('data');  
	}

}
