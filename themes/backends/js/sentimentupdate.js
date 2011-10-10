var xmlHttp

function callAjaxSentiment(id,sentiment) {
	
	var siteUrl = $("meta[name=site_url]").attr('content');

	if (id.length==0) { 
  	return
  } 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null) {
  	alert ("Browser does not support HTTP Request")
  	return
  } 
	var url= siteUrl+'/tweet/post_sentiment/'+id+'/'+sentiment;
	
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}


function stateChanged(){ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
 		window.location.reload();
 	} 
}

function GetXmlHttpObject() {
	var xmlHttp=null;
	try {
 		// Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
 	}
	catch (e) {
 		// Internet Explorer
 			try {
  			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		}
 			catch (e) {
  			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  		}
 	}
	return xmlHttp;
}