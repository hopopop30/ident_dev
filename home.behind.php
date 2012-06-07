<?
    session_start();
    include_once(dirname(__FILE__). "/core/presenters/home/class.Home_Presenter.php");
    if($_POST['nav'] == 'envoiLogin'){
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];

        $pres = unserialize($_SESSION["home_pres"]);
        if($pres->connexion($login, $mdp) == "badLog" || $pres->connexion($login, $mdp) == "badPass"){
            $retour = "error";
        }
        else {
            $retour = $pres->connexion($login, $mdp);
            $_SESSION["current_user"] = serialize($retour);
        }

        echo json_encode($retour);
    }
?>