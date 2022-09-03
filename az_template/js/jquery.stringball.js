 /*

	StringBall ver2.0 for jQuery(gt Ver 1.3.2)
	Developped  by Coichiro Aso
	Copyright Codesign.verse 2009　http://codesign.verse.jp/
	Licensed under the MIT license:http://www.opensource.org/licenses/mit-license.php/

	コピーライト書いてますが、削除しない限り
	ご自由にお使い頂けます
	ただし使用の際は、自己責任でお願いします。

-------------------------------------------------------------------------------------------*/

/*note


------------------------------------------------------------------------------------------*/
(function ($){

	$.fn.stringball=function(options){

		var defaults={
			camd:1000,
			radi:250,
			speed:10

		};

	var options = $.extend(defaults, options);

	var target=$(this);
	var elem=$("li" ,target);
	var scrz=280;
	var radi=options.radi;
	var camd=options.camd;
	var speed=options.speed;

	var offset=0;
	var accx=0;
	var accy=0;
	var roteang=0;
	var axang=0;
	var ac=0;
	var as=0;
	var rotec=0;
	var rotes=0;
	var looptimer=0;
	var itxpos = target.offset().left;
	var itw = target.width();
	var itypos=target.offset().top;
	var ith=target.height();

		function setini(){

			for(i=0;i<elem.length;i++){
			elem[i].anga=Math.PI*2/elem.length*Math.round(Math.random()*elem.length);
			elem[i].angb=Math.PI*2*Math.random();
			elem[i].fw=$(elem[i]).width();
			elem[i].fh=$(elem[i]).height();
			elem[i].xpos=radi*Math.cos(elem[i].angb)*Math.sin(elem[i].anga);
			elem[i].ypos=radi*Math.sin(elem[i].angb);
			elem[i].zpos=radi*Math.cos(elem[i].angb)*Math.cos(elem[i].anga);
			}
		}

		function setpos(){
			for(i=0;i<elem.length;i++){

				//軸の単位方向ベクトル
				ac=Math.cos(axang);
				as=Math.sin(axang);
				//回転距離計算
				rotec=Math.cos(roteang);
				rotes=Math.sin(roteang);
				//軸まわりの回転処理
				elem[i].xpos2=elem[i].xpos*(Math.pow(ac,2)+(1-Math.pow(ac,2))*rotec)+elem[i].ypos*(ac*as*(1-rotec))-elem[i].zpos*(as*rotes);
				elem[i].ypos2=elem[i].xpos*(ac*as*(1-rotec))+elem[i].ypos*(Math.pow(as,2)+(1-Math.pow(as,2))*rotec)+elem[i].zpos*(ac*rotes);
				elem[i].zpos2=elem[i].xpos*as*rotes-elem[i].ypos*ac*rotes+elem[i].zpos*rotec;
			/*	//カメラ位置計算
				elem[i].xpos3=elem[i].xpos2;
				elem[i].ypos3=elem[i].ypos2*Math.cos(camh)+elem[i].zpos2*Math.sin(camh);
				elem[i].zpos3=-elem[i].ypos2*Math.sin(camh)+elem[i].zpos2*Math.cos(camh);
			*/
				//基本位置更新
				elem[i].xpos=elem[i].xpos2;
				elem[i].ypos=elem[i].ypos2;
				elem[i].zpos=elem[i].zpos2;

				//スケール簡易計算
				elem[i].scale=scrz/(camd+elem[i].zpos2);
				//スクリーン位置計算
				elem[i].rxpos=elem[i].xpos2*elem[i].scale+itw/2-elem[i].fw/2;
				elem[i].rypos=elem[i].ypos2*elem[i].scale+ith/2-elem[i].fh/2;
			}
			//ポジション反映
			for(i=0;i<elem.length;i++){
				elem[i].style.left=elem[i].rxpos+"px";
				elem[i].style.top=elem[i].rypos+"px";
				elem[i].style.fontSize=elem[i].scale*100+"%";
				elem[i].style.opacity=elem[i].scale;
			}
			//回転スピード計算　結構雑な計算だから改良の余地あり。
			roteang=-(Math.max(Math.abs(accx),Math.abs(accy)))/100/speed;
			//マウスオーバーキャンセル
			return false;
		}

		//初期設定実行
		setini();
		setpos();

		

		
		
		target.click(
			function(){
			clearInterval(looptimer);
			//alert('Top: ' + $(this).offset().top + ' Left: ' + $(this).offset().left);
			//target.mousemove(function(e){
			//alert('Top: ' + e.clientX + ' Left: ' + e.clientY);
			accx = (0/*e.clientX*/-itxpos-itw/2)/itw;
			accy = (0/*e.clientY*/-itypos-ith/2)/ith;
				//任意の軸
				axang=Math.PI/2+Math.atan2(accy,accx);
			//});
			looptimer=setInterval(setpos,16);			
		}/*,
		function(){
			clearInterval(looptimer);
		}*/);

	}
})(jQuery);

