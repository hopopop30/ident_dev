<?php
	session_start();
        include_once(dirname(__FILE__). "/../core/managers/business/class.user.php");

        $user = unserialize($_SESSION["current_user"]);

        if(!isset($user) || $user == ""){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = '../home.php'; </script>";
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="icon" type="image/png" href="../content/images/favicon.ico" />
            <link rel="stylesheet" media="screen" href="../generic/generic.css" />
            <link rel="stylesheet" media="screen" href="uploadPictures.css" />

            <!--JQUERY-->
            <script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
            <script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
            <link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	

            <!--Autres scripts-->
            <script language='JavaScript' src='../scripts/generic.js'></script>
            <script language='JavaScript' src='../scripts/menu_manager.js'></script>
            <script language='JavaScript' src='uploadPictures.js'></script>
            
            <!--Module upload-->
            <link href="../content/UploadComponent/moduleUpload.css" type="text/css" rel="stylesheet" />
            <script type="text/javascript" src="../content/UploadComponent/swfobject.js"></script>
            <script type="text/javascript" src="../content/UploadComponent/jquery.uploadify.v2.1.4.min.js"></script>
            
            <title>
                    Identificator - Charger des photos
            </title>
    </head>
    <body onload="Hour();">
        <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
        <?php
            include_once(dirname(__FILE__). "/../generic/top.php");
            include_once(dirname(__FILE__). "/../core/presenters/uploadpictures/class.UploadPictures_Presenter.php");
            $pres = new UploadPictures_Presenter($user->getId(), $user->getLogin());
            
            $user_picture_dir = "../".$pres->getUserPictureDirectory();

            if($user->getPhotoProfil() != ""){
                echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
            }
            else echo "<input type='hidden' id='photo_profil' value='../content/images/Default_white.png' />";
            
            echo "<input type='hidden' id='hiddenTempFolder' value='../".$pres->getRepOrig()."' />";
            
            $_SESSION['uploadPics_pres'] = serialize($pres);
        ?>
        <script language='JavaScript'>
            InitHeader(document.getElementById('photo_profil').value, "Choisissez un ordre ...", '... et charger vos photos.');
        </script>
        <div id="content">
            <div id="menu" class="menu">
                <img id="menuImg1" class="menuImg" src="../content/images/menus/fleche_menu.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                    style="cursor:pointer;"
                                                                                                    onclick="javascript:window.location='../menu.php'"/>

                <img id="menuImg2" class="menuImg" src="../content/images/menus/fleche_depotPhotos.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                        style="cursor:pointer;"
                                                                                                        onclick="javascript:window.location='uploadPictures.php'"/>	
            </div>
            <div id="divselectOrdre">
                Sélectionnez un ordre : 
                <select id="selectOrdre" >
                    <option>Choisissez un ordre</option>
                    <?php
                        $orders = $pres->getOrderList();
                        foreach($orders as $order){
                            echo "<option>".$order->getNom()."</option>";
                        }
                    ?>
                </select>
            </div>
            <div id="divUpload" style="display:block;" >
                <div id="custom-demo" class="demo">
                    <h2 class="sIFR-replaced" style=""></h2>

                    <div class="demo-box">
                        <div id="divUpGauche">
                            <input type="file" id="file_upload" name="file_upload" />

                        </div>
                    </div>
                </div>
                <p id="textInfo">
                    Cliquez sur 'Sélection photos' pour ajouter des photos, puis sur 'Charger'.
                </p>
                <div id="divUpDroit">
                    <input type="button" class="bouton" value="Charger" onclick="javascript:chargementPhotos();" />
                </div>
            </div>
            <div id="divBlocDroit" style="display:block;">
                <div id="divSelectDate">
                    <p style="text-align:center;">Date : <input id="inputDate" type="text" /></p>
                </div>
                <div id="divSelectLieu">
                    <p style="text-align:center;">Lieu : <input id="inputLieu" type="text"  /></p>
                </div>
            </div>
            <div id="notification" >
                <p id="text_notification" style="text-align:center;"></p>
            </div>
        </div>
        <?php
            include_once(dirname(__FILE__). "/../generic/footer.php");
        ?>
    </body>
</html>
