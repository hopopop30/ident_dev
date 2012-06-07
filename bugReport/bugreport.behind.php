<?php
	session_start();
	include_once(dirname(__FILE__). "/../core/presenters/bugreport/class.BugReport_Presenter.php");
	if($_POST['nav'] == 'envoireport'){
		$desc = $_POST['desc'];
		$page = $_POST['page'];
                
		$pres = unserialize($_SESSION["bugreport_pres"]);
                 
		$isOk = $pres->sendReport($page, $desc);
		
		$_SESSION["bugreport_pres"] = serialize($pres);
		echo json_encode($isOk);
	}
?>