/*
 * Default CKEditor preset and connector
 */

var ckeditorClasses = Array();
ckeditorClasses['editor'] = 'editor'; // Full editor
ckeditorClasses['medieditor'] = 'medieditor'; // Medium editor
ckeditorClasses['minieditor'] = 'minieditor'; // Mini editor

function ckeditorReplace() {
	var textareas = document.getElementsByTagName('textarea');
	for (var i = 0; i < textareas.length; i++) {
		var textareaClass = textareas[i].getAttribute('class');
		if (textareaClass && textareaClass.indexOf(ckeditorClasses['editor']) !== -1) {
			var textareasStyle = getComputedStyle(textareas[i], null) || textareas[i].currentStyle;
			CKEDITOR.replace(textareas[i], {height:textareasStyle.height, width:'100%', toolbar: ckeditorClasses[textareas[i].getAttribute('class')]});
		}
	}
}

if (typeof jQuery == 'undefined') {
	if (window.addEventListener) {
		window.addEventListener('load', ckeditorReplace, false);
	} else if (window.attachEvent) {
		window.attachEvent('onload', ckeditorReplace);
	} else {
		window.onload = ckeditorReplace;
	}
} else {
	$(document).ready(ckeditorReplace);
	ajaxSuccessHandlers.push(ckeditorReplace);
}
