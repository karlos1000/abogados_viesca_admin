<?php
$dirname = dirname(__DIR__);
include_once  $dirname.'/common/DataServices.php';

class casoAccionesDB {

    //method declaration
    public function ObtCasoAccionesDB(){
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

        $result = $ds->Execute("ObtCasoAccionesDB", $param);
        $ds->CloseConnection();
        return $result;
    }

    public function CasoAccionesPorIdDB($id){
        $ds = new DataServices();
        $param[0]= $id;
        $result = $ds->Execute("CasoAccionesPorIdDB", $param);
        $ds->CloseConnection();

        return $result;
    }

    public function CrearCasoAccionDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("CrearCasoAccionDB", $param, true);
        return $result;
    }

    public function EditarCasoAccionDB($param){
        $ds = new DataServices();
        $result = $ds->Execute("EditarCasoAccionDB", $param, false, true);
        $ds->CloseConnection();
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