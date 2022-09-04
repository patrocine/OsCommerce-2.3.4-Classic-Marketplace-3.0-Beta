// AjaxAsynch class
function AjaxAsynch() {
}

function AjaxRequestObj(){
  var zHRObj=false;
  if (window.XMLHttpRequest) {
    zHRObj = new XMLHttpRequest();
    if (zHRObj.overrideMimeType) {
      zHRObj.overrideMimeType("text/xml");
    }
  }else if (window.ActiveXObject){
    try{
    zHRObj = new ActiveXObject("Microsoft.XMLHTTP");
    }catch(e){
      try{
      zHRObj = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {}
    }
  }
  return zHRObj;
}


function AjaxAsynch_call(url) {
	var instance = this;
	zHTTP_Req=AjaxRequestObj();
	if (!zHTTP_Req) {
		alert("Invalid Request Object(AJAX Error 02)");
		return false;
	}

	zHTTP_Req.onreadystatechange = function(){
		switch (zHTTP_Req.readyState) {
			case 1: instance.loading(); break;
			case 2: instance.loaded(); break;
			case 3: instance.intractive(); break;
			case 4: instance.complete(zHTTP_Req.status, zHTTP_Req.statusText,zHTTP_Req.responseText, zHTTP_Req.responseXML); break;
		}
	}
	zHTTP_Req.open("GET", url, true);
	zHTTP_Req.send(null);
}

function AjaxAsynch_post(url, params) {
	var instance = this;
	zHTTP_Req=AjaxRequestObj();
	if (!zHTTP_Req) {
		alert("Invalid Request Object(AJAX Error 02)");
		return false;
	}

	zHTTP_Req.onreadystatechange = function(){
		switch (zHTTP_Req.readyState) {
			case 1: instance.loading(); break;
			case 2: instance.loaded(); break;
			case 3: instance.intractive(); break;
			case 4: instance.complete(zHTTP_Req.status, zHTTP_Req.statusText,zHTTP_Req.responseText, zHTTP_Req.responseXML); break;
		}
	}
	zHTTP_Req.open("POST", url, true);
	zHTTP_Req.send(params);
}

function AjaxAsynch_loading() {}
function AjaxAsynch_loaded() {}
function AjaxAsynch_intractive() {}
function AjaxAsynch_complete() {}

AjaxAsynch.prototype.loading = AjaxAsynch_loading;
AjaxAsynch.prototype.loaded = AjaxAsynch_loaded;
AjaxAsynch.prototype.intractive = AjaxAsynch_intractive;
AjaxAsynch.prototype.complete = AjaxAsynch_complete;
AjaxAsynch.prototype.call = AjaxAsynch_call;
AjaxAsynch.prototype.post = AjaxAsynch_post;

// end of class AjaxAsynch









// ajax functionality
function ajaxFunction(sourceFile,idName) {
	
  // set loader
  document.getElementById(idName).innerHTML='<div style="padding-top:20px;" align="center"><img src="images/loader.gif" alt="" /></div>';
  
  var xmlHttp;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
	
	xmlHttp.onreadystatechange=function()
      {
      if(xmlHttp.readyState==4)
        {
       	document.getElementById(idName).innerHTML=xmlHttp.responseText;


		// if this is not the initial page 
		if(blnInitialLoad) {
			addToRecentlyViewed(); // "add clicked recipe data to cookie"
			//alert(document.getElementById("home").innerHTML);
		}

	
			
      }
    }
	  
	var params = "?xml="+sourceFile
//    xmlHttp.open("GET","loadxml.asp"+params,true);
//    xmlHttp.send(null);
	document.getElementById(idName).innerHTML= "TATA";
	
	
	
  }

