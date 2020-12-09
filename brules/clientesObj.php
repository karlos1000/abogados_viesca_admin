<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/database/clientesDB.php';
include_once  $dirname.'/database/datosBD.php';
include_once  $dirname.'/brules/configuracionesGridObj.php';

class clientesObj extends configuracionesGridObj{
    private $_idCliente = 0;
    private $_nombre = '';
    private $_telefono = '';
    private $_email = '';
    private $_direccion = '';
    private $_activo = 0;
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
    public function ObtClientes(){
        $array = array();
        $ds = new clientesDB();
        $datosBD = new datosBD();
        $result = $ds->ObtClientesDB();
        $array =  $datosBD->arrDatosObj($result);

        return $array;
    }

    public function ClientePorId($id){
        $usrDS = new clientesDB();
        $obj = new clientesObj();
        $datosBD = new datosBD();
        $result = $usrDS->ClientePorIdDB($id);

        return $datosBD->setDatos($result, $obj);
    }

    public function CrearCliente(){
        $objDB = new clientesDB();
        $this->_idCliente = $objDB->CrearClienteDB($this->getParams());
    }

    public function EditarCliente(){
        $objDB = new clientesDB();
        return $objDB->EditarClienteDB($this->getParams(true));
    }

    private function getParams($update = false){
        $dateByZone = obtDateTimeZone();
        $this->_fechaCreacion = $dateByZone->fechaHora;
        $this->_fechaAct = $dateByZone->fechaHora;

        $param[0] = $this->_nombre;
        $param[1] = $this->_telefono;
        $param[2] = $this->_email;
        $param[3] = $this->_direccion;
        $param[4] = $this->_fechaAct;
        $param[5] = $this->_fechaCreacion;

        if($update){ //Para actualizar
            $param[5] = $this->_idCliente;
        }
        return $param;
    }

    /* public function ActCampoEnfermedad($campo, $valor, $id){
        $param[0] = $campo;
        $param[1] = $valor;
        $param[2] = $id;

        $objDB = new clientesDB();
        $resAct = $objDB->ActCampoEnfermedadDB($param);
        return $resAct;
    }

    //Grid
    public function ObtEnfermedadesGrid(){
        $DataServices = new DataServices();
        $dbConn = $DataServices->getConnection();
        $ds = new MySQLiDataSource($dbConn);
        $uDB = new clientesDB();
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
        $usrDS = new clientesDB();
        $obj = new clientesObj();
        $datosBD = new datosBD();
        $result = $usrDS->obtNombreEnfermedadesPorIdsDB($id);

        return $datosBD->setDatos($result, $obj);
    } */

}
