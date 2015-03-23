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
	$target_dir = public_path() . FILE_PATH . '/' . str_random(9);// $_FILES["file"]["tmp_name"] ;
	$filename = str_replace(' ', '_', basename($_FILES["file"]["name"]));
	$target_file = $target_dir . '/' . $filename;
	$uploadOk = 1;

	// Check if file already exists
	if (file_exists($target_file)) {
		Session::flash('SUCCESS_MESSAGE', trans('admin.upload.file_exists'));
		$uploadOk = 0;
	}
	
	// Check file size
	if ($_FILES["file"]["size"] > FILE_SIZE_MAX) {
		Session::flash('SUCCESS_MESSAGE', trans('admin.upload.file_too_large'));
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		Session::flash('SUCCESS_MESSAGE', trans('admin.upload.file_not_uploaded'));
	} else {
		// if everything is ok, try to upload file
		File::makeDirectory($target_dir, $mode = 0777, true, true);
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			Session::flash('SUCCESS_MESSAGE', trans('admin.upload.file_uploaded', ['filename'	=>	$filename]));
			Session::flash('FILE_UPLOAD_SESSION', $target_file);
			$uploadOk = 1;
		} else {
			Session::flash('SUCCESS_MESSAGE', trans('admin.upload.error_unknow'));
			$uploadOk = 0;
		}
	}

	return $uploadOk;
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
			}
		}
	}

	return $html;
}

//get check icon
function getCheckIcon($boolean)
{
	return $boolean ? '<i class="fa fa-check"></i>' : '-'; 
}
