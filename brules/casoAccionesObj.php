<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/database/casoAccionesDB.php';
include_once  $dirname.'/database/datosBD.php';
include_once  $dirname.'/brules/configuracionesGridObj.php';

class casoAccionesObj extends configuracionesGridObj{
    private $_idAccion = 0;
    private $_casoId = 0;
    private $_nombre = '';
    private $_comentarios = '';
    private $_fechaAlta = '0000-00-00';
    private $_fechaAct = '0000-00-00 00:00:00';
    private $_fechaCreacion = '0000-00-00 00:00:00';


    //get y set
    public function __get($name) {
        return $this->{"_".$name};
    }
    public function __set($name, $value) {
        $this->{"_".$name} = $value;
    }

    //Obtener coleccion
    public function ObtCasoAcciones(){
        $array = array();
        $ds = new casoAccionesDB();
        $datosBD = new datosBD();
        $result = $ds->ObtCasoAccionesDB();
        $array =  $datosBD->arrDatosObj($result);

        return $array;
    }

    public function CasoAccionesPorId($id){
        $usrDS = new casoAccionesDB();
        $obj = new casoAccionesObj();
        $datosBD = new datosBD();
        $result = $usrDS->CasoAccionesPorIdDB($id);

        return $datosBD->setDatos($result, $obj);
    }

    public function CrearCasoAccion(){
        $objDB = new casoAccionesDB();
        $this->_idAccion = $objDB->CrearCasoAccionDB($this->getParams());
    }

    public function EditarCasoAccion(){
        $objDB = new casoAccionesDB();
        return $objDB->EditarCasoAccionDB($this->getParams(true));
    }

    private function getParams($update = false){
        $dateByZone = obtDateTimeZone();
        $this->_fechaCreacion = $dateByZone->fechaHora;
        $this->_fechaAct = $dateByZone->fechaHora;

        $param[0] = $this->_casoId;
        $param[1] = $this->_nombre;
        $param[2] = $this->_comentarios;
        $param[3] = $this->_fechaAlta;
        $param[4] = $this->_fechaAct;
        $param[5] = $this->_fechaCreacion;

        if($update){ //Para actualizar
            $param[5] = $this->_idAccion;
        }
        return $param;
    }

    /* public function ActCampoEnfermedad($campo, $valor, $id){
        $param[0] = $campo;
        $param[1] = $valor;
        $param[2] = $id;

        $objDB = new casoAccionesDB();
        $resAct = $objDB->ActCampoEnfermedadDB($param);
        return $resAct;
    }

    //Grid
    public function ObtEnfermedadesGrid(){
        $DataServices = new DataServices();
        $dbConn = $DataServices->getConnection();
        $ds = new MySQLiDataSource($dbConn);
        $uDB = new casoAccionesDB();
        $ds = $uDB->EnfermedadesDataSet($ds);
        $grid = new KoolGrid("cat_enfermedades");
        $configGrid = new configuracionesGridObj();

        $configGrid->defineGrid($grid, $ds);
        $configGrid->defineColumn($grid, "idEnfermedad", "ID", false, true);
        $configGrid->defineColumn($grid, "nombre", "Nombre", true, false, 1);
        $configGrid->defineColumn($grid, "tratamientoId", "Tratamiento", true, false, 1);
        $configGrid->defineColumn($grid, "opcionId", "Opcion", true, false, 1);
        $configGrid->defineColumn($grid, "opcionInfo", "Mensaje", false, false);
        $configGrid->defineColumn($grid, "activo", "Activo", true, false, 0);
        // if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){
            $configGrid->defineColumnEdit($grid);
        // }

        //pocess grid
        $grid->Process();

        return $grid;
    } */

    /* // Imp. obt nombre de Enfermedades por ids
    public function obtNombreEnfermedadesPorIds($id){
        $usrDS = new casoAccionesDB();
        $obj = new casoAccionesObj();
        $datosBD = new datosBD();
        $result = $usrDS->obtNombreEnfermedadesPorIdsDB($id);

        return $datosBD->setDatos($result, $obj);
    } */

}
