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

		//$this->mock = \Mockery::mock('App\Lib\Prototype\Interfaces\ManuscriptInterface')->makePartial();	  
		$this->mock = \Mockery::mock('App\Lib\Prototype\DBClasses\Eloquent\EloquentManuScriptRepository')->makePartial();	 

		
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
 	/**
	* with drawn
	* 
	*/
	//ADMIN
	public function testWithDrawn1()
    {
		$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
        $this->assertResponseStatus(333);
	}
	//AUTHOR
	public function testWithDrawn2()
    {
		$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
       	$this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//MANAGING_EDITOR
	public function testWithDrawn3()
    {
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
       	$this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//SCREENING_EDITOR
	public function testWithDrawn4()
    {
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
        $this->assertResponseStatus(333);
	}
	//SECTION_EDITOR
	public function testWithDrawn5()
    {
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
       	$this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//REVIEWER
	public function testWithDrawn6()
    {
		$user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
        $this->assertResponseStatus(333);
	}
	//CHIEF_EDITOR
	public function testWithDrawn7()
    {
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
       	$this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//COPY_EDITOR
	public function testWithDrawn8()
    {
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
        $this->assertResponseStatus(333);
	}
	//LAYOUT_EDITOR
	public function testWithDrawn9()
    {
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
        $this->assertResponseStatus(333);
	}
	//PRODUCTION_EDITOR
	public function testWithDrawn10()
    {
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('withdrawn');
        $this->call('get', 'admin/manuscript/withdrawn');
        $this->assertResponseStatus(333);
	}

	/**
     * reject
     * 
     */
    
    //ADMIN
    public function testReject1()
    {
		$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('message');  
	}
	//AUTHOR
	public function testReject2()
    {
		$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//MANAGING_EDITOR
	public function testReject3()
    {
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//SCREENING_EDITOR
	public function testReject4()
    {
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('message');  
	}
	//SECTION_EDITOR
	public function testReject5()
    {
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//REVIEWER
	public function testReject6()
    {
		$user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('message');  
	}
	//CHIEF_EDITOR
	public function testReject7()
    {
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//COPY_EDITOR
	public function testReject8()
    {
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('message');  
	}
	//LAYOUT_EDITOR
	public function testReject9()
    {
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('message');  
	}
	//PRODUCTION_EDITOR
	public function testReject10()
    {
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('rejected');
        $this->call('get', 'admin/manuscript/rejected');
        $this->assertViewHas('message');  
	}
	
	/**
     * reviewed
     * 
     */
	//ADMIN
	public function testReviewed1()
    {
		$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//AUTHOR
	public function testReviewed2()
    {
		$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//MANAGING_EDITOR
	public function testReviewed3()
    {
		$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//SCREENING_EDITOR
	public function testReviewed4()
    {
		$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//SECTION_EDITOR
	public function testReviewed5()
    {
		$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//REVIEWER
	public function testReviewed6()
    {
		$user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions'); 
	}
	//CHIEF_EDITOR
	public function testReviewed7()
    {
		$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//COPY_EDITOR
	public function testReviewed8()
    {
		$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//LAYOUT_EDITOR
	public function testReviewed9()
    {
		$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}
	//PRODUCTION_EDITOR
	public function testReviewed10()
    {
		$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('reviewed');
        $this->call('get', 'admin/manuscript/reviewed');
        $this->assertViewHas('message');  
	}

	/**
     * post new manuscript
     * 
     */
    public function testCreaterNewManuScript()
    {
		$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
	    $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);
        $this->call('post', 'admin/manuscript/insert');
        $this->assertResponseStatus(500);
	}

	public function testCreaterNewManuScript1()
    {
	    $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);
        $this->call('post', 'admin/manuscript/insert');
        $this->assertResponseStatus(500);
	}
	public function testCreaterNewManuScript2()
    {
    	$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
		Session::start(); // Start a session for the current test
        $params = [
            '_token' => csrf_token(), // Retrieve current csrf token
        ];
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);

        $response = $this->call('POST', 'admin/manuscript/insert', $params);
        $this->assertResponseStatus(500);
        //$this->assertRedirectedTo('/'); 
	}

	public function testCreaterNewManuScript3()
    {
    	$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
		Session::start(); // Start a session for the current test
		//$uploadedFile = new Symfony\Component\HttpFoundation\File\UploadedFile('/tests/test.pdf', 'original-file-name.ext');
		$uploadedFile = Mockery::mock(
        '\Symfony\Component\HttpFoundation\File\UploadedFile',
        [
            'getClientOriginalName'      => 'test.doc',
            'getClientOriginalExtension' => 'doc',
        ]
    );
        $params = array(
				'_token' => csrf_token(),
				"type" => [0 => "1"],
  				"name" => "this is title",
  				"summary_vi" => "Aliquam blandit eget neque non commodo. Cras ut tempor libero. Nam in lectus condimentum, efficitur nunc condimentum, vulputate purus. Etiam finibus ante eget dolor gravida euismod. Suspendisse et sodales risus. Nunc mollis nunc ut elit vehicula bibendum. Duis bibendum metus tortor, vel porta quam imperdiet eu. Curabitur pulvinar viverra aliquam. Donec pretium efficitur tortor eget interdum.
				    Donec sed orci congue, malesuada mi ac, finibus lorem. Morbi pretium tristique lorem a bibendum. Integer elementum diam nec blandit faucibus. Curabitur aliquam, libero sed mollis luctus, nulla urna gravida odio, sed vulputate arcu erat eget nisi. Integer quam diam, efficitur eget sem malesuada, fermentum fringilla diam. Aenean aliquet mollis urna quis porta. Etiam dapibus in dolor consequat mattis. Aliquam nunc libero, luctus et posuere vitae, sollicitudin et tortor. Mauris cursus vehicula metus, non euismod mauris maximus a. Morbi eleifend sed orci eu ultrices. Maecenas nec volutpat nibh, ultricies ultricies velit. Pellentesque aliquet scelerisque metus, eu tincidunt dui sagittis nec. Nam in feugiat nibh, et pulvinar tortor.",
  				"keyword_vi" => [0 => "1",1 => "2",2 => "3", 3 => "4",4 => "5",],
  				"summary_en" => "Aliquam blandit eget neque non commodo. Cras ut tempor libero. Nam in lectus condimentum, efficitur nunc condimentum, vulputate purus. Etiam finibus ante eget dolor gravida euismod. Suspendisse et sodales risus. Nunc mollis nunc ut elit vehicula bibendum. Duis bibendum metus tortor, vel porta quam imperdiet eu. Curabitur pulvinar viverra aliquam. Donec pretium efficitur tortor eget interdum.
    				Donec sed orci congue, malesuada mi ac, finibus lorem. Morbi pretium tristique lorem a bibendum. Integer elementum diam nec blandit faucibus. Curabitur aliquam, libero sed mollis luctus, nulla urna gravida odio, sed vulputate arcu erat eget nisi. Integer quam diam, efficitur eget sem malesuada, fermentum fringilla diam. Aenean aliquet mollis urna quis porta. Etiam dapibus in dolor consequat mattis. Aliquam nunc libero, luctus et posuere vitae, sollicitudin et tortor. Mauris cursus vehicula metus, non euismod mauris maximus a. Morbi eleifend sed orci eu ultrices. Maecenas nec volutpat nibh, ultricies ultricies velit. Pellentesque aliquet scelerisque metus, eu tincidunt dui sagittis nec. Nam in feugiat nibh, et pulvinar tortor.",
  				"keyword_en" =>[0 => "6",1 => "7",2 => "8", 3 => "9",4 => "10",],
  				"topic" => "Aliquam blandit eget neque non commodo. Cras ut tempor libero. Nam in lectus condimentum, efficitur nunc condimentum, vulputate purus. Etiam finibus ante eget dolor gravida euismod. Suspendisse et sodales risus. Nunc mollis nunc ut elit vehicula bibendum. Duis bibendum metus tortor, vel porta quam imperdiet eu. Curabitur pulvinar viverra aliquam. Donec pretium efficitur tortor eget interdum.
    				Donec sed orci congue, malesuada mi ac, finibus lorem. Morbi pretium tristique lorem a bibendum. Integer elementum diam nec blandit faucibus. Curabitur aliquam, libero sed mollis luctus, nulla urna gravida odio, sed vulputate arcu erat eget nisi. Integer quam diam, efficitur eget sem malesuada, fermentum fringilla diam. Aenean aliquet mollis urna quis porta. Etiam dapibus in dolor consequat mattis. Aliquam nunc libero, luctus et posuere vitae, sollicitudin et tortor. Mauris cursus vehicula metus, non euismod mauris maximus a. Morbi eleifend sed orci eu ultrices. Maecenas nec volutpat nibh, ultricies ultricies velit. Pellentesque aliquet scelerisque metus, eu tincidunt dui sagittis nec. Nam in feugiat nibh, et pulvinar tortor.",
  				"propose_reviewer" => " Aliquam blandit eget neque non commodo. Cras ut tempor libero. Nam in lectus condimentum, efficitur nunc condimentum, vulputate purus. Etiam finibus ante eget dolor gravida euismod. Suspendisse et sodales risus. Nunc mollis nunc ut elit vehicula bibendum. Duis bibendum metus tortor, vel porta quam imperdiet eu. Curabitur pulvinar viverra aliquam. Donec pretium efficitur tortor eget interdum.  
    				Donec sed orci congue, malesuada mi ac, finibus lorem. Morbi pretium tristique lorem a bibendum. Integer elementum diam nec blandit faucibus. Curabitur aliquam, libero sed mollis luctus, nulla urna gravida odio, sed vulputate arcu erat eget nisi. Integer quam diam, efficitur eget sem malesuada, fermentum fringilla diam. Aenean aliquet mollis urna quis porta. Etiam dapibus in dolor consequat mattis. Aliquam nunc libero, luctus et posuere vitae, sollicitudin et tortor. Mauris cursus vehicula metus, non euismod mauris maximus a. Morbi eleifend sed orci eu ultrices. Maecenas nec volutpat nibh, ultricies ultricies velit. Pellentesque aliquet scelerisque metus, eu tincidunt dui sagittis nec. Nam in feugiat nibh, et pulvinar tortor.",
  				"expect_journal_id" => "23",
  				"author_comments" => " Aliquam blandit eget neque non commodo. Cras ut tempor libero. Nam in lectus condimentum, efficitur nunc condimentum, vulputate purus. Etiam finibus ante eget dolor gravida euismod. Suspendisse et sodales risus. Nunc mollis nunc ut elit vehicula bibendum. Duis bibendum metus tortor, vel porta quam imperdiet eu. Curabitur pulvinar viverra aliquam. Donec pretium efficitur tortor eget interdum.
   				Donec sed orci congue, malesuada mi ac, finibus lorem. Morbi pretium tristique lorem a bibendum. Integer elementum diam nec blandit faucibus. Curabitur aliquam, libero sed mollis luctus, nulla urna gravida odio, sed vulputate arcu erat eget nisi. Integer quam diam, efficitur eget sem malesuada, fermentum fringilla diam. Aenean aliquet mollis urna quis porta. Etiam dapibus in dolor consequat mattis. Aliquam nunc libero, luctus et posuere vitae, sollicitudin et tortor. Mauris cursus vehicula metus, non euismod mauris maximus a. Morbi eleifend sed orci eu ultrices. Maecenas nec volutpat nibh, ultricies ultricies velit. Pellentesque aliquet scelerisque metus, eu tincidunt dui sagittis nec. Nam in feugiat nibh, et pulvinar tortor.",
  				"co_author" => "Aliquam blandit eget neque non commodo. Cras ut tempor libero. Nam in lectus condimentum, efficitur nunc condimentum, vulputate purus. Etiam finibus ante eget dolor gravida euismod. Suspendisse et sodales risus. Nunc mollis nunc ut elit vehicula bibendum. Duis bibendum metus tortor, vel porta quam imperdiet eu. Curabitur pulvinar viverra aliquam. Donec pretium efficitur tortor eget interdum.
    				Donec sed orci congue, malesuada mi ac, finibus lorem. Morbi pretium tristique lorem a bibendum. Integer elementum diam nec blandit faucibus. Curabitur aliquam, libero sed mollis luctus, nulla urna gravida odio, sed vulputate arcu erat eget nisi. Integer quam diam, efficitur eget sem malesuada, fermentum fringilla diam. Aenean aliquet mollis urna quis porta. Etiam dapibus in dolor consequat mattis. Aliquam nunc libero, luctus et posuere vitae, sollicitudin et tortor. Mauris cursus vehicula metus, non euismod mauris maximus a. Morbi eleifend sed orci eu ultrices. Maecenas nec volutpat nibh, ultricies ultricies velit. Pellentesque aliquet scelerisque metus, eu tincidunt dui sagittis nec. Nam in feugiat nibh, et pulvinar tortor.",
  				"policy" => "English Đây là nội dung và điều khoản của ban biên tập...",
  				"confirm" => "1",
  				"status" => "1",
  				"file" => $uploadedFile,
			); 
		$this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);
        $response = $this->call('POST', 'admin/manuscript/insert', $params);
        //$this->assertResponseStatus(302);  
       // dd($response->getContent());
        //$this->assertEquals('Hello ' . $params['name'], $response->getContent());
	}

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
	//
	
	/**
	 * all
	 */
	

	//ADMIN
	public function testAll1()
    {
    	$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);
        $response = $this->call('get', 'admin/manuscript/all');
        $this->assertResponseOk();
        $this->assertViewHas('message');
	}
	//AUTHOR
	public function testAll2()
    {
    	$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);
        $response = $this->call('get', 'admin/manuscript/all');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//MANAGING_EDITOR
	public function testAll3()
    {
    	$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);
        $response = $this->call('get', 'admin/manuscript/all');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//SCREENING_EDITOR
	//SECTION_EDITOR
	public function testAll5()
    {
    	$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/all');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//REVIEWER
	//CHIEF_EDITOR
	public function testAll7()
    {
    	$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/all');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//COPY_EDITOR
	public function testAll8()
    {
    	$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/all');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//LAYOUT_EDITOR
	//PRODUCTION_EDITOR
	
	/**
	 * report journal
	 */
	
	//ADMIN
	public function testReportJournal1()
    {
    	$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/report/journal');
        $this->assertResponseOk();
        $this->assertViewHas('data');  
       	$this->assertViewHas('permissions');
	}
	//AUTHOR
	
	//MANAGING_EDITOR
	//SCREENING_EDITOR
	//SECTION_EDITOR
	//REVIEWER
	//CHIEF_EDITOR
	//COPY_EDITOR
	//LAYOUT_EDITOR
	//PRODUCTION_EDITOR
	
	/**
	 * admin/report/review_loop
	 */
	
	//ADMIN
	public function testReviewLoop1()
    {
    	$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/report/review_loop');
        $this->assertResponseOk();
        $this->assertViewHas('data');  
       	$this->assertViewHas('permissions');
	}
	//AUTHOR
	//MANAGING_EDITOR
	//SCREENING_EDITOR
	//SECTION_EDITOR
	//REVIEWER
	//CHIEF_EDITOR
	//COPY_EDITOR
	//LAYOUT_EDITOR
	//PRODUCTION_EDITOR
	

	/**
	 * admin/report/review_time
	 */
	
	//ADMIN
	public function testReviewTime()
    {
    	$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('update')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/report/review_time');
        $this->assertResponseOk();
        $this->assertViewHas('data');  
       	$this->assertViewHas('permissions');
	}
	//AUTHOR
	//MANAGING_EDITOR
	//SCREENING_EDITOR
	//SECTION_EDITOR
	//REVIEWER
	//CHIEF_EDITOR
	//COPY_EDITOR
	//LAYOUT_EDITOR
	//PRODUCTION_EDITOR
	

	/**
	 * admin/manuscript/published
	 */
	
	//ADMIN
	public function testPublished1()
    {
    	$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//AUTHOR
	public function testPublished2()
    {
    	$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//MANAGING_EDITOR
	public function testPublished3()
    {
    	$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//SCREENING_EDITOR
	public function testPublished4()
    {
    	$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
         $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//SECTION_EDITOR
	public function testPublished5()
    {
    	$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//REVIEWER
	public function testPublished6()
    {
    	$user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
         $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//CHIEF_EDITOR
	public function testPublished7()
    {
    	$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//COPY_EDITOR
	public function testPublished8()
    {
    	$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//LAYOUT_EDITOR
	public function testPublished9()
    {
    	$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//PRODUCTION_EDITOR
	public function testPublished10()
    {
    	$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('published')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/published');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}

	/**
	 * admin/manuscript/rejected-review
	 */
	
	//ADMIN
	public function testRejectedReview1()
    {
    	$user = User::where('actor_no',ADMIN)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//AUTHOR
	public function testRejectedReview2()
    {
    	$user = User::where('actor_no',AUTHOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//MANAGING_EDITOR
	public function testRejectedReview3()
    {
    	$user = User::where('actor_no',MANAGING_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//SCREENING_EDITOR
	public function testRejectedReview4()
    {
    	$user = User::where('actor_no',SCREENING_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//SECTION_EDITOR
	public function testRejectedReview5()
    {
    	$user = User::where('actor_no',SECTION_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//REVIEWER
	public function testRejectedReview6()
    {
    	$user = User::where('actor_no',REVIEWER)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
        $this->assertViewHas('result');  
       	$this->assertViewHas('permissions');
	}
	//CHIEF_EDITOR
	public function testRejectedReview7()
    {
    	$user = User::where('actor_no',CHIEF_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//COPY_EDITOR
	public function testRejectedReview8()
    {
    	$user = User::where('actor_no',COPY_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//LAYOUT_EDITOR
	public function testRejectedReview9()
    {
    	$user = User::where('actor_no',LAYOUT_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
	//PRODUCTION_EDITOR
	public function testRejectedReview10()
    {
    	$user = User::where('actor_no',PRODUCTION_EDITOR)->first(); 
        $this->be($user);
        $this->mock
			 ->shouldReceive('rejectedReview')
			 ->andReturn($this->mock);

        $response = $this->call('get', 'admin/manuscript/rejected-review');
        $this->assertResponseOk();
       	$this->assertViewHas('message');
	}
}
