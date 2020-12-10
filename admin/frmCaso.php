<?php
session_start();
$idRol = $_SESSION['idRol'];
$rol = true;
switch ($idRol) {
    case 1: case 2:  $rol = true; break;
    default: $rol = false; break;
}
if($_SESSION['status']!= "ok" || $rol!=true)
        header("location: logout.php");

$dirname = dirname(__DIR__);
include_once '../common/screenPortions.php';
include '../brules/utilsObj.php';
require_once '../brules/KoolControls/KoolAjax/koolajax.php';
libreriasKool();
include_once '../brules/casosObj.php';
include_once '../brules/catTipoCasosObj.php';
// include_once $dirname.'/brules/usuariosObj.php';
// include_once $dirname.'/brules/rolesObj.php';
$casosObj = new casosObj();
$catTipoCasosObj = new catTipoCasosObj();
// $usuariosObj = new usuariosObj();

//establecer la zona horaria
$tz = obtDateTimeZone();
$fecha = $tz->fecha;
$msjResponse = "";
$msjResponseE = "";
$id = (isset($_GET['id']))?$_GET['id']:0;

$colTipos = $catTipoCasosObj->ObtCatTipoCasos();
// echo "<pre>";
// print_r($colTipos);
// echo "</pre>";


/* if(isset($_POST["idUsuario"])){
	$usuarioGObj = new usuariosObj();
    $idUsuario = $_POST["idUsuario"];
    $idRolG = $_POST["idRol"];

    $usuarioGObj->idUsuario = $idUsuario;
    $usuarioGObj->idRol = $idRolG;
    $usuarioGObj->nombre = $_POST["nombreU"];
    $usuarioGObj->email = $_POST["emailU"];
    $usuarioGObj->password = $_POST["passU"];
    $usuarioGObj->activo = $_POST["activoU"];

    $res = 0;
    if($idUsuario == 0){
    	$usuarioGObj->GuardarUsuario();
        $idUsuario = $usuarioGObj->idUsuario;
        if($idUsuario > 0){
            $res = 1;
        }
    }else{
    	$res = $usuarioGObj->EditarUsuario();
    }


    if($res > 0){
        $msjResponse .= "Cambios guardados";
        header("location: catalogos.php?catalog=usuarios");
    }
    else{
        $msjResponse .= "No hay cambios que guardar";
    }

} */


$cliente = "";
$idTipo = 0;
$titular = "";
$fechaAlta = $tz->fechaF2;
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Nuevo Caso</title>
    <?php echo estilosPagina(true); ?>
</head>

<body>
	<?php echo getHeaderMain($_SESSION['myusername'], true);?>
    <?php $menu = getAdminMenu(); ?>

    <section class="section-internas">
    	<div class="panel-body">
    		<div class="container-fluid">
    			<div class="row">
    				<div class="colmenu col-md-2 menu_bg">
                        <?php echo getNav($menu); ?>
                    </div>

                    <div class="col-md-10">
                        <h1 class="titulo">Nuevo Caso<span class="pull-right"><a id="btnAyudaweb" onclick="mostrarAyuda('web_prospectos')" href="#fancyAyudaWeb"><img src="../images/icon_ayuda.png" width="20px"></a></span></h1>
                        <ol class="breadcrumb">
                            <li><a href="listadocasos.php">Inicio</a></li>
                            <li class="active">Nuevo caso</li>
                        </ol>

                        <!--Mostrar en caso de presionar el boton de guardar-->
                        <?php if ($msjResponse != "") { ?>
                            <div class="new_line alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $msjResponse; ?>
                            </div>
                        <?php } ?>

                        <!-- <form role="form" id="formUsuario" name="formUsuario" method="post" action="" enctype="multipart/form-data">
                        	<input type="hidden" name="idRolSesion" id="idRolSesion" value="<?php echo $idRol; ?>">
                            <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario; ?>">
                            <input type="hidden" name="idEmpresaUrs" id="idEmpresaUrs" value="<?php echo $empresaUsr; ?>">

                            <div class="row">
                                <div class="text-right form-group col-md-2 col-sm-2 col-xs-2">
                                    <label for="idRol">Rol:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <select class="form-control <?php echo ($usuarioObj->idUsuario > 0)?"":"required"; ?>" id="idRol" name="idRol" <?php echo ($usuarioObj->idUsuario > 0)?"":""; ?>>
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($roles as $rol) {
                                            $selec = "";
                                            if($rol->idRol == $usuarioObj->idRol){
                                                $selec = "selected";
                                            }
                                            echo '<option value="'.$rol->idRol.'" '.$selec.'>'.$rol->rol.'</option>';

                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="text-right form-group col-md-2 col-sm-2 col-xs-2">
                                    <label for="nombreU">Nombre:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input type="text" id="nombreU" name="nombreU" class="form-control required" value="<?php echo $usuarioObj->nombre ?>" maxlength="150" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="text-right form-group col-md-2 col-sm-2 col-xs-2">
                                    <label for="emailU">E-mail:</label>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-5">
                                    <input type="text" id="emailU" name="emailU" class="form-control required email" onchange="validateMail()" value="<?php echo $usuarioObj->email ?>" maxlength="100" >
                                    <span id="spanLabel"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="text-right form-group col-md-2 col-sm-2 col-xs-2">
                                    <label for="passU">Contrase&ntilde;a:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="password">
                                        <input type="text" id="passU" name="passU" value="<?php echo $usuarioObj->password ?>" class="form-control password required" onkeyup="mostrarOjo(this.id)" onmouseover="mostrarOjo(this.id)" autocomplete="?completes">
                                        <span class="glyphicon glyphicon-eye-open" id="eye-passU" onmousedown="mostrarPassword('passU')" onmouseup="ocultarPassword('passU')" mouseout="ocultarPassword('passU')"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-2 col-sm-2 col-xs-2">
                                    <a onclick="generarPassword('passU')" class="btn btn-primary" role="button" >Generar</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="text-right form-group col-md-2 col-sm-2 col-xs-2">
                                    <label for="activoU">Activo:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <select class="form-control required" id="activoU" name="activoU">
                                        <option value="1" <?php if($usuarioObj->activo == 1 || $usuarioObj->idUsuario === 0)echo "selected"; ?>>Si</option>
                                        <option value="0" <?php if($usuarioObj->activo === 0 && $usuarioObj->idUsuario > 0)echo "selected"; ?>>No</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-2">
                                     <a href="catalogos.php?catalog=usuarios" class="btn btn-danger" role="button">Cancelar</a>
                                </div>
                                <div class="col-md-2">
                                    <a onclick="guardarFrmUsuario()" class="btn btn-primary" role="button" id="btnGuardarUsuario">Guardar</a>
                                </div>
                            </div>

                            <div class="cont_btnrequisicion">
                                <div class="new_line">
                                </div>
                            </div>
                        </form> -->

                        <form role="form" id="formCaso" name="formCaso" method="post" action="">
                            <input type="hidden" name="form_caso">
                            <input type="hidden" name="c_id" id="c_id" value="<?php echo $id;?>">
                            <!--
                            <input type="hidden" name="usuarioIdCreador" id="usuarioIdCreador" value="<?php echo $_SESSION['idUsuario'];?>">
                            <input type="hidden" name="dp_ids_deptos" id="dp_ids_deptos" value="<?php echo $idsDeptos; ?>">
                            <input type="hidden" id="dp_borrarP" value="<?php echo $borrarP; ?>">
                            <input type="hidden" id="salvarSinCrearVer" name="salvarSinCrearVer" value="0">
                            <input type="hidden" id="check_soloLectura" value="<?php echo $soloLectura;?>"> -->


                            <div class="content_wrapper">
                                <div class="row">
                                    <!-- columna 1 -->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3 text-right">
                                                <label>Fecha alta:</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input class="form-control inputfechaGral required" type="text" name="c_falta" id="c_falta" value="<?php echo $fechaAlta;?>" style="width:50%;display:inline-block;" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 text-right">
                                                <label>Cliente:</label>
                                            </div>
                                            <div class="col-md-7 form-group">
                                                <input type="hidden" id="c_idcliente" name="c_idcliente" value="0"/>
                                                <input type="text" id="c_cliente" name="c_cliente" value="<?php echo $cliente;?>" class="form-control required" readonly style="width:80%;display:inline-block;"/>
                                                <button type="button" class="btn btn-primary" role="button" title="Buscar" id="busca_clientes" value="Buscar" onclick="obtListaClientes();">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 text-right">
                                                <label>Tipo:</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select id="c_tipo" name="c_tipo" class="form-control required">
                                                    <option value="">---Seleccionar---</option>
                                                        <?php
                                                            foreach ($colTipos as $elem) {
                                                                $sel = ($idTipo==$elem->idTipo)?"selected":"";
                                                                echo '<option '.$sel.' value="'.$elem->idTipo.'">'.$elem->nombre.'</option>';
                                                            }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-3 text-right">
                                                <label>Titular:</label>
                                            </div>
                                            <div class="col-md-7 form-group">
                                                <input type="hidden" id="c_idtitular" name="c_idtitular" value="0"/>
                                                <input type="text" id="c_titular" name="c_titular" value="<?php echo $titular;?>" class="form-control required" readonly style="width:80%;display:inline-block;"/>
                                                <button type="button" class="btn btn-primary" role="button" title="Buscar" id="busca_titular" value="Buscar" onclick="obtListaTitulares();">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-3 text-right">
                                                <label>Autorizados:</label>
                                            </div>
                                            <div class="col-md-7 form-group">
                                                <textarea class="form-control" name="c_autorizados" id="c_autorizados" rows="6"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- columna 2 -->
                                    <!-- <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3 text-right">
                                                <label>Estatus:</label>
                                            </div>
                                            <div class="col-md-7 form-group  alert alert-info">
                                                ?php
                                                if($idP>0){
                                                    if($estatusDp==1){
                                                        echo '<span class="texto_estatus">En creaci&oacute;n</span>';
                                                    }
                                                    if($estatusDp==2){
                                                        echo '<span class="texto_estatus">Espera de aprobaci&oacute;n</span>';
                                                    }
                                                    if($estatusDp==3){
                                                        echo '<span class="texto_estatus">Aprobado</span>';
                                                    }
                                                    if($estatusDp==4){
                                                        echo '<span class="texto_estatus">Rechazado</span>';
                                                    }

                                                    echo '<input type="hidden" id="dp_estatus" name="dp_estatus" value="'.$estatusDp.'">';
                                                }else{
                                                    echo '<span class="texto_estatus">En creaci&oacute;n</span>';
                                                    echo '<input type="hidden" id="dp_estatus" name="dp_estatus" value="1">'; //Valor default en creacion
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <button type="button" class="btn btn-primary" role="button" title="Imprimir Proceso" onclick="printProcess()">
                                                    <span class="glyphicon glyphicon-print"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            <label>Revisiones:</label>
                                            </div>
                                            <div class="col-md-12">
                                            ?php
                                                echo $koolajax->Render();
                                                if($resultRevs != null){
                                                    echo $resultRevs->Render();
                                                }
                                            ?>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                        </form>


                    </div>
    			</div>
    		</div>
        </div>

        <!-- Modal lista de clientes -->
        <div class="modal fade" id="modalListaClientes" role="dialog" data-backdrop="static" data-keyboard="false" style="display:none;">
          <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Lista de clientes</h4>
                </div>
                <div class="row">

                  <form role="form" id="formListaClientes" name="formListaClientes" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id_sel_cliente" id="id_sel_cliente" value="0">

                    <br>
                    <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                        <div id="cont_listaclientes"></div>
                    </div>

                    <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                      <div class="row">
                        <div class="col-md-offset-6 col-md-6 text-right">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                          <a class="btn btn-primary" id="btnObt" onclick="btnObtIdCliente()">Aceptar</a>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12"><br/></div>
                  </form>

                </div>
            </div>
          </div>
        </div>

        <!-- Modal lista de clientes -->
        <div class="modal fade" id="modalListaTitulares" role="dialog" data-backdrop="static" data-keyboard="false" style="display:none;">
          <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Lista de Titulares</h4>
                </div>
                <div class="row">

                  <form role="form" id="formListatitulares" name="formListatitulares" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id_sel_titular" id="id_sel_titular" value="0">

                    <br>
                    <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                        <div id="cont_listatitulares"></div>
                    </div>

                    <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                      <div class="row">
                        <div class="col-md-offset-6 col-md-6 text-right">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                          <a class="btn btn-primary" id="btnObt" onclick="btnObtIdCliente()">Aceptar</a>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12"><br/></div>
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
    <script>
        $(document).ready(function(){
            <?php if( isset($res) && $res==1){ ?>
                alertify.success("Informaci&oacute;n guardada correctamente.");
                setTimeout(function(){
                    window.location.href = "frmUsuario.php?id="+'<?php echo $idUsuario?>';
                }, 500);
            <?php } ?>
        });
    </script>
</body>

</html>
