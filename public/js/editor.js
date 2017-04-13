function Editor(elementId){
	this.elementId = "#"+elementId;

	/*
	buttons
	 */
	this.buttons = ["b", "i", "blue_text", "red_text"];
	
	var textarea = document.getElementById(elementId);


	$(this.elementId).before('<div class="editorNavigation"></div>');
	this.buttons.forEach(function(element) {
		$(this.elementId).prev(".editorNavigation").append('<span class="editorButton" data-type="'+element+'">'+element+'</span>')
	}); 


	$(this.elementId).prev(".editorNavigation").find(".editorButton").click(function(){
		var buttonType = $(this).attr("data-type");
		var textareaText = textarea.value;
		var selectionText = getSelection(textarea);
		var cursorPosition = getCaret(textarea);

		/*
		buttons event
		 */
		switch(buttonType){ 
			case "b": 
					replaceText(textarea, cursorPosition, textareaText, selectionText, '<span class="fbold">' + selectionText + '</span>');
				break;
			case "i":  
					replaceText(textarea, cursorPosition, textareaText, selectionText, '<span class="fitalic">' + selectionText + '</span>');
				break;
			case "blue_text": 
					replaceText(textarea, cursorPosition, textareaText, selectionText, '<span class="blue">' + selectionText + '</span>');
				break;
			case "red_text": 
					replaceText(textarea, cursorPosition, textareaText, selectionText, '<span class="red">' + selectionText + '</span>');
				break;
		}
	});

	$(this.elementId).keyup(function(event){  
		var textareaText = textarea.value;
		var cursorPosition = getCaret(textarea);

		switch(event.keyCode){
			case 13:
				textarea.value = textareaText.substr(0, cursorPosition-1) + "<br/>\n" + textareaText.substr(cursorPosition);
				cursor_to_pos(textarea, cursorPosition+5);
				break;
		}
	});
}


function replaceText(textarea, cursorPos, oldText, searchText, newText){
	var firstPart = oldText.substr(0, cursorPos);
	var secondPart = oldText.substr(cursorPos + searchText.length);
	
	textarea.value = firstPart + newText + secondPart;

	cursor_to_pos(textarea, (firstPart + newText).length);
}
// Флаги для определения браузеров
var uagent    = navigator.userAgent.toLowerCase();
var is_safari = ( (uagent.indexOf('safari') != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var is_ie     = ( (uagent.indexOf('msie') != -1) && (!is_opera) && (!is_safari) && (!is_webtv) );
var is_ie4    = ( (is_ie) && (uagent.indexOf("msie 4.") != -1) );
var is_moz    = (navigator.product == 'Gecko');
var is_ns     = ( (uagent.indexOf('compatible') == -1) && (uagent.indexOf('mozilla') != -1) && (!is_opera) && (!is_webtv) && (!is_safari) );
var is_ns4    = ( (is_ns) && (parseInt(navigator.appVersion) == 4) );
var is_opera  = (uagent.indexOf('opera') != -1);  
var is_kon    = (uagent.indexOf('konqueror') != -1);
var is_webtv  = (uagent.indexOf('webtv') != -1);

var is_win    =  ( (uagent.indexOf("win") != -1) || (uagent.indexOf("16bit") !=- 1) );
var is_mac    = ( (uagent.indexOf("mac") != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var ua_vers   = parseInt(navigator.appVersion);

// Сама функция
function getSelection( textarea ){
    var selection = null;
    if ((ua_vers >= 4) && is_ie && is_win) {
        if (textarea.isTextEdit) {
            textarea.focus();
            var sel = document.selection;
            var rng = sel.createRange();
            rng.collapse;
            if((sel.type == "Text" || sel.type == "None") && rng != null)
                selection = rng.text;
        }
    } else if (typeof(textarea.selectionEnd) != "undefined" ) { 
        selection = (textarea.value).substring(textarea.selectionStart, textarea.selectionEnd);
    }
    return selection;
} 
 
function getCaret(el) { 
  if (el.selectionStart) { 
    return el.selectionStart; 
  } else if (document.selection) { 
    el.focus(); 
 
    var r = document.selection.createRange(); 
    if (r == null) { 
      return 0; 
    } 
 
    var re = el.createTextRange(), 
        rc = re.duplicate(); 
    re.moveToBookmark(r.getBookmark()); 
    rc.setEndPoint('EndToStart', re); 
 
    return rc.text.length; 
  }  
  return 0; 
}

function cursor_to_pos(area, pos){
	// Выполняет: перемещение курсора (cursor) textarea в нужном месте 

	// Для всех Нормальных браузеров  
	if (area.selectionStart){// узнаем длину содержимого textarea 

	 	// активируем фокус ввода на объекте
	 	area.focus();
	 	// перемещаемся в  нужном месте
	 	area.setSelectionRange(pos,pos);
	 	// aктивируем фокус ввода на объекте
	 	area.focus();
	}

	// отдельная корявка под Internet Explorer
	if (area.createTextRange){// выделяем весь текст
	 	var r=area.createTextRange();

 		// Свойство collapsed вернет true, если граничные точки имеют
	 	// одинаковые контейнеры и смещение (false в противном случае)
		r.collapse(false);
		r.select();
	}
}