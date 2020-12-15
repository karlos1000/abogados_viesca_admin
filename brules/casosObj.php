<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/database/casosDB.php';
include_once  $dirname.'/database/datosBD.php';
include_once  $dirname.'/brules/configuracionesGridObj.php';

class casosObj extends configuracionesGridObj{
    private $_idCaso = 0;
    private $_clienteId = 0;
    private $_tipoId = 0;
    private $_titularId = 0;
    private $_autorizadosIds = "";
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
    public function ObtCasos(){
        $array = array();
        $ds = new casosDB();
        $datosBD = new datosBD();
        $result = $ds->ObtCasosDB();
        $array =  $datosBD->arrDatosObj($result);

        return $array;
    }

    public function CasoPorId($id){
        $usrDS = new casosDB();
        $obj = new casosObj();
        $datosBD = new datosBD();
        $result = $usrDS->CasoPorIdDB($id);

        return $datosBD->setDatos($result, $obj);
    }

    public function CrearCaso(){
        $objDB = new casosDB();
        $this->_idCaso = $objDB->CrearCasoDB($this->getParams());
    }

    public function EditarCaso(){
        $objDB = new casosDB();
        return $objDB->EditarCasoDB($this->getParams(true));
    }

    private function getParams($update = false){
        $dateByZone = obtDateTimeZone();
        $this->_fechaCreacion = $dateByZone->fechaHora;
        $this->_fechaAct = $dateByZone->fechaHora;

        $param[0] = $this->_clienteId;
        $param[1] = $this->_tipoId;
        $param[2] = $this->_titularId;
        $param[3] = $this->_autorizadosIds;
        $param[4] = $this->_fechaAlta;
        $param[5] = $this->_fechaAct;
        $param[6] = $this->_fechaCreacion;

        if($update){ //Para actualizar
            $param[6] = $this->_idCaso;
        }
        return $param;
    }

    public function ActCampoCaso($campo, $valor, $id){
        $param[0] = $campo;
        $param[1] = $valor;
        $param[2] = $id;

        $objDB = new casosDB();
        $resAct = $objDB->ActCampoCasoDB($param);
        return $resAct;
    }


    //Grid
    public function ObtListadoCasosGrid($filSel="", $filTexto="", $filEstatus=""){
        $DataServices = new DataServices();
        $dbConn = $DataServices->getConnection();
        $ds = new MySQLiDataSource($dbConn);
        $uDB = new casosDB();
        $ds = $uDB->CasosDataSet($ds);
        $grid = new KoolGrid("casos");
        $configGrid = new configuracionesGridObj();

        $configGrid->defineGrid($grid, $ds);
        $configGrid->defineColumn($grid, "idCaso", "ID", true, true);
        if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){
            $configGrid->defineColumn($grid, "titular", "Responsable", true, false, 1);
        }
        $configGrid->defineColumn($grid, "cliente", "Cliente", true, false, 1);
        $configGrid->defineColumn($grid, "tipocaso", "Tipo", true, false, 1);
        $configGrid->defineColumn($grid, "fechaAlta2", "F. Alta", true, false, 1);
        $configGrid->defineColumn($grid, "fechaAct2", "Ult. Act.", true, false);
        // $configGrid->defineColumn($grid, "opcionInfo", "T. Gastos", false, false);
        // if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){
            $configGrid->defineColumnEdit($grid);
        // }

        //pocess grid
        $grid->Process();

        return $grid;
    }

    /* // Imp. obt nombre de Enfermedades por ids
    public function obtNombreEnfermedadesPorIds($id){
        $usrDS = new casosDB();
        $obj = new casosObj();
        $datosBD = new datosBD();
        $result = $usrDS->obtNombreEnfermedadesPorIdsDB($id);

        return $datosBD->setDatos($result, $obj);
    } */

}
