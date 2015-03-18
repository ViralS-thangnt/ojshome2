<?php

return [
	"hostedJournals" => 	"Hosted Journals",
	"settings.journalRedirect"=>"Journal redirect",
	"settings.security"=>"Security",
	"settings.security.plugins"=>"Prevent journal managers from installing, updating or deleting plugins.",
	"settings.options"=>"Options",
	"settings.useAlphalist"=>"For sites with many journals, show an alphalist on the homepage allowing for quick alphabetical navigation between journals.",
	"settings.usePaging"=>"For sites with many journals, break the list of journals up into several pages.",
	"settings.journalRedirectInstructions"=>"Requests to the main site will be redirected to this journal. This may be useful if the site is hosting only a single journal, for example.",
	"settings.noJournalRedirect"=>"Do not redirect",
	"settings.journalsList"=>"Journal elements",
	"settings.journalsList.description"=>"Please choose the journal elements that will be displayed for each journal at the site page.",
	"settings.journalsList.showThumbnail"=>"Journal thumbnail",
	"settings.journalsList.showTitle"=>"Journal title",
	"settings.journalsList.showDescription"=>"Journal description",
	"settings.defaultMetricDescription"=>"
		Your OJS installation is configured to record more than one usage metric. Usage statistics will be displayed in severeral contexts.
		There are cases where a single usage statistic must be used, e.g. to display an ordered list of most-used articles or to rank
		search results. Please select one of the configured metrics as a default.
	",
	"languages.primaryLocaleInstructions"=>"This will be the default language for the site and any hosted journals.",
	"languages.supportedLocalesInstructions"=>"Select all locales to support on the site. The selected locales will be available for use by all journals hosted on the site, and also appear in a language select menu to appear on each site page (which can be overridden on journal-specific pages). If multiple locales are not selected, the language toggle menu will not appear and extended language settings will not be available to journals.",
	"locale.maybeIncomplete"=>"Marked locales may be incomplete.",
	"languages.confirmUninstall"=>"Are you sure you want to uninstall this locale? This may affect any hosted journals currently using the locale.",
	"languages.installNewLocalesInstructions"=>"Select any additional locales to install support for in this system. Locales must be installed before they can be used by hosted journals. See the OJS documentation for information on adding support for new languages.",
	"languages.downloadLocales"=>"Download Locales",
	"languages.downloadFailed"=>"The locale download failed. The error message(s) below describe the failure.",
	"languages.localeInstalled"=>"The \"{:locale}\" locale has been installed.",
	"languages.download"=>"Download Locale",
	"languages.reloadDefaultEmailTemplates"=>"Reload Default Email Templates",
	"languages.download.cannotOpen"=>"Cannot open language descriptor from PKP web site.",
	"languages.download.cannotModifyRegistry"=>"Cannot add the new locale to the locale registry file, typically 'registry/locales.xml'.",
	"auth.ojs"=>"OJS User Database",
	"auth.enableSyncProfiles"=>"Enable user profile synchronization (if supported by this authentication plug-in). User profile information will be automatically updated from the remote source when a user logs in, and profile changes (including password changes) made within OJS will be automatically updated on the remote source. If this option is not enabled OJS profile information will be kept separate from remote source profile information.",
	"auth.enableSyncPasswords"=>"Enable user password modification (if supported by this authentication plug-in). Enabling this option allows users to modify their password from within OJS and to use the OJS \"lost password\" feature to reset a forgotten password. These functions will be unavailable to users with this authentication source if this option is not enabled.",
	"auth.enableCreateUsers"=>"Enable user creation (if supported by this authentication plug-in). Users created within OJS with this authentication source will be automatically added to the remote authentication source if they do not already exist. Additionally, if this source is the default authentication source, OJS accounts created through user registration will also be added to the remote authentication source.",
	"systemVersion"=>"OJS Version",
	"systemConfiguration"=>"OJS Configuration",
	"systemConfigurationDescription"=> "<![CDATA[OJS configuration settings from <tt>config.inc.php</tt>.]]>",
	"journals.journalSettings"=>"Journal Settings",
	"journals.noneCreated"=>"No journals have been created.",
	"journals.confirmDelete"=>"Are you sure you want to permanently delete this journal and all of its contents?",
	"journals.create"=>"Create Journal",
	"journals.createInstructions"=>"You will automatically be enrolled as the manager of this journal. After creating a new journal, enter it as a manager to continue with its setup and user enrollment.",
	"journals.urlWillBe"=>"This should be a single short word or acronym that identifies the journal. The journal's URL will be {:sampleUrl}",
	"journals.form.titleRequired"=>"A title is required.",
	"journals.form.pathRequired"=>"A path is required.",
	"journals.form.pathAlphaNumeric"=>"The path can contain only alphanumeric characters, underscores, and hyphens, and must begin and end with an alphanumeric character.",
	"journals.form.pathExists"=>"The selected path is already in use by another journal.",
	"journals.enableJournalInstructions"=>"Enable this journal to appear publicly on the site",
	"journals.journalDescription"=>"Journal description",
	"journal.pathImportInstructions"=>"Existing journal path or path to create (e.g., \"ojs\").",
	"journals.importSubscriptions"=>"Import subscriptions",
	"journals.transcode"=>"Transcode article metadata from ISO8859-1",
	"journals.redirect"=>"Generate code to map OJS 1 URLs to OJS 2 URLs",
	"journals.form.importPathRequired"=>"The import path is required.",
	"journals.importErrors"=>"Importing failed to complete successfully",
	"mergeUsers"=>"Merge Users",
	"mergeUsers.mergeUser"=>"Merge User",
	"mergeUsers.into.description"=>"Select a user to whom to attribute the previous user's authorships, editing assignments, etc.",
	"mergeUsers.from.description"=>"Select a user (or several) to merge into another user account (e.g., when someone has two user accounts). The account(s) selected first will be deleted and any submissions, assignments, etc. will be attributed to the second account.",
	"mergeUsers.allUsers"=>"All Enrolled Users",
	"mergeUsers.confirm"=>"Are you sure you wish to merge the selected { :oldAccountCount} account(s) into the account with the username \"{:newUsername}\"? The selected { :oldAccountCount} accounts will not exist afterwards. This action is not reversible.",
	"mergerUsers.noneEnrolled"=>"No enrolled users.",


	// new OJS system
	'manuscript.title_page_admin'	=>	"DRAFT",
	'manuscript.manuscript_info'	=>	"Manuscript infomation",

	//manuscript
	'manuscript.create'			=>	'Create New Manuscript',
	'manuscript.unsubmit' 		=>	'Unsubmitted Manuscript',
	'manuscript.inScreening' 	=>	'In Screening Manuscript',
	'manuscript.inReview' 		=>	'In Review Manuscript',
	'manuscript.inEditing' 		=>	'In Editing Manuscript',
	'manuscript.rejected' 		=>	'Rejected Manuscript',
	'manuscript.withdrawn' 		=>	'Withdrawn Manuscript',
	'manuscript.published' 		=>	'Published Manuscript',
	'admin.manuscript.all'		=>	'All Manuscripts',

	//review
	'manuscript.unReview'       =>  'Manuscript Waiting For Review',
	'manuscript.reviewed'       =>  'Manuscript Reviewed',
	'manuscript.rejectedReview' =>  'Manuscript Rejected Review',

	'manuscript.lastModified'	=>  'Last Modified',
	'manuscript.name'			=>	'Name',
	'manuscript.author' 		=>	'Author',

	//common
	'edit'						=>	'Edit',
	'delete'					=>	'Delete',
	'emptyData'					=>	'No match record found',

	//message
	'FailedLoginMessage'		=>	'These credentials do not match our records.',

	//user
	'user.create'				=>	'Create New User',
	'user.index'				=>	'List Users',

	// manuscript - create
	'manuscript.create.navigation.draft'	=>	'Bản thảo',
	'manuscript.create.navigation.create'	=>	'Tạo mới bản thảo',

	'manuscript.create.detail.header'		=>	'Chi tiết',
	'manuscript.create.author.header' 		=>	'Thông tin tác giả',
	'manuscript.create.upload.header' 		=>	'Tải lên tài liệu',
	'manuscript.create.policy.header' 		=>	'Chính sách và điều khoản',

	'manuscript.create.type'				=>	'Thể loại bài viết',
	'manuscript.create.name'				=>	'Tên bài viết',
	'manuscript.create.summary_vi'			=>	'Tóm tắt Tiếng Việt',
	'manuscript.create.keyword_vi'			=>	'Từ khoá Tiếng Việt',
	'manuscript.create.summary_en'			=>	'Tóm tắt Tiếng Anh',
	'manuscript.create.keyword_en'			=>	'Từ khoá Tiếng Anh',
	'manuscript.create.topic'				=>	'Chủ đề bài viết',
	'manuscript.create.propose_reviewer'	=>	'Đề xuất nhà phản biện',
	'manuscript.create.expect_journal_id'	=>	'Mong muốn đăng trên tạp chí số',
	'manuscript.create.author_comments'		=>	'Kiến nghị gửi Ban biên tập',

	'manuscript.create.co_author'			=>	'Thông tin đồng tác giả (nếu có)',
	'manuscript.create.title_policy'		=>	'Tôi đã đọc và đồng ý với các điều khoản và chính sách của ban biên tập',
	'manuscript.create.policy_yes'			=>	'Đồng ý',
	'manuscript.create.policy_no'			=>	'Không đồng ý',

	'manuscript.create.help.name'						=>	'(Nhập tên bài viết. Tối đa 20 từ)',
	'manuscript.create.help.summary_vi'					=>	'(Nhập tóm tắt Tiếng Việt. Độ dài từ 150 - 200 từ)',
	'manuscript.create.help.keyword'					=>	'(Tối đa 3 - 5 từ khoá)',
	'manuscript.create.help.summary_en'					=>	'(Nhập tóm tắt Tiếng Anh. Độ dài từ 150 - 200 từ)',
	'manuscript.create.help.propose_reviewer'			=>	'(Bạn hãy ghi rõ tên, thông tin liên lạc với nhà phản biện.)',
	'manuscript.create.help.expect_journal_id'			=>	'(Bạn muốn đăng bài viết trên tạp chí số bao nhiêu)',
	'manuscript.create.help.co_author'					=>	'(Bạn hãy ghi rõ thông tin của đồng tác giả nếu có)',

	'manuscript.create.placeholder.name'				=>	'Nhập tên bài viết. Tối đa 20 từ ...',
	'manuscript.create.placeholder.summary_vi'			=>	'Nhập tóm tắt Tiếng Việt. Độ dài từ 150 - 200 từ ...',
	'manuscript.create.placeholder.summary_en'			=>	'Nhập tóm tắt Tiếng Anh. Độ dài từ 150 - 200 từ ...',
	'manuscript.create.placeholder.topic'				=>	'Nhập chủ đề bài viết...',
	'manuscript.create.placeholder.propose_reviewer'	=>	'Nhập đề xuất nhà phản biện. Bạn hãy ghi rõ tên, thông tin liên lạc với nhà phản biện...',
	'manuscript.create.placeholder.expect_journal_id'	=>	'Nhập mong muốn đăng bài viết của bạn trên tạp chí số bao nhiêu...',
	'manuscript.create.placeholder.author_comments'		=>	'Nhập kiến nghị gửi Ban biên tập chúng tôi...',
	'manuscript.create.placeholder.co_author'			=>	'Bạn hãy nhập thông tin của đồng tác giả nếu có...',
	'manuscript.create.placeholder.policy'				=>	'Đây là thông tin điều khoản mà bạn phải đọc và đồng ý blah blah...',

	'manuscript.create.submit'			=>	'Gửi bài',
	'manuscript.create.save'			=>	'Lưu',

	// manuscript - general
	'manuscript.title'					=>	'Thông tin bản thảo',
	'manuscript.header_title'			=>	'Chi tiết',
	'manuscript.detail'					=>	'Chi tiết',
	'manuscript.more_detail'			=>	'Xem thêm',

	// manuscript - In review
	'manuscript_in_review.title'		=>	"Thông tin các bản thảo đang bình duyệt",

	// validate - manuscript
	'summary_vi.regex'			=>	'Từ khoá Tiếng Việt chỉ được nhập từ 150 - 200 từ',
	'summary_en.regex'			=>	'Từ khoá Tiếng Anh chỉ được nhập từ 150 - 200 từ ',
	'name.regex'				=>	'Tên chỉ được nhập từ 1 - 20 từ',
	'file.required'				=>	'Bạn chưa chọn file upload',

	'expect_journal_id.numeric'	=>	'Số mong muốn xuất bản phải có định dạng số',
	'name.required'				=>	'Bạn phải nhập tên của bài viết ',
	'summary_vi.required'		=>	'Bạn phải nhập thông tin trong trường tóm tắt Tiếng Việt',
	'summary_en.required'		=>	'Bạn phải nhập thông tin trong trường tóm tắt Tiếng Anh',

	'keyword_en.required'		=>	'Bạn chưa chọn từ khoá Tiếng Anh',
	'keyword_vi.required'		=>	'Bạn chưa chọn từ khoá Tiếng Việt',
	'keyword_vi.max'			=>	'Từ khoá Tiếng Việt chỉ có thể chọn tối đa 5 từ khoá',
	'keyword_vi.min'			=>	'Từ khoá Tiếng Việt phải chọn tối thiểu 3 từ khoá',
	'keyword_en.max'			=>	'Từ khoá Tiếng Anh chỉ có thể chọn tối đa 5 từ khoá',
	'keyword_en.min'			=>	'Từ khoá Tiếng Anh phải chọn tối thiểu 3 từ khoá',

	'topic.required'			=>	'Bạn phải nhập thông tin trong trường chủ đề',
	'confirm.in'				=>	'Bạn chưa đồng ý với chính sách và điều khoản của ban biên tập',

	// Upload file
	'upload.file_exists'		=>	'Sorry, file already exists.',
	'upload.file_too_large'		=>	'Sorry, your file is too large.',
	'upload.file_uploaded'		=>	'The file :filename has been uploaded.',
	'upload.file_not_uploaded'	=>	'Sorry, your file was not uploaded.',
	'upload.error_unknow'		=>	'Từ khoá Tiếng Việt phải chọn tối thiểu 3 từ khoá',

	// Column header - Blade template
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

	// 


];
