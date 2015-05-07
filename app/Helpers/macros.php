<?php
Form::macro('input_text', function($name, $label, $type = 'text', $help_block = '', $class = array()) {
	$html = '<div class="form-group">';
	$html .= Form::label($name, $label, ['class' => 'text-form-large']);
	$html .= '<p class="help-block-custom ">'.$help_block.'</p>';

	$class = (!empty($class)) ? implode(' ', $class) : '';
	$class = 'form-control '. $class;

	switch ($type) {
		case 'email':
			$html .= Form::email($name, null, ['class' => $class]);
			break;
		case 'password':
			$html .= Form::password($name, ['class' => $class]);
			break;
		
		default:
			$html .= Form::text($name, null, ['class' => $class]);
			break;
	}
	$html .= '</div>';

	return $html;
});

Form::macro('output_text', function($label, $content) {
	$html = '<dt>'.$label.'</dt>';
	$html .= '<dd>'.$content.'</dd>';

	return $html;
});

Form::macro('input_file', function($name, $label, $help_block = '') {
	$html = '<div class="form-group">';
	$html .= Form::label($name, $label, ['class' => 'text-form-large']);
	$html .= '<p class="help-block-custom ">'.$help_block.'</p>';
	$html .= Form::file($name);
	$html .= '</div>';

	return $html;
});

Form::macro('output_file', function($name, $url, $label, $download = 'download') {
	$html = '<div class="form-group">';
	$html .= Form::label($name, $label, ['class' => 'text-form-large']);
	$html .= '<br /><a href="'.$url.'" '.$download.'>'.$name.'</a>';
	$html .= '</div>';

	return $html;
});

Form::macro('output_list', function($title, $list = array()) {
	$html = '<h3>'.$title.'</h3><ul>';
	foreach ($list as $value) {
		$html .= '<li>'.$value.'</li>';
	}
	$html .= '</ul>';

	return $html;
});

Form::macro('section', function($title, $comment, $decide = false, $anchor = false) {
	$anchor = $anchor ? $anchor : '';
	$html = '<section id="">';
	$html .= '<h2 class="page-header"><a href="#'.$anchor.'">'.$title.'</a></h2>';
	$html .= '<div class="lead">'.$comment.'</div>';
	//dd(trans(Constant::$full_decide[$decide]));
	if ($decide !== false) {
		$html .= '<b>'.trans(isset(Constant::$full_decide[$decide]) ? Constant::$full_decide[$decide] : '-').'</b>';
	}
	
	$html .= '</section>';

	return $html;
});

Form::macro('editor', function($label, $name, $disabled = false, $type = 'ck_editor',$content = null) {
	$options = ['id' => $name, 'rows' => 10, 'cols' => 80];

	if ($type == 'html5') {
		$html = '<script type="text/javascript">
		            $(function() {
		                //bootstrap WYSIHTML5 - text editor
		                $("#'.$name.'").wysihtml5();
		            });
		        </script>';
		$options['class'] = 'textarea';
		$tools = '<div class="pull-right box-tools">
                    <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                 </div><!-- /. tools -->';
	} else {
		$html = '<script type="text/javascript">
		            $(function() {
		                // Replace the <textarea id="editor1"> with a CKEditor
                		// instance, using default configuration.
		                CKEDITOR.replace("'.$name.'");
		            });
		        </script>';
		$tools = '';
	}

	if ($disabled) {
		$options['disabled'] = 'disabled';
	}

	$html .= '<div class="box-header">';
	$html .= '<h3 class="box-title">'.$label.'</h3>';
	$html .= $tools;
	$html .= '</div><!-- /.box-header -->';
    $html .= '<div class="box-body pad">
    		 '.Form::textarea($name, $content, $options).'
            </div>';

	return $html;
});

Form::macro('date_range', function($name, $label, $time = false) {
	$icon = $time ? '<i class="fa fa-clock-o"></i>' : '<i class="fa fa-calendar"></i>';
	$html = '<div class="form-group">
                <label>'.$label.':</label>
                <div class="input-group">
                    <div class="input-group-addon">'.
                        $icon
                    .'</div>'.
                    Form::text($name, null, ['class' => 'form-control pull-right', 'id' => $name, 'readonly' => 'readonly'])
                .'</div><!-- /.input group -->
            </div><!-- /.form group -->';
    $config = $time ? "timePicker: true, timePickerIncrement: 1, format: 'DD/MM/YYYY,HH:MM:SS'" : "timePickerIncrement: 1, format: 'DD/MM/YYYY'";
    $html .= '<script type="text/javascript">
            	$(function() {
            		$(\'#'.$name.'\').daterangepicker({'.$config.'});
            	});
              </script>';

    return $html;
});

Form::macro('date_pick', function($name, $label) {
	return '<div class="form-group">
                <label>'.$label.':</label>
                <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i></div>'.
                    Form::text($name, null, ['class' => 'form-control pull-right', 'id' => $name, 'readonly' => 'readonly'])
                .'</div><!-- /.input group -->
            </div><!-- /.form group -->
            <script type="text/javascript">
            	$(function() {
            		$(\'#'.$name.'\').datepicker({
            			format: \'mm/dd/yy\',
            			enableOnReadonly: true
            		});
            	});
              </script>';
});

Form::macro('multi_select', function($name, $label, $value = array(), $help_block = '') {
	//translate data
	foreach ($value as $key => $item) {
		$value[$key] = trans($item);
	}

	$html = '<div class="form-group">';
	$html .= Form::label($name, $label, ['class' => 'text-form-large']);
	$html .= '<p class="help-block-custom ">'.$help_block.'</p>';
	$html .= Form::select($name, $value, null, ['class' => 'chosen-select', 'multiple' => 'multiple']);
	$html .= '</div>';

	return $html;
});

Form::macro('input_select', function($name, $label, $value = array(), $help_block = '', $disabled = false) {
	//translate data
	foreach ($value as $key => $item) {
		$value[$key] = trans($item);
	}

	$options = ['class' => 'form-control'];
	if ($disabled == true) {
		$options['disabled'] = 'disabled';
	}

	$html = '<div class="form-group">';
	$html .= Form::label($name, $label, ['class' => 'text-form-large']);
	$html .= '<p class="help-block-custom ">'.$help_block.'</p>';
	$html .= Form::select($name, $value, null, $options);
	$html .= '</div>';

	return $html;
});


Form::macro('multi_check', function($name, $value = array()) {
	$html = '';
	if (!empty($value)) {
		foreach ($value as $key => $item) {
			$html .= '<div class="checkbox">';
			$html .= Form::checkbox($name.'[]', $key);
			$html .= $item;
			$html .= '</div>';
		}
	}
	
	return $html;
});

Form::macro('input_check', function($name, $label, $value = true) {
	$html = '<div class="form-group">
				<input type="checkbox" name="'.$name.'" value="'.$value.'" /> '.$label.'
			</div>';
});

Form::macro('input_radio', function($name, $label = '', $value = array()) {
	$html =    '<label class="col-sm-2 control-label">'.$label.'</label>';
	if (!empty($value)) {
		foreach ($$value as $key => $item) {
			$html .= '<label class="radio-inline">';
			$html .= Form::radio($item, $key);
			$html .= '</label>';
		}
	}
	
	return $html;
});

// Custom label 
Form::macro('label_custom', function($content = 'label', 

									$class = '', 
									$is_required_symbol = false){
	$span = ($is_required_symbol) ? ' <span style="color: red">*</span>' : '';

	return $result = '<label for="type" class="' . $class . '">' . $content . $span . '</label>';
});

// Custom combobox
Form::macro('combobox_custom', function($name = 'combobox', 
										$data = array(), 
										$class = 'form-control',
										$is_multiple = true,
										$disabled = false,
										$selected = null){
	$disabled = ($disabled) ? ' disabled ' : '' ;
	if($is_multiple)

		return $result = Form::select($name, $data, $selected, ['class' => $class, 'multiple' => 'multiple', $disabled => '', 'name' => $name . '[]']);
	
	return $result = Form::select($name, $data, $selected, ['class' => $class, $disabled => '', 'name' => $name . '[]']);
});

// Custom help block style
Form::macro('help_block', function($content = '', $class = ''){

	return '<p class="help-block-custom ' . $class . '">' . $content . '</p>';
});

// Custom textarea
Form::macro('textarea_custom', 
				function($name = '', 
						$content = '',
						$rows = 5, 
						$placeholder = 'Enter something...', 
						$class = 'form-control',
						$attr = ['' => ''],
						$disabled = false){
					// dd('dfjkls');
	$disabled = ($disabled) ? ' disabled ' : '' ;

	if ($rows == 1) {

		return $result = Form::text($name, $content, ['class' => $class, 'placeholder' => $placeholder, $disabled => '',  key($attr) => current($attr)]);
	} 

	return $result = Form::textarea($name, $content, array_merge(['class' => $class, 'placeholder' => $placeholder, $disabled => '', 'rows' => $rows], $attr));
});

// Custom image
Form::macro('image_custom', function($src = '', $alt = 'Image', $class = IMAGE_CIRCLE){

	return '<img src="' . $src . '" class="' . $class . '" alt="' . $alt . '">';
});

// Create custom menu item 
Form::macro('menu_item', function ($menu_name = 'menu', 
							$childs = ['Menu' => '#'],
							$icon_menu_class = ICON_MENU_SPEED_DIAL, 
							$is_active = 0,
							$menu_link = '#'
							)
{
	$total_items = count($childs);
	if($total_items == 0 and $is_active == 0){

		return '<ul class="sidebar-menu">
					<li>
						<a href="#">
							<i class="fa ' . $icon_menu_class . '"></i>
							<span>' . $menu_name . '</span>
						</a>
					</li>
				</ul>';
	} 
	else 
	{
		$result = '<ul class="sidebar-menu">';
		$result = $result . '<li class="treeview">
								<a href="#">
									<i class="fa ' . $icon_menu_class . '"></i>
									<span>' . $menu_name . '</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
							 <ul class="treeview-menu">';
		
		foreach ($childs as $key => $value) {
			$result = $result . '<li><a href="' . url($value) . '" style="margin-left: 10px;">
										<i class="fa fa-angle-double-right"></i> '. trans($key) .'</a></li>';
	}
	
	return $result . '</ul></li></ul>';
	}
});

// Create dashboard item
Form::macro('dashboard_item', function($icon_class = ICON_DOCUMENT_TEXT, 
												$color_class = COLOR_LIME, 
												$link = '#', 
												$title = 'Box', 
												$new_notify_number = 0){

	return $result = '<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box ' . $color_class . '">
						<div class="inner">
							<h3>
								' . $new_notify_number . '
							</h3>
							<p>' . $title . '</p>
						</div>
						<div class="icon">
							<i class="ion ' . $icon_class . '"></i>
						</div>
						<a href="' . $link . '" class="small-box-footer">
							Xem Thêm <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>';

});

// Create navigate link
Form::macro('navigate_link', function($icon_class = MENU_ICON_DASHBOARD, 
										$navigate_links = array('#' => '#' )){
	if (empty($navigate_links)) {
		
		return $result = '<ol class="breadcrumb">
							<li><a href="' . current($navigate_links) . '"><i class="fa ' . $icon_class . '">
								</i> Trang chủ</a></li></ol>';
	} 

	$result = '<ol class="breadcrumb">
				<li><a href="' . current($navigate_links) . '"><i class="fa ' . $icon_class . '">
					</i> ' .  key($navigate_links) . '</a></li>';
	next($navigate_links);
	$count = count($navigate_links);
	for($i = 1; $i < $count; $i++){
		$result = $result . '<li><a href="' . current($navigate_links) . '">' . key($navigate_links) . '</a></li>';
	}

	return $result . '</ol>';
});

// Header Form for Input
Form::macro('title_box_header', function($title){
	
	return '<div class="box-header">
				<h3 class="box-title">' . $title . '</h3>
			</div><!-- /.box-header -->';
});

// Custom <ul> for dashboard
Form::macro('ul_custom', function($data = [''],
									$links = array(), 
									$new_notify_number = array(),
									$ul_class = '', 
									$li_class = ''){

	$result = '<ul class="' . $ul_class . '">';
	$count_links = count($links);
	$count = count($data);
	if (empty(count($links))) {
		for($i = 0; $i < $count; $i++)
			$result = $result . '<li class="' . $li_class . '">' . $data[$i] . '</li>';

		return $result;
	}
	
	for($i = 0; $i < $count; $i++)
		if($count_links >= $i)
			$result = $result . '<li class="' . $li_class . '"><a href="' . url($links[$i]) . '">' . trans($data[$i]) . '</a></li>';

	$result = $result . '</ul';

	return $result;
});

// Custom div
Form::macro('div_open', function($class = '', $id = ''){

	return '<div class="' . $class . '" id ="' . (empty($id) ?  '' : $id ) . '">';
});

Form::macro('div_close', function(){

	return '</div>';
});

// Custom <h>
Form::macro('h_custom', function($level_number = 3, $content = '', $class = ''){

	return '<h' . $level_number . ' class="' . $class . '">' . $content . '</h' . $level_number . '>';
});

// Select form with selected value and other options.
Form::macro('mySelectList', function($attributeValueList , $options = array(), $attr_name='attribute_value'){
	$selectors = [];
	// if(!empty($options['select_none'])) { // Add none select option on select form
	//     $selectors += [ATTRIBUTE_VALUE_NOT_SET => $options['select_none']];
	// }   
	foreach ($attributeValueList as $attrKey => $attrValue) {
		$selectors += [$attrKey => $attrValue];
	}   

	return Form::select($attr_name, $selectors, isset($options['default']) ? $options['default'] : null, array('id' => $options['id'], 'name' => $options['name']));
});





