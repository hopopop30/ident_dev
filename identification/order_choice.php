<?php
	session_start();
        include_once(dirname(__FILE__). "/../core/managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../core/presenters/identification/class.OrderChoice_Presenter.php");

        $user = unserialize($_SESSION["current_user"]);

        if(!isset($user) || $user == ""){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = '../home.php'; </script>";
        }
        
        $pres = new OrderChoice_Presenter($user->getId());
        $_SESSION['order_choice_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="order_choice.css" />
		<link rel="icon" type="image/png" href="../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../scripts/generic.js'></script>
		<script language='JavaScript' src='../scripts/menu_manager.js'></script>
  		<title>
			Identificator - Ordres
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../generic/top.php");
			
                        //--Gestion de la photo de l'utilisateur
                        $user_picture_dir = "../".$pres->getUserPictureDirectory();
                        
			if($user->getPhotoProfil() != ""){
                            echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
                        }
                        else echo "<input type='hidden' id='photo_profil' value='../content/images/Default_white.png' />";
		?>
		<script language='JavaScript'>
			InitHeader(document.getElementById('photo_profil').value, "Sélectionnez un ordre...", "... avant l'identification.");
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
                        <img id="menuImg3" class="menuImg" src="../content/images/menus/fleche_identification_disabled.png" />		
                    </div>
                     <?php
                        $orderList = $pres->getAllOrders();
                        $nbr = count($orderList);
                        if($nbr > 4){ $nbr = 4;}
                     ?>
                     <div class="div_middle Item<?php echo $nbr; ?>">	
                         <?php
                            foreach($orderList as $order){
                                echo "<a href='identification.php?order=".$order->getId()."' class='lien_order_item'>";
                                echo "<div id='order_".$order->getId()."' class='div_elem'>";
                                echo "<img id='order_".$order->getId()."' src='../photos/ordres/".$order->getLienImage()."' class='image_order_item' />";
                                echo "<span class='text_order_item'>".$order->getNom()."</span>";
                                echo "</div>";
                                echo "</a>";
                            }
                         ?>
                     </div>
		<?php
			include_once(dirname(__FILE__). "/../generic/footer.php");
		?>
	</body>
</html>
