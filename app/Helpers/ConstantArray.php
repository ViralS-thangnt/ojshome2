<?php namespace App\Helpers;

class ConstantArray
{
	public static $author_per       = [
			'admin.manuscript.create'         =>  'admin/manuscript/form',
			'admin.manuscript.unsubmit'       =>  'admin/manuscript/unsubmit',
			'admin.manuscript.inScreening'    =>  'admin/manuscript/in-screening',
			'admin.manuscript.inReview'       =>  'admin/manuscript/in-review',
			'admin.manuscript.inEditing'      =>  'admin/manuscript/in-editing',
			'admin.manuscript.rejected'       =>  'admin/manuscript/rejected',
			'admin.manuscript.withdrawn'      =>  'admin/manuscript/withdrawn',
			'admin.manuscript.published'      =>  'admin/manuscript/published'
	];
	public static $admin_per            = [
			'admin.user.create'               =>  'admin/user/form',
			'admin.user.index'                =>  'admin/user',
	];
	public static $reviewer_per         = [
			'admin.manuscript.unReview'       =>  'admin/manuscript/un-review',
			'admin.manuscript.reviewed'       =>  'admin/manuscript/reviewed',
			'admin.manuscript.rejectedReview' =>  'admin/manuscript/rejected-review',
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
		'col_header' 	=> ['ID', 'Ngày gửi', 	'Tên bài', 	'Tác giả liên hệ', 	'Tiến trình', 		'Quyết định của ban biên tập'],	
		'col_db'    	=> ['id', 'send_at', 	'name', 	'last_name', 		'round_no_review', 	'round_decide_editor'],
		'col'        	=> ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 'users.last_name', 
							'editor_manuscripts.loop as round_no_review', 
							'editor_manuscripts.comments as round_decide_editor'],
	];

	public static $in_review_chief_editor = [
		'col_header' 	=> ['ID',	'Ngày gửi',	'Tên bài',	'Tác giả liên hệ',	'Tiến trình',		'Phản biện',	'Biên tập viên chuyên trách',	'Thông báo tổng biên tập',	'Quyết định của tổng biên tập'],	
		'col_db'    	=> ['id',	'send_at',	'name',		'last_name',		'round_no_review',	'reviewer', 	'section_editor', 				'notify_chief_editor', 		'round_decide_chief_editor'],
		'col'        	=> ['manuscripts.id', 'manuscripts.send_at', 'manuscripts.name', 'users.last_name', 'manuscripts.loop',
							'manuscripts.editor_id', 'manuscripts.section_editor_id', 'manuscripts.is_chief_review as notify_chief_editor',
							'editor_manuscripts.comments as round_decide_editor'],

							
	];


}
