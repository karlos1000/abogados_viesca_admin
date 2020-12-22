<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/common/DataServices.php';

class casosDB {

    //method declaration
    public function ObtCasosDB(){
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

        $result = $ds->Execute("ObtCasosDB", $param);
        $ds->CloseConnection();
        return $result;
    }

    public function CasoPorIdDB($id){
        $ds = new DataServices();
        $param[0]= $id;
        $result = $ds->Execute("CasoPorIdDB", $param);
        $ds->CloseConnection();

        return $result;
    }

    public function CrearCasoDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("CrearCasoDB", $param, true);
        return $result;
    }

    public function EditarCasoDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("EditarCasoDB", $param, false, true);
        $ds->CloseConnection();
        return $result;
    }

    public function ActCampoCasoDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("ActCampoCasoDB", $param, false, true);
        $ds->CloseConnection();
        return $result;
    }

    public function CasosDataSet($ds, $idCliente, $idAbogado){
        $dsO = new DataServices();
        $param[0] = "";
        $query = array();

        if($idCliente > 0){
            $query[] = " a.clienteId IN ($idCliente) ";
        }
        if($idAbogado > 0){
            $idAbogado = $idAbogado.",";
            $query[] =  " a.autorizadosIds LIKE '%".$idAbogado."%' ";
        }

        //En caso de llevar filtro
        if(count($query) > 0){
          $wordWhere = " WHERE ";
          $setWhere = implode(" AND ", $query);
          // echo $setWhere;
          $param[0] = $wordWhere.$setWhere;
        }
        // print_r($param);

        $ds->SelectCommand = $dsO->ExecuteDS("ObtCasosDB", $param);
        // $param = null;
        // $ds->InsertCommand = $dsO->ExecuteDS("insEnfermedadGrid", $param);
        // $ds->UpdateCommand = $dsO->ExecuteDS("actEnfermedadGrid", $param);
        // $ds->DeleteCommand = $dsO->ExecuteDS("delEnfermedadGrid", $param);
        $dsO->CloseConnection();

        return $ds;
    }

}