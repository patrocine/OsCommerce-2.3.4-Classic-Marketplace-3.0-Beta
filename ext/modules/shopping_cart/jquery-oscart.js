/* jQuery Shopping Cart 
 *
 * Published under GNU License 
 * 
 * 2010/07/01 - by delete ( olivier@smartmarseille.com )
 * 2010/07/14 - by delete ( olivier@smartmarseille.com ) - Added Attributes support
 * 2013/05/31 - by Dr. Rolex - Added support for product listing and osCommerce 2.3.3
 * 2013/06/03 - by Dr. Rolex - Supports multiple product images, Improved animation
 */
$(document).ready(function() {

// Add to cart for product_info page
//
$('.buttonAction_oscart').click(function()
{

// Partial Source code from :  http://webresourcesdepot.com/wp-content/uploads/file/jbasket/fly-to-basket/
		var productId = $(this).attr('id');    

		var $oldprod =  $('#cart-image-' + productId );
		//First we clone the image to the shopping cart and get the offset
		var $newprod = $oldprod.clone().appendTo('#boxcart-content');
		var newOffset = $('#boxcart-content').offset();
		
		//Get the old position
		var oldOffset = $oldprod.offset();
		//Clone the old image for use in animation
		var $tempprod = $oldprod.clone().appendTo('body');
		//Hide new image and set css attributes
		//Use big z-index, make sure to edit this to something that works with the page
		$tempprod
		  .css('position', 'absolute')
		  .css('left', oldOffset.left)
		  .css('top', oldOffset.top)
//		  .css('border', '1px dashed black'); //Optional dashed square around image
		  .css('zIndex', 1000);
		$newprod.hide();
//		$oldprod.hide(); //Optional hide image on start of animation (Uncomment $oldprod.show(); below together with this)

		//Animate the $tempprod to the position of $newprod
		$tempprod
			.animate({opacity: 0.4}, 40) //First value is how transparent image is at start of animation; Last value is millisec until animation starts
			.animate( {
				opacity: 0.0, // Transparency of image at end of animation
				'top': newOffset.top, // How high we will fly
				'left':newOffset.left, // How far we will fly
				width: $oldprod.width() / 3, // Resize image width on animation
				height: $oldprod.height() / 3 // Resize image height on animation
				}, 1000, function(){ // Value is total time for animation to finish
					
		   //Callback function, we remove $newprod and $tempprod
		   $newprod.remove();
		   $tempprod.remove();
//		   $oldprod.show(); //Optional show image on end of animation (Uncomment $oldprod.hide(); above together with this)
		   

          products_id = productId ;
          qty = parseInt($('#pq-' + productId).html());
		
          if ( qty )  qty = qty + 1 ; 
          else qty = 1 ;
     
          // Look for attributes
          //
          products_attributes = '' ;
          $('form[name=cart_quantity-' + productId + ']').find('select option:selected').each(function() {
               products_attributes += '{' + $(this).parent().attr('name').replace(/[^0-9]/g, '') + '}' + $(this).val() ; 
          });  
          if ( products_attributes != '' ) products_id = products_id + products_attributes;
               
          // Delete button in shopping cart infoboxe
          // 
          new_button = $('#boxcart-button-remove').clone() ;
          new_button.find('a').attr('id', 'bcr' + $('input[name="products_id"]').val()) ;
          new_button.find('a').attr('rel', products_id) ;

          // Products details in shopping cart infoboxe
          //
          product_name = '<tr id="pc-' + products_id + '"><td align="right" valign="top"><span class="newItemInCart">';
          product_name += '<span id="pq-' + products_id +  '">' + qty +'</span>&nbsp;x&nbsp;</span></td><td valign="top"><span class="newItemInCart">'  ; 
          product_name += $('#pi-product-info-' + productId).html() ;
          product_name += '</span>' ;
          product_name += new_button.html()  ;
          product_name += '<input type="hidden" name="products_id[]" value="' + products_id + '" />'  ;
          product_name += '<input type="checkbox" name="cart_delete[]" value="' + products_id + '" style="display:none;" />'  ;
          product_name += '</td></tr>' ;

          // Updating infobox content Ta bort Dubblering
          $("#boxcart-total-area").show();

          $.ajax({
              type: 'POST',
              url: encodeURI($('form[name=cart_quantity-' + productId + ']').attr('action')) + '&show_total=1&ajax=1',
              data: $('form[name=cart_quantity-' + productId + ']').serialize(),
              success: function(data) {
                  $('#boxcart-total').html(data);
				  update_cart();
              }
           });


          // Remove product from infobox list
          // 
          $('tr[id=pc-' + products_id + ']').remove() ;
          
          // Product count 
          //
          count = $('tr[id^="pc-"]').size() ;

          if ( count == 0 ) $('#boxcart-content').html('') ;

		//update_cart();
          
          // Append product to the list
          $('#boxcart-content').append( product_name ) ;
          
          $('#' + new_button.find('a').attr('id') ).click(function()
          {
            return($(this).boxcart_remove());
          });
          


        });

return(false) ;

});

// Update cart infobox
//
function update_cart()
{
   $.ajax({
        type: 'POST',
		url: encodeURI($('form[name=boxcart_quantity]').attr('action')) + '&count_contents=1&ajax=1',
        data: $('form').serialize(),
        success: function(data) {
            $('#headercart').html(data);
            }
        });
   return(false);	

}

// Remove from cart infobox 
//
$.fn.boxcart_remove = function() { 

   products_id = $(this).attr('rel') ;

   if ( ! confirm( $('#boxcart-text-remove').html() + ' ?' ) ) return false ;
                      
   $('input[value="' + products_id + '"][name=\"cart_delete[]\"]').attr('checked', true) ;

  // Refresh entire page if current page is shopping_cart.php !
  //
  url = $(location).attr('href').split("/");
  filename = url[url.length - 1];
  filename = filename.split('\?')[0] ;           
  
  if ( filename == 'shopping_cart.php' ) 
  {
    $('form[name=boxcart_quantity]').submit(); 
  }

    // Updating cart total
    //
    $.ajax({
        type: 'POST',
        url: encodeURI($('form[name=boxcart_quantity]').attr('action')) + '&show_total=1&ajax=1',
        data: $('form[name=boxcart_quantity]').serialize(),
        success: function(data) {
            $('#boxcart-total').html(data);
            update_cart();
            }
        });
        
  $('tr[id=pc-' + products_id + ']').remove() ;

  // Product count 
  //
  count = $('tr[id^="pc-"]').size() ;

  if ( count == 0 ) {
	$("#boxcart-total-area").hide();
	$('#boxcart-content').html('<tr><td align="right" valign="top">' + $('#boxcart-text-empty').html() + '</td></tr>') ;
  }

  return(false);        
}
$('.boxcart-remove').click(function()
{
  return($(this).boxcart_remove());
});

// Remove from cart
//
$.fn.cart_remove = function() 
{
    products_id = $(this).attr('rel') ;

    $('tr[id=pc-' + products_id + ']').remove() ; ;
      
    $('input[value="' + products_id + '"][name=\"cart_delete[]\"]').attr('checked', true) ;

	$.ajax({
        type: 'POST',
        url: encodeURI($('form[name=cart_quantity]').attr('action')) + '&show_total=1&ajax=1', 
        data: $('form').serialize(),
        success: function(data) {
            $('#boxcart-total').html(data);
            }
        });
    
    $.ajax({
        type: 'POST',
        url: encodeURI($('form[name=cart_quantity]').attr('action')) + '&ajax=1',
        data: $('form[name=cart_quantity]').serialize(),
        success: function(data) {
          $("#content-body").html(data);
          update_cart();
        },
        dataType: 'html'
      });
    return(false);
}
$('.cart-remove').click(function()
{
  return($(this).cart_remove());
});


// Plus or Minus function
//
$('.update-qty').click(function()
{
  products_id = $(this).attr('rel') ;

  val = parseInt( $('input[id="pl' + products_id + '"][name=\"cart_quantity[]\"]').val() ) ;

  action = $(this).attr('class').split(' ').slice(-1) ;
     
  if ( action  == 'plus' ) 
  {
    val = val + 1 ;
  }
  else if ( action == 'moins' )
  {
    if ( val <= 0 ) return(false) ;
    val = val - 1 ;
  } 
  else
  {
    return(false) ;
  }
  
  $('input[id="pl' + products_id + '"][name=\"cart_quantity[]\"]').val(val) ;

    // osCommerce default shopping cart infoboxe product line :
    //
    product_name = '<tr id="pc-' + products_id + '"><td align="right" valign="top"><span class="newItemInCart">';
    product_name += '<span id="pq-' + products_id + '">' + val + '</span>&nbsp;x&nbsp;</span></td><td valign="top"><span class="newItemInCart">';
    product_name += $('span[id=pn-' + products_id + ']').html() ;
    product_name += '</span>';
    product_name += $('#boxcart-button-remove').html() ;
    product_name += '<input type="hidden" name="products_id[]" value="' + products_id + '" />'  ;        
    product_name += '<input type="checkbox" name="cart_delete[]" value="' + products_id + '" style="display:none;" />';
    
    // Look for attributes
    //
    products_attributes = '' ; 
    $('form[name=cart_quantity]').find('select option:selected').each(function() {
      products_attributes += '{' + $(this).parent().attr('name').replace(/[^0-9]/g, '') + '}' + $(this).val() ; 
    });  
    if ( products_attributes != '' ) products_id = products_id + products_attributes;

    product_name += '</td></tr>' ;
  
    // Updating infobox content 
    //
    
    
    // Remove product from infobox list
    // 
    $('tr[id=pc-' + products_id + ']').remove() ;
    
    // Append product to the list
    //
    $('#boxcart-content').append( product_name ) ;

  $.ajax({
      type: 'POST',
      url: encodeURI($('form[name=cart_quantity]').attr('action')) + '&ajax=1',
      data: $('form[name=cart_quantity]').serialize(),
      async:false,
      success: function(data) {
        $("#content-body").html(data);
        update_cart();
      },
      dataType: 'html'
    });
    // Updating cart total
    //
    $.ajax({
        type: 'POST',
        url: encodeURI($('form[name=cart_quantity]').attr('action')) + '&show_total=1&ajax=1', 
        data: $('form').serialize(),
        success: function(data) {
            $('#boxcart-total').html(data);
            }
        });
  return(false);
});

$('.update-qty').css('visibility', 'visible');
$('.cart-remove').css('visibility', 'visible');
$('.boxcart-remove').css('visibility', 'visible');
$('input[name=\"cart_delete[]\"]').css('display', 'none');

});
