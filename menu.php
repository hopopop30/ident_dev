<?php
	session_start();
        include_once(dirname(__FILE__). "/core/managers/business/class.user.php");
	include_once(dirname(__FILE__). "/core/presenters/menu/class.Menu_Presenter.php");

        $user = unserialize($_SESSION["current_user"]);

        if(!isset($user) || $user == ""){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = 'home.php'; </script>";
        }
        $pres = new Menu_Presenter($user->getId());
        $_SESSION['menu_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" media="screen" href="generic/generic.css" />
        <link rel="stylesheet" media="screen" href="menu.css" />
        <link rel="icon" type="image/png" href="content/images/favicon.ico" />

        <!--JQUERY-->
        <script language='JavaScript' src='scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
        <script language='JavaScript' src='scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	

        <!--Autres scripts-->
        <script language='JavaScript' src='scripts/generic.js'></script>
        <script language='JavaScript' src='scripts/menu_manager.js'></script>
        <title>
            Identificator - Menu principal
        </title>
    </head>
    <body onload="Hour();">
        <img id="image_fond" src="content/images/background/fond.png" style="width:99%; height:99%;"/>
            <?php
		include_once(dirname(__FILE__). "/generic/top.php");
                
                $user_picture_dir = $pres->getUserPictureDirectory();

                if($user->getPhotoProfil() != ""){
                    echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
                }
                else echo "<input type='hidden' id='photo_profil' value='content/images/Default_white.png' />";
            ?>
            <script language='JavaScript'>
                InitHeader(document.getElementById('photo_profil').value, "Faites votre choix", 'En cliquant sur un élément du menu');
            </script>
            <div id="content">		
                <div id="div_galerie" class="secondPlan" onmouseover="javascript:plan(this);">
                    <a href="inBuild/inbuild.php">
                        <img ID="img_galerie" src="content/images/menu/cadre-galerie.png" title="Vers les galeries de photos"/>
                    </a>
                </div>
                <div id="div_identification" class="premierPlan" onmouseover="javascript:plan(this);">
                    <a href="identification/order_choice.php">
                        <img ID="img_identification" src="content/images/menu/cadre-identification.png" title="Vers l'identification"/>
                    </a>
                </div>
                <div id="div_ajout" class="secondPlan" onmouseover="javascript:plan(this);">
                    <a href="uploadPictures/uploadPictures.php">
                        <img ID="img_ajout" src="content/images/menu/cadre-ajout.png" title="Vers l'ajout de photos"/>
                    </a>
                </div>
                <div id="div_admin" class="secondPlan" onmouseover="javascript:plan(this);">
                    <a href="administration/administration.php">
                        <img ID="img_admin" src="content/images/menu/cadre-admin.png" title="Vers les pages d'administration"/>
                    </a>
                </div>
            </div>
        
            <?php
                include_once(dirname(__FILE__). "/generic/footer.php");
            ?>
        <script type="text/javascript">
            function plan(elem) {

                //--Gestion des plans
                document.getElementById("div_galerie").setAttribute("style", "z-index:0");
                document.getElementById("div_ajout").setAttribute("style", "z-index:0");
                document.getElementById("div_admin").setAttribute("style", "z-index:0");
                document.getElementById("div_identification").setAttribute("style", "z-index:1");

                var div = document.getElementById(elem.id);
                div.setAttribute("style", "z-index:2");
            }
        </script>
    </body>
</html>
