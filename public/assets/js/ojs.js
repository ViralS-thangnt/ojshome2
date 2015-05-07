// ojs.js

// Counter character in control
function countChar(val, max, min, colorok, colorerror, divname) {
	var len = val.value.length;
	if (len > max) {
		// val.value = val.value.substring(0, 10);
		$('#' + divname).text('Bạn đã nhập quá số ký tự cho phép').css({'color' : colorerror});
	} else if(len < min) {
		$('#' + divname).text('Số ký tự không thể ít hơn ' + min + ' ký tự').css({'color' : colorerror});
	} else {
		$('#' + divname).text('Số ký tự hiện tại ' + len + '. Số ký tự có thể nhập thêm: ' + (max - len) + ' ký tự').css({'color' : colorok});
	}
}

// Counter words in control
function countWords(val, max, min, colorok, colorerror, divname){         
	// s = document.getElementById(val).value;         
	s = val.value;
	// s = s.replace(/(^\s*)|(\s*$)/gi,"");         
	// s = s.replace(/[ ]{2,}/gi," ");         
	// s = s.replace(/\n /,"\n");         
	var len = s.split(' ').length; 

	if (len > max) {
		$('#' + divname).text('Bạn đã nhập quá số từ cho phép là : ' + len + ' từ . Chỉ được nhập tối đa ' + max + ' từ').css({'color' : colorerror});
	} else if(len < min) {
		$('#' + divname).text('Bạn đã nhập : ' + len + ' từ. Số từ nhập không thể ít hơn ' + min + ' từ').css({'color' : colorerror});
	} else {
		$('#' + divname).text('Số từ đã nhập : ' + len + ' từ. Số từ có thể nhập thêm: ' + (max - len) + ' từ').css({'color' : colorok});
	}
}

function resetText(idControl){
	
	var inp = $(idControl)[0]; // select the input with proper selector
	alert(idControl);
	var default_value = inp.value;

	inp.addEventListener("input", function () { 
		this.value = default_value;
	}, false);
}