<?php
$dirname = dirname(__DIR__);

class configuracionesGridObj {

    //Define el grid
    protected function defineGrid($grid, $ds)
    {
        // $grid->id // Es el nombre del grid
        // echo "<pre>";
        // print_r($grid->id);
        // echo "</pre>";
        //create and define grid
        $grid->scriptFolder = "../brules/KoolControls/KoolGrid";
        $grid->styleFolder="office2010blue";
        $grid->Width = "760px";
        $grid->AllowScrolling = false;
        //$grid->MasterTable->Height = "540px";
        //$grid->MasterTable->ColumnWidth = "130px";
        $grid->RowAlternative = true;
        $grid->AjaxEnabled = true;
        $grid->AjaxLoadingImage =  "../brules/KoolControls/KoolAjax/loading/5.gif";
        $grid->Localization->Load("../brules/KoolControls/KoolGrid/localization/es.xml");
        $grid->AllowInserting = true;
        $grid->AllowEditing = true;
        $grid->AllowDeleting = true;
        $grid->AllowSorting = true;
        $grid->ColumnWrap = true;
        $grid->AllowResizing = true;
        $grid->MasterTable->DataSource = $ds;
        $grid->MasterTable->AutoGenerateColumns = false;
        $grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
        $grid->MasterTable->Pager->ShowPageSize = true;
        $grid->MasterTable->Pager->PageSizeOptions = "10,25,50,100,150";

        if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){
            //Show Function Panel
            if ($grid->id == "usuariosGrid") {
                $grid->MasterTable->ShowFunctionPanel = true;
                $grid->MasterTable->FunctionPanel->ShowInsertButton = false;
            }elseif ($grid->id == "rolGrid") {
                $grid->MasterTable->ShowFunctionPanel = true;
                $grid->MasterTable->FunctionPanel->ShowInsertButton = false;
            }elseif ($grid->id == "comunicados") {
                $grid->MasterTable->ShowFunctionPanel = true;
                $grid->MasterTable->FunctionPanel->ShowInsertButton = false;
            }elseif ($grid->id == "casos") {
                $grid->MasterTable->ShowFunctionPanel = false;
                // $grid->MasterTable->FunctionPanel->ShowInsertButton = false;
            }elseif ($grid->id == "caso_acciones") {
                $grid->MasterTable->ShowFunctionPanel = false;
            }elseif ($grid->id == "accion_gastos") {
                $grid->MasterTable->ShowFunctionPanel = false;
            }
            else {
                $grid->MasterTable->ShowFunctionPanel = true;
            }
        }
        //Insert Settings
        $grid->MasterTable->InsertSettings->Mode = "Form";
        $grid->MasterTable->EditSettings->Mode = "Form";
        $grid->MasterTable->InsertSettings->ColumnNumber = 1;
        $grid->ClientSettings->ClientEvents["OnRowConfirmEdit"] = "Handle_OnRowConfirmEdit";
        $grid->ClientSettings->ClientEvents["OnConfirmInsert"] = "Handle_OnConfirmInsert";
        $grid->ClientSettings->ClientEvents["OnRowDelete"] = "Handle_OnRowDelete";

        switch ($grid->id) {
            case 'casos':
            case 'caso_acciones':
                $grid->Width = "960px";
            break;
            case 'accion_gastos':
                $grid->Width = "490px";
            break;
            /*case 'uso_estadisticas':
                $grid->Width = "1000px";
                $grid->MasterTable->ShowFunctionPanel = false; //Show Function Panel
                // $grid->MasterTable->Pager->Position = "top";//Show both pager
                // $grid->MasterTable->FunctionPanel->ShowInsertButton = false;
                // $grid->MasterTable->FunctionPanel->ShowRefreshButton = true;
            break;
            // case 'cat_tasas':
            //     if($_SESSION['idRol']==1 || $_SESSION['idRol']==2){
            //         $grid->MasterTable->ShowFunctionPanel = true; //Show Function Panel
            //     }
            // break;*/
        }
    }

    //define la columna del grid
    protected function defineColumn($grid, $name_field, $name_header, $visible=true, $read_only=false, $validator=0, $field_type="", $width = "90px"){
        $column = new gridboundcolumn();

        if($grid->id=="usuariosGrid"){
            if($name_field == 'idRol') {
                $column = new GridDropDownColumn();
                $rolObj = new rolesObj();
                $rolArr = $rolObj->GetAllRoles();
                $column->AddItem('-- Seleccionar --',NULL);
                foreach($rolArr as $rolTmp){
                    $column->AddItem($rolTmp->rol,$rolTmp->idRol);
                }
                $column->AllowFiltering = true;
                $column->FilterOptions  = array("No_Filter","Equal");//Only show 3 chosen
            }
            elseif($name_field == 'activo') {
                $column = new GridBooleanColumn();
                $column->UseCheckBox = true;
                // $column->CheckBox = true;
            }elseif ($name_field == 'nombre' || $name_field == 'email') {
                $column->AllowFiltering = true;
                $column->FilterOptions  = array("No_Filter","Equal","Contain");//Only show 3 chosen
            }
            else{
                $column = new gridboundcolumn();
            }
        }
        elseif($grid->id=="comunicados"){
            if ($name_field == 'activo') {
                $column = new GridDropDownColumn();
                $column->AddItem('No',0);
                $column->AddItem('Si',1);
            }
            elseif ($name_field == 'descripcionCorta') {
                $column = new GridTextAreaColumn();
                $column->BoxHeight = "50px";
            }
        }
        elseif($grid->id=="cat_tipo_casos"){
            if ($name_field == 'activo') {
                $column = new GridDropDownColumn();
                $column->AddItem('No',0);
                $column->AddItem('Si',1);
            }
        }
        elseif($grid->id=="cat_conceptos"){
            if ($name_field == 'activo') {
                $column = new GridDropDownColumn();
                $column->AddItem('No',0);
                $column->AddItem('Si',1);
            }
        }


        /*if($grid->id=="patentes_competencia"){
            if($name_field == 'esPatente') {
                $column = new GridDropDownColumn();
                $column->AddItem('No',0);
                $column->AddItem('Si',1);
            }
            elseif ($name_field == 'presentacion') {
                $column = new GridTextAreaColumn();
                $column->AllowHtmlRender = false;
                $column->BoxHeight = "50px";
            }
            elseif ($name_field == 'cicloTratamiendo') {
                $column = new GridTextAreaColumn();
                $column->AllowHtmlRender = false;
                $column->BoxHeight = "50px";
            }
        }

        if($grid->id=="uso_estadisticas"){
            if($name_field == 'usuarioId') {
                $column = new GridDropDownColumn();
                $usuarioObj = new usuariosObj();
                $colUsuarios = $usuarioObj->obtTodosUsuarios();
                foreach($colUsuarios as $usuarioTmp)
                {
                    $column->AddItem($usuarioTmp->nombre, $usuarioTmp->idUsuario);
                }
            }
        }*/


        //Valida si es requerido
        if($validator > 0){
            $column->addvalidator($this->GetValidator ($validator));
        }

        //Tipo de validacion
        if($field_type != ""){
            $column->addvalidator($this->GetValidatorFieldType($field_type));
        }

        $column->Visible = $visible;
        $column->DataField = $name_field;
        $column->HeaderText = $name_header;
        $column->ReadOnly = $read_only;
        $column->Width = $width;
        $grid->MasterTable->AddColumn($column);
    }

    //validar campo
    private function GetValidator($type){
        switch ($type) {
            case 1: //required
                $validator = new RequiredFieldValidator();
                $validator->ErrorMessage = "Campo requerido";
                return $validator;
                break;
        }
    }

    //valido el tipo del campo
    private function GetValidatorFieldType($field_type){
        switch ($field_type) {
            case "INT":
                $validatorTmp = new RegularExpressionValidator();
                $validatorTmp->ValidationExpression = "/^([0-9])+$/";
                $validatorTmp->ErrorMessage = "Campo tipo entero";
                return $validatorTmp;
            break;
            case "FLOAT":
                $validatorTmp = new RegularExpressionValidator();
                $validatorTmp->ValidationExpression = "/^([.0-9])+$/";
                $validatorTmp->ErrorMessage = "Campo tipo flotante";
                return $validatorTmp;
            break;
            case "EMAIL":
                $validatorTmp = new RegularExpressionValidator();
                $validatorTmp->ValidationExpression = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
                $validatorTmp->ErrorMessage = "Campo tipo email";
                return $validatorTmp;
            break;
        }
    }

    //define la columna de acciones
    protected function defineColumnEdit($grid)
    {
        $column = new GridCustomColumn();
        if($_SESSION['idRol']==1 ){  //Rol super administradores
            if($grid->id == "rolGrid"){
                $column->ItemTemplate = '
                <a class="kgrLinkEdit" onclick="grid_edit(this)" href="javascript:void 0" title="Editar"></a>';
            }
            elseif ($grid->id == "usuariosGrid") {
                $column->ItemTemplate = '
                <a href="frmUsuario.php?id={idUsuario}" class="kgrLinkEdit"></a>'
                . '<a class="kgrLinkDelete btnFancy" onclick="verificaUsoTabla(\'usuarios\', {idUsuario})" href="#fancyElimCat" title="Eliminar"></a>';
            }
            elseif($grid->id == "comunicados"){
                $column->ItemTemplate = '
                <a class="kgrLinkEdit" onclick="edicionGrid(\'comunicados\', {idComunicado});" href="javascript:void 0" title="Editar"></a>'
                    .' <a class="kgrLinkDelete" onclick="grid_delete(this)" href="javascript:void 0" title="Eliminar"></a>'
                // . '<a class="btnDesactivarUsuario" onclick="muestraDesactivarUsuario({idUsuario},\'usuariosGrid\',\'usuarios\',{activo})"  href="#fancyDesactivarUsuario" title="Activar/Desactivar usuario"><img src="../images/{nombreImg}" class="iconoDesactivar" ></a>'
                ;
            }
            elseif($grid->id == "casos"){
                $link = '';
                $link .= '<a class="" onclick="edicionGrid(\'casos\', {idCaso});" href="javascript:void 0" title="Editar"><img src="../images/iconos/iconos_grid/editar.png" class="iconoDesactivar" ></a>';
                $column->ItemTemplate = $link;
            }
            elseif($grid->id == "caso_acciones"){
                $link = '';
                // $link .= '<a href="#" data-toggle="modal" data-target="#popup_modalCrearAccion" class="agregarAccion" title="Editar acci&oacute;n" idAccion="{idAccion}"><img width="16px" src="../images/iconos/iconos_grid/editar.png"></a>';
                $link .= '<a href="javascript:void(0);" onclick="popupCreaEditaAccion({casoId}, {idAccion})" title="Editar acci&oacute;n"><img width="16px" src="../images/iconos/iconos_grid/editar.png"></a>';
                $link .= '&nbsp; <a href="javascript:void(0);" onclick="popupCreaEditaGasto(0, {casoId}, {idAccion}, \'{nombre}\')" title="Agregar gasto"><img width="16px" src="../images/iconos/iconos_grid/agregar.png"></a>';
                $link .= '&nbsp; <a href="javascript:void(0);" onclick="eliminarAccion({idAccion})" title="Eliminar acci&oacute;n"><img width="16px" src="../images/iconos/iconos_grid/eliminar.png"></a>';
                $column->ItemTemplate = $link;
            }
            elseif($grid->id == "clientes"){
                $link = '';
                $link .= '<a class="kgrLinkEdit" onclick="grid_edit(this)" href="javascript:void 0" title="Editar"></a>';
                $column->ItemTemplate = $link;
            }
            elseif ($grid->id == "cat_tipo_casos") {
                $link = '';
                $link .= '<a class="kgrLinkEdit" onclick="grid_edit(this)" href="javascript:void 0" title="Editar"></a>';
                $link .= '<a class="kgrLinkDelete" onclick="grid_delete(this)" href="javascript:void 0" title="Eliminar"></a>';
                $column->ItemTemplate = $link;
            }
            elseif ($grid->id == "cat_conceptos") {
                $link = '';
                $link .= '<a class="kgrLinkEdit" onclick="grid_edit(this)" href="javascript:void 0" title="Editar"></a>';
                $link .= '<a class="kgrLinkDelete" onclick="grid_delete(this)" href="javascript:void 0" title="Eliminar"></a>';
                $column->ItemTemplate = $link;
            }
            else{
                $column->ItemTemplate = '
                <a class="kgrLinkEdit" onclick="grid_edit(this)" href="javascript:void 0" title="Editar"></a>'
                . '<a class="kgrLinkDelete" onclick="grid_delete(this)" href="javascript:void 0" title="Eliminar"></a>'
                // . '<a class="btnDesactivarUsuario" onclick="muestraDesactivarUsuario({idUsuario},\'usuariosGrid\',\'usuarios\',{activo})"  href="#fancyDesactivarUsuario" title="Activar/Desactivar usuario"><img src="../images/{nombreImg}" class="iconoDesactivar" ></a>'
                ;
            }
        }elseif($_SESSION['idRol']==2){ //Rol administradores
              if ($grid->id=="comunicados") {
                $column->ItemTemplate = '
                <a class="kgrLinkEdit" onclick="grid_edit(this)" href="javascript:void 0" title="Editar"></a>'
                . '<a class="kgrLinkDelete" onclick="grid_delete(this)" href="javascript:void 0" title="Eliminar"></a>'
                // . '<a class="btnDesactivarUsuario" onclick="muestraDesactivarUsuario({idUsuario},\'usuariosGrid\',\'usuarios\',{activo})"  href="#fancyDesactivarUsuario" title="Activar/Desactivar usuario"><img src="../images/{nombreImg}" class="iconoDesactivar" ></a>'
                ;
              }elseif($grid->id == "comunicados"){
                $column->ItemTemplate = '
                <a class="kgrLinkEdit" onclick="edicionGrid(\'comunicados\', {idComunicado});" href="javascript:void 0" title="Editar"></a>'
                    .' <a class="kgrLinkDelete" onclick="grid_delete(this)" href="javascript:void 0" title="Eliminar"></a>'
                // . '<a class="btnDesactivarUsuario" onclick="muestraDesactivarUsuario({idUsuario},\'usuariosGrid\',\'usuarios\',{activo})"  href="#fancyDesactivarUsuario" title="Activar/Desactivar usuario"><img src="../images/{nombreImg}" class="iconoDesactivar" ></a>'
                ;
            }
            else {
               $column->ItemTemplate = '
               <a class="kgrLinkEdit" onclick="grid_edit(this)" href="javascript:void 0" title="Editar"></a>'
               // . '<a class="btnDesactivarUsuario" onclick="muestraDesactivarUsuario({idUsuario},\'usuariosGrid\',\'usuarios\',{activo})"  href="#fancyDesactivarUsuario" title="Activar/Desactivar usuario"><img src="../images/{nombreImg}" class="iconoDesactivar" ></a>'
               ;
              }
        }elseif($_SESSION['idRol']==3){  //Rol clientes
            if($grid->id == "casos"){
                $link = '';
                $link .= '<a href="frmCasoSoloLectura.php?id={idCaso}" title="Ver"><img src="../images/iconos/iconos_grid/ver.png"></a>';
                $column->ItemTemplate = $link;
            }
            if($grid->id == "caso_acciones"){
                $link = '';
                $link .= '<a href="javascript:void(0);" onclick="popupCreaEditaAccion({casoId}, {idAccion})" title="Ver detalle acci&oacute;n"><img width="16px" src="../images/iconos/iconos_grid/ver.png"></a>';
                $column->ItemTemplate = $link;
            }
        }elseif($_SESSION['idRol']==4){  //Rol abogados
            if($grid->id == "casos"){
                $link = '';
                $link .= '<a class="" onclick="edicionGrid(\'casos\', {idCaso});" href="javascript:void 0" title="Editar"><img src="../images/iconos/iconos_grid/editar.png" class="iconoDesactivar" ></a>';
                $column->ItemTemplate = $link;
            }
            if($grid->id == "caso_acciones"){
                $link = '';
                $link .= '<a href="javascript:void(0);" onclick="popupCreaEditaAccion({casoId}, {idAccion})" title="Editar acci&oacute;n"><img width="16px" src="../images/iconos/iconos_grid/editar.png"></a>';
                $link .= '&nbsp; <a href="javascript:void(0);" onclick="popupCreaEditaGasto(0, {casoId}, {idAccion}, \'{nombre}\')" title="Agregar gasto"><img width="16px" src="../images/iconos/iconos_grid/agregar.png"></a>';
                $link .= '&nbsp; <a href="javascript:void(0);" onclick="eliminarAccion({idAccion})" title="Eliminar acci&oacute;n"><img width="16px" src="../images/iconos/iconos_grid/eliminar.png"></a>';
                $column->ItemTemplate = $link;
            }
        }


        $column->Align = "center";
        $column->HeaderText = "Acciones";
        $column->Width = "80px";
        $grid->MasterTable->AddColumn($column);
    }
}