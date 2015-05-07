<?php 
/**
 * Handle upload file
 *
 * @param  Request::file('icon')
 * @return filename
 */
function doUpload($file, $path = IMAGE_PATH)
{
	$filename           = $file->getClientOriginalName();
	$destination_path   = public_path($path);
	$file->move($destination_path, $filename);

	return $filename;
}

function doUploadDocument(){
	// dump('upload');
	// dd($_FILES);
	$dir_file = str_random(9);

	// full path to file
	$target_dir = public_path() . FILE_PATH . '/' . $dir_file;// $_FILES["file"]["tmp_name"] ;

	// file name
	$filename = str_replace(' ', '_', basename($_FILES["file"]["name"]));

	// folder save file
	$dir_file = $dir_file . '/' . $filename;

	// full path + filename
	$target_file = $target_dir . '/' . $filename;

	// upload ok or fail
	$uploadOk = 1;
	
	// Check if file already exists
	if (file_exists($target_file)) {
		Session::flash(SUCCESS_MESSAGE, trans('admin.upload.file_exists'));
		$uploadOk = 0;
	}
	
	// Check file size
	if ($_FILES["file"]["size"] > FILE_SIZE_MAX) {
		Session::flash(SUCCESS_MESSAGE, trans('admin.upload.file_too_large'));
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		Session::flash(SUCCESS_MESSAGE, trans('admin.upload.file_not_uploaded'));
	} else {
		// if everything is ok, try to upload file
		File::makeDirectory($target_dir, $mode = 0777, true, true);
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			// dd($uploadOk);
			Session::flash(SUCCESS_MESSAGE, trans('admin.upload.file_uploaded', ['filename'	=>	$filename]));
			
			// dd($dir_file);
			Session::flash(FILE_UPLOAD_SESSION, $dir_file);
			// Session::flash('FILE_UPLOAD_TYPE', $_FILES["file"]["type"]);
			// Session::flash('FILE_UPLOAD_NAME', pathinfo($filename, PATHINFO_FILENAME));
			Session::flash(FILE_UPLOAD_EXTENSION, pathinfo($filename, PATHINFO_EXTENSION));

			$uploadOk = 1;
		} else {
			Session::flash(SUCCESS_MESSAGE, trans('admin.upload.error_unknow'));
			$uploadOk = 0;
		}
	}

// dump('end upload', $uploadOk);
	return $uploadOk;
}

function doDownloadFileWithFullPath($fullPath, $time_limit = 0)
{
	try
	{
		ignore_user_abort(true);
		set_time_limit($time_limit); // disable the time limit for this script

		// $fullPath = $path_to_file; //"/absolute_path_to_your_files/"; // change the path to fit your websites document structure
		// $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file_name);//$_GET['download_file']); // simple file name validation

		// if($is_filter)
		// 	$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters

		// $fullPath = $path.$dl_file;

		if ($fd = fopen ($fullPath, "r")) {
		    $fsize = filesize($fullPath);
		    $path_parts = pathinfo($fullPath);
		    $ext = strtolower($path_parts["extension"]);
		    switch ($ext) {
		        case "pdf":
		        header("Content-type: application/pdf");
		        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
		        break;
		        // add more headers for other content types here
		        default;
		        header("Content-type: application/octet-stream");
		        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
		        break;
		    }
		    header("Content-length: $fsize");
		    header("Cache-control: private"); //use this to open files directly
		    while(!feof($fd)) {
		        $buffer = fread($fd, 2048);
		        echo $buffer;
		    }
		}
		fclose ($fd);
		exit;
	}
	catch(Exception $e)
	{
		echo 'Lỗi khi tải file, có thể file không có trên server </br>';
		// echo $e->getMessage();

		exit;
	}
	
}

function doDownloadFileWithFileName($path_to_file, $file_name, $is_filter = true, $time_limit = 0)
{
	ignore_user_abort(true);
	set_time_limit($time_limit); // disable the time limit for this script

	$path = $path_to_file; //"/absolute_path_to_your_files/"; // change the path to fit your websites document structure
	$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $file_name);//$_GET['download_file']); // simple file name validation

	if($is_filter)
		$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters

	$fullPath = $path.$dl_file;

	if ($fd = fopen ($fullPath, "r")) {
	    $fsize = filesize($fullPath);
	    $path_parts = pathinfo($fullPath);
	    $ext = strtolower($path_parts["extension"]);
	    switch ($ext) {
	        case "pdf":
	        header("Content-type: application/pdf");
	        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
	        break;
	        // add more headers for other content types here
	        default;
	        header("Content-type: application/octet-stream");
	        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
	        break;
	    }
	    header("Content-length: $fsize");
	    header("Cache-control: private"); //use this to open files directly
	    while(!feof($fd)) {
	        $buffer = fread($fd, 2048);
	        echo $buffer;
	    }
	}
	fclose ($fd);
	exit;
}

//get actor string from actor id
function actor($actor_no)
{
	$actor_arr = explode(',', $actor_no);
	$actors = Constant::$actor;
	$actor = '';
	foreach ($actor_arr as $key => $value) {
		if ($key == count($actor_arr)-1) {
			$actor .= $actors[$value]; 
		} else {
			$actor .= $actors[$value].', ';
		}
		
	}

	return $actor;
}

//get dashboard item by user permission
function getDashboardItem($permissions)
{
	$actors = Constant::$actor;
	unset($actors[ADMIN]);

	$html = '';
	foreach ($actors as $key => $value) {
		if(in_array($key, $permissions) || in_array(ADMIN, $permissions)) {
			$html .= Form::dashboard_item(ICON_PEOPLE, COLOR_AQUA, url('admin/user-dashboard'), $value, 30);
		}
	}

	return $html;
}

//get dashboard menu item by user permission
function getMenuItem($permissions)
{
	$html = '';
	if (!empty($permissions)) {

		foreach ($permissions as $permission) {
			switch ($permission) {
				case ADMIN:
					$html .= Form::menu_item('Administrator', Constant::$admin_per);
					$html .= Form::menu_item('Report', Constant::$report_menu, ICON_MENU_CHART);
					break;
				case AUTHOR:
					$html .= Form::menu_item('Author', Constant::$author_per);
					break;

				case REVIEWER:
					$html .= Form::menu_item('Reviewer', Constant::$reviewer_per);
					break;  
				case COPY_EDITOR:
					$html .= Form::menu_item('Copy Editor', Constant::$copy_editor_per);
					break;
				case MANAGING_EDITOR:
					$html .= Form::menu_item('Managing Editor', Constant::$managing_editor_per);
					break;  
				case SECTION_EDITOR:
					$html .= Form::menu_item('Section Editor', Constant::$section_editor_per);  
					break;
				case LAYOUT_EDITOR:
					$html .= Form::menu_item('Layout Editor', Constant::$layout_editor_per);
					break;
				case SCREENING_EDITOR:
					$html .= Form::menu_item('Screening Editor', Constant::$screening_editor_per);
					break;
				case CHIEF_EDITOR:
					$html .= Form::menu_item('Chief Editor', Constant::$chief_editor);
					break;
			}
		}
	}
	// dump($html);
	// dd($permissions, ADMIN);

	return $html;
}

function fileAttachUrl($files = array(), $manuscript_status)
{
	if (!is_null($files)) {
		if ($manuscript_status == IN_SCREENING) {
			foreach ($files as $file) {
				if ($file->type == AUTHOR_FILE) {
					return url(FILE_PATH.'/'.$file->name);
				}
			}
		}
	}

	return '#';
}

//date format input: m/d/Y
function dateToTimestamp($date)
{
	return date('Y-m-d H:i:s', strtotime($date));
}

function getStageByStatus($status)
{
	switch ($status) {
		case IN_SCREENING:
			return SCREENING;
			break;
		case IN_REVIEW:
			return REVIEWING;
			break;
		case IN_EDITING:
			return EDITING;
		case PUBLISHED:
			return PUBLISHING;
		default:
			return SCREENING;
	}
}

function makeCurrentId($manuscript_id, $stage, $loop)
{
	return $manuscript_id.'_'.$stage.'_'.$loop;
}

function makeProcessName($stage, $loop)
{
	if ($stage == EDITING || $stage == PUBLISHING) {
        return trans(Constant::$stage[$stage]);
    } else {
        return trans(Constant::$stage[$stage]).' '.trans('admin.round').' '.$loop;
    }
}

function makeProcessNameById($id)
{
	if (is_null($id)) {
		return '-';
	}
	$attr = explode('_', $id);

	return makeProcessName($attr[1], $attr[2]);
}

//remove value from set1 and push it to set2
function popAndPush($set1, $set2, $value)
{
	$set1 = is_null($set1) ? [] : explode(',', $set1);
	$set2 = is_null($set2) ? [] : explode(',', $set2);

	if (($key = array_search($value, $set1)) !== false) {
		unset($set1[$key]);
	}

	if (empty($set2)) {
		$set2 = [$value];
	} else {
		array_push($set2, $value);
	}

	$set1 = trim(implode(',', $set1), ',');
	$set2 = trim(implode(',', $set2), ',');

	return ['set1' => $set1, 'set2' => $set2];
}

function findInSet($value, $set)
{
	if (is_null($set)) {
		return false;
	}
	$set = explode(',', $set);

	return in_array($value, $set);
}

//get check icon
function getCheckIcon($boolean)
{
	return $boolean ? '<i class="fa fa-check"></i>' : '-'; 
}

//get a specifict manuscript file from file collection by file type
function getFileByType($files, $type)
{
    if (!$files->isEmpty()) {

        return $files->whereLoose('type', $type)->last();
    } 

    return false;      
}

function replaceSymbolString($string, $old, $new)
{
	dump($string, $old, $new);
	$string = str_replace($old, $new, $string);

	return $string;
}

function replaceArraySymbolString($string, $array)
{
	foreach ($array as $value) {
		$string = replaceSymbolString($string, $value, $value . ' ');
	}

	return $string;
}
