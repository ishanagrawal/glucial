function createRequestObject(){
	var request_;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer"){
		request_ = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		request_ = new XMLHttpRequest();
	}
	
	return request_;
}
			
var http = new Array();
var http2 = new Array();
				
			
function getInfo(){
			
var curDateTime = new Date();
http[curDateTime] = createRequestObject();

http[curDateTime].open('get', 'textChat/refresh.php?chat_id=' + '{/literal}{$chat_id}{literal}');

http[curDateTime].onreadystatechange = function(){
	if (http[curDateTime].readyState == 4) 
	{
		if (http[curDateTime].status == 200 || http[curDateTime].status == 304) 
		{
			var response = http[curDateTime].responseText;
			document.getElementById('view_ajax').innerHTML = response;
			
		}
	}
}

http[curDateTime].send(null);
}


function getInfo2(){
var curDateTime = new Date();
http2[curDateTime] = createRequestObject();
http2[curDateTime].open('get', 'textChat/submit.php?chat='+ document.ajax.chat.value + '&chat_id=' + '{/literal}{$chat_id}{literal}');
//http2[curDateTime].onreadystatechange = function(){
//	if (http2[curDateTime].readyState == 4) 
//	{
//		if (http2[curDateTime].status == 200 || http2[curDateTime].status == 304) 
//		{
//			var response = http2[curDateTime].responseText;
//			alert(response);
//		}
//	}
//}
http2[curDateTime].send(null);
}

function send(){
	
	getInfo2();
	document.ajax.chat.value=" ";
}


function go(){
getInfo();
window.setTimeout("go()", 2000);
}

$(document).ready(function(){
go();
})			
