<?php
	session_start();
        include_once(dirname(__FILE__). "/../core/managers/business/class.user.php");
        include_once(dirname(__FILE__). "/../core/managers/business/class.picture.php");
	include_once(dirname(__FILE__). "/../core/presenters/identification/class.Identification_Presenter.php");

        $idOrdre = $_GET['order'];
        
        
        $user = unserialize($_SESSION["current_user"]);

        if(!isset($user) || $user == ""){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = '../home.php'; </script>";
        }
        $pres = new Identification_Presenter($idOrdre, $user->getId());
        $_SESSION['identification_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="identification.css" />
		<link rel="icon" type="image/png" href="../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
                <script src="../scripts/lightbox/js/jquery-1.7.2.min.js"></script>
                <script src="../scripts/lightbox/js/lightbox.js"></script>
                <link href="../scripts/lightbox/css/lightbox.css" rel="stylesheet" />
                
		<!--Autres scripts-->
		<script language='JavaScript' src='../scripts/generic.js'></script>
		<script language='JavaScript' src='../scripts/menu_manager.js'></script>
		<script language='JavaScript' src='identification.js'></script>
  		<title>
			Identificator - Identification
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../generic/top.php");
                        
                        $user_picture_dir = "../".$pres->getUserPictureDirectory();
                        
			if($user->getPhotoProfil() != ""){
                            echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
                        }
                        else echo "<input type='hidden' id='photo_profil' value='../content/images/Default_white.png' />";
		?>
		<script language='JavaScript'>
			InitHeader(document.getElementById('photo_profil').value, "Naviguez avec les flèches ...", '... et identifiez les photos.');
		</script>
		 <div id="content">
			<div id="menu" class="menu">
                            <img id="menuImg1" class="menuImg" src="../content/images/menus/fleche_menu.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                style="cursor:pointer;"
                                                                                                                onclick="javascript:window.location='../menu.php'"/>
                            <img id="menuImg2" class="menuImg" src="../content/images/menus/fleche_ordres.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='order_choice.php'"/>
                            <img id="menuImg3" class="menuImg" src="../content/images/menus/fleche_identification.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='identification.php?order=<?php echo $idOrdre ?>'"/>			
			</div>
			<div id="div_middle" class="div_middle">
                            <input type="hidden" id="siteAddress" value="<?php echo $pres->getSiteAddress(); ?>" />
                            <input type="hidden" id="pictureDir" value="<?php echo $pres->getPictureDir(); ?>" />
                            <div id="div_filtres">
                                Afficher les photos non visionnées : <input type="checkbox" id="check_photos_vues" onchange="check_vue_change()" />
                            </div>
                            <div id="div_nav_photos">
                                <div id="notification_photo" style="display:none;">
                                    <img src="../content/images/badLog.png" style="width:50px;height:50px;" title="Déja identifiée">
                                </div>
                                <div id="divFlecheGauche">
                                    <a href="#"><img id="flecheG" src="../content/images/gauche_simple.png" onmouseover="flecheOverG()" onmouseout="flecheOutG()" onclick="prevPic()"/></a>
                                </div>
                                <div id="divImage">
                                    <?php
                                        $picture = $pres->getCurrentPic();
                                     ?>
                                    <?php
                                        if($picture != "empty"){
                                            echo "<a id='lien_img_principale' href='".$pres->getSiteAddress().$pres->getPictureDir()."/".$picture->getNomFichier()."' rel='lightbox' >";
                                            //echo "<img id='img_pricipale' src='../photos/identification/".$picture->getNomFichier()."' />";
                                                echo "<img id='img_pricipale' src='".$pres->getSiteAddress().$pres->getPictureDir()."/".$picture->getNomFichier()."' />";
                                            echo "</a>";
                                        }
                                        else {
                                            echo "<img id='img_pricipale' src='../content/images/folder_empty.png' />";
                                        }
                                     ?>
                                </div>
                                <div id="div_numero_photo" >
                                    <span style="font-size: 1.2em">
                                        <span id="photoNumber" style="color:orange">
                                            <?php echo $pres->getCurrentNumber(); ?>
                                        </span>
                                        /
                                        <span id="photoTotal">
                                            <?php echo $pres->getPhotoNumber(); ?>
                                        </span>
                                    </span>
                                </div>
                                <div id="divFlecheDroite">
                                    <a href="#"><img id="flecheD" src="../content/images/droite_simple.png" onmouseover="flecheOverD()" onmouseout="flecheOutD()" onclick="nextPic()" /></a>
                                </div>
                            </div>
                            
                            <div id="divIdentification">
                                <div id="divTableauIdent">
                                <table id="tabIdent">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Superfamille :
                                            </td>
                                            <td>
                                                <select id="select_superfamille" class="elemForm_Ident" onchange = "ListeFamille()">
                                                </select>
                                            </td>
                                        </tr>	
                                        <tr>
                                            <td>
                                                Famille :
                                            </td>
                                            <td>
                                                <select id="select_famille" class="elemForm_Ident" onchange = "ListesSuperFamilleEtSousFamille()">
                                                </select>
                                            </td>
                                        </tr>	
                                        <tr>
                                            <td>
                                                Sous-famille :
                                            </td>
                                            <td>
                                                <select id="select_sousfamille" class="elemForm_Ident" onchange = "ListeTribu()"></select>
                                            </td>
                                        </tr>	
                                        <tr>
                                            <td>
                                                Tribu :
                                            </td>
                                            <td>
                                                <select id="select_tribu" class="elemForm_Ident" onchange = "ListeGenre()"></select>
                                            </td>
                                        </tr>		
                                        <tr>
                                            <td>
                                                Genre
                                            </td>
                                            <td>
                                                <select id="select_genre" class="elemForm_Ident" onchange = "ListeSousGenre()"></select>
                                            </td>
                                        </tr>		
                                        <tr>
                                            <td>
                                                Sous-genre :
                                            </td>
                                            <td>
                                                <select id="select_sousGenre" class="elemForm_Ident" onchange = "ListeEspece()"></select>
                                            </td>
                                        </tr>		
                                        <tr>
                                            <td>
                                                Espèce :
                                            </td>
                                            <td>
                                                <select id="select_espece" class="elemForm_Ident" onchange = "rempliInfos()"></select>
                                            </td>
                                        </tr>	
                                        <tr>	
                                            <td>
                                                Descripteur :
                                            </td>
                                            <td>
                                                <input type="text"  id="champ_descripteur" class= "elemForm_Ident" readonly="readonly"/>
                                            </td>
                                        </tr>	
                                        <tr>	
                                            <td>
                                                Année :
                                            </td>
                                            <td>
                                                <input type="text"  id="champ_annee" class= "elemForm_Ident" readonly="readonly"/>
                                            </td>	
                                        </tr>	
                                        <tr>
                                            <td>
                                                Nom vernaculaire :
                                            </td>
                                            <td>
                                                <input type="text"  id="champ_nomVernaculaire" class= "elemForm_Ident" readonly="readonly"/>
                                            </td>
                                        </tr>							
                                </tbody>
                            </table>
                            </div>
                            <div id="divBoutValider">
                                <input type="button" id="bout_badOrdre" name="bout_badOrdre" value="Mauvais ordre" class="bouton" onclick="mauvaisOrdre()" />
                                <input type="button" id="bout_valider" name="bout_valider" value="Valider" class="bouton" onclick="validation()" />
                            </div>
                        </div>
                        <div id="divInfoImage">
                            <p style="text-align:center;">
                                <?php
            
                                    if($picture != "empty"){
                                        $dateExplode = explode(" ", $picture->getDatePriseVue());
                                        $dateExplode2 = explode("-", $dateExplode[0]);
                                        $jour = $dateExplode2[2];
                                        $mois = $dateExplode2[1];
                                        $an = $dateExplode2[0];
                                        $dateAffich = $jour."-".$mois."-".$an;

                                        echo "Date de prise de vue : <span id='span_date'>".$dateAffich."</span>
                                            <br /> 
                                            <br />
                                            Lieu : <span id=span_lieu>".$picture->getLieu()."</span>";
                                    }
                                    else {
                                        echo "Date de prise de vue : <span id='span_date'></span>
                                            <br /> 
                                            <br />
                                            Lieu : <span id=span_lieu></span>";
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../generic/footer.php");
		?>
	</body>
</html>
