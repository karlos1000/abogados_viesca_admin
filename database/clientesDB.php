<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/common/DataServices.php';

class clientesDB {

    //method declaration
    public function ObtClientesDB(){
        $ds = new DataServices();
        $param[0] = "";
        $query = array();

        // if($activo > 0){
        //     $query[] = " activo=$activo ";
        // }

        //En caso de llevar filtro
        if(count($query) > 0){
          $wordWhere = " WHERE ";
          $setWhere = implode(" AND ", $query);
          // echo $setWhere;
          $param[0] = $wordWhere.$setWhere;
        }

        $result = $ds->Execute("ObtClientesDB", $param);
        $ds->CloseConnection();
        return $result;
    }

    public function ClientePorIdDB($id){
        $ds = new DataServices();
        $param[0]= $id;
        $result = $ds->Execute("ClientePorIdDB", $param);
        $ds->CloseConnection();

        return $result;
    }

    public function CrearClienteDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("CrearClienteDB", $param, true);
        return $result;
    }

    public function EditarClienteDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("EditarClienteDB", $param, false, true);
        $ds->CloseConnection();
        return $result;
    }

    /* public function ActCampoEnfermedadDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("ActCampoEnfermedadDB", $param, false, true);
        $ds->CloseConnection();
        return $result;
    }*/

    public function ClientesDataSet($ds){
        $dsO = new DataServices();
        $param[0] = "";
        $ds->SelectCommand = $dsO->ExecuteDS("ObtClientesDB", $param);
        $param = null;
        $ds->InsertCommand = $dsO->ExecuteDS("insClienteGrid", $param);
        $ds->UpdateCommand = $dsO->ExecuteDS("actClienteGrid", $param);
        // $ds->DeleteCommand = $dsO->ExecuteDS("delClienteGrid", $param);
        $dsO->CloseConnection();

        return $ds;
    }

}