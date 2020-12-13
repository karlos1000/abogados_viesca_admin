<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/common/DataServices.php';

class accionGastosDB {

    //method declaration
    public function ObtAccionGastosDB($accionId, $casoId){
        $ds = new DataServices();
        $param[0] = "";
        $query = array();

        if($accionId > 0){
            $query[] = " accionId=$accionId ";
        }

        if($casoId > 0){
            $query[] = " casoId=$casoId ";
        }

        //En caso de llevar filtro
        if(count($query) > 0){
          $wordWhere = " WHERE ";
          $setWhere = implode(" AND ", $query);
          // echo $setWhere;
          $param[0] = $wordWhere.$setWhere;
        }

        $result = $ds->Execute("ObtAccionGastosDB", $param);
        $ds->CloseConnection();
        return $result;
    }

    public function AccionGastosPorIdDB($id){
        $ds = new DataServices();
        $param[0]= $id;
        $result = $ds->Execute("AccionGastosPorIdDB", $param);
        $ds->CloseConnection();

        return $result;
    }

    public function CrearAccionGastoDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("CrearAccionGastoDB", $param, true);
        return $result;
    }

    public function EditarAccionGastoDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("EditarAccionGastoDB", $param, false, true);
        $ds->CloseConnection();
        return $result;
    }

    /* public function ActCampoEnfermedadDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("ActCampoEnfermedadDB", $param, false, true);
        $ds->CloseConnection();
        return $result;
    }*/

    public function GastosDataSet($ds){
        $dsO = new DataServices();
        $param[0] = "";
        $ds->SelectCommand = $dsO->ExecuteDS("ObtAccionGastosDB", $param);
        $dsO->CloseConnection();

        return $ds;
    }

    public function EliminarGastoDB($idGasto, $idAccion){
        $ds = new DataServices();
        $param[0] = "";
        $query = array();

        if($idGasto > 0){
            $query[] = " idGasto=$idGasto ";
        }

        if($idAccion > 0){
            $query[] = " accionId=$idAccion ";
        }

        //En caso de llevar filtro
        if(count($query) > 0){
          $wordWhere = " WHERE ";
          $setWhere = implode(" AND ", $query);
          // echo $setWhere;
          $param[0] = $wordWhere.$setWhere;
        }

        $result = $ds->Execute("EliminarGastoDB", $param);
        $ds->CloseConnection();

        return $result;
    }
}