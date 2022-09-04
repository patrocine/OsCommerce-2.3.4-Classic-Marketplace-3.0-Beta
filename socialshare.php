<?php
      $SOCIALLOGININTERFACE = '';
		if(tep_session_is_registered('customer_id')) {
        }
				
elseif (!isset($lrsetting['apikey']) || !isset($lrsetting['apisecret'])){  	
        $SOCIALLOGININTERFACE .= '<div style="font-size: 10px; font-weight: bold;">' . $lrsetting['sociallogintitle'] . '<div>
<div style="background-color: #FFFFE0;border: 1px solid #E6DB55;padding: 5px;"><div style="color:red;margin-bottom:5px">LoginRadius Social Login Plugin is not configured!</div><p style="line-height:1.3;margin-bottom:4px">To activate your plugin, navigate to <strong>Social Login and Social Share under module</strong>&nbsp;section in your OsCommerce admin panel and insert LoginRadius API Key &amp; Secret. Follow <a target="_blank" href="http://support.loginradius.com/customer/portal/articles/677100-how-to-get-loginradius-api-key-and-secret">this</a> document to learn how to get API Key &amp; Secret.</p></div></div></div>';
	}
		
// Checking apikey and show interface.
    elseif (!empty($lrsetting['apikey']) && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $lrsetting['apikey']) && !empty($lrsetting['apisecret']) && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $lrsetting['apisecret'])){
	  $loc = tep_href_link(FILENAME_ACCOUNT, '', 'SSL');
        ?><script src="//hub.loginradius.com/include/js/LoginRadius.js" ></script> <script type="text/javascript"> var options={}; options.login=true; LoginRadius_SocialLogin.util.ready(function () { $ui = LoginRadius_SocialLogin.lr_login_settings;$ui.interfacesize = "small";$ui.apikey = "<?php echo $lrsetting['apikey'];?>";$ui.callback="<?php echo $loc;?>"; $ui.lrinterfacecontainer ="interfacecontainerdiv"; LoginRadius_SocialLogin.init(options); }); </script><?php 
		
        $SOCIALLOGININTERFACE .= '<div style="font-size: 10px; font-weight: bold;">' . $lrsetting['sociallogintitle'] . '<div id="interfacecontainerdiv" class="interfacecontainerdiv"></div></div>';
      
    }
	else {
	$SOCIALLOGININTERFACE .= '<div style="font-size: 10px; font-weight: bold;">' . $lrsetting['sociallogintitle'] . '<p style ="color:red;">Your API connection setting not working. try to change setting from module option or check your php.ini setting for (<b>cURL support = enabled</b> OR <b>allow_url_fopen = On</b>)</p></div>';
	}
//check false of social share 
	if ($lrsetting['enableshare'] == '1') {
	  	$socialsharetitle = "";
    	if ($lrsetting['chooseshare'] == '0') {
		  $size = '32';
          $interface = 'horizontal';
		  $socialsharetitle='<div style="font-size: 10px; font-weight: bold;">'.$lrsetting['socialsharetitle'].'</div>';
        }
        else if ($lrsetting['chooseshare'] == '1') {
          $size = '16';
          $interface = 'horizontal';
		  $socialsharetitle='<div style="font-size: 10px; font-weight: bold;">'.$lrsetting['socialsharetitle'].'</div>';
        }
        else if ($lrsetting['chooseshare'] == '2') {
          $size = '32';
          $interface = 'simpleimage';
		  $socialsharetitle='<div style="font-size: 10px; font-weight: bold;">'.$lrsetting['socialsharetitle'].'</div>';
        }
        else if ($lrsetting['chooseshare'] == '3') {
          $size = '16';
          $interface = 'simpleimage';
		  $socialsharetitle='<div style="font-size: 10px; font-weight: bold;">'.$lrsetting['socialsharetitle'].'</div>';
        }
        else if ($lrsetting['chooseshare'] == '4') {
          $size = '32';
          $interface = 'Simplefloat';
		  $socialsharetitle="";
        }
        else if ($lrsetting['chooseshare'] == '5') {
          $size = '16';
          $interface = 'Simplefloat';
		  $socialsharetitle="";
        }
        if ($lrsetting['choosesharepos'] == '0') {
          $vershretop = (is_numeric($lrsetting['verticalsharetopoffset'])? $lrsetting['verticalsharetopoffset'] : '0').'px';
          $vershreright = '';
          $vershrebottom = '';
          $vershreleft = '0px';
        }
        else if ($lrsetting['choosesharepos'] == '1') {
          $vershretop = (is_numeric($lrsetting['verticalsharetopoffset'])? $lrsetting['verticalsharetopoffset'] : '0').'px';
          $vershreright = '0px';
          $vershrebottom = '';
          $vershreleft = '';
        }
        else if ($lrsetting['choosesharepos'] == '2') {
          $vershretop = (is_numeric($lrsetting['verticalsharetopoffset'])? $lrsetting['verticalsharetopoffset'] : '0').'px';
          $vershreright = '';
          $vershrebottom = (is_numeric($lrsetting['verticalsharetopoffset']) ? '' : '0px');
          $vershreleft = '0px';
        }
        else if ($lrsetting['choosesharepos'] == '3') {
          $vershretop = (is_numeric($lrsetting['verticalsharetopoffset'])? $lrsetting['verticalsharetopoffset'] : '0').'px';
          $vershreright = '0px';
		  $vershrebottom = (is_numeric($lrsetting['verticalsharetopoffset']) ? '' : '0px');
		  $vershreleft = '';
		}
		else {
		  $vershretop = '';
		  $vershreright = '';
		  $vershrebottom = '';
		  $vershreleft = '';
		}
		$sharescript = '<script type="text/javascript">var islrsharing = true; var islrsocialcounter = true;</script> <script type="text/javascript" src="//share.loginradius.com/Content/js/LoginRadius.js" id="lrsharescript"></script> <script type="text/javascript"> LoginRadius.util.ready(function () { $i = $SS.Interface.'.$interface.'; $SS.Providers.Top = [';
		$rearrnage_provider = (!empty($lrsetting['rearrange_settings']) ? unserialize($lrsetting['rearrange_settings']) : "");
		if(empty($lrsetting['rearrange_settings']))
		{		
			$rearrnage_provider[] = 'facebook';
			$rearrnage_provider[] = 'twitter';
			$rearrnage_provider[] = 'Email';
			$rearrnage_provider[] = 'googleplus';
			$rearrnage_provider[] = 'pinterest';
			$rearrnage_provider[] = 'linkedin';					
		}
		foreach ($rearrnage_provider as $key=>$value) { 
		  $sharescript .= '"' .$value .'",';
        }
		$sharescript .=']; $u = LoginRadius.user_settings; $u.apikey= "'.$lrsetting['apikey'].'"; $i.size = '.$size.';$i.left = "'.$vershreleft.'"; $i.top = "'.$vershretop.'";$i.right = "'.$vershreright.'";$i.bottom = "'.$vershrebottom.'"; $i.show("lrsharecontainer"); }); </script>';
		echo $sharescript;
      $socialshare = $socialsharetitle.'<div class="lrsharecontainer"></div>';
   }


//check false of social counter
	if ($lrsetting['enablecounter'] == '1') {
		  $socialcountertitle='';
		  $enablefblike = ((!empty($lrsetting['enablefblike']) AND $lrsetting['enablefblike'] == 'on')  ? 'Facebook Like' : '');
          $enablefbrecommend = ((!empty($lrsetting['enablefbrecommend']) AND $lrsetting['enablefbrecommend'] == 'on')  ? 'Facebook Recommend' : '');
          $enablefbsend = ((!empty($lrsetting['enablefbsend']) AND $lrsetting['enablefbsend'] == 'on')  ? 'Facebook Send' : '');
          $enablegplusone = ((!empty($lrsetting['enablegplusone']) AND $lrsetting['enablegplusone'] == 'on')  ? 'Google+ +1' : '');
          $enablegshare = ((!empty($lrsetting['enablegshare']) AND $lrsetting['enablegshare'] == 'on')  ? 'Google+ Share' : '');
		  $enablepinit = ((!empty($lrsetting['enablepinit']) AND $lrsetting['enablepinit'] == 'on')  ? 'Pinterest Pin it' : '');
          $enablelinkedinshare = ((!empty($lrsetting['enablelinkedinshare']) AND $lrsetting['enablelinkedinshare'] == 'on')  ? 'LinkedIn Share' : '');
          $enabletweet = ((!empty($lrsetting['enabletweet']) AND $lrsetting['enabletweet'] == 'on')  ? 'Twitter Tweet' : '');
          $enablestbadge = ((!empty($lrsetting['enablestbadge']) AND $lrsetting['enablestbadge'] == 'on')  ? 'StumbleUpon Badge' : '');
          $enableredditshare = ((!empty($lrsetting['enableredditshare']) AND $lrsetting['enableredditshare'] == 'on')  ? 'Reddit' : '');
		  $enableHybridshare = ((!empty($lrsetting['enableHybridshare']) AND $lrsetting['enableHybridshare'] == 'on')  ? 'Hybridshare' : '');
		    
		  if(empty($enablefblike) && empty($enablefbrecommend) && empty($enablefbsend) && empty($enablegplusone) && empty($enablegshare) && empty($enablelinkedinshare) && empty($enabletweet) && empty($enablestbadge) && empty($enableredditshare) && empty($enablepinit) && empty($enableHybridshare)) {
		  $enablefblike = 'Facebook Like';
		  $enablegplusone = 'Google+ +1';
		  $enablelinkedinshare = 'LinkedIn Share';
		  $enabletweet = 'Twitter Tweet';
		  }
		  
		  if ($lrsetting['choosecounter'] == '0') {
		    $ishorizontal = 'true';
			$counter_type = 'horizontal';
			$socialcountertitle='<div style="font-size: 10px; font-weight: bold;">'.$lrsetting['socialcountertitle'].'</div>';
		  }
		  else if ($lrsetting['choosecounter'] == '1') {
		    $ishorizontal = 'true';
			$counter_type = 'vertical';
			$socialcountertitle='<div style="font-size: 10px; font-weight: bold;">'.$lrsetting['socialcountertitle'].'</div>';
		  }
		  else if ($lrsetting['choosecounter'] == '2') {
		    $ishorizontal = 'false';
			$counter_type = 'horizontal';
		  }
		  else if ($lrsetting['choosecounter'] == '3') {
		    $ishorizontal = 'false';
			$counter_type = 'vertical';
		  }
		  if ($lrsetting['choosecounterpos'] == '0') {
          $vercounttop = (is_numeric($lrsetting['verticalcountertopoffset'])? $lrsetting['verticalcountertopoffset'] : '0').'px';
          $vercountright = '';
          $vercountbottom = '';
          $vercountleft = '0px';
        }
        else if ($lrsetting['choosecounterpos'] == '1') {
          $vercounttop = (is_numeric($lrsetting['verticalcountertopoffset'])? $lrsetting['verticalcountertopoffset'] : '0').'px';
          $vercountright = '0px';
          $vercountbottom = '';
          $vercountleft = '';
        }
        else if ($lrsetting['choosecounterpos'] == '2') {
          $vercounttop = (is_numeric($lrsetting['verticalcountertopoffset'])? $lrsetting['verticalcountertopoffset'] : '0').'px';
          $vercountright = '';
          $vercountbottom = (is_numeric($lrsetting['verticalcountertopoffset'])? '' : '0px');
          $vercountleft = '0px';
        }
        else if ($lrsetting['choosecounterpos'] == '3') {
          $vercounttop = (is_numeric($lrsetting['verticalcountertopoffset'])? $lrsetting['verticalcountertopoffset'] : '0').'px';
          $vercountright = '0px';
		  $vercountbottom = (is_numeric($lrsetting['verticalcountertopoffset'])? '' : '0px');
		  $vercountleft = '';
		}
		else {
		  $vercounttop = '';
		  $vercountright = '';
		  $vercountbottom = '';
		  $vercountleft = '';
		}
          echo $counterscript = '<script type="text/javascript">var islrsharing = true; var islrsocialcounter = true;</script> <script type="text/javascript" src="//share.loginradius.com/Content/js/LoginRadius.js"></script> <script type="text/javascript"> LoginRadius.util.ready(function () { $SC.Providers.Selected = ["'.$enablefbsend.'","'.$enablefblike.'","'.$enablelinkedinshare.'","'.$enablegplusone.'","'.$enabletweet.'","'.$enablefbrecommend.'","'.$enablestbadge.'","'.$enablegshare.'","'.$enablepinit.'","'.$enableredditshare.'","'.$enableHybridshare.'"]; $S = $SC.Interface.simple; $S.isHorizontal = '.$ishorizontal.'; $S.countertype = "'.$counter_type.'"; $S.left = "'.$vercountleft.'"; $S.top = "'.$vercounttop.'"; $S.right = "'.$vercountright.'"; $S.bottom = "'.$vercountbottom.'"; $S.show("lrcounter_simplebox"); }); </script>';
		$socialcounter = $socialcountertitle.'<div class="lrcounter_simplebox"></div>';
	}
?><?php 
$current_page = basename($PHP_SELF);
require_once('social_sharing_header.php');?>