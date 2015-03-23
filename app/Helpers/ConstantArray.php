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
			'wait-review'			  =>	'admin/manuscript/wait-review',
			'all'			  		  =>	'admin/manuscript/all',
			'report-rejected'		  =>	'admin/report/rejected',
			'get_all'			  	  =>    'admin/manuscript/get_all'
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
			'admin.manuscript.all'			  =>  'admin/manuscript/all'
	];
	public static $admin_per            = [
			'admin.user.create'               =>  'admin/user/form',
			'admin.user.index'                =>  'admin/user',
			'admin.manuscript.all'			  =>  'admin/manuscript/all'
	];
	public static $managing_editor_per	= [
			'admin.manuscript.inScreening'     =>  'admin/manuscript/in-screening',
			'admin.manuscript.inReview'        =>  'admin/manuscript/in-review',
			'admin.manuscript.inEditing'       =>  'admin/manuscript/in-editing',
			'admin.manuscript.rejected'       =>  'admin/manuscript/rejected',
			'admin.manuscript.withdrawn'      =>  'admin/manuscript/withdrawn',
			'admin.manuscript.published'      =>  'admin/manuscript/published',
			'admin.manuscript.all' 			  =>  'admin/manuscript',
	];
	public static $section_editor_per 		=	[
		'admin.manuscript.inReview'        =>  'admin/manuscript/in-review',
		'admin.manuscript.inEditing'       =>  'admin/manuscript/in-editing',
		'admin.manuscript.rejected'       =>  'admin/manuscript/rejected',
		'admin.manuscript.withdrawn'      =>  'admin/manuscript/withdrawn',
		'admin.manuscript.published'      =>  'admin/manuscript/published',
		'admin.manuscript.all' 			  =>  'admin/manuscript',
	];
	public static $layout_editor_per	=	[
		'admin.manuscript.inEditing'       =>  'admin/manuscript/in-editing',
		'admin.manuscript.published'      =>  'admin/manuscript/published',
		'admin.manuscript.all' 			  =>  'admin/manuscript',
	];
	public static $reviewer_per         = [
			'admin.manuscript.waitReview'		=>	'admin/manuscript/wait-review',			// Chờ phản biện
			'admin.manuscript.unReview'			=>  'admin/manuscript/unreview',			// Không nhận phản biện
			'admin.manuscript.reviewed'			=>  'admin/manuscript/reviewed',			// Đã phản biện
			'admin.manuscript.rejectedReview'	=>	'admin/manuscript/rejected-review',     // Không nhận phản biện
	];
	public static $copy_editor_per 		= [
			'admin.manuscript.inEditing'      =>  'admin/manuscript/in-editing',
			'admin.manuscript.published'      =>  'admin/manuscript/published',
			'admin.manuscript.all' 			  =>  'admin/manuscript',
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

	// Stage of manuscript in Editor Manuscript
	public static $process			= ['-', 'Sơ loại', 'Bình duyệt', 'Biên tập', 'Xuất bản'];

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

	//reviewer decide 
	public static $is_review = [
		0 			=> 		'Không nhận phản biện',
		1			=> 		'Nhận phản biện'
	];

	// chief decide
	public static $chief_decide = [
		'-', 'Chấp nhận, Từ chối, Yêu cầu chỉnh sửa, Gửi phản biện lại'
	];

	// Screen editor decide
	public static $editor_decide = [
		'-', 'Đồng ý', 'Từ chối', 'Yêu cầu chỉnh sửa'
	];

	// editor notify to chief editor
	public static $notify_chief_editor = [
		'-', 'Đã thông báo', 'Chưa thông báo',
	];

	// reviewer decide
	public static $reviewer_decide = [
		'-', 'Từ chối', 'Chấp nhận', 'Yêu cầu chỉnh sửa', 'Gửi phản biện lại',
	];

	public static $auther_public_view = [
		'col_header'  => ['ID', 'Ngày gửi','Tên bài','Tên tạp chí' ,'Số tạp chí','Ngày đăng tạp chí'],
		'col_db'      => ['id', 'send_at' , 'name'  ,'journal_name','num'       , 'publish_at'],
		'manuscripts' => ['id', 'send_at' , 'name'  ,'publish_journal_id'],
		'journal'     => ['id','name','num','publish_at'],
	];
// nguoi phan bien  'ban thao da phan bien'
	public static $reviewer = [
		'col_header'=> ['ID', 'Ngày mời PB',  'Tên bài', 'Tiến trình', 'Khuyến nghị PB','Quyết định BBT'],	
		'col_db'    => ['id', 'delivery_at'    ,  'name'  , 'process'   ,'decide' ,'section_editor_decide' ],
		'col'       => ['id', 'name', 'status','current_editor_manuscript_id'],
	];
// admin lay ra tat ca cac ban thao
	public static $adminAll = [
		'col_header'=> ['ID',  'Tên bài', 'Tiến trình'],	
		'col_db'    => ['id',  'name'  , 'process'  ],
		'col'       => ['id', 'name', 'status'],
	];

	public static $in_review_author = [
		  'col_header'      => ['ID', 	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Quyết định của ban biên tập'],    
		  'col_db'         	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'round_decide_editor'],
		  'col'             => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 
		  						'manuscripts.author_id', 'manuscripts.current_editor_manuscript_id', 'manuscripts.editor_id', 'manuscripts.chief_decide',],
	 ];

	public static $in_review_chief_editor = [
		'col_header' 	=> ['ID',	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Phản biện',	'Biên tập viên chuyên trách',	'Thông báo tổng biên tập',	'Quyết định của tổng biên tập'],	
		'col_db'    	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'reviewer', 	'section_editor', 				'notify_chief_editor', 		'round_decide_chief_editor'],
		'col'             => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 
		  						'manuscripts.author_id', 'manuscripts.current_editor_manuscript_id', 'manuscripts.section_editor_id', 'manuscripts.chief_decide', 'manuscripts.editor_id', 'manuscripts.is_chief_review',],
	];

	public static $in_review_section_editor = [
		'col_header' 	=> ['ID',	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Phản biện',	'Thông báo tổng biên tập',	'Quyết định của tổng biên tập'],	
		'col_db'    	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'reviewer',		'notify_chief_editor', 		'round_decide_chief_editor'],
		'col'           => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 
		  						'manuscripts.author_id', 'manuscripts.current_editor_manuscript_id', 'manuscripts.editor_id', 'manuscripts.chief_decide', 'manuscripts.is_chief_review'],
	];

	public static $in_review_manager_editor = [
		'col_header' 	=> ['ID',	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Phản biện',	'Biên tập viên chuyên trách',	'Quyết định của tổng biên tập'],	
		'col_db'    	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'reviewer',		'section_editor', 				'round_decide_chief_editor'],
		'col'             => ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 
		  						'manuscripts.author_id', 'manuscripts.current_editor_manuscript_id', 'manuscripts.section_editor_id', 'manuscripts.chief_decide', 'manuscripts.is_chief_review'],
	];

	public static $inScreeningAuthor = [
		'col_header' => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên lạc', 'Tiến trình', 'Quyết định BBT'],	
		'col_db'     => ['id', 'send_at',  'name'  ,'fullname', 'process'   ,'decide'  ],
		'col'        => ['id', 'send_at', 'name','author_id','current_editor_manuscript_id','editor_id','section_editor_id'],
	];

	public static $inScreeningChief = [
		'col_header' => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên lạc', 'Tiến trình','BTV sơ loại', 'Quyết định BTV sơ loại'],
		'col_db'    => ['id', 'send_at',  'name'  ,'fullname', 'process' ,'editor_name','decide'  ],
		'col'        => ['id', 'send_at', 'name','author_id','current_editor_manuscript_id','editor_id'],
	];

	public static $inScreeningScreengEditor = [
		'col_header' => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên lạc', 'Tiến trình','Ngày giao', 'Quyết định BTV sơ loại'],
		'col_db'    => ['id', 'send_at',  'name'  ,'fullname', 'process' ,'delivery_at','decide'],
		'col'        => ['id', 'send_at', 'name','author_id','current_editor_manuscript_id','editor_id'],
	];

	public static $inRejected = [
		'col_header' => ['ID', 'Ngày gửi', 'Tên bài', 'Tác giả liên lạc', 'Tiến trình', 'Nhà phản biện', 'BTV chuyên trách','Quyết định TBT'],
		'col_db'    => ['id', 'send_at',  'name'  ,'fullname', 'process' ,'editor_name','section_editor_name' ,'decide' ],
		'col'        => ['id', 'send_at', 'name','author_id','current_editor_manuscript_id','editor_id','section_editor_id','status'],
	];

	public static $withdrawn = [
		'col_header' 	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tác giả liên lạc',	'Tiến trình cuối cùng',	'Ngày rút nộp', 'Quyết định cuối của BTV',	'Quyết định cuối của TBT'],
		'col_db'    	=> ['id', 'send_at',  	'name'  ,	'last_name', 		'round_no_review' ,		'withdrawn_at',	'editor_decide',			'editor_chief_decide'],
		'col'        	=> ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name','manuscripts.author_id', 'manuscripts.chief_decide'],
	];

	public static $wait_review = [
		'col_header' 	=> ['ID', 'Ngày mời phản biện',	'Thời hạn phản biện',	'Tên bài',	'Tiến trình',		'Khuyến nghị phản biện'],
		'col_db'    	=> ['id', 'delivery_at',  		'deadline_at'  ,		'name', 	'round_no_review' ,	'decide'],
		'col'        	=> ['id', 'name'],
	];


	public static $rejectedReview = [
		'col_header' 	=> ['ID', 'Ngày mời phản biện', 'Tên bài', 'Phản hồi của PB', 'Ngày phản hồi'],
		'col_db'		=> ['id', 'delivery_at', 'name', 'is_review', 'time_response'],
		'col'			=> ['id', 'name', 'is_review', 'editor_id','current_editor_manuscript_id']
	];

	public static $all = [
		'col_header' 	=> ['ID',	'Tên bài',	'Tác giả',		'Ngày gửi',	'Tiến trình',	'Vòng cuối'],
		'col_db'    	=> ['id',	'name', 	'last_name',	'send_at', 	'process' ,		'last_round'],
		'col'        	=> ['id', 'name', 'send_at', 'status'],
	];

	//========================QUAN DT============================/

	public static $tableColumns = [
		UNSUBMIT 		=>		[
				AUTHOR 		=>	[
						'col_header'   => ['ID', 'admin.lastModified', 'admin.mnsName', 'admin.authorName'],
						'col_result'   => ['id', 'updated_at', 'name', 'author_full_name'],
						'col_select'   => ['id', 'updated_at', 'name', 'author_id'],
						'col_relate'     => ['author' => 'full_name'],	
				],
		],
		IN_EDITING 		=>		[
				COPY_EDITOR =>	[
						'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
						'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'revise', 'print_out', 'pre_public'],
						'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id'],
						'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
				],
				SECTION_EDITOR =>	[
						'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
						'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'revise', 'print_out', 'pre_public'],
						'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id'],
						'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
				],
				LAYOUT_EDITOR =>	[
						'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.printOut', 'admin.prePublic'],
						'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'print_out', 'pre_public'],
						'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id'],
						'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
				],
				MANAGING_EDITOR =>	[
						'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.SeName','admin.revise', 'admin.printOut', 'admin.prePublic'],
						'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'seEditor_full_name','revise', 'print_out', 'pre_public'],
						'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'section_editor_id'],
						'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process', 'seEditor' => 'full_name'],
				],
				CHIEF_EDITOR =>	[
						'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.SeName','admin.revise', 'admin.printOut', 'admin.prePublic'],
						'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'seEditor_full_name','revise', 'print_out', 'pre_public'],
						'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'section_editor_id'],
						'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process', 'seEditor' => 'full_name'],
				],
				AUTHOR =>	[
						'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
						'col_result' 	=> ['id', 'send_at', 'name', 'process', 'revise', 'print_out', 'pre_public'],
						'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'current_editor_manuscript_id'],
						'col_relate'	=> ['editorManuscript' => 'process'],
				],
		],
	];

	public static $relateColSelect = [
		UNSUBMIT 		=>	[
				AUTHOR 		=>	[
						'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
				],
		],
		IN_EDITING 		=>	[
				COPY_EDITOR	=>	[
					'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
					'editorManuscript'	=>	['stage', 'loop', 'id'],
				],
				SECTION_EDITOR	=>	[
					'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
					'editorManuscript'	=>	['stage', 'loop', 'id'],
				],
				LAYOUT_EDITOR	=>	[
					'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
					'editorManuscript'	=>	['stage', 'loop', 'id'],
				],
				MANAGING_EDITOR	=>	[
					'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
					'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
					'editorManuscript'	=>	['stage', 'loop', 'id'],
				],
				CHIEF_EDITOR	=>	[
					'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
					'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
					'editorManuscript'	=>	['stage', 'loop', 'id'],
				],
				AUTHOR 		=>	[
					'editorManuscript'	=>	['stage', 'loop', 'id'],
				],
		],	
	];

	public static $stage = [
		SCREENING 	=>	'admin.ScreeningStage',
		REVIEWING	=>	'admin.ReviewingStage',
		EDITING 	=>	'admin.EditingStage',
		PUBLISHING  =>	'admin.PublishingStage',
	];

	public static $require_permission = [
		IN_EDITING 	=>	[COPY_EDITOR, SECTION_EDITOR, LAYOUT_EDITOR, MANAGING_EDITOR, CHIEF_EDITOR, AUTHOR],
	];

	//========================QUAN DT============================/

}
