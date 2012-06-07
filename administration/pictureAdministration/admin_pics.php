<?php
	session_start();
        include_once(dirname(__FILE__). "/../../core/managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../../core/presenters/class.Default_Presenter.php");

        $user = unserialize($_SESSION["current_user"]);

        if((!isset($user) || $user == "")|| $user->getAdmin() == 0){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = '../../home.php'; </script>";
        }
        $pres = new Default_Presenter($user->getId());
        $_SESSION['default_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="admin_pics.css" />
		<link rel="icon" type="image/png" href="../../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../../scripts/generic.js'></script>
		<script language='JavaScript' src='../../scripts/menu_manager.js'></script>
  		<title>
			Identificator - Administration des photos
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../../generic/top_level2.php");
			
                        $user_picture_dir = "../../".$pres->getUserPictureDirectory();
                        
			if($user->getPhotoProfil() != ""){
                            echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
                        }
                        else echo "<input type='hidden' id='photo_profil' value='../../content/images/Default_white.png' />";
		?>
		<script language='JavaScript'>
			InitHeader(document.getElementById('photo_profil').value, "Administration des photos ...", '... faites votre choix', true);
		</script>
		 <div id="content">
			<div id="menu" class="menu">
				<img id="menuImg1" class="menuImg" src="../../content/images/menus/fleche_menu.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='../../menu.php'"/>
			
				<img id="menuImg2" class="menuImg" src="../../content/images/menus/fleche_admin.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='../administration.php'"/>
			
				<img id="menuImg2" class="menuImg" src="../../content/images/menus/fleche_images.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='admin_pics.php'"/>
			</div>
			<div id="div_middle" class="div_middle">
				<span id='label_Info' class='label_Info'>
                                    
				</span>
                                <a href="../../inBuild/inBuild.php">
                                    <div id="div_elem_utilisateurs" class="div_elem" title="Cliquez pour consulter les photos identifiées">
                                        <img src="../../content/images/photo_ok.png"/>
                                        <span>Photos identifiées</span>
                                    </div>
                                </a>
                                <a href="set_order_to_pics.php">
                                    <div id="div_elem_ordre" class="div_elem" title="Cliquez pour attribuer un ordre aux photos identifiées comme mauvais ordre">
                                        <img src="../../content/images/photo_nok.png"/>
                                        <span>Photos sans ordre</span>
                                    </div>
                                </a>
				<span id="label_error" class="label_error"></span>
			</div>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../../generic/footer_level2.php");
		?>
	</body>
</html>
