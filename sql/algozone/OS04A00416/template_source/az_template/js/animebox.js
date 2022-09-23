
$(function(){ // wait for the document to load
		   
	  var globals = {
		  	session_id:				session_id,
            az_cart_fetch_file:		fetch_url ,
			az_cart_fetch: 			false,
            az_loading_image: 		'<div class="animBoxCartLoading"></div>',
			az_cart_image_width: 	image_width,
			az_cart_image_height: 	image_height,
			az_cart_opacity: 		0.9,
			az_box_status: 			false,
			az_timer: 				"",
			az_speed: 				"fast",
			text_cart_quantity: 	text_cart_quantity,
			text_cart_subtotal:	 	text_cart_subtotal,
			text_cart_empty:		text_cart_empty,
			cart_text:				cart_text,
			cart_link:				cart_link
			
        };
	  $("#animBoxCart").html(globals.az_loading_image);
	  $("#btn_animBoxCart").hover(					
					function(){						
						retrievecart();
						clearTimeout(globals.az_timer);
						animatedbox("show");	   					
	 				},
					function(){							
	   					globals.az_timer = setTimeout('animatedbox("hide")',400);
	 				}
		);	  
	  $("#animBoxCart").hover(					
					function(){clearTimeout(globals.az_timer);animatedbox("show");},
					function(){globals.az_timer = setTimeout('animatedbox("hide")',400);
	 				}
		);	  
	  animatedbox = function(action){	
	  		if(action=="show") $("#animBoxCart").animate({height: "show", opacity: "show"}).animate({opacity:globals.az_cart_opacity});	
			else $("#animBoxCart").animate({height: "hide", opacity: "hide"});
	  }
	  retrievecart = function(){
		  $.ajax({
				url: globals.az_cart_fetch_file,
				dataType: "xml",				
				success: function(returned_data){
						parsedata(returned_data);						
						globals.az_cart_fetch = true;
					}
				});
	  }
	  
	  parsedata = function(xml){		  
			var str = "";
			var image = "";
			var cart = xml.documentElement.firstChild;
		  	if(cart.childNodes.length > 0 ){				
				str = str + '<table border="0" width="100%" cellspacing="0" cellpadding="5">';
				str = str + '  <tr><td class="animBoxCartLink" colspan="2"><a href="' + globals.cart_link + '">' + globals.cart_text + '</a></td></tr>';
				for (var i = 0; i < cart.childNodes.length; i++){		
					try{name =  cart.getElementsByTagName("name")[i].childNodes[0].nodeValue;}catch(e){name = "Item";}
					try{attributes =  cart.getElementsByTagName("attributes")[i].childNodes[0].nodeValue;}catch(e){attributes = "";}
					try{llink =  cart.getElementsByTagName("link")[i].childNodes[0].nodeValue;}catch(e){llink = "http://www.algozone.com";}
					try{image =  cart.getElementsByTagName("image")[i].childNodes[0].nodeValue;}catch(e){image = "No Image";}
					try{qty =  cart.getElementsByTagName("qty")[i].childNodes[0].nodeValue;}catch(e){qty = "message";}
					try{price =  cart.getElementsByTagName("price")[i].childNodes[0].nodeValue;}catch(e){price = "$0.00";}
					
					dimension = (globals.az_cart_image_width ? 'width="' + globals.az_cart_image_width : '') + (globals.az_cart_image_height ? '" height="' + globals.az_cart_image_height + '"' : '');
					
					str = str + '  <tr>';
					str = str + '    <td class="animBoxCartImage" width="' + globals.az_cart_image_width + '" align="center"><a href="' + llink +'"><img src="' + image + '" ' + dimension + ' border="0" alt="' + name + '"></a></td>';
					str = str + '    <td class="animBoxCartContent" width="100%">';
					str = str + '      <div class="animBoxCartName"><a href="' + llink + '">' + name + '</a><br>' + attributes + '</div>';
					str = str + '      ' + globals.text_cart_quantity + ' ' + qty;
					str = str + '      <div class="animBoxCartPrice">' + price + '</a></div>';
					str = str + '      <a href="' + llink + '"> More Info </a>';
					str = str + '    </td>';
					str = str + '  </tr>';
			  	}  
				total = cart.nextSibling;
				str = str + '  <tr><td class="animBoxCartTotal" colspan="2"> Total &nbsp;' +total.childNodes[0].nodeValue + '</td></tr>';
				str = str + '</table>';
		  	}else{
				str = str + '<div class="animBoxCartNotice">' + globals.text_cart_empty + '</div>';
			}
		  $("#animBoxCart").html(str);	
	  }
		  
 });



