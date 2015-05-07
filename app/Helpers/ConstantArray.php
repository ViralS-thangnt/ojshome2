<?php namespace App\Helpers;
use Illuminate\Support\Facades\Lang;

class ConstantArray
{
	public static $url 				= [
			'manuscript.form'         =>    'admin/manuscript/form/{id?}',
			'manuscript.update'		  =>	'admin/manuscript/form/{id}',
			'manuscript.insert' 	  => 	'admin/manuscript/insert/',
			'manuscript.withdrawn' 	  => 	'admin/manuscript/withdrawn',

			'editor.manuscript.form'  =>	'admin/editor-manuscript/form/{manuscript_id}/{id?}',
			'editor.manuscript.update'  =>	'admin/editor-manuscript/form/{manuscript_id}/{id?}',
			'editor.manuscript.update-editor'  =>	'admin/editor-manuscript/form/{manuscript_id}/{id}',

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
			'get_all'			  	  =>    'admin/manuscript/get_all',
			
			'report-rejected'		  =>	'admin/report/rejected',
			'report-submited'		  =>	'admin/report/submited',
			'report-publish-in-year'  =>	'admin/report/publish',
			'report-review-loop'	  =>	'admin/report/review_loop',
			'report-withdrawn'	  	  =>	'admin/report/withdraw',
			'report-ratio-reject'	  =>	'admin/report/ratio_rejected',
			'report-published-delinquent' =>	'admin/report/published_delinquent',	// xuất bản không đúng hạn
			'report-journal-in-year'  =>	'admin/report/journal',
			'report-review-time'	  =>	'admin/report/review_time',

			'download-file'			  =>	'admin/editor/download-file/',
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
			// 'admin.manuscript.all'			  =>  'admin/manuscript/all',
			// 'admin.jounal.create'			  =>  'admin/journal/form',
			// 'admin.jounal.all'				  =>  'admin/journal',
			// 'admin.keyword.create'			  =>  'admin/keyword/form',
			// 'admin.keyword.all'				  =>  'admin/keyword',
	];
	public static $managing_editor_per	= [
			'admin.manuscript.inScreening'     =>  'admin/manuscript/in-screening',
			'admin.manuscript.inReview'        =>  'admin/manuscript/in-review',
			'admin.manuscript.inEditing'       =>  'admin/manuscript/in-editing',
			'admin.manuscript.rejected'       =>  'admin/manuscript/rejected',
			'admin.manuscript.withdrawn'      =>  'admin/manuscript/withdrawn',
			'admin.manuscript.published'      =>  'admin/manuscript/published',
			'admin.manuscript.all' 			  =>  'admin/manuscript/all',
	];
	public static $section_editor_per 		=	[
		'admin.manuscript.inReview'        =>  'admin/manuscript/in-review',
		'admin.manuscript.inEditing'       =>  'admin/manuscript/in-editing',
		'admin.manuscript.rejected'       =>  'admin/manuscript/rejected',
		'admin.manuscript.withdrawn'      =>  'admin/manuscript/withdrawn',
		'admin.manuscript.published'      =>  'admin/manuscript/published',
		'admin.manuscript.all' 			  =>  'admin/manuscript/all',
	];
	public static $layout_editor_per	=	[
		'admin.manuscript.inEditing'       =>  'admin/manuscript/in-editing',
		'admin.manuscript.published'      =>  'admin/manuscript/published',
		// 'admin.manuscript.all' 			  =>  'admin/manuscript/all',
	];
	public static $reviewer_per         = [
			'admin.manuscript.waitReview'		=>	'admin/manuscript/wait-review',			// Chờ phản biện
			'admin.manuscript.reviewed'			=>  'admin/manuscript/reviewed',			// Đã phản biện
			'admin.manuscript.rejectedReview'	=>	'admin/manuscript/rejected-review',     // Không nhận phản biện
	];
	public static $copy_editor_per 		= [
			'admin.manuscript.inEditing'      =>  'admin/manuscript/in-editing',
			'admin.manuscript.published'      =>  'admin/manuscript/published',
			'admin.manuscript.all' 			  =>  'admin/manuscript/all',
	];
	
	public static $screening_editor_per	=	[
			'admin.manuscript.inScreening'     =>  'admin/manuscript/in-screening',	
	];

	public static $chief_editor = [
		'admin.manuscript.inScreening'    	=>	'admin/manuscript/in-screening',
		'admin.manuscript.inReview'        	=>	'admin/manuscript/in-review',
		'admin.manuscript.inEditing'       	=>	'admin/manuscript/in-editing',
		'admin.manuscript.rejected'        	=>	'admin/manuscript/rejected',
		'admin.manuscript.withdrawn'       	=>	'admin/manuscript/withdrawn',
		'admin.manuscript.published'       	=>	'admin/manuscript/published',
		'admin.manuscript.all' 			   	=>	'admin/manuscript/all',
		'admin.manuscript.delete'		   	=>	'admin/manuscript/get_all',

		// 'Quản lý tạp chí'					=>	'admin/journal',
		// 'Thêm tạp chí'						=>	'admin/journal/form',
		
		'admin.jounal.create'			  	=>  'admin/journal/form',
		'admin.jounal.all'				  	=>  'admin/journal',
		'English Tạp chí chưa xuất bản'		=>	'admin/journal/unpublish',
		'Enlish Tạp chí đã xuất bản'		=>	'admin/journal/published',

		'admin.keyword.create'			  	=>  'admin/keyword/form',
		'admin.keyword.all'				  	=>  'admin/keyword',
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
	public static $decide 	=	[
			NULL			=>	'-',
			REFUSE 			=>	'admin.refuse',
			ACCEPT 			=>	'admin.accept',
			REQUIRE_EDIT	=>	'admin.requireEdit',
	];

	public static $full_decide = [
		NULL			=>	'-',
		REFUSE 			=>	'admin.refuse',
		ACCEPT 			=>	'admin.accept',
		REQUIRE_EDIT	=>	'admin.requireEdit',
		RE_REVIEW 		=> 'admin.reReview'
	];

	public static $child_decide = [RE_REVIEW => 'admin.reReview'];

	// Stage of manuscript in Editor Manuscript
	public static $process			= [
			NULL 		=>	'-',
			SCREENING 	=>	'Sơ loại',
			REVIEWING 	=>	'Bình duyệt',
			EDITING 	=>  'Biên tập',
			PUBLISHING 	=>	'Xuất bản',
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

	//reviewer decide 
	public static $is_review = [
		0 			=> 		'Không nhận phản biện',
		1			=> 		'Nhận phản biện'
	];

	// chief decide
	public static $chief_decide = [
		NULL 				=>	'-',
		ACCEPT 				=> 'Chấp nhận', 
		REJECT 				=> 'Từ chối', 
		NEED_EDIT_AGAIN 	=> 'Yêu cầu chỉnh sửa', 
		RE_REVIEW 			=> 'Gửi phản biện lại'
	];

	// Screen editor decide
	public static $editor_decide = [
		NULL 				=>	'-', 
		ACCEPT 				=>	'Đồng ý', 
		REJECT 				=>	'Từ chối', 
		NEED_EDIT_AGAIN 	=>	'Yêu cầu chỉnh sửa'
	];

	// editor notify to chief editor
	public static $notify_chief_editor = [
		NULL 				=>	'-',
		NOTIFIED 			=>	'Đã thông báo',
		NOT_NOTIFY 			=>	'Chưa thông báo',
	];

	// reviewer decide
	public static $reviewer_decide = [
		NULL 					=>	'-', 
		REVIEW_ACCEPT 			=>	'Chấp nhận', 
		REVIEW_REJECT 			=>	'Từ chối', 
		REVIEW_NEED_EDIT_AGAIN 	=>	'Yêu cầu chỉnh sửa', 
		REVIEW_RE_REVIEW 		=>	'Gửi phản biện lại',
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

	public static $unOrder = [
		'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài', 'Tac gia'],
		'col_result' 	=> ['id', 'send_at',  	'name',  'author_full_name'],
		'col_select' 	=> ['id', 'send_at',  	'name',  'author_id'],
		'col_relate'	=> ['author' => 'full_name'],
	];

	public static $relateUnOrder = [
		'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
	];

	public static $tableColumns = [
		UNSUBMIT 		=>		[
			AUTHOR 		=>	[
				'col_header'   => ['ID', 'admin.lastModified', 'admin.mnsName', 'admin.authorName'],
				'col_result'   => ['id', 'updated_at', 'name', 'author_full_name'],
				'col_select'   => ['id', 'updated_at', 'name', 'author_id', 'status'],
				'col_relate'     => ['author' => 'full_name'],	
			],
		],
		IN_EDITING 		=>		[
			COPY_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id','status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
			],
			SECTION_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
			],
			LAYOUT_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
			],
			MANAGING_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.SeName','admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'seEditor_full_name','revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'section_editor_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process', 'seEditor' => 'full_name'],
			],
			CHIEF_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.SeName','admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'seEditor_full_name','revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'section_editor_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process', 'seEditor' => 'full_name'],
			],
			AUTHOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'current_editor_manuscript_id', 'status'],
				'col_relate'	=> ['editorManuscript' => 'process'],
			],
		],
		PUBLISHED 	=>	[
			LAYOUT_EDITOR => [
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài', 'Tac gia',	     'Tiến trình',    /* 'File so ban',  'File chinh ban', */ 'So xep',          'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name',  'author_full_name', 'process' ,	  /* 'file_beta',   'file_official', */ 'pre_journal_id',    'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',  'current_editor_manuscript_id', 'author_id', 'chief_decide', 'status'],
				'col_relate'	=> ['author' => 'full_name'],
			],
			CHIEF_EDITOR => [
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài', 'Tac gia',	     'Tiến trình',    /* 'File so ban',  'File chinh ban', */ 'So xep',          'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name',  'author_full_name', 'process' ,	  /* 'file_beta',   'file_official', */ 'pre_journal_id',    'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',  'current_editor_manuscript_id', 'author_id', 'chief_decide', 'status'],
				'col_relate'	=> ['author' => 'full_name'],
			],
			JOURNALIST => [
				'col_header'	=> ['ID', 'Tên bài', 'Tac gia',	         'File so ban',  'File chinh ban',   ],
				'col_result' 	=> ['id',  'name',  'author_full_name',	   'file_beta',   'file_official',   ],
				'col_select' 	=> ['id',  'name',  'current_editor_manuscript_id', 'author_id', 'status'],
				'col_relate'	=> ['author' => 'full_name'],
			],
			AUTHOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'current_editor_manuscript_id'],
				'col_relate'	=> ['editorManuscript' => 'process'],
			],
			MANAGING_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.SeName','admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'seEditor_full_name','revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'section_editor_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process', 'seEditor' => 'full_name'],
			],
			SECTION_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Thong bao TBT', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name', 'is_review',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			COPY_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id','status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
			],
		],
		IN_REVIEW 	=>	[
			MANAGING_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide', 'status'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			CHIEF_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Thong bao TBT', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name', 'is_review',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide', 'status'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			SECTION_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Thong bao TBT', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name', 'is_review',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			AUTHOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'current_editor_manuscript_id'],
				'col_relate'	=> ['editorManuscript' => 'process'],
			],
		],
		WAIT_REVIEW 	=>	[
			REVIEWER 	=>	[
				'col_header'	=> ['ID', 'Ngày mời phản biện',	'Thời hạn phản biện',	'Tên bài',	'Tiến trình',		'Khuyến nghị phản biện'],
				'col_result' 	=> ['id', 'delivery_at',  		'deadline_at'  ,		'name', 	'process' ,	'editorManuscript_decide_text'],
				'col_select' 	=> ['id', 'delivery_at',  		'deadline_at', 			'name',    'current_editor_manuscript_id', 'status'],
				'col_relate'	=> ['editorManuscript' => 'decide_text'],
			],
		],
		REVIEWED 	=>	[
			REVIEWER 	=>	[
				'col_header'	=> ['ID', 'Ngày mời phản biện',	'Thời hạn phản biện',	'Tên bài',	'Tiến trình',		'Khuyến nghị phản biện'],
				'col_result' 	=> ['id', 'delivery_at',  		'deadline_at'  ,		'name', 	'process' ,	'editorManuscript_decide_text'],
				'col_select' 	=> ['id', 'delivery_at',  		'deadline_at', 			'name',    'current_editor_manuscript_id'],
				'col_relate'	=> ['editorManuscript' => 'decide_text'],
			],
		],
		REJECTED_REVIEW 	=>	[
			REVIEWER 	=>	[
				'col_header'	=> ['ID', 'Ngày mời phản biện',	'Thời hạn phản biện',	'Tên bài',	'Tiến trình',		'Khuyến nghị phản biện'],
				'col_result' 	=> ['id', 'delivery_at',  		'deadline_at'  ,		'name', 	'process' ,	'editorManuscript_decide_text'],
				'col_select' 	=> ['id', 'delivery_at',  		'deadline_at', 			'name',    'current_editor_manuscript_id', 'status'],
				'col_relate'	=> ['editorManuscript' => 'decide_text'],
			],
		],
		IN_SCREENING_REFUSE 	=>	[
			AUTHOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'current_editor_manuscript_id'],
				'col_relate'	=> ['editorManuscript' => 'process'],
			],
			MANAGING_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide', 'status'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			CHIEF_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Thong bao TBT', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name', 'is_review',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide', 'status'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			SECTION_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Thong bao TBT', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name', 'is_review',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
		],
		IN_REVIEW_REFUSE 	=>	[
			AUTHOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'current_editor_manuscript_id'],
				'col_relate'	=> ['editorManuscript' => 'process'],
			],
			MANAGING_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide', 'status'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			CHIEF_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Thong bao TBT', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name', 'is_review',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide', 'status'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
			SECTION_EDITOR 	=>	[
				'col_header'	=> ['ID', 'Ngày gửi',	'Tên bài',	'Tiến trình',  'Phản biện',  'BTV Chuyên trách', 'Thong bao TBT', 'Quyết định TBT'],
				'col_result' 	=> ['id', 'send_at',  	'name', 	'process' ,	   'reviewers_full_name',   'seEditor_full_name', 'is_review',  'chief_decide_text'],
				'col_select' 	=> ['id', 'send_at',  	'name',    'current_editor_manuscript_id','invite_reviewer_ids', 'reviewer_ids', 'section_editor_id', 'chief_decide'],
				'col_relate'	=> ['seEditor' => 'full_name'],
			],
		],
		IN_SCREENING 		=>		[
			SCREENING_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process'],
			],
			MANAGING_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.SeName','admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'seEditor_full_name','revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'section_editor_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process', 'seEditor' => 'full_name'],
			],
			CHIEF_EDITOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.authorName', 'admin.process', 'admin.SeName','admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'author_full_name', 'editorManuscript_process', 'seEditor_full_name','revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'author_id', 'current_editor_manuscript_id', 'section_editor_id', 'status'],
				'col_relate'	=> ['author' => 'full_name', 'editorManuscript' => 'process', 'seEditor' => 'full_name'],
			],
			AUTHOR =>	[
				'col_header'	=> ['ID', 'admin.dateSent', 'admin.manuscriptName', 'admin.process', 'admin.revise', 'admin.printOut', 'admin.prePublic'],
				'col_result' 	=> ['id', 'send_at', 'name', 'process', 'revise', 'print_out', 'pre_public'],
				'col_select' 	=> ['id', 'send_at', 'name', 'status','is_revise', 'is_print_out', 'is_pre_public', 'current_editor_manuscript_id', 'status'],
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
		PUBLISHED => [
			LAYOUT_EDITOR => [
				'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			CHIEF_EDITOR => [
				'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			JOURNALIST => [
				'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			AUTHOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			MANAGING_EDITOR	=>	[
				'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
				'editorManuscript'	=>	['stage', 'loop', 'id'],
			],
			SECTION_EDITOR	=>	[
				'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
				'editorManuscript'	=>	['stage', 'loop', 'id'],
			],
			COPY_EDITOR	=>	[
				'author'	=>	['id', 'first_name', 'last_name', 'middle_name'],
				'editorManuscript'	=>	['stage', 'loop', 'id'],
			],
		],
		IN_REVIEW 	=>	[
			MANAGING_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			CHIEF_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			SECTION_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			AUTHOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
		],
		WAIT_REVIEW 	=>	[
			REVIEWER 	=>	[
				'editorManuscript'	=>	['decide', 'current_id'],
			],
		],
		REVIEWED 	=>	[
			REVIEWER 	=>	[
				'editorManuscript'	=>	['decide', 'current_id'],
			],
		],
		REJECTED_REVIEW 	=>	[
			REVIEWER 	=>	[
				'editorManuscript'	=>	['decide', 'current_id'],
			],
		],	
		IN_SCREENING_REFUSE 	=>	[
			AUTHOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			MANAGING_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			CHIEF_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			SECTION_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
		],
		IN_REVIEW_REFUSE 	=>	[
			AUTHOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			MANAGING_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			CHIEF_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
			SECTION_EDITOR 	=>	[
				'seEditor'	=>	['id', 'first_name', 'last_name', 'middle_name'],
			],
		],
		IN_SCREENING 		=>	[
			SCREENING_EDITOR	=>	[
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
		IN_REVIEW 	=>	[MANAGING_EDITOR, CHIEF_EDITOR, SECTION_EDITOR, REVIEWER, AUTHOR],
		REJECTED 	=>	[AUTHOR, CHIEF_EDITOR, SECTION_EDITOR, MANAGING_EDITOR],
		IN_SCREENING 	=>	[AUTHOR, CHIEF_EDITOR, SCREENING_EDITOR, MANAGING_EDITOR],
	];

	public static $view_manuscript_editor = [
		MANAGING_EDITOR 	=> 'manuscripts.editors.managing',
		SCREENING_EDITOR 	=> 'manuscripts.editors.screening',
		REVIEWER 			=> 'manuscripts.editors.review',
		CHIEF_EDITOR 		=> 'manuscripts.editors.chief',
		SECTION_EDITOR 		=> 'manuscripts.editors.section',
		COPY_EDITOR 		=> 'manuscripts.editors.copy',
		LAYOUT_EDITOR 		=> 'manuscripts.editors.layout',
		AUTHOR 				=> 'manuscripts.editors.author',
		
	];

	public static $file_version = [
		AUTHOR_FILE 	=>	'File tác giả',
		SE_FILE 	=>	'File btv chuyên trách',
		REVIEWER_FILE => 'File nhà phản biện',
	];

	public static $report = [
		REPORT_REJECTED	=> [
			'title'			=>	'Tổng số các bản thảo bị từ chối',
			'inner-title'	=>	'Số Bản thảo',
		],
		REPORT_SUBMITED	=> [
			'title'			=>	'Tổng số các bản thảo đã gửi',
			'inner-title'	=>	'Số Bản thảo',
		],
		REPORT_PUBLISH_IN_YEAR	=>	[
			'title'			=>	'Tổng số các bản thảo đã xuất bản',
			'inner-title'	=>	'Số Bản thảo',
		],	
		REPORT_REVIEW_LOOP	=>	[
			'title'			=>	'Số vòng phản biện bình quân',
			'inner-title'	=>	'\u0053\u1ed1 \u0076\u00f2\u006e\u0067 ',	// 'Số vòng ' //'Tỷ lệ phản biện',
		],
		REPORT_WITHDRAWN	=>	[
			'title'			=>	'Số bản thảo rút nộp',
			'inner-title'	=>	'Số bản thảo',
		],
		REPORT_RATIO_REJECT	=>	[
			'title'			=>	'Tỷ lệ bản thảo bị từ chối',
			'inner-title'	=>	'Tổng Tỷ lệ từ chối',
			'screen-title'	=>	'\u0054\u1ef7 \u006c\u1ec7 \u0074\u1eeb \u0063\u0068\u1ed1\u0069 \u0073\u01a1 \u006c\u006f\u1ea1\u0069', // 'Tỷ lệ từ chối \n sơ loại',
			'review-title'	=>	'Tỷ lệ từ chối \n bình duyệt',
		],
		REPORT_PUBLISHED_DELINQUENT	=>	[
			'title'			=>	'Tổng số tạp chí xuất bản không đúng kỳ hạn',
			'inner-title'	=>	'\u0053\u1ed1 \u0074\u1ea1\u0070 \u0063\u0068\u00ed',
		],
		REPORT_JOURNAL_IN_YEAR	=>	[
			'title'			=>	'Tổng số tạp chí xuất bản trong khoảng thời gian',
			'inner-title'	=>	'\u0053\u1ed1 \u0074\u1ea1\u0070 \u0063\u0068\u00ed',	//'Số tạp chí',
		],
		REPORT_REVIEW_TIME	=>	[
			'title'			=>	'Thời gian phản biện bình quân',
			'inner-title'	=>	'\u0053\u1ed1 \u006e\u0067\u00e0\u0079', // 'Số ngày',
		],
	];


	public static $journalAll = [
		'col_header' 	=> ['ID', 'Tên tạp chí', 'Số tạp chí', 'Ngày đăng tạp chí(dự kiến)', 'Ngày đăng tạp chí( thực tế)'],
		'col_db'		=> ['id', 'name', 'num', 'expect_publish_at', 'publish_at'],
		'col'			=> ['id', 'name', 'num', 'publish_at','expect_publish_at','cover']
	];

	public static $report_menu = [
		'Tổng số các bản thảo bị từ chối'				=>	'admin/report/rejected',
		'Tổng số các bản thảo đã gửi'					=>	'admin/report/submited',
		'Tổng số các bản thảo đã xuất bản trong 1 năm'	=>	'admin/report/publish',
		'Số vòng phản biện bình quân'					=>	'admin/report/review_loop',
		'Số bản thảo rút nộp'							=>	'admin/report/withdraw',
		'Tỷ lệ bản thảo bị từ chối'						=>	'admin/report/ratio_rejected',
		'Tổng số tạp chí xuất bản không đúng kỳ hạn'	=>	'admin/report/published_delinquent',
		'Tổng số tạp chí xuất bản trong vòng 1 năm'		=>	'admin/report/journal',
		'Thời gian phản biện bình quân'					=>	'admin/report/review_time',
	];

	public static $keyword_type = [
		EN 					=>	'English',
		VI 					=>	'Vietnam',
	];

	public static $keywordAll = [
		'col_header'	=> ['ID', 'Ngôn ngữ', 'Text'],
		'col_db'		=> ['id', 'lang_code', 'text'],
		'col'			=> ['id', 'lang_code', 'text']
	];

	public static $report_url = [
		REPORT_REJECTED		  	=>	'admin/report/rejected',
		REPORT_SUBMITED		  	=>	'admin/report/submited',
		REPORT_PUBLISH_IN_YEAR  =>	'admin/report/publish',
		REPORT_REVIEW_LOOP	  	=>	'admin/report/review_loop',
		REPORT_WITHDRAWN	  	=>	'admin/report/withdraw',
		REPORT_RATIO_REJECT	  	=>	'admin/report/ratio_rejected',
		REPORT_PUBLISHED_DELINQUENT =>	'admin/report/published_delinquent',	// xuất bản không đúng hạn
		REPORT_JOURNAL_IN_YEAR  	=>	'admin/report/journal',
		REPORT_REVIEW_TIME	  		=>	'admin/report/review_time',
	];

}
