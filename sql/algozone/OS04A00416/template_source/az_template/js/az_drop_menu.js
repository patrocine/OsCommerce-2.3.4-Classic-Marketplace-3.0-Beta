;(function($, undefined){
	$.fn.reverse = []._reverse||[].reverse;

	$.fn.bgiframe = $.fn.bgiframe ? $.fn.bgiframe : $.fn.bgIframe ? $.fn.bgIframe : function(){
		return this;
	};

	$.fn.az_dropDownMenu = function(options){
		return this.each(function(){
			var $mainObj = $(this), menus = [], classname, timeout, $obj, $obj2, 
				settings = $.extend({
					timer: 500,
					parentMO: undefined,
					childMO: undefined,
					levels: [],
					numberOfLevels: 5
				}, options||{}, $.metadata ? $mainObj.metadata() : {});
	
			if (settings.levels.length){
				settings.numberOfLevels = settings.levels.length;
			}else{
				settings.levels[0] = settings.parentMO ? settings.parentMO : settings.childMO;
				for (var i=1; i<settings.numberOfLevels+1; i++)
					settings.levels[i] = settings.childMO;
			}
	
			menus[0] = $mainObj.children('li');
			for (var i=1; i<settings.numberOfLevels+1; i++){
				classname = settings.levels[i-1];
				menus[i] = menus[i-1].children('ul').children('li');
	
				menus[i-1].bind('mouseover.multi-ddm', function(){
					$obj = $(this); $obj2 = $obj.children('a');
	
					if (timeout) 
						clearTimeout(timeout);
	
					$('a', $obj.siblings('li')).each(function(){
						var $a = $(this), classname = $a.data('classname');
						if ($a.hasClass(classname))
							$a.removeClass(classname);
					});
	
					$obj.siblings('li').find('ul:visible').reverse().hide();
					$obj2.addClass( $obj2.data('classname') ).siblings('ul').bgiframe().show();
				}).bind('mouseout.multi-ddm', function(){
					if ($(this).children('a').data('classname') == settings.levels[0])
						timeout = setTimeout(closemenu, settings.timer);
				}).children('a').data('classname', classname);
			}
	
			$(document).click(closemenu);
	
			function closemenu(){
				$('a', $mainObj).each(function(){
					var $a = $(this), classname = $a.data('classname');
					if ($a.hasClass(classname))
						$a.removeClass(classname);
				});

				$('ul:visible', $mainObj).reverse().hide();

				if (timeout) 
					clearTimeout(timeout);
			}
		});
	};
})(jQuery);
