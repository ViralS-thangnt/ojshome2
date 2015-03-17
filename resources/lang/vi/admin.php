<?php

return [

	"hostedJournals"	=>	"Các tạp chí trên Website",
	"settings.journalRedirect"	=>	"Chuyển hướng tạp chí",
	"settings.journalRedirectInstructions"	=>	"Website chính sẽ được chuyển hướng sáng tạp chí này. Điều này hữu ích khi website chỉ có một tạp chí.",
	"settings.noJournalRedirect"	=>	"Không chuyển hướng",
	"languages.primaryLocaleInstructions"	=>	"Đây sẽ là ngôn ngữ mặc định cho web site và cho bất kỳ tạp chí nào đặt trên web site này.",
	"languages.supportedLocalesInstructions"	=>	"Lựa chọn tất cả các ngôn ngữ sẽ được sử dụng trên web site. Các ngôn ngữ được lựa chọn có thể được sử dụng cho tất cả các tạp chí và xuất hiện trong menu có ở mỗi tạp chí (có thể được đặt khác đi ở từng trang tạp chí cụ thể). Nếu chỉ có một ngôn ngữ được lựa chọn, menu ngôn ngữ sẽ không xuất hiện và không thể thiết lập thêm cho ngôn ngữ.",
	"languages.confirmUninstall"	=>	"Quý có chắc chắn muốn loại bỏ ngôn ngữ này? Điều này có thể ảnh hưởng tới bất kỳ tạp chí nào hiện đang đặt trên web site sử dụng ngôn ngữ đó.",
	"languages.installNewLocalesInstructions"	=>	"Lựa chọn bất kỳ ngôn ngữ bổ sung nào để cài đặt hỗ trợ cho hệ thống này. Ngôn ngữ phải được cài đặt trước khi nó có thể được sử dụng trên các tạp chí đặt trên web site này. Xem tài liệu hướng dẫn sử dụng OJS để có thêm thông tin về cài đặt thêm ngôn ngữ mới.",
	"languages.downloadLocales"	=>	"Tải Ngôn ngữ",
	"languages.downloadFailed"	=>	"Ngôn ngữ không tải được. Thông báo lỗi dưới đây giải thích về sự cố này.",
	"languages.localeInstalled"	=>	"Ngôn ngữ \"{:locale}\" đã được cài đặt.",
	"languages.download"	=>	"Tải Ngôn ngữ",
	"languages.reloadDefaultEmailTemplates"	=>	"Nạp lại mẫu email mặc định",
	"languages.download.cannotOpen"	=>	"Không mở được định danh ngôn ngữ từ website của PKP.",
	"languages.download.cannotModifyRegistry"	=>	"Không thể thêm ngôn ngữ mới vào file đăng ký ngôn ngữ, thường là \"registry/locales.xml\".",
	"auth.ojs"	=>	"CSDL người dùng OJS",
	"auth.enableSyncProfiles"	=>	"Cho phép đồng nhất hồ sơ người sử dụng(nếu công cụ xác thực này hỗ trợ). Thông tin hồ sơ của người dùng sẽ được cập nhật tự động bằng nguồn từ xa, và những thay đổi trong hồ sơ (gồm cả thay đổi mật khẩu) trên phần mềm OJS cũng sẽ được cập nhật tự động lên nguồn từ xa. Nếu tính năng này không được kích hoạt, thông tin hồ sơ trên OJS sẽ được lưu giữ độc lập với thông tin hồ sơ nguồn từ xa.",
	"auth.enableSyncPasswords"	=>	"Cho phép sửa mật khẩu người dùng (nếu công cụ xác thực này hỗ trợ). Kích hoạt lựa chọn này sẽ cho phép người dùng sửa mật khẩu của họ trong phần mềm OJS và sử dụng chức năng \"quên mật khẩu\" để khởi tạo lại mật khẩu. Những chức năng này sẽ không dành cho người dùng từ nguồn xác thực này nếu lựa chọn không được kích hoạt.",
	"auth.enableCreateUsers"	=>	"Cho phép tạo người dùng (nếu công cụ xác thực này hỗ trợ). Người dùng được khởi tạo trong OJS bằng công cụ xác thực này sẽ được cập nhật tự động lên nguồn xác thực từ xa nếu như người dùng đó chưa có trên nguồn này. Ngoài ra, nếu nguồn này la nguồn xác thực mặc định, những tài khoản người dùng do người dùng tự đăng ký trên OJS cũng sẽ được cập nhật lên nguồn xác thực từ xa.",
	"systemVersion"	=>	"Phiên bản OJS",
	"systemConfiguration"	=>	"Cấu hình OJS",
	"systemConfigurationDescription"	=>	"<![CDATA[Cấu hình OJS ghi trong <tt>config.inc.php</tt>.]]	",
	"journals.journalSettings"	=>	"Thiết lập tạp chí",
	"journals.noneCreated"	=>	"Chưa có tạp chí nào được khởi tạo.",
	"journals.confirmDelete"	=>	"Quý vị có chắc chắn muốn xóa vĩnh viễn tạp chí này và tất cả nội dung của tạp chí?",
	"journals.create"	=>	"Khởi tạp một tạp chí",
	"journals.createInstructions"	=>	"Quý vị sẽ tự động được bổ nhiệm là người quản lý (Tổng biên tập) tạp chí này. Sau khi tạo một tạp chí mới, đăng nhập vào với tư cách Tổng biên tập để tiếp tục thiết lập cho tạp chí và bổ nhiệm người dùng.",
	"journals.urlWillBe"	=>	"Địa chỉ của tạp chí sẽ là {:sampleUrl}",
	"journals.form.titleRequired"	=>	"Phải có tên tạp chí.",
	"journals.form.pathRequired"	=>	"Phải có đường dẫn.",
	"journals.form.pathAlphaNumeric"	=>	"Đường dẫn chỉ được phép có các ký tự chữ cái, chữ số, dấu gạch dưới, gạch ngang và phải bắt đầu bằng chữ cái, chữ số.",
	"journals.form.pathExists"	=>	"Đường dẫn vừa chọn đã được dùng cho một tạp chí khác.",
	"journals.enableJournalInstructions"	=>	"Để tạp chí này xuất hiện công khai trên web site",
	"journals.journalDescription"	=>	"Mô tả tạp chí",
	"journals.importOJS1"	=>	"Nhập từ OJS 1",
	"journals.importOJS1.success"	=>	"Tạp chí đã được nhập vào thành công.",
	"journals.importOJS1.editMigratedJournal"	=>	"Sửa các tạp chí từ phiên bản trước",
	"journals.importOJS1.redirect.desc"	=>	"Để hướng người đọc từ các tạp chí dùng OJS 1 sang OJS 2, tạp các file PHP sau sử dụng nội dung dưới đây. Những file tương ứng có thể được đặt trong đường dẫn hệ thống OJS 1, hoặc trong đường dẫn file hệ thống OJS 2  đối với trường hợp phần mềm chỉ dùng cho một tạp chí.",
	"journals.importOJS1.redirect.ojs1root"	=>	"Đặt trong đường dẫn hệ thống file OJS 1 cũ (ví dụ, /var/www/ojs1).",
	"journals.importOJS1.redirect.ojs1orojs2root"	=>	"Đặt trong đường dẫn hệ thống file OJS 1 cũ (ví dụ, /var/www/ojs1), hoặc trong đường dẫn file hệ thống OJS 2  đối với trường hợp phần mềm chỉ dùng cho một tạp chí (ví dụ, /var/www/ojs2)",
	"journals.importOJS1.conflict.desc"	=>	"Một số tài khoản người dùng có thông tin trùng nhau. Phiên bản OJS 1.x cho phép nhiều tài khoản dùng chung một địa chỉ email, trong khi phiên bản không hỗ trợ điều này. Trong danh sách sau, tài khoản thứ hai được tạm thời gắn cho một địa chỉ email. Người quản trị cần sửa bằng tay, bằng cách hoặc gắn cho một địa chỉ email khác hoặc sáp nhập các tài khoản thành một.",
	"journals.importOJS1.conflict"	=>	"{:firstUsername} ({:firstName}) và {:secondUsername} ({:secondName})",
	"journals.importOJS1Instructions"	=>	"Tham khảo tài liệu NÂNG CẤP phát hành cùng OJS để xem chi tiết thông tin về việc nhập dữ liệu từ OJS 1 sang OJS 2.",
	"journal.pathImportInstructions"	=>	"Đường dẫn hiện tại của tạp chí hoặc đường dẫn cần tạo (v.d., \"ojs\").",
	"journal.importPath"	=>	"Đường dẫn OJS 1",
	"journal.importPathInstructions"	=>	"Nhập đường dẫn nội bộ tới phần cài đặt OJS 1 (v.d., \"/var/www/ojs\").",
	"journals.importSubscriptions"	=>	"Nhập khách hàng đặt tạp chí",
	"journals.transcode"	=>	"Chuyển mã dữ liệu mô tả từ chuẩn ISO8859-1",
	"journals.redirect"	=>	"Tạo mã để ánh xạ các đường dẫn của OJS 1 sang OJS 2",
	"journals.form.importPathRequired"	=>	"Phải có đường dẫn để nhập.",
	"journals.importErrors"	=>	"Nhập dữ liệu không thành công",
	"mergeUsers"	=>	"Hợp nhất người dùng",
	"mergeUsers.mergeUser"	=>	"Hợp nhất người dùng",
	"mergeUsers.into.description"	=>	"Chọn một người dùng sẽ tiếp nhận các quyền tác giả và công việc biên tập của người dùng trước đây.",
	"mergeUsers.from.description"	=>	"Chọn một người dùng để hợp nhất vào một tài khoản người dùng khác (v.d., khi một người có 2 tài khoản. Tài khoản được lựa chọn trước sẽ bị xoá và các bài nộp, bài được giao,... sẽ được chuyển sang tài khoản thứ hai.",
	"mergeUsers.allUsers"	=>	"Tất cả người dùng đã bổ nhiệm",
	"mergeUsers.confirm"	=>	"Quý vị có chắc chắn muốn hợp nhất tài khoản có bí danh \"{:oldUsername}\" vào tài khoản có bí danh \"{:newUsername}\"? Tài khoản có bí danh \"{:oldUsername}\" sau đó sẽ không còn tồn tại. Tác vụ này không thể thay đổi lại.",
	"mergerUsers.noneEnrolled"	=>	"Chưa có người dùng được bổ nhiệm",

	// new OJS system
	'manuscript.title_page_admin' 			=> "BẢN THẢO",
	'manuscript.manuscript_info'			=> "Thông tin bản thảo",

	//manuscript
	'manuscript.create'			=>	'Tạo bản thảo mới',
	'manuscript.unsubmit' 		=>	'Bản thảo chưa gửi',
	'manuscript.inScreening' 	=>	'Bản thảo đang sơ loại',
	'manuscript.inReview' 		=>	'Bản thảo đang bình duyệt',
	'manuscript.inEditing' 		=>	'Bản thảo đang biên tập',
	'manuscript.rejected' 		=>	'Bản thảo bị từ chối',
	'manuscript.withdrawn' 		=>	'Bản thảo rút nộp',
	'manuscript.published' 		=>	'Bản thảo xuất bản',
 
	// manuscript - create
	'manuscript.create.navigation.draft'	=>	'Bản thảo',
	'manuscript.create.navigation.create'	=>	'Thêm mới bản thảo',
	'manuscript.'	=>	'',

	//review
	'manuscript.unReview'       =>  'Bản thảo chờ phản biện',
    'manuscript.reviewed'       =>  'Bản thảo đã phản biện',
    'manuscript.rejectedReview' =>  'Bản thảo không nhận phản ',

    'manuscript.lastModified'	=>  'Lần chỉnh sửa cuối',
    'manuscript.name'			=>	'Tên bản thảo',
    'manuscript.author' 		=>	'Tác giả',

    //common
    'edit'						=>	'Sửa',
    'delete'					=>	'Xoá',
    'emptyData'					=>	'Không có bản ghi phù hợp nào được tìm thấy',

    //message
    'FailedLoginMessage'		=>	'Tài khoản đăng nhập không tồn tại!',

	//user
	'user.create'				=>	'Thêm User',
	'user.index'				=>	'Danh sách User',

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




];
