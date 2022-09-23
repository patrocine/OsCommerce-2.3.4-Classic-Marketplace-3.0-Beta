function az_popupWindow(url) {
	window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}

jQuery(document).ready(function() {
	var $az_cat_menu_width = 0;
	
	$("img[src$='images/checkout_bullet.gif']").css('vertical-align', 'bottom');
	$("br:last").css({display: 'none'});
	
	$('#az_category_menu > li').each(function (i) {
		$az_cat_menu_width += $(this).outerWidth()
    });
	$('#az_category_menu_wrapper').width($az_cat_menu_width+'px')

	$('#az_category_menu').az_dropDownMenu({timer: 500, parentMO: 'parent-hover', childMO: 'child-hover'});
});