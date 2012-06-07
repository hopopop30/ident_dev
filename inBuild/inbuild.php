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
  		<link rel="stylesheet" media="screen" href="../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="inbuild.css" />
		<link rel="icon" type="image/png" href="../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../scripts/generic.js'></script>
		<script language='JavaScript' src='../scripts/menu_manager.js'></script>
  		<title>
			Identificator - En construction
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../generic/top.php");
			
		?>
		<script language='JavaScript'>
			InitHeader('../content/images/en_construction.png', "Cette page ...", '... est en cours de construction', true);
		</script>
		 <div id="content">
			<div id="menu" class="menu">
				<img id="menuImg1" class="menuImg" src="../content/images/menus/fleche_menu.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='../menu.php'"/>
				
			</div>
			<div id="div_middle" class="div_middle">
                            <br/>
                            <p style="text-align:center;">
				<img src="../content/images/en_construction.png" style="width: 150px; height:150px;"/>
                                <br/>
                                En construction
                            </p>
			</div>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../generic/footer.php");
		?>
	</body>
</html>
