	var preloadedData;
 	function generateNextPageURL() {
 		if(pageNext < pageCount) {
	 		pageNext = pageNext + 1;
 			splitPageResultsAjax = pageURL + "&" + pageName + "=" + pageNext;
 		} else
 			splitPageResultsAjax = "";
 	}
  	
  	function preloadData() {
          var ajax = new AjaxAsynch();
            ajax.complete = function(status,statusText, responseText, responseXML) {
              var responce = responseText;
              lines = responce.split("\n");
              preloadedData = "";
				for(i = 0; i < lines.length; i++) {
					if(lines[i].indexOf('!--  ajax_results_begining') == 1)
						preloadedData = " ";
					else if(lines[i].indexOf('ajax_results_ending') > 0 && preloadedData.length > 0) 
						return;
					else if (preloadedData.length > 0)
						preloadedData = preloadedData +  lines[i];
				}
              
              return true;
            }
          if(splitPageResultsAjax.length > 0)
          	ajax.call(splitPageResultsAjax);
          else
          	hideShowMore();
  };
	
	function hideShowMore() {
		var showMoreTable = document.getElementById("splitPageResultsAjaxTable");
		if(showMoreTable!=null)
			showMoreTable.style.visibility="hidden";
	}

	function showMoreResults() {
		var productsGridTable = document.getElementById('productsGrid');
		productsGridTable.innerHTML =  productsGridTable.innerHTML + preloadedData;
		generateNextPageURL();
		window.setTimeout("preloadData()",1000);
	}
