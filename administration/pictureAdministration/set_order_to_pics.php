<?php
	session_start();
        include_once(dirname(__FILE__). "/../../core/managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../../core/presenters/administration/pictureAdministration/class.setOrderToPicture_Presenter.php");

        $user = unserialize($_SESSION["current_user"]);

        if((!isset($user) || $user == "")|| $user->getAdmin() == 0){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = 'home.php'; </script>";
        }
        $pres = new Admin_SetOrderToPicture_Presenter($user->getId());
        $_SESSION['setOrder_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="set_order_to_pics.css" />
  		<link rel="stylesheet" media="screen" href="../../styles/grid.css" />
		<link rel="icon" type="image/png" href="../../content/images/favicon.ico" />
                
		<!--JQUERY-->
		<script language='JavaScript' src='../../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
                
                <script src="../../scripts/lightbox/js/jquery-1.7.2.min.js"></script>
                <script src="../../scripts/lightbox/js/lightbox.js"></script>
                <link href="../../scripts/lightbox/css/lightbox.css" rel="stylesheet" />
                
		<!--Autres scripts-->
		<script language='JavaScript' src='../../scripts/generic.js'></script>
		<script language='JavaScript' src='../../scripts/menu_manager.js'></script>
		<script language='JavaScript' src='set_order_to_pics.js'></script>
  		<title>
			Identificator - Photos sans ordre
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
			InitHeader(document.getElementById('photo_profil').value, "Réattribuez un ordre aux photos ...", "... identifiées comme 'Mauvais ordre' ", true);
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
				<img id="menuImg3" class="menuImg" src="../../content/images/menus/fleche_images.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='admin_pics.php'"/>
				<img id="menuImg4" class="menuImg" src="../../content/images/menus/fleche_ordres.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='set_order_to_pics.php'"/>
			</div>
			<div id="div_middle" class="div_middle">
                            <input type="hidden" id="siteAddress" value="<?php echo $pres->getSiteAddress(); ?>" />
                            <input type="hidden" id="pictureDir" value="<?php echo $pres->getPictureDir(); ?>" />
                            
                            <span id='label_Info' class='label_Info'></span>
                                
                            <div>
                                <table id='table_header'><tbody>
                                <tr>
                                        <th class='tiny'>Voir</th>
                                        <th class='big'>Auteur</th>
                                        <th class='small'>Date</th>
                                        <th class='small'>Lieu</th>
                                        <th class='medium'>Ordre</th>
                                        <th class='tiny'>Supp.</th>
                                    </tr>
                                </tbody></table>
                            </div>
                            <div id='conteneur_table'>
                            <table id='table_central'>
                                <tbody id="table_central_tbody">

                                </tbody>
                            </table>
                                        
			</div>
                            <span id="notification" class="label_error"><p id="text_notification" style="text-align:center;"></p></span>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../../generic/footer_level2.php");
		?>
	</body>
</html>
