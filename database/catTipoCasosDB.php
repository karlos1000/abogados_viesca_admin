<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/common/DataServices.php';

class catTipoCasosDB {

    //method declaration
    public function ObtCatTipoCasosDB($activo){
        $ds = new DataServices();
        $param[0] = "";
        $query = array();

        if($activo > 0){
            $query[] = " activo=$activo ";
        }

        //En caso de llevar filtro
        if(count($query) > 0){
          $wordWhere = " WHERE ";
          $setWhere = implode(" AND ", $query);
          // echo $setWhere;
          $param[0] = $wordWhere.$setWhere;
        }

        $result = $ds->Execute("ObtCatTipoCasosDB", $param);
        $ds->CloseConnection();
        return $result;
    }

    public function TipoCasoPorIdDB($idCanal){
        $ds = new DataServices();
        $param[0]= $idCanal;
        $result = $ds->Execute("TipoCasoPorIdDB", $param);
        $ds->CloseConnection();

        return $result;
    }

    public function crearTipoCasoDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("crearTipoCasoDB", $param, true);
        return $result;
    }

    /* public function ActCampoEnfermedadDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("ActCampoEnfermedadDB", $param, false, true);
        $ds->CloseConnection();
        return $result;
    }

    public function EnfermedadesDataSet($ds){
        $dsO = new DataServices();
        $param[0] = "";
        $ds->SelectCommand = $dsO->ExecuteDS("ObtCatEnfermedadesDB", $param);
        $param = null;
        $ds->InsertCommand = $dsO->ExecuteDS("insEnfermedadGrid", $param);
        $ds->UpdateCommand = $dsO->ExecuteDS("actEnfermedadGrid", $param);
        $ds->DeleteCommand = $dsO->ExecuteDS("delEnfermedadGrid", $param);
        $dsO->CloseConnection();

        return $ds;
    } */

}