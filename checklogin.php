<?php
ob_start();

include_once 'brules/usuariosObj.php';
$userObj = new usuariosObj();

$usrEmail = stripslashes($_POST['usr_email']);
$usrPass = stripslashes($_POST['usr_pass']);

//verificar si existe usuario

$user = $userObj->LogInUser(trim($usrEmail), str_replace("'", "", trim($usrPass)));

if($user->idUsuario>0)
{
    if($user->activo>0)
    {
        session_start();
        $_SESSION['idUsuario'] = $user->idUsuario;
        $_SESSION['idRol'] = $user->idRol;
        $_SESSION['myusername'] = $user->nombre;
        $_SESSION["status"] = "ok";
        $_SESSION['clienteId'] = $user->clienteId;

        if($user->idRol == 1 || $user->idRol == 2){
            header("location:admin/index.php");
        }
        elseif ($user->idRol == 3 || $user->idRol==4) {
            header("location:admin/index.php");
        }
        else{
            header("location:index.php?login=error");
        }
    }
    else{
        header("location:index.php?login=inactivo");
    }
}
else
{
    header("location:index.php?login=error");
}
ob_flush();
?>
