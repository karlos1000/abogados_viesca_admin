<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/database/usuariosBD.php';
include_once  $dirname.'/database/datosBD.php';
include_once  $dirname.'/brules/configuracionesGridObj.php';
include_once  $dirname.'/brules/rolesObj.php';
include_once  $dirname.'/brules/generalConsultObj.php';

class usuariosObj extends configuracionesGridObj{
    private $_idUsuario = 0;
    private $_idRol = 0;
    private $_nombre = '';
    private $_email = '';
    private $_password = '';
    private $_activo = 0;
    private $_fechaCreacion = '0000-00-00 00:00:00';
    private $_fechaAct = '';
    //extras
    private $_usuarioActivo = '';
    private $_nombreImg = '';
    // private $_editcol = '';


    //get y set
    public function __get($name) {
        return $this->{"_".$name};
    }
    public function __set($name, $value) {
        $this->{"_".$name} = $value;
    }

    public function GetAllData($activo){
      $generalConsultObj = new generalConsultObj();
      $data=$generalConsultObj->GetAllData("usuarios",$activo);
      return $data;
    }

    public function actualizar($campo,$valor,$id){
      $generalConsultObj = new generalConsultObj();
      $data=$generalConsultObj->Actualizar("usuarios",$campo,$valor,"idUsuario",$id);
      return $data;
    }

    public function Eliminar($id){
      $generalConsultObj = new generalConsultObj();
      $data=$generalConsultObj->Eliminar("usuarios","idUsuario",$id);
      return $data;
    }


    //logueo de usuario
    public function LoginUser($email, $password){
        $usrDS = new usuariosBD();
        $datosBD = new datosBD();
        $obj =  new usuariosObj();
        $result = $usrDS->LoginUser($email, $password);

        return $datosBD->setDatos($result, $obj);
    }
    //usuario por id
    public function UserByID($id){
        $usrDS = new usuariosBD();
        $obj = new usuariosObj();
        $datosBD = new datosBD();
        $result = $usrDS->UserByID($id);

        return $datosBD->setDatos($result, $obj);

    }

    //Usuario por email (para recupera la contrasenia)
    public function UserByEmail($email){
        $usrDS = new usuariosBD();
        $obj = new usuariosObj();
        $datosBD = new datosBD();
        $result = $usrDS->UserByEmailDB($email);
        return $datosBD->setDatos($result, $obj);
    }


    //region
    //Grid usuarios
     public function GetUsersGrid($rolIds = ""){
        $DataServices = new DataServices();
        $dbConn = $DataServices->getConnection();
        $ds = new MySQLiDataSource($dbConn);
        $uDB = new usuariosBD();
        $ds = $uDB->UsersDataSet($ds, $rolIds);
        $grid = new KoolGrid("usuariosGrid");
        $configGrid = new configuracionesGridObj();

        $configGrid->defineGrid($grid, $ds);
        $configGrid->defineColumn($grid, "idUsuario", "ID", false, true);
        $configGrid->defineColumn($grid, "idRol", "Rol", true, false, 1, "");
        $configGrid->defineColumn($grid, "nombre", "Nombre", true, false, 1, "");
        $configGrid->defineColumn($grid, "email", "Correo Electr&oacute;nico", true, false, 1, "EMAIL");
        $configGrid->defineColumn($grid, "password", "Contraseña", true, false, 1, "");
        //$configGrid->defineColumn($grid, "usuarioActivo", "Activo", true, true, 1, "", "60px");
        //$configGrid->defineColumn($grid, "editcol", "", true, true, 1, "", "40px");
        $configGrid->defineColumn($grid, "activo", "Activo", true, true, 1, "", "80px");

        // if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){
            $configGrid->defineColumnEdit($grid);
        // }

        //pocess grid
        $grid->Process();

        return $grid;
    }

    public function GuardarUsuario(){
        $objDB = new usuariosBD();
        $this->_idUsuario = $objDB->insertUsuarioDB($this->getParams());
    }

    public function EditarUsuario(){
        $objDB = new usuariosBD();
        return $objDB->actualizarUsuarioDB($this->getParams(true));
    }

    private function getParams($update = false){
        $dateByZone = obtDateTimeZone();
        $this->_fechaCreacion = $dateByZone->fechaHora;
        $this->_fechaAct = $dateByZone->fechaHora;

        $param[0] = $this->_idRol;
        $param[1] = $this->_nombre;
        $param[2] = $this->_email;
        $param[3] = $this->_password;
        $param[4] = $this->_activo;

        if(!$update){
            $param[5] = $this->_fechaCreacion;
        }
        else{
            $param[5] = $this->_fechaAct;
            $param[6] = $this->_idUsuario;
        }

        return $param;
    }
    public function ActualizarUsuario($campo, $valor, $id){
        $param[0] = $campo;
        $param[1] = $valor;
        $param[2] = $id;

        $objDB = new usuariosBD();
        $resAct = $objDB->updateUsuarioDB($param);
        return $resAct;
    }

    public function EliminarUsuario($idUsuario){
        $objDB = new usuariosBD();
        $param[0] = $idUsuario;
        return $objDB->deleteUsuarioDB($param);
    }


    //Obtener todos los usuarios
    public function obtTodosUsuarios($opcObj=true, $idRol = "", $esDirector = ""){
        $array = array();
        $ds = new usuariosBD();
        $datosBD = new datosBD();
        $result = $ds->obtTodosUsuariosDB($idRol, $esDirector);

        if($opcObj==true){
           $array = (array)$datosBD->arrDatosObj($result);
            // $array = (array)arrDatosObj($result);
        }else{
           $array = $datosBD->arrDatosObj($result);
           // $array = arrDatosObj($result);
        }
        return $array;
    }

    public function obtUsuariosByIdRol($idRol= "", $activo=1, $empresaId = "", $esDirector = ""){
        $array = array();
        $ds = new usuariosBD();
        $datosBD = new datosBD();

        $result = $ds->obtUsuariosByIdRolDB($idRol, $activo, $empresaId, $esDirector);
        $array = $datosBD->arrDatosObj($result);
        return $array;
    }

}
