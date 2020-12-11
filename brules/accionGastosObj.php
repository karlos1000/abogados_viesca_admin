<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/database/accionGastosDB.php';
include_once  $dirname.'/database/datosBD.php';
include_once  $dirname.'/brules/configuracionesGridObj.php';

class accionGastosObj extends configuracionesGridObj{
    private $_idGasto = 0;
    private $_casoId = 0;
    private $_accionId = 0;
    private $_conceptoId = 0;
    private $_monto = 0;
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
    public function ObtAccionGastos($accionId=0){
        $array = array();
        $ds = new accionGastosDB();
        $datosBD = new datosBD();
        $result = $ds->ObtAccionGastosDB($accionId);
        $array =  $datosBD->arrDatosObj($result);

        return $array;
    }

    public function AccionGastosPorId($id){
        $usrDS = new accionGastosDB();
        $obj = new accionGastosObj();
        $datosBD = new datosBD();
        $result = $usrDS->AccionGastosPorIdDB($id);

        return $datosBD->setDatos($result, $obj);
    }

    public function CrearAccionGasto(){
        $objDB = new accionGastosDB();
        $this->_idGasto = $objDB->CrearAccionGastoDB($this->getParams());
    }

    public function EditarAccionGasto(){
        $objDB = new accionGastosDB();
        return $objDB->EditarAccionGastoDB($this->getParams(true));
    }

    private function getParams($update = false){
        $dateByZone = obtDateTimeZone();
        $this->_fechaCreacion = $dateByZone->fechaHora;
        $this->_fechaAct = $dateByZone->fechaHora;

        $param[0] = $this->_casoId;
        $param[1] = $this->_accionId;
        $param[2] = $this->_conceptoId;
        $param[3] = $this->_monto;
        $param[4] = $this->_fechaAlta;
        $param[5] = $this->_fechaAct;
        $param[6] = $this->_fechaCreacion;

        if($update){ //Para actualizar
            $param[6] = $this->_idGasto;
        }
        return $param;
    }

    /* public function ActCampoEnfermedad($campo, $valor, $id){
        $param[0] = $campo;
        $param[1] = $valor;
        $param[2] = $id;

        $objDB = new accionGastosDB();
        $resAct = $objDB->ActCampoEnfermedadDB($param);
        return $resAct;
    }*/

    //Grid
    public function ObtGastoGrid($accionId=0){
        $DataServices = new DataServices();
        $dbConn = $DataServices->getConnection();
        $ds = new MySQLiDataSource($dbConn);
        $uDB = new accionGastosDB();
        $ds = $uDB->GastosDataSet($ds);
        $grid = new KoolGrid("accion_gastos");
        $configGrid = new configuracionesGridObj();

        $configGrid->defineGrid($grid, $ds);
        $configGrid->defineColumn($grid, "idGasto", "ID", false, true);
        $configGrid->defineColumn($grid, "fechaAlta2", "Fecha", true, false, 1);
        $configGrid->defineColumn($grid, "concepto", "Concepto", true, false, 1);
        $configGrid->defineColumn($grid, "monto2", "Monto", true, false, 1);
        // if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){
            $configGrid->defineColumnEdit($grid);
        // }

        //pocess grid
        $grid->Process();

        return $grid;
    }

    /* // Imp. obt nombre de Enfermedades por ids
    public function obtNombreEnfermedadesPorIds($id){
        $usrDS = new accionGastosDB();
        $obj = new accionGastosObj();
        $datosBD = new datosBD();
        $result = $usrDS->obtNombreEnfermedadesPorIdsDB($id);

        return $datosBD->setDatos($result, $obj);
    } */

}
