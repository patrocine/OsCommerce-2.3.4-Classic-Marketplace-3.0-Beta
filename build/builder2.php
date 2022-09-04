<?php
/*
  $Id: builder2.php,v 2.5.1 2008/09/13 23:03:53 10c Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>

<script language="JavaScript">
var tindex=0;
var final_sum=0,sum=0,shipmentprice=0;
// MAXIMUM BUILDER CATEGORIES
var fields=20;
var price = new Array();
var product = new Array();
var description = new Array();
var image = new Array();
var pid = new Array();
var recid = new Array();
var ammount = new Array();
var categ = new Array();
var prods_counter=0;
// IF AN OPTION IS NOT SET YET THEN THE MESSAGE IS HELD IN VARIABLE default_line (BELOW)
var default_line="&nbsp;&nbsp;<img src='./build/no_select.gif' align='absmiddle' width='17' height='17'>&nbsp;&nbsp;(click Aquí para Seleccionar)";
var fmTimer;
var faded=true;
var fadeObj;

for (i=0;i<=fields;i++){
        price[i] = 0;
        product[i] = "0";
        description[i] = "";
        image[i] = "";
        pid[i] = "";
        recid[i] = "";
        ammount[i] = 0;
        categ[i]="";
}

//--------------------- Print Field ---------------------------- FOR DISPLAYING EACH LINE OF THE COMPONENTS SELECTED
function print_field(category,indx,row,picname,assemb_id){
            categ[indx]=category;
        document.write
("<tr onmouseover=\"this.style.backgroundColor='#DEDEDE';\" onmouseout=\"this.style.backgroundColor='';\" height=30>"
  +"<th onClick=\"oFrame.style.display='none'\" valign=center width=168 align=left><img src='./build/img/"+picname+"'></th>"
  +"<th>"
        +"<table style='border-collapse: collapse' bordercolor='#dddddd' border=0>"
          +"<tr>"
                +"<th align='left' onclick='show_products(event,this,"+indx+","+row+","+assemb_id+")' style='cursor: hand;' width=100%>"+default_line+"</th>"
                +"<th onClick='show_products(event,this,"+indx+","+row+","+assemb_id+")' style='cursor: hand;' >"+"<img src='./build/img/scroll.gif' hspace='5' width='20' height='18'></th>"
                +"<th onClick=\"oFrame.style.display='none'\" valign=center><input type=\"button\" value=\"info\" style=\"border: #C4B0AB 1px solid; background-color: #F1F1F1; color: #5C5C5C; font-weight: bold\" onclick='show_desc("+indx+")'></th>"
          +"</tr>"
        +"</table>"
  +"</th>"
  +"<th align='right' onClick=\"oFrame.style.display='none'\" ></th>"
  +"<th align='center' onClick=\"oFrame.style.display='none'\" width=35>"
    +"<input type='hidden' name='products_id["+indx+"]' value='-1'>"
    +"<select name='qty["+indx+"]'  onchange=\"calc_subtotal(mainform);calc_total(mainform);\">");
        document.write ("<option value=1 selected>1</option>");
        for (i=2;i<=1000;i++)
        document.write ("<option value="+i+">"+i+"</option>");
        document.write ("</select></th></tr>");
}

//--------------------- Fader ----------------------------
function fade(){
  if (!faded) {
        faded=true;
        faderObj.innerHTML=default_line;
        window.clearTimeout(fmTimer);
  }else{
          faded=false;
        fmTimer=window.setTimeout("Fade()",2000);
  }
}

//--------------------- Fade Row ---------------------------- INCLUDES PRIORITY ERRORS
function fade_row(row){
        if (!faded){
                faded=true;
                faderObj.innerHTML=default_line;
                window.clearTimeout(fmTimer);
        }
        var note="";
        switch (row){
                case 2:
                        if (!recid[1]) note=note1;
                        break;
                case 3:
                        if (!recid[2]) note=note2;
                        break;
        }
        if (note!="") {
                faderObj = document.getElementById("prod_table").rows[row].cells[1].childNodes[0].rows[0].cells[0];
                faderObj.innerHTML=default_line+note;
                fade();
                return false;
        } else {
                return true;
        }
}

//--------------------- Show Products ---------------------------- IN POPUP
function show_products(evt,e,pindex,row,assemb_id){
	if (pindex!=tindex){
	    document.getElementById("oFrame").style.display="none";
	    tindex=pindex;
	}
	if (!fade_row(pindex+1)) return;
	sURL="prduct_list.php?assemb_id="+assemb_id+"&row="+pindex+"&currency="+currency+"&pindex="+pindex;
  	for (i=0;i<recid.length;i++)
  	{
		sURL+="&idp"+i+"="+recid[i];
  	}

	//var sURL="prduct_list.php?assemb_id="+assemb_id+"&row="+pindex+"&currency="+currency+"&pindex="+pindex+"&dcpu="+recid[row]+"&dmem="+product[pindex];
	if (document.getElementById("oFrame").innerHTML==""){
		document.getElementById("oFrame").innerHTML="<iframe name='oiFrame' id='oiFrame' height='100%' width='100%' border='0' frameborder='0'></iframe>";
	}
// A LITTLE CHANGE I MADE AFTER MESSING WITH THE STYLESHEETS - TENCENTS
	var buffer="<html><head><style>BODY{font-family:Verdana,Arial,Tahoma,Helvetica,sans-serif;font-size:9pt;}TH{background-color:#86A5D2;filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr='#0086A5D2',EndColorStr='#C0FFFFFF');font-style:italic;border:1px solid Black;cursor:default;}.select_table{BORDER-COLLAPSE:collapse;border:1px ridge;background-color:#F5F5F5;}tr{cursor:hand;}BODY{overflow: auto; margin: 0 0 0 0;background-color: #F5F5F5;}</style>";
//	buffer+="<table style='BORDER-COLLAPSE: collapse' borderColor='#86A5D2' border='1' width='100%'>";
//	var buffer="<table style='border-collapse: collapse' borderColor='#86A5D2' border='1' width='100%'>";
	switch (pindex){
		case 1:
		    add_product('-1','','','','','','2');
		    sURL+="&select="+product[pindex]+"&currency="+currency;
		    oiFrame.document.write("<center><br>"+buffer+text_please_wait+"<br><br><img src='./build/pbar.gif' width='71' height='11' border='0'>");
		    window.open(sURL,"oiFrame");
		    break;
		case 2:
		    oiFrame.document.write("<center><br>"+buffer+text_please_wait+"<br><br><img src='./build/pbar.gif' width='71' height='11' border='0'>");
		    window.open(sURL,"oiFrame");
		    break;
		case 0:
		    add_product('-1','','','','','','1');
		    add_product('-1','','','','','','2');

// ADD MORE HERE IF YOU WANT TO CLEAR FURTHER DOWN THE LIST - OR EVEN SELECTED ITEMS
// EG.          add_product('-1','','','','','','3');
//		    add_product('-1','','','','','','4');
		default:
		    sURL+="&select="+product[pindex]+"&currency="+currency;
		    oiFrame.document.write("<center><br>"+buffer+text_please_wait+"<br><br><img src='./build/pbar.gif' width='71' height='11' border='0'>");
		    window.open(sURL,"oiFrame");
		    if (pindex){
		      buffer+="<tr onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\" onclick=\"parent.add_product('','','','','','"+pindex+"','"+pindex+"');\"><td align='center' colspan=3><b>"+text_deselect_items+"</b></td></tr>";
		      oiFrame.document.write(buffer+loadRow(pindex)+"</table>");
		      window.open(sURL,"oiFrame");
		    }
		    break;
	}
    if (document.getElementById("oFrame").style.display=="none") {
        var categoryid=-1;
        var aTag;
        tab=e.parentNode; //TR
        var aTag=tab;
        var leftpos=0;
 //       var offsetHeight=10;
        var leftpos=0;
        var toppos=0;
        do {
                aTag = aTag.offsetParent;
                leftpos += aTag.offsetLeft;
                toppos += aTag.offsetTop;
        } while(aTag.tagName!="BODY");

        var PopupHeight=254;
        var TotTop=tab.offsetTop+tab.offsetHeight+toppos;

        document.getElementById("oFrame").style.left =tab.offsetLeft+leftpos+1;
        if (evt.clientY+PopupHeight+10>document.body.clientHeight){
                TotTop-=PopupHeight+tab.offsetHeight;
        }
        document.getElementById("oFrame").style.height=PopupHeight;
        document.getElementById("oFrame").style.top = TotTop;
        document.getElementById("oFrame").style.width = tab.cells[0].offsetWidth+tab.cells[1].offsetWidth+1;
        document.getElementById("oFrame").style.display="inline";
    }
    else{
      document.getElementById("oFrame").style.display="none";
    }
}

//--------------------- Load Row ----------------------------
function loadRow(indx){
        var j;
        var buffer="";
        for (j=0;(l[indx][j]);j++)
		  buffer+=print_line(indx,j);
        if (!buffer)
          buffer = "";
        return buffer;
}

//--------------------- Print Line ---------------------------- CHECK THIS OUT - add_product SYNTAX - DOESNT LOOK RIGHT!!
function print_line(row,line){
  var buffer="";
  if (l[row][line][1]){
        var pdesc2 = l[row][line][1].replace(/:inc:/gi, '"')
        re2 = new RegExp ('\'', 'gi') ;
        l[row][line][1] = l[row][line][1].replace(re2, ":tag:")
        buffer+= "<tr onclick=\"parent.add_product('"+l[row][line][0]+"','"+l[row][line][1]+"','"+l[row][line][2]+"','"+l[row][line][3]+"',"+l[row][line][4]+");\" onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\">"
+"<td align='left'>"+pdesc+"</td><td align='right' width=70>&nbsp;"+l[row][line][2]+""+currency+"</td></tr>";
  }else{
        buffer+=print_title(l[row][line][0]);
  }
  return buffer;
}

//--------------------- Print Title ----------------------------
function print_title(title){
        return "<tr><th align='center' colspan='3'>"+title+"</th></tr>";
}

//--------------------- Calculate Subtotal ----------------------------
function calc_subtotal(form){
        var sum=0

        for (i=0;i<=fields;i++){
                if (price[i]>0){
//                      sum=sum+parseFloat(price[i]*(form.elements["qty["+(i-1)+"]"].selectedIndex+1));
//                        sum=sum+parseFloat(price[i].replace(",",".")*(form.elements["qty["+(i-1)+"]"].selectedIndex+1));
                        sum=sum+parseFloat(price[i]*(form.elements["qty["+(i-1)+"]"].selectedIndex+1));

                }
        }
        var lines=form.select1.length
        var softprice=0;
        for (i=1;i<lines;i++){
                if (form.select1.options(i).selected){
                        softprice+=parseFloat(form.select1.options(i).price)*parseFloat(form.qty100.selectedIndex+1);
                }
        }
        form.sum.value=formatnumber(sum+softprice,2);
}

//--------------------- Calculate Sum ---------------------------- CHANGED BY TENCENTS FOR NUMBER FORMATTING (.00)
// THIS ONE ONLY SEEMS TO GET CALLED WHEN CHANGING A QTY
function calc_total(form){

// alert(form.ass.value);
// if (form.ass.value==1) { sum=formatnumber(parseFloat(5.00));   }

    	form.totsum.value=formatnumber(parseFloat(form.sum.value),2);
}

function calc_total_tmp(form){
        var sum=0;
        var final_sum;
        for (i=0;i<=fields;i++){
                if (price[i]>0){
                        sum=sum+parseFloat(price[i]*(form.elements["qty["+(i-1)+"]"].selectedIndex+1));
                }
        }
        var lines=form.select1.length
        var softprice=0;
        for (i=1;i<lines;i++){
                if (form.select1.options(i).selected){
                        softprice+=parseFloat(form.select1.options(i).price)*parseFloat(form.qty[100].selectedIndex+1);
                }
        }
        sum=formatnumber(sum+softprice,2);
        final_sum=sum;
        form.sum.value=final_sum;
        form.totsum.value=" "+currency_left+" "+final_sum+""+currency_right;
}

//--------------------- Form check before submission ---------------------------- now checks for proper 'zero'
function mainform_onsubmit(form,sact,fields)
{
        if (form.sum.value<"0.01"){
                alert ("You must have products in order");
                return false;
        }
        for (i=0;i<=fields;i++){
                ammount[i+1]=form.elements["qty["+i+"]"].selectedIndex+1;
        }
        var urltemp="compbuild.php?action=add_products&products_id=";
        var urltempammount="&product_ammount=";
        form.product.value="";
        form.description.value="";
        form.image.value="";
        form.pid.value="";
        form.price.value="";
        form.ammount.value="";
        form.recid.value="";
        form.totprint.value=currency_left+" "+form.totsum.value+" "+currency_right;

        for (i=0;i<=fields+1;i++){
                form.product.value+=product[i]+"::";
                form.description.value+=description[i]+"::";
                form.image.value+=image[i]+"::";
                form.pid.value+=pid[i]+"::";
                form.price.value+=currency_left+" "+price[i]+" "+currency_right+"::";
                form.ammount.value+=ammount[i]+"::";
                form.recid.value+=recid[i]+"::";
                if (recid[i]){
                    urltemp+=recid[i]+",";
                    urltempammount+=ammount[i]+",";
                }
        }

        var lines=form.select1.length
        for (i=1;i<lines;i++){
                if (form.select1.options(i).selected){
                        form.product.value+=form.select1.options(i).value+";;";
                        form.description.value+=form.select1.options(i).description;
                        form.image.value+=form.select1.options(i).image;
                        form.price.value+=form.select1.options(i).price;
                        form.pid.value+=form.select1.options(i).pid;
                        form.recid.value+=form.select1.options(i).recid;
                        form.ammount.value+=(form.qty[100].selectedIndex+1)+";;";
                }
        }

		 if (sact==2){
		        urltemp+=urltempammount;
		        form.action=urltemp;
		        form.target="_self";
		        form.submit();
		} else if (sact==1){
		        form.action="print.php";
		        form.target="_blank";
		        form.submit();
		}
}

//----------------- Show Description ---------------
function show_desc(row){
        row++;
        if (recid[row])
                window.open ("product_info.php?products_id="+recid[row],'new', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=Yes,resizable=yes,copyhistory=yes');
}
</script>
