<?php
session_start();
$checkRol = ($_SESSION['idRol']==1 || $_SESSION['idRol']==2 || $_SESSION['idRol']==3 || $_SESSION['idRol']==4) ?true :false;

if($_SESSION['status']!= "ok" || $checkRol!=true)
        header("location: logout.php");

include_once '../common/screenPortions.php';
include '../brules/utilsObj.php';
require_once '../brules/KoolControls/KoolAjax/koolajax.php';
libreriasKool();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Inicio</title>
    <?php echo estilosPagina(true); ?>
</head>
<body>
    <?php echo getHeaderMain($_SESSION['myusername'], true);?>
    <?php $menu = getAdminMenu(); ?>

    <input type="hidden" name="vista" id="vista" value="inicio">

    <section class="section-internas">
        <div class="panel-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="colmenu col-md-2 menu_bg ">
                        <?php echo getNav($menu); ?>
                    </div>
                    <div class="col-md-10">
                        <h1 class="titulo">Bienvenido <span class="pull-right"><a id="btnAyudaweb" onclick="mostrarAyuda('web_inicio')" href="#fancyAyudaWeb"><img src="../images/icon_ayuda.png" width="20px"></a></span> </h1>

                        <div class="cont_iconos">
                            <?php if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){ ?>
                            <div class="row">
                                 <div class="col-md-4">
                                    <a href="catalogos.php"><p><img src="../images/iconos/iconos_menu_lateral/catalogos.png" class="icon-obras" title="Cat&aacute;logos" alt="Cat&aacute;logos"><br class="inicio">Cat&aacute;logos</p></a>
                                </div>
                                <div class="col-md-4">
                                    <a href="catalogos.php"><p><img src="../images/iconos/iconos_menu_lateral/mis-casos.png" class="icon-obras" title="Mis Casos" alt="Mis Casos"><br class="inicio">Mis Casos</p></a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="panel-footer">
            <?php echo getPiePag(true); ?>
        </div>
    </footer>

    <?php echo scriptsPagina(true); ?>
</body>
</html>
