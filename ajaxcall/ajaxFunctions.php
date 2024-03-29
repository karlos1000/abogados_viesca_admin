<?php
/*
 *  © 2013 Framelova. All rights reserved. Privacy Policy
 *  Creado: 31/03/2017
 *  Por: MJCS
 *  Descripción: This functions  are called via Ajax
 */
$dirname = dirname(__DIR__);
include_once $dirname.'/brules/catConfiguracionesObj.php';
include_once $dirname.'/brules/usuariosObj.php';
include_once $dirname.'/brules/catAyudasObj.php';
include_once $dirname.'/brules/comunicadosObj.php';
include_once $dirname.'/brules/utilsObj.php';
include_once $dirname.'/brules/clientesObj.php';
include_once $dirname.'/brules/catTipoCasosObj.php';
include_once $dirname.'/brules/casosObj.php';
include_once $dirname.'/brules/casoAccionesObj.php';
include_once $dirname.'/brules/accionGastosObj.php';
include_once $dirname.'/brules/EmailFunctionsObj.php';

//Fisrt check the function name
$function= $_GET['funct'];
switch ($function){
    case "funcionEjemplo":
        funcionEjemplo($_GET['callback'], $_GET['id'],$_GET['valor']);
        break;
    case "verificaExisteEmail":
        verificaExisteEmail($_GET['callback'],$_GET['email']);
    break;

    case "obtDatosConfiguracion":
        obtDatosConfiguracion();
    break;

    case "guardarConfiguracion":
        guardarConfiguracion($_POST['idConfiguracion'], $_POST['valor']);
    break;

    case "mostrarAyuda":
      mostrarAyuda($_GET['callback'],$_GET['alias']);
   break;

   case "guardarAyuda":
        guardarAyuda($_POST['alias'] ,$_POST['contenido']);
    break;

    case "generarPasswordUsuario":
        generarPasswordUsuario($_GET['callback']);
    break;

    case "verificaUsoTabla":
       verificaUsoTabla($_GET['callback'],$_GET['nombreTabla'],$_GET['idRegistro']);
    break;

     case "eliminarRegCatalogo":
       eliminarRegCatalogo($_GET['callback'],$_GET['elimTipo'],$_GET['elimRegId']);
    break;

    case "guardarComunicado":
        guardarComunicado($_POST);
    break;

    case "muestraTablaContenido":
    muestraTablaContenido($_GET['callback']);
    break;

    case "cargaSelector":
        cargaSelector($_GET['callback']);
      break;

    // Listados de clientes
    case "tblListaClientes": tblListaClientes(); break;
    case "tblListaTitulares": tblListaTitulares(); break;
    case "crearCliente": crearCliente(); break;
    case "crearTipo": crearTipo(); break;
    case "crearCaso": crearCaso(); break;
    case "creaEditaAccion": creaEditaAccion(); break;
    case "obtDatosAccion": obtDatosAccion(); break;
    case "tblListaGastos": tblListaGastos(); break;
    case "creaEditaGasto": creaEditaGasto(); break;
    case "obtDatosGasto": obtDatosGasto(); break;
    case "eliminarGasto": eliminarGasto(); break;
    case "eliminarAccion": eliminarAccion(); break;
    case "obtTotalGastos": obtTotalGastos(); break;

    default:
      echo "Not valid call";
}


// Obtener la lista de clientes
function tblListaClientes(){
  $callback = (isset($_GET['callback']) !="")?$_GET['callback']:"";
  $idTabla = (isset($_GET['idTabla']) !="")?$_GET['idTabla']:"";
  // $idUsuario = (isset($_GET['idUsuario']) !="")?$_GET['idUsuario']:"";

  $clientesObj = new clientesObj();
  $colRes = $clientesObj->ObtClientes();
  $arr = array("success"=>false);

  // echo "<pre>";
  // print_r($colRes);
  // echo "</pre>";
  // exit();
  if(count($colRes)>0){
    // table-striped
    $html = '
        <table id="'.$idTabla.'" class="table table-bordered table-condensed dataTable no-footer dt-responsive hover" role="grid" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <th>ID <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                    <th>Nombre <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
            ';
              foreach($colRes as $item){
                // if($idUsuario!=$item->idUsuario && $item->idRol!=4){
                  $html .= '
                  <tr>
                      <td>'.$item->idCliente.'</td>
                      <td>'.$item->nombre.'</td>
                  </tr>
                  ';
                // }
              }
        $html .= '
            </tbody>
        </table>
    ';

    $arr = array("success"=>true, "tblListaClientes"=>$html);
  }

  echo $callback . '(' . json_encode($arr) . ');';
}

// Obtener la lista titulares
function tblListaTitulares(){
  $callback = (isset($_GET['callback']) !="")?$_GET['callback']:"";
  $idTabla = (isset($_GET['idTabla']) !="")?$_GET['idTabla']:"";
  // $idUsuario = (isset($_GET['idUsuario']) !="")?$_GET['idUsuario']:"";

  $usuariosObj = new usuariosObj();
  $colRes = $usuariosObj->obtTodosUsuarios(true, 2);
  $arr = array("success"=>false);

  // echo "<pre>";
  // print_r($colRes);
  // echo "</pre>";
  // exit();
  if(count($colRes)>0){
    // table-striped
    $html = '
        <table id="'.$idTabla.'" class="table table-bordered table-condensed dataTable no-footer dt-responsive hover" role="grid" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <th>ID <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                    <th>Nombre <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
            ';
              foreach($colRes as $item){
                // if($idUsuario!=$item->idUsuario && $item->idRol!=4){
                  $html .= '
                  <tr>
                      <td>'.$item->idUsuario.'</td>
                      <td>'.$item->nombre.'</td>
                  </tr>
                  ';
                // }
              }
        $html .= '
            </tbody>
        </table>
    ';

    $arr = array("success"=>true, "tblListaTitulares"=>$html);
  }

  echo $callback . '(' . json_encode($arr) . ');';
}



function funcionEjemplo($callback, $id, $valor){
    $gamaModelosObj = new gamaModelosObj();
    $actualizacionesObj = new catActualizacionesObj();
    $actualizacionesObj->updActualizacion("gama_modelos");
    $res = $gamaModelosObj->ActCampoGamaModelo('activo', $valor, $id);
    $return_arr = array("success"=>true, "res"=>$res);
    echo $callback . '(' . json_encode($return_arr) . ');';
}

function verificaExisteEmail($callback, $email){
    $usuariosObj = new usuariosObj();
    //$prospectoObj = new clientesProspectosObj();

    $usuario = $usuariosObj->UserByEmail($email);
    //$prospecto = $prospectoObj->ObtClienteProspectoByEmail($email);

    $return_arr = array("success"=>true, "idUsuario"=>$usuario->idUsuario);

    echo $callback . '(' . json_encode($return_arr) . ');';
}

function guardarConfiguracion($idConfiguracion, $valor){
  $dirname = dirname(__DIR__);
  include  $dirname.'/common/config.php';
  $valor = base64_decode($valor);
  $valor = convertirTextoEnriquecido($valor,$siteURL, true );

  $catConfiguracionesObj = new catConfiguracionesObj();
  $catConfiguracionesObj->valor = convertirTextoEnriquecido($valor);
  $catConfiguracionesObj->idConfiguracion = $idConfiguracion;
  $catConfiguracionesObj->nombre = $_POST["nombreConf"];

  $res = $catConfiguracionesObj->ActualizarConfiguracion();

  $return_arr = array("success"=>true, "res"=>$res);
  echo json_encode($return_arr);
}

// obtener datos de la configuracion imp 17/10/19
function obtDatosConfiguracion(){
  $catConfiguracionesObj = new catConfiguracionesObj();

  $callback = (isset($_GET['callback']) !="")?$_GET['callback']:"";
  $idConfiguracion = (isset($_GET['idConfiguracion']) !="")?$_GET['idConfiguracion']:0;
  $arr = array("success"=>false);

  if($idConfiguracion>0){
    $datosConf = $catConfiguracionesObj->ObtConfiguracionByID($idConfiguracion);
    if($datosConf->idConfiguracion>0){
      $arr = array("success"=>true, "datosConf"=>$datosConf);
    }
  }

  echo $callback . '(' . json_encode($arr) . ');';
}


function mostrarAyuda($callback, $alias){
    $catAyudasObj = new catAyudasObj();

    $ayuda =$catAyudasObj->ObtAyudaPorAlias($alias);
    // var_dump($catAyudasObj->idAyuda);
    // die();
    if($ayuda->idAyuda > 0){
      $descripcion = str_replace("&#34;",'"', $ayuda->descripcion);
      $return_arr = array("success"=>true, "titulo"=>$ayuda->titulo, "descripcion"=>$descripcion);
    }
    else{
        $return_arr = array("success"=>false);
    }

    echo $callback . '(' . json_encode($return_arr) . ');';
}


function guardarAyuda($alias, $contenido){
    $catAyudasObj = new catAyudasObj();

    $res = $catAyudasObj->ActAyudaPorAlias('descripcion', convertirTextoEnriquecido(base64_decode($contenido)), $alias);

    if($res > 0){
        $return_arr = array("success"=>true);
    }
    else{
        $return_arr = array("success"=>false);
    }

  echo json_encode($return_arr);
}

function generarPasswordUsuario($callback){
    $return_arr = array("success"=>true, "password"=>generarPassword(5));
    echo $callback . '(' . json_encode($return_arr) . ');';
}

function verificaUsoTabla($callback, $nombreTabla, $idRegistro){
  $textoResult = '';
  $sePuedeEliminar = true;
  $palabrasTabla = array();
  $nombreReg = '';

  switch ($nombreTabla) {
    case 'usuarios':
      $usuariosObj = new usuariosObj();

      $palabrasTabla = array("pluralMayus"=>"Usuarios", "pluralMinus"=>"usuarios", "singularMayus"=>"Usuario", "singularMinus"=>"usuario");


      $usuario = $usuariosObj->UserByID($idRegistro);
      // $contactos = $catContactosObj->ObtContactosBuscar("", "", $idRegistro);
      // $cotizaciones = $cotizacionesObj->ObtTodosCotizaciones("", $idRegistro);
      $nombreReg = $usuario->nombre;
      $contactos = array();

      if(count($contactos) > 0){
        $sePuedeEliminar = false;
        $textoResult .= 'El usuario '.$nombreReg.', se utiliza en '.count($contactos).' contactos<br>';
      }

      if($idRegistro == 1){
        $sePuedeEliminar = false;
        $textoResult .= 'El usuario .'.$nombreReg.', es el usuario principal del sistema<br>';
      }




    break;
    default:break;
  }
  if($sePuedeEliminar){
    $textoResult = '&#191;Est&aacute; seguro de eliminar este '.$palabrasTabla["singularMinus"].'? ('.$nombreReg.')';
  }

  $return_arr = array("success"=>true, "texto"=>$textoResult, "sePuedeEliminar"=>$sePuedeEliminar, "palabrasTabla"=>$palabrasTabla, "nombreReg"=>$nombreReg);
  echo $callback . '(' . json_encode($return_arr) . ');';
}


function eliminarRegCatalogo($callback, $elimTipo, $elimRegId){
  $res = 0;
  switch ($elimTipo) {
    case 'usuarios':
      $usuariosObj = new usuariosObj();
      $res = $usuariosObj->EliminarUsuario($elimRegId);
      break;

    default:break;
  }


  $return_arr = array("success"=>true, "res"=>$res);
  echo $callback . '(' . json_encode($return_arr) . ');';
}


// Guardar comunicado
function guardarComunicado($post){
    $dirname = dirname(__DIR__);
    include  $dirname.'/common/config.php';

    $comunicadosObj = new comunicadosObj();
    $add = 0;
    $res = 0;
    $res1 = 0;
    $res2 = 0;
    $opc = "";
    $save_folder = '../upload/comunicados/';
    $imgComunicado = (isset($_FILES))?subirArchivo('imgComunicado', $save_folder):"";
    $contenido = base64_decode($post["contenidoHd"]);
    $contenido = convertirTextoEnriquecido($contenido,$siteURL, true );
    $descripcionCorta = convertirTextoEnriquecido($post["descripcionCorta"],$siteURL, true );

    $comunicadosObj->titulo = convertirTextoEnriquecido($post["titulo"], "", false);
    $comunicadosObj->descripcionCorta = $descripcionCorta;
    $comunicadosObj->contenido = $contenido;
    $comunicadosObj->opcTipo = $post["opcTipo"];
    $comunicadosObj->activo = $post["activo"];
    $comunicadosObj->urlComunicado = convertirTextoEnriquecido($post["urlComunicado"]);
    $comunicadosObj->urlVideo = convertirTextoEnriquecido($post["urlVideo"]);

    if($post["idComunicado"] == 0){
        $comunicadosObj->imgComunicado = $imgComunicado;
        $comunicadosObj->GuardarComunicado();
        $add = $comunicadosObj->idComunicado;
        $opc = "add";
    }else{
        $comunicadosObj->idComunicado = $post["idComunicado"];
        $comunicadosObj->idUsuarioCmb = $post["idUsuario"];
        $res1 = $comunicadosObj->ActualizarComunicado();
        if($imgComunicado != ""){
            $res2 = $comunicadosObj->ActualizarCampoComunicado("imgComunicado", $imgComunicado, $post["idComunicado"]);
        }
        if($res1 > 0 || $res2 > 0){
            $res = 1;
        }
        $opc = "upd";
    }

    $return_arr = array("success"=>true, "post"=>$post, "add"=>$add, "res"=>$res, "opc"=>$opc, "files"=>$_FILES, "imgComunicado"=>$imgComunicado);

    echo json_encode($return_arr);
}


  function muestraTablaContenido($callback){
    $id = (isset($_GET["id"]))?$_GET["id"]:0;
    $tabla = (isset($_GET["tabla"]))?$_GET["tabla"]:'';

    $html = '';
    $titulo = '';

    switch($tabla){
      case 'dispositivos':
        $regDispObj = new registroDispositivo();
        $usuariosObj = new usuariosObj();


        $regDispObj->usuarioId = $id;
        $dispositivos = $regDispObj->obtTodosRegDispositivoPorIdUsr2();
        $usuario = $usuariosObj->UserByID($id);

        $titulo = "Dispositivos del tutor ".$usuario->nombre;

        $html .= '<div class="table-responsive" id="tablaDetVentaRenov">';
        $html .= '<table class="table table-condensed table-hover ">';//table-striped: clase
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th class="text-center">#</th>';
        $html .= '<th class="text-center">Nombre</th>';
        $html .= '<th class="text-center">Fecha registro</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        $html .= '<tbody>';

        foreach ($dispositivos as $dispositivo) {

            $html .= '<tr>';
            $html .= '<td class="text-right">'.$dispositivo->navegadorCont.'</td>';
            $html .= '<td class="">'.$dispositivo->alias.'</td>';
            $html .= '<td>'.convertirFechaVista($dispositivo->fechaCreacion).'</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';

        $html .= '</table>';
        $html .= '</div>';
      break;

      case 'notificaciones':
        $historicosObj = new historicosObj();
        $alumnosObj = new alumnosObj();
        $usuariosObj = new usuariosObj();

        $historicos = $historicosObj->GetAllHistoricos($id);

        $usuario = $usuariosObj->UserByID($id);

        $titulo = "Notificaciones del tutor ".$usuario->nombre;

        $html .= '<div class="table-responsive" id="tablaDetVentaRenov">';
        $html .= '<table class="table table-condensed table-hover ">';//table-striped: clase
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th class="text-center">Alumno</th>';
        $html .= '<th class="text-center">Fecha</th>';
        $html .= '<th class="text-center">Hora</th>';
        $html .= '<th class="text-center">Tipo</th>';
        $html .= '<th class="text-center">Registrado</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        $html .= '<tbody>';

        foreach ($historicos as $historico) {
            $alumno = $alumnosObj->obtAlumnoPorId($historico->alumnoId);
            switch($historico->tipo){
              case 1: $tipo = "Entrada";break;
              case 2: $tipo = "Salida";break;

          }
          $arrFecha = explode(" ",$historico->fecha);
          $hora = $arrFecha[1];
            $html .= '<tr>';
            $html .= $alumno->nombreAlumno;
            $html .= convertirFechaVista($historico->fecha);
            $html .= $hora;
            $html .= $tipo;
            $html .= convertirFechaVistaConHora($historico->fechaCreacion);
            $html .= '</tr>';
        }

        $html .= '</tbody>';

        $html .= '</table>';
        $html .= '</div>';
      break;

      default:
      break;
    }



    $return_arr = array("success"=>true, "html"=>$html, "titulo"=>$titulo);

    echo $callback . '(' . json_encode($return_arr) . ');';
  }


  function cargaSelector($callback){
    $catProductosObj = new catProductosObj();

    $html = "";
    $arrConsulta = array();
    $opcTodos = (isset($_GET["opcTodos"]))?$_GET["opcTodos"]:false;
    $onchange = "";
    $tipochange = (isset($_GET["tipochange"]))?$_GET["tipochange"]:1;
    $dataText = "";
    $campoDT = "";
    $campoDT2 = "";

    switch ($_GET["tabla"]) {
        case 'productos':
            $arrConsulta = $catProductosObj->ObtTodasProductos($_GET["idOrigen"]);
            $idTabla = "idProducto";
            $campoDT = "uMedidaId";
        break;

        default:
            # code...
            break;
    }

    switch ($tipochange) {
      case '1':
        $onchange = 'onchange="guardaValorTextoDeSelect(this, \'uMedidaId\');"';
      break;

      case '2':
        $onchange = 'onchange="cargaSelector(\'$_GET["idInputOrigen"]\', \'$_GET["idInputDestino"]\', \'$_GET["tabla"]\')"';
      break;

      default:
        # code...
        break;
    }
    // if(count($arrConsulta) > 0){
    $html .= '<select name="'.$_GET["idInputDestino"].'" id="'.$_GET["idInputDestino"].'" class="required" '.$onchange.'>';
    $html .= '<option value="">Seleccione...</option>';

    if($opcTodos){
        $html .= '<option value="0">Todos</option>';
    }

    foreach ($arrConsulta as $item) {
      $dataText = ($campoDT != "")?' data-texto="'.$item->$campoDT.'" ':'';
      $dataText2 = ($campoDT2 != "")?' data-texto2="'.$item->$campoDT2.'" ':'';
      $html .= '<option value="'.$item->$idTabla.'" '.$dataText.' '.$dataText2.'>'.$item->nombre.'</option>';
    }
    $html .= '</select>';
    // }


    $arr = array("success" => true, "html" => $html);
    echo $callback . '(' . json_encode($arr) . ');';
}





function subirArchivo($name_input, $save_folder){
    $dateByZone = new DateTime("now", new DateTimeZone('America/Mexico_City') );
    $dateTime = $dateByZone->format('Y-m-d'); //fecha Actual
    $date=explode("-",$dateTime);

    //Obtener la extrension
    $extension = obtenerExtension($_FILES[$name_input]['name']);
    //Cambiar nombre a la imagen
    $nuevaImg = generarPassword(10, TRUE, TRUE, FALSE, FALSE).".".$extension;
    $destino = $save_folder.$date[0]."/".$date[1]."/".$nuevaImg;

    if(!file_exists($save_folder.$date[0]."/".$date[1])){
      mkdir($save_folder.$date[0]."/".$date[1], 0777, true);
    }

    if(move_uploaded_file($_FILES[$name_input]['tmp_name'], $destino)){
       return $date[0]."/".$date[1]."/".$nuevaImg;
    }
    else{
        return "";
    }
}

// >>>>>>
// >>>>>> Funciones especificas para el sistema
// >>>>>>

// Crear cliente
function crearCliente(){
  $tz = obtDateTimeZone();
  unset($_GET['funct']); //remover el nombre de la funcion para evitar errores
  base64DecodeSubmit(0, $_GET);
  // $motivosPropuestaObj = new motivosPropuestaObj();

  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $clientesObj = new clientesObj();


  // Setear datos
  $clientesObj->nombre = (isset($_GET['pc_cliente']) && $_GET['pc_cliente']!="")?$_GET['pc_cliente']:"";
  $clientesObj->telefono = (isset($_GET['pc_tel']) && $_GET['pc_tel']!="")?$_GET['pc_tel']:"";
  $clientesObj->email = (isset($_GET['pc_email']) && $_GET['pc_email']!="")?$_GET['pc_email']:"";
  $clientesObj->direccion = (isset($_GET['pc_dir']) && $_GET['pc_dir']!="")?$_GET['pc_dir']:"";
  $clientesObj->empresa = (isset($_GET['pc_empresa']) && $_GET['pc_empresa']!="")?$_GET['pc_empresa']:"";
  $clientesObj->fechaAct = $tz->fechaHora;
  $clientesObj->fechaCreacion = $tz->fechaHora;
  $clientesObj->CrearCliente();

  if($clientesObj->idCliente){
    $arr = array("success"=>true);
  }

  echo $callback . '(' . json_encode($arr) . ');';
  // echo "<pre>";
  // print_r($_GET);
  // echo "</pre>";
  // exit();
}

// Crear tipo
function crearTipo(){
  $tz = obtDateTimeZone();
  unset($_GET['funct']); //remover el nombre de la funcion para evitar errores
  base64DecodeSubmit(0, $_GET);

  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $catTipoCasosObj = new catTipoCasosObj();

  // Setear datos
  $catTipoCasosObj->nombre = (isset($_GET['pc_tipo']) && $_GET['pc_tipo']!="")?$_GET['pc_tipo']:"";
  $catTipoCasosObj->activo = 1;
  $catTipoCasosObj->CrearTipoCaso();

  if($catTipoCasosObj->idTipo){
    $opcion = array("id"=>$catTipoCasosObj->idTipo, "val"=>trim($catTipoCasosObj->nombre));
    $arr = array("success"=>true, "opcion"=>$opcion);
  }

  echo $callback . '(' . json_encode($arr) . ');';
  // echo "<pre>";
  // print_r($_GET);
  // echo "</pre>";
  // exit();
}

// Crear tipo
function crearCaso(){
  $tz = obtDateTimeZone();
  unset($_GET['funct']); //remover el nombre de la funcion para evitar errores
  base64DecodeSubmit(0, $_GET);

  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idCaso = (isset($_GET['c_id']) && $_GET['c_id']!="")?$_GET['c_id']:0;
  $casosObj = new casosObj();
  $clientesObj = new clientesObj();
  $usuariosObj = new usuariosObj();
  $emailObj = new EmailFunctionsObj();

  // Setear datos
  $casosObj->clienteId = (isset($_GET['c_idcliente']) && $_GET['c_idcliente']!="")?$_GET['c_idcliente']:"";
  $casosObj->tipoId = (isset($_GET['c_tipo']) && $_GET['c_tipo']!="")?$_GET['c_tipo']:"";
  $casosObj->titularId = (isset($_GET['c_idtitular']) && $_GET['c_idtitular']!="")?$_GET['c_idtitular']:"";
  $casosObj->autorizadosIds = (isset($_GET['c_idsautorizados']) && $_GET['c_idsautorizados']!="")?$_GET['c_idsautorizados'].",":""; //Se le agrega una "," para facilitar la busqueda en sql
  $casosObj->fechaAlta = (isset($_GET['c_falta']) && $_GET['c_falta']!="")?conversionFechas($_GET['c_falta']):"";

  if($idCaso>0){
    $casosObj->idCaso = $idCaso;
    $resp = $casosObj->EditarCaso();
  }else{
    $casosObj->CrearCaso();
    $resp = $casosObj->idCaso;
    // Obtener el nombre del cliente
    $datosCliente = $clientesObj->ClientePorId(trim($_GET['c_idcliente']));

    //verificar si ya existe para no duplicar usuarios y si existe solo mandar correo con datos de acceso
    $datosUsuario = $usuariosObj->UserByEmail($datosCliente->email);
    if($datosUsuario->idUsuario>0){
      //Solo mandar correo con datos de acceso
      // $emailObj->EnviarDatosDeAcceso("carlos.ramirez@framelova.com", $datosUsuario->nombre, $datosUsuario->password);
      $emailObj->EnviarDatosDeAcceso($datosUsuario->email, $datosUsuario->nombre, $datosUsuario->password);
    }else{
      $password = generarPassword(5, true, true, false, false);
      $usuariosObj->idRol = 3;
      $usuariosObj->nombre = $datosCliente->nombre;
      $usuariosObj->email = $datosCliente->email;
      $usuariosObj->password = $password;
      $usuariosObj->activo = 1;
      $usuariosObj->GuardarUsuario();

      if($usuariosObj->idUsuario>0){
        //Agregar id del cliente en la tabla de usuarios
        $usuariosObj->ActualizarUsuario("clienteId", trim($_GET['c_idcliente']), $usuariosObj->idUsuario);

        //Mandar correo
        // $emailObj->EnviarDatosDeAcceso("carlos.ramirez@framelova.com", $datosCliente->nombre, $password);
        $emailObj->EnviarDatosDeAcceso($datosCliente->email, $datosCliente->nombre, $password);
      }
    }
  }

  if($casosObj->idCaso){
    $arr = array("success"=>true, "id"=>$casosObj->idCaso);
  }

  echo $callback . '(' . json_encode($arr) . ');';
  // echo "<pre>";
  // print_r($_GET);
  // echo "</pre>";
  // exit();
}

// Crear y editar accion
function creaEditaAccion(){
  $tz = obtDateTimeZone();
  unset($_GET['funct']); //remover el nombre de la funcion para evitar errores
  base64DecodeSubmit(0, $_GET);

  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idaccion = (isset($_GET['pa_idaccion']) && $_GET['pa_idaccion']!="")?$_GET['pa_idaccion']:0;
  $casoAccionesObj = new casoAccionesObj();
  $casosObj = new casosObj();

  // Setear datos
  $casoAccionesObj->casoId = (isset($_GET['pa_casoid']) && $_GET['pa_casoid']!="")?$_GET['pa_casoid']:"";
  $casoAccionesObj->nombre = (isset($_GET['pa_accion']) && $_GET['pa_accion']!="")?$_GET['pa_accion']:"";
  $casoAccionesObj->comentarios = (isset($_GET['pa_comentario']) && $_GET['pa_comentario']!="")?$_GET['pa_comentario']:"";
  $casoAccionesObj->fechaAlta = (isset($_GET['pa_fechaaccion']) && $_GET['pa_fechaaccion']!="")?conversionFechas($_GET['pa_fechaaccion']):"";

  if($idaccion>0){
    $casoAccionesObj->idAccion = $idaccion;
    $resp = $casoAccionesObj->EditarCasoAccion();
  }else{
    $casoAccionesObj->CrearCasoAccion();
    $resp = $casoAccionesObj->idAccion;
  }

  if($resp){
    $arr = array("success"=>true);
    //Actualizar la fecha de ultima actualizacion
    $casosObj->ActCampoCaso("fechaAct", $tz->fechaHora, trim($_GET['pa_casoid']));
  }

  echo $callback . '(' . json_encode($arr) . ');';
  // echo "<pre>";
  // print_r($_GET);
  // echo "</pre>";
  // exit();
}

// Obtener datos de la accion
function obtDatosAccion(){
  $tz = obtDateTimeZone();
  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idAccion = (isset($_GET['idAccion']) && $_GET['idAccion']!="")?$_GET['idAccion']:0;
  $casoAccionesObj = new casoAccionesObj();

  $datosAccion = $casoAccionesObj->CasoAccionesPorId($idAccion);
  if($datosAccion->idAccion>0){
    $arr = array("success"=>true, "datos"=>$datosAccion);
  }

  echo $callback . '(' . json_encode($arr) . ');';
}

// Eliminar accion
function eliminarAccion(){
  $tz = obtDateTimeZone();
  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idAccion = (isset($_GET['idAccion']) && $_GET['idAccion']!="")?$_GET['idAccion']:0;
  $casoAccionesObj = new casoAccionesObj();
  $accionGastosObj = new accionGastosObj();

  // Eliminar la accion
  $resp = $casoAccionesObj->Eliminar($idAccion);
  if($resp){
    // Elimina todos los gastos asociados a la accion
    $resp2 = $accionGastosObj->Eliminar(0, $idAccion);
    $arr = array("success"=>true);
  }

  echo $callback . '(' . json_encode($arr) . ');';
}

// Obtener la lista de gastos
function tblListaGastos(){
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idTabla = (isset($_GET['idTabla']) && $_GET['idTabla']!="")?$_GET['idTabla']:"";
  $idAccion = (isset($_GET['idAccion']) && $_GET['idAccion']!="")?$_GET['idAccion']:"";
  $colAccion = (isset($_GET['colAccion']) && $_GET['colAccion']!="")?$_GET['colAccion']:0;
  // $idUsuario = (isset($_GET['idUsuario']) !="")?$_GET['idUsuario']:"";

  $accionGastosObj = new accionGastosObj();
  $colRes = $accionGastosObj->ObtAccionGastos($idAccion);
  $arr = array("success"=>false);

  // echo "<pre>";
  // print_r($colRes);
  // echo "</pre>";
  // exit();
  // if(count($colRes)>0){
    // table-striped
    $html = '
        <table id="'.$idTabla.'" class="table table-bordered table-condensed dataTable no-footer dt-responsive " role="grid" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <th>ID <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                    <th>Fecha <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                    <th>Concepto <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                    <th>Monto <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>
                    ';
                    if($colAccion>0){
                      $html .= '<th>Acciones <i class="fa fa-fw fa-sort " aria-hidden="true"></i></th>';
                    }
                  $html .= '
                </tr>
            </thead>
            <tbody>
            ';
              foreach($colRes as $item){
                // if($idUsuario!=$item->idUsuario && $item->idRol!=4){
                  $html .= '
                  <tr style="cursor:initial !important;">
                      <td>'.$item->idGasto.'</td>
                      <td>'.$item->fechaAlta2.'</td>
                      <td>'.$item->concepto.'</td>
                      <td>'.$item->monto2.'</td>
                      ';
                      if($colAccion>0){
                      $html .= '<td>
                        <a href="javascript:void(0);" onclick="popupCreaEditaGasto('.$item->idGasto.', '.$item->casoId.', '.$item->accionId.', \''.$item->concepto.'\')" title="Editar gasto"><img width="16px" src="../images/iconos/iconos_grid/editar.png"></a>
                        <!-- &nbsp;<a href="javascript:void(0);" onclick="editargasto('.$item->idGasto.')" title="Editar gasto"><img width="16px" src="../images/iconos/iconos_grid/editar.png"></a>-->
                        <a href="javascript:void(0);" onclick="eliminargasto('.$item->idGasto.')" title="Eliminar gasto"><img width="16px" src="../images/iconos/iconos_grid/eliminar.png"></a>
                      </td>';
                      }
                    $html .= '
                  </tr>
                  ';
                // }
              }
        $html .= '
            </tbody>
        </table>
    ';

    $arr = array("success"=>true, "tblListaGastos"=>$html);
  // }

  echo $callback . '(' . json_encode($arr) . ');';
}

// Crea y edita un gasto
function creaEditaGasto(){
  $tz = obtDateTimeZone();
  unset($_GET['funct']); //remover el nombre de la funcion para evitar errores
  base64DecodeSubmit(0, $_GET);

  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idGasto = (isset($_GET['pg_idgasto']) && $_GET['pg_idgasto']!="")?$_GET['pg_idgasto']:"";
  $accionGastosObj = new accionGastosObj();
  $casosObj = new casosObj();

  // Setear datos
  $accionGastosObj->casoId = (isset($_GET['pg_casoid']) && $_GET['pg_casoid']!="")?$_GET['pg_casoid']:"";;
  $accionGastosObj->accionId = (isset($_GET['pg_idaccion']) && $_GET['pg_idaccion']!="")?$_GET['pg_idaccion']:"";
  $accionGastosObj->conceptoId = (isset($_GET['pg_idconcepto']) && $_GET['pg_idconcepto']!="")?$_GET['pg_idconcepto']:"";
  $accionGastosObj->monto = (isset($_GET['pg_monto']) && $_GET['pg_monto']!="")?removerCaracteres($_GET['pg_monto']):0;
  $accionGastosObj->fechaAlta = (isset($_GET['pg_fechagasto']) && $_GET['pg_fechagasto']!="")?conversionFechas($_GET['pg_fechagasto']):"";

  if($idGasto>0){
    $accionGastosObj->idGasto = $idGasto;
    $resp = $accionGastosObj->EditarAccionGasto();
  }else{
    $accionGastosObj->CrearAccionGasto();
    $resp = $accionGastosObj->idGasto;
  }

  if($resp){
    $arr = array("success"=>true);
    //Actualizar la fecha de ultima actualizacion
    $casosObj->ActCampoCaso("fechaAct", $tz->fechaHora, trim($_GET['pg_casoid']));
  }

  echo $callback . '(' . json_encode($arr) . ');';
}

// Obtener datos del gasto
function obtDatosGasto(){
  $tz = obtDateTimeZone();
  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idGasto = (isset($_GET['idGasto']) && $_GET['idGasto']!="")?$_GET['idGasto']:0;
  $accionGastosObj = new accionGastosObj();

  $datosGasto = $accionGastosObj->AccionGastosPorId($idGasto);
  if($datosGasto->idGasto>0){
    $arr = array("success"=>true, "datos"=>$datosGasto);
  }

  echo $callback . '(' . json_encode($arr) . ');';
}

// Eliminar gasto
function eliminarGasto(){
  $tz = obtDateTimeZone();
  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idGasto = (isset($_GET['idGasto']) && $_GET['idGasto']!="")?$_GET['idGasto']:0;
  $accionGastosObj = new accionGastosObj();

  $resp = $accionGastosObj->Eliminar($idGasto);
  if($resp){
    $arr = array("success"=>true);
  }

  echo $callback . '(' . json_encode($arr) . ');';
}

// Obtener el total general de los gastos
function obtTotalGastos(){
  $tz = obtDateTimeZone();
  $arr = array("success"=>false);
  $callback = (isset($_GET['callback']) && $_GET['callback']!="")?$_GET['callback']:"";
  $idCaso = (isset($_GET['idCaso']) && $_GET['idCaso']!="")?$_GET['idCaso']:0;
  $accionGastosObj = new accionGastosObj();

  $colGastos = $accionGastosObj->ObtAccionGastos(0, $idCaso);
  $tGastos = 0;
  foreach($colGastos as $elem){
    $tGastos += $elem->monto;
  }

  if($tGastos>0){
    $tGastos = formatoMoneda($tGastos);
    $arr = array("success"=>true, "tGastos"=>$tGastos);
  }

  echo $callback . '(' . json_encode($arr) . ');';
}

?>