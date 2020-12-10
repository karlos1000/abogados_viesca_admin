<?php
session_start();
$checkRol = ($_SESSION['idRol']==1 || $_SESSION['idRol']==2) ?true :false;

if($_SESSION['status']!= "ok" || $checkRol!=true)
        header("location: logout.php");

include_once '../common/screenPortions.php';
include '../brules/utilsObj.php';
require_once '../brules/KoolControls/KoolAjax/koolajax.php';
libreriasKool();
include_once '../brules/casosObj.php';
$casosObj = new casosObj();

$filSel = "";
$filTexto = "";
$filEstatus = "";
$result = $casosObj->ObtListadoCasosGrid($filSel, $filTexto, $filEstatus);
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

    <input type="hidden" name="vista" id="vista" value="listadocasos">

    <section class="section-internas">
        <div class="panel-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="colmenu col-md-2 menu_bg ">
                        <?php echo getNav($menu); ?>
                    </div>
                    <div class="col-md-10">
                        <h1 class="titulo">Mis Casos<span class="pull-right"><a id="btnAyudaweb" onclick="mostrarAyuda('web_prospectos')" href="#fancyAyudaWeb"><img src="../images/icon_ayuda.png" width="20px"></a></span></h1>

                        <ol class="breadcrumb">
                            <li><a href="index.php">Inicio</a></li>
                            <li class="active">Mis Casos</li>
                        </ol>

                        <div class="row">
                            <div class="col-md-offset-8 col-md-2 text-right">
                                <a href="frmCaso.php?id=0" class="btn btn-primary">Nuevo</a>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="index.php"><input type="button" id="regresar" value="Regresar" class="btn"></a>
                            </div>
                        </div>
                        <br/>

                        <!-- <div class="filtro">
                            <form role="form" id="frmFilProcesos" name="frmFilProcesos" method="get" action="">
                                <div class="row">
                                    <div class="text-right form-group col-md-3 col-sm-3 col-xs-3 alinear">
                                        <input type="text" id="filTexto" name="filTexto" value="<?php echo $filTexto; ?>" class="">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <select class="form-control" id="filSel" name="filSel">
                                            <option value="">--Seleccionar--</option>
                                            <option value="1" <?php echo ($filSel==1)?"selected":""; ?>>Nombre</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1 form-group">
                                        Estatus
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <select class="form-control " id="filEstatus" name="filEstatus">
                                            <option value="">--Seleccionar--</option>
                                            <?php
                                            foreach ($colEstatus as $elem) { ?>
                                                <option value="<?php echo $elem->idEstatus;?>"><?php echo $elem->nombre; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div style="display:inline-block;">
                                            <button type="submit" class="btn btn-primary" role="button" title="Buscar" name="buscarProceso" id="buscarProceso" value="Buscar">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </div>
                                        <div style="display:inline-block;">
                                            <button type="button" class="btn btn-primary" role="button" value="Limpiar" title="Limpiar" onclick="limpiarBusqueda();">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> -->



                        <form name="grids" method="post">
                            <?php
                            echo $koolajax->Render();
                            if($result != null){
                                echo $result->Render();
                            }
                            ?>
                        </form>
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
