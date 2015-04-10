<?php
//degree config
define('BACHELOR', 1);
define('MASTER', 2);
define('DOCTORAL', 3);
define('ASSOCIATE_PROFESSOR', 4);
define('PROFESSOR', 5);
//academic config
define('MASTER_ECONOMIC', 6);
define('MASTER_SCIENCE', 7);
define('DR_ECONOMIC', 8);
define('DR_SCIENCE', 9);
//define actor
define('ADMIN', 1);
define('AUTHOR', 2);
define('MANAGING_EDITOR', 3);
define('SCREENING_EDITOR', 4);
define('SECTION_EDITOR', 5);
define('REVIEWER', 6);
define('CHIEF_EDITOR', 7);
define('COPY_EDITOR', 8);
define('LAYOUT_EDITOR', 9);
define('PRODUCTION_EDITOR', 10);
//define manuscript type
define('A', 1);
define('B', 2);
define('C', 3);
define('D', 4);
define('E', 5);

//define require permission session
define('REQUIRE_PERMISSION', 'require_permission');

//define authenticate redirect link
define('REDIRECT_PATH', '/admin');
define('LOGIN_PATH', '/user/login');
define('LOGOUT_PATH', '/user/logout');
define('REGISTER_PATH', '/user/register');

//define message type
define('SUCCESS_MESSAGE', 'success-message');

//define manuscript status
define('UNSUBMIT', 0);
define('IN_SCREENING', 1);
define('IN_REVIEW', 2);
define('IN_EDITING', 3);
define('REJECTED', 4);
define('WITHDRAWN', 5);
define('PUBLISHED', 6);
//manuscript review list
define('WAIT_REVIEW', 8);		// Chờ phản biện
define('REVIEWED', 9); 			//Da phan bien
define('REJECTED_REVIEW',10);	//khong nhan phan bien


define('ALL', 9);			// Tất cả các bản thảo
define('IN_SCREENING_REFUSE', 10); //screening manuscript refused in screening stage
define('IN_SCREENING_EDIT', 11); // manuscript need to edit
define('IN_REVIEW_REFUSE', 12);
define('IN_REVIEW_EDIT', 13);
// define('RE_REVIEW', 14);         // manuscript need to review again

//define editor stage
define('SCREENING', 1);
define('REVIEWING', 2);
define('EDITING', 3);
define('PUBLISHING', 4);

//define editor decide
define('REFUSE', 1);
define('ACCEPT', 2);
define('REQUIRE_EDIT', 3);

//define decide key
define('NULL', 0);			//'-'
define('REJECT', 4);
define('PUBLISH', 5);
define('NEED_EDIT_AGAIN', 6);
define('RE_REVIEW', 7);

define('REVIEW_ACCEPT', 8);
define('REVIEW_REJECT', 9);
define('REVIEW_NEED_EDIT_AGAIN', 10);
define('REVIEW_RE_REVIEW', 11);

// define notify chief key
define('NOTIFIED', 2);
define('NOT_NOTIFY', 1);

//define file upload type
define('AUTHOR_FILE', 1);
define('REVIEWER_FILE', 2);
define('SE_FILE', 3);
define('REVISE_FILE', 4);
define('LAYOUT_PRINT_FILE', 5);
define('PRE_PRINT_FILE', 6);
define('OFFICIAL_FILE', 7);

// Define box icon 
define('ICON_PEOPLE', 'ion-ios7-people');
define('ICON_CHATBOX', 'ion-ios7-chatboxes');
define('ICON_DOCUMENT_TEXT', 'ion-document-text');
define('ICON_STORAGE', 'ion-android-storage');
define('ICON_SYSTEM_HOME', 'ion-android-system-home');
define('ICON_PIE_GRAPH', 'ion-pie-graph');
define('ICON_STATS_BAR', 'ion-stats-bars');
define('ICON_STORAGE_STAR', 'ion-android-star');
define('ICON_PRINTER', 'ion-android-printer');
define('ICON_EARTH', 'ion-android-earth');
define('ICON_LIGTHBULB', 'ion-android-lightbulb');
define('ICON_DEVELOPER', 'ion-android-developer');
define('ICON_DISPLAY', 'ion-android-display');

// Define menu icon
define('ICON_MENU_SPEED_DIAL', 'fa-th');
define('ICON_MENU_DASHBOARD', 'fa-dashboard');
define('ICON_MENU_SEARCH', 'fa-search');
define('ICON_MENU_CHART', 'fa-bar-chart-o');
define('ICON_MENU_BOOK', 'fa-book');
define('ICON_MENU_ANGLE_DOUBLE_RIGHT', 'fa-angle-double-right');
define('ICON_MENU_ANGLE_DOUBLE_LEFT', 'fa-angle-double-left');
define('ICON_MENU_ANGLE_RIGHT', 'fa-angle-right');
define('ICON_MENU_ANGLE_LEFT', 'fa-angle-left');
define('ICON_MENU_ARROW_CIRCLE_RIGHT', 'fa-arrow-circle-right');
define('ICON_MENU_EDIT', 'fa-edit');

// Define box color
define('COLOR_AQUA', 'bg-aqua');
define('COLOR_RED', 'bg-red');
define('COLOR_YELLOW', 'bg-yellow');
define('COLOR_GREEN', 'bg-green');
define('COLOR_NAVY', 'bg-navy');
define('COLOR_TEAL', 'bg-teal');
define('COLOR_OLIVE', 'bg-olive');
define('COLOR_LIME', 'bg-lime');
define('COLOR_ORANGE', 'bg-orange');
define('COLOR_PURPLE', 'bg-purple');

// Define frame type of image
define('IMAGE_CIRCLE', 'img-circle');

// Define paths
define('IMAGE_PATH', '/images/');
define('FILE_PATH', '/files');

// File size
define('FILE_SIZE_MAX', 7000000000);

// File path final
define('FILE_UPLOAD_SESSION', 'path_file_uploaded');
define('FILE_UPLOAD_TYPE', 'file_type');
define('FILE_UPLOAD_NAME', 'file_name');
define('FILE_UPLOAD_TOTAL_PAGE', 'file_total_page');
define('FILE_UPLOAD_EXTENSION', 'file_extension');


// define report
define('REPORT_REJECTED', 1);
define('REPORT_SUBMITED', 2);
define('REPORT_PUBLISH_IN_YEAR', 3);
define('REPORT_REVIEW_LOOP', 4);
define('REPORT_WITHDRAWN', 5);
define('REPORT_RATIO_REJECT', 6);
define('REPORT_PUBLISHED_DELINQUENT',7);	// Xuất bản không đúng hạn
define('REPORT_JOURNAL_IN_YEAR', 8);
define('REPORT_REVIEW_TIME', 9);

// define keyword type
define('EN', 1);
define('VI', 2);

// define('INNER_JOURNAL_NUMBER', \Lang::get('report.inner.journal_number'));
// define('VI', 2);

// choose manuscript file of copy editor or author
define('COPY_MANUSCRIPT_FILE', false);
define('NEW_MANUSCRIPT_FILE', true);

// Trong giai chế bản hay không
define('PRINT_OUT', 1);
define('NOT_PRINT_OUT', 0);

// file type
define('FILE_TYPE_PRINT_OUT', 0);

// Trong giai đoạn kiểm bông hay không
define('PRE_PUBLIC', 1);
define('NOT_PRE_PUBLIC', 0);

// Bắt đầu giai đoạn xuất bản, layout editor kích hoạt giai đoạn xuất bản
define('START_PUBLISH', 1);


