<?php namespace App\Helpers;

class ConstantArray
{
	public static $url 				= [
			'manuscript.form'         =>    'admin/manuscript/form/{id?}',
			'unsubmit'				  =>	'admin/manuscript/unsubmit',
			'in-screening'			  =>	'admin/manuscript/in-screening',
			'in-review' 			  =>	'admin/manuscript/in-review',
			'reviewed'				  =>	'admin/manuscript/reviewed',
			'rejected-review'		  =>	'admin/manuscript/rejected-review',
			'in-editing' 			  =>	'admin/manuscript/in-editing',
			'rejected' 				  =>	'admin/manuscript/rejected',
			'withdrawn' 			  =>	'admin/manuscript/withdrawn',
			'published' 			  =>	'admin/manuscript/published',
	];
	public static $author_per       = [
			'admin.manuscript.create'         =>  'admin/manuscript/form',
			'admin.manuscript.unsubmit'       =>  'admin/manuscript/unsubmit',
			'admin.manuscript.inScreening'    =>  'admin/manuscript/in-screening',
			'admin.manuscript.inReview'       =>  'admin/manuscript/in-review',
			'admin.manuscript.inEditing'      =>  'admin/manuscript/in-editing',
			'admin.manuscript.rejected'       =>  'admin/manuscript/rejected',
			'admin.manuscript.withdrawn'      =>  'admin/manuscript/withdrawn',
			'admin.manuscript.published'      =>  'admin/manuscript/published',
			'admin.manuscript.all'				=>	'admin/manuscript/all'
	];
	public static $admin_per            = [
			'admin.user.create'               =>  'admin/user/form',
			'admin.user.index'                =>  'admin/user',
	];
	public static $managing_editor_per	= [
			'admin.manuscript.inScreening'     =>  'admin/manuscript/'.MANAGING_EDITOR_SN.'/in-screening',
			'admin.manuscript.inReview'        =>  'admin/manuscript/'.MANAGING_EDITOR_SN.'/in-review',
			'admin.manuscript.inEditing'       =>  'admin/manuscript/'.MANAGING_EDITOR_SN.'/in-editing',
			'admin.manuscript.rejected'       =>  'admin/manuscript/'.MANAGING_EDITOR_SN.'/rejected',
			'admin.manuscript.withdrawn'      =>  'admin/manuscript/'.MANAGING_EDITOR_SN.'/withdrawn',
			'admin.manuscript.published'      =>  'admin/manuscript/'.MANAGING_EDITOR_SN.'/published',
			'admin.manuscript.all' 			  =>  'admin/manuscript',
	];
	public static $reviewer_per         = [
			'admin.manuscript.rejectedReview'	=>	'admin/manuscript/rejected-review',
			'admin.manuscript.waitReview'		=>	'admin/manuscript/wait_review',			// Chờ phản biện
			'admin.manuscript.unReview'			=>  'admin/manuscript/unreview',			// Không nhận phản biện
			'admin.manuscript.reviewed'			=>  'admin/manuscript/reviewed',			// Đã phản biện
	];
	public static $degree           = [
			BACHELOR                =>  'Bachelor',
			MASTER                  =>  'Master',
			DOCTORAL                =>  'Doctoral',
			ASSOCIATE_PROFESSOR     =>  'Associate Professional',
			PROFESSOR               =>  'Professor',
	];
	public static $academic         = [
			MASTER_ECONOMIC         =>  'Master Economic',
			MASTER_SCIENCE          =>  'Master Science',
			DR_ECONOMIC             =>  'Doctor Economic',
			DR_SCIENCE              =>  'Doctor Science',
	];
	public static $actor            = [
			ADMIN                   => 'Administrator',
			AUTHOR                  => 'Author',
			MANAGING_EDITOR         => 'Managing Editor',
			SCREENING_EDITOR        => 'Screening Editor',
			SECTION_EDITOR          => 'Section Editor',
			REVIEWER                => 'Reviewer',
			CHIEF_EDITOR            => 'Chief Editor',
			COPY_EDITOR             => 'Copy Editor',
			LAYOUT_EDITOR           => 'Layout Editor',
			PRODUCTION_EDITOR       => 'Production Editor',
	];
	public static $actor_register   = [
			AUTHOR                  => 'Author',
			REVIEWER                => 'Reviewer',
	];
	public static $manucript_type   = [
			A                       => 'A',
			B                       => 'B',
			C                       => 'C',
			D                       => 'D',
			E                       => 'E',
	];

	public static $col_header		= [
			'id'						=>  'ID', 
			'send_at'					=>  'Ngày gửi', 
			'name'						=>  'Tên bài', 
			'last_name'					=>  'Tác giả liên hệ', 
			'round_no_review'			=>	'Tiến trình',
			'reviewer'					=>	'Phản biện', 
			'section_editor'			=>	'Biên tập viên chuyên trách', 
			'notify_chief_editor'		=>	'Thông báo tổng biên tập', 
			'round_decide_chief_editor'	=>	'Quyết định của tổng biên tập',
			'round_decide_editor'		=>	'Quyết định của ban biên tập',

	];

	public static $chief_decide = [
		'Đồng ý', 'Từ chối', 'Yêu cầu chỉnh sửa', 'Xuất bản'
	];

	public static $notify_chief_editor = [
		'Đồng ý', 'Từ chối', 'Yêu cầu chỉnh sửa', 'Đề xuất khác', 'Tham khảo tổng biên tập'
	];

	public static $auther_public_view = [
		'col_header'  => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên hệ', 'Tiến trình','File sơ bản', 'File chính bản', 'Sơ xếp' , 'Quyết định xuất bản'],	
		'col_db'      => ['id', 'send_at' , 'name'   , 'fullname'       , 'process'   ,'file_page'  , 'file_final'    , 'publish_pre_no'    , 'num'],
		'col'         => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name','users.last_name','users.first_name', 'manuscripts.status','manuscripts.file_page','manuscripts.file_final','manuscripts.publish_pre_no','journals.num'],
	];

	public static $reviewed = [
		'col_header' => ['ID', 'Ngày mời phản biện', 'Thời hạn phản biện', 'Tên bài', 'Tiến trình', 'Khuyến nghị PB'],	
		'col_db'    => ['id', 'delivery_at'       , 'deadline_at'       ,  'name'  , 'process'   ,'comments'  ],
		'col'        => ['manuscripts.id', 'editor_manuscripts.delivery_at', 'editor_manuscripts.deadline_at','manuscripts.name', 'manuscripts.status','editor_manuscripts.comments'],
	];


	public static $in_review_author = [
		  'col_header'      => ['ID', 	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Quyết định của ban biên tập'],    
		  'col_db'         	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'round_decide_editor'],
		  'col'             => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 'users.last_name',
								   'manuscripts.loop as round_no_review',
								   'editor_manuscripts.decide as round_decide_editor'],
	 ];

	public static $in_review_chief_editor = [
		'col_header' 	=> ['ID',	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Phản biện',	'Biên tập viên chuyên trách',	'Thông báo tổng biên tập',	'Quyết định của tổng biên tập'],	
		'col_db'    	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'reviewer', 	'section_editor', 				'notify_chief_editor', 		'round_decide_chief_editor'],
		'col'        	=> ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 'users.last_name', 'manuscripts.loop as round_no_review',
							'manuscripts.editor_id as reviewer', 'manuscripts.section_editor_id', 'manuscripts.is_chief_review as notify_chief_editor',
							'manuscripts.chief_decide as round_decide_chief_editor'],

							
	];

	public static $in_review_section_editor = [
		'col_header' 	=> ['ID',	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Phản biện',	'Thông báo tổng biên tập',	'Quyết định của tổng biên tập'],	
		'col_db'    	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'reviewer',		'notify_chief_editor', 		'round_decide_chief_editor'],
		'col'        	=> ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 'users.last_name', 'manuscripts.loop as round_no_review',
							'manuscripts.editor_id as reviewer', 'manuscripts.is_chief_review as notify_chief_editor',
							'manuscripts.chief_decide as round_decide_chief_editor'],	
	];

	public static $in_review_manager_editor = [
		'col_header' 	=> ['ID',	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Phản biện',	'Biên tập viên chuyên trách',	'Quyết định của tổng biên tập'],	
		'col_db'    	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'reviewer',		'section_editor', 		'round_decide_chief_editor'],
		'col'        	=> ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 'users.last_name', 'manuscripts.loop as round_no_review',
							'manuscripts.editor_id as reviewer', 'manuscripts.section_editor_id',
							'manuscripts.chief_decide as round_decide_chief_editor'],	
	];

	public static $inScreeningAuthor = [
		'col_header' => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên lạc', 'Tiến trình', 'Quyết định BBT'],	
		'col_db'     => ['id', 'send_at',  'name'  ,'fullname', 'process'   ,'decide'  ],
		'col'        => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name','manuscripts.author_id','manuscripts.current_editor_manuscript_id','manuscripts.editor_id'],
	];

	public static $inScreeningChief = [
		'col_header' => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên lạc', 'Tiến trình','BTV sơ loại', 'Quyết định BTV sơ loại'],
		'col_db'    => ['id', 'send_at',  'name'  ,'fullname', 'process' ,'editor_name','decide'  ],
		'col'        => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name','manuscripts.author_id','manuscripts.current_editor_manuscript_id','manuscripts.editor_id','manuscripts.chief_decide'],
	];

	public static $inScreeningScreengEditor = [
		'col_header' => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên lạc', 'Tiến trình','Ngày giao', 'Quyết định BTV sơ loại'],
		'col_db'    => ['id', 'send_at',  'name'  ,'fullname', 'process' ,'delivery_at','decide'],
		'col'        => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name','manuscripts.author_id','manuscripts.current_editor_manuscript_id','manuscripts.editor_id','manuscripts.chief_decide'],
	];

}
