<?php
	session_start();
        include_once(dirname(__FILE__). "/../core/managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../core/presenters/class.Default_Presenter.php");

        $user = unserialize($_SESSION["current_user"]);

        if(!isset($user) || $user == "" ){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = 'home.php'; </script>";
        }
        $pres = new Default_Presenter($user->getId());
        $_SESSION['default_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="administration.css" />
		<link rel="icon" type="image/png" href="../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../scripts/generic.js'></script>
		<script language='JavaScript' src='../scripts/menu_manager.js'></script>
  		<title>
			Identificator - Menu Administration
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../generic/top.php");
			
                        $user_picture_dir = "../../".$pres->getUserPictureDirectory();
                        
			if($user->getPhotoProfil() != ""){
                            echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
                        }
                        else echo "<input type='hidden' id='photo_profil' value='../content/images/Default_white.png' />";
		?>
		<script language='JavaScript'>
			InitHeader(document.getElementById('photo_profil').value, "Choisissez dans ce menu ....", '... ce que vous voulez administrer', true);
		</script>
		 <div id="content">
			<div id="menu" class="menu">
				<img id="menuImg1" class="menuImg" src="../content/images/menus/fleche_menu.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='../menu.php'"/>
			
				<img id="menuImg2" class="menuImg" src="../content/images/menus/fleche_admin.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='administration.php'"/>
			</div>
                        <?php
                        //--Si l'utilisateur est administrateur alors il peut voir le code suivant
                        if($user->getAdmin() == 1){
                        //--Si l'utilisateur est administrateur d'un ou plusieurs ordres, alors seule l'administration des ordres s'affiche

                       echo "
			<div id='div_middle' class='div_middle'>
				<span id='label_Info' class='label_Info'></span>
                                    
                                    <a href='../administration/userAdministration/admin_users.php'>
                                        <div id='div_elem_utilisateurs' class='div_elem' title=\"Cliquez pour accéder à l'administration des utilisateurs\">
                                            <img src='../content/images/comptes_utilisateurs.png'/>
                                            <span>Utilisateurs</span>
                                        </div>
                                    </a>
                                    <a href='../inBuild/inbuild.php'>
                                        <div id='div_elem_ordre' class='div_elem' title=\"Cliquez pour accéder à l'administration des ordres\">
                                            <img src='../content/images/ordres.png'/>
                                            <span>Ordres</span>
                                        </div>
                                    </a>
                                    <a href='../inBuild/inbuild.php'>
                                        <div id='div_elem_taxons' class='div_elem' title=\"Cliquez pour accéder à l'administration des taxons\">
                                            <img src='../content/images/taxons.jpg'/>
                                            <span>Taxons</span>
                                        </div>
                                    </a>
                                    <a href='../administration/pictureAdministration/admin_pics.php'>
                                        <div id='div_elem_photos' class='div_elem' title=\"Cliquez pour accéder à l'administration des photos\">
                                            <img src='../content/images/camera.png'/>
                                            <span>Photographies</span>
                                        </div>
                                    </a>
                                    <a href='../inBuild/inbuild.php'>
                                        <div id='div_elem_references' class='div_elem' title=\"Cliquez pour accéder à l'administration des références\">
                                            <img src='../content/images/references.png'/>
                                            <span>Références</span>
                                        </div>
                                    </a>
                                    <a href='../inBuild/inbuild.php'>
                                        <div id='div_elem_parametres' class='div_elem' title=\"Cliquez pour accéder à l'administration des parametres\">
                                            <img src='../content/images/parametres.png'/>
                                            <span>Paramètres</span>
                                        </div>
                                    </a>
				<span id='label_error' class='label_error'></span>
			</div>";
                        }
                        else{
                            echo "<div class='div_erreur'><span id='label_error' class='label_error'>Vous n'etes pas administrateur</span></div>";
                        }
                        ?>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../generic/footer.php");
		?>
	</body>
</html>
