/*
 * Date: 5/05/2017
 * Actualizado: 07/12/2020
 * Funciones generales y especificas de javascript
 */

$(document).ready(function(){

  // Evento cada vez que actualiza el listbox
  $('#c_autorizados').change(function() {
    if($(this).val()!=null){
        $("#c_idsautorizados").val($(this).val());
    }else{
        $("#c_idsautorizados").val("");
    }
  });

  // Popup tipo
  $('.agregarCliente').click(function() {
    clearForm("formCrearCliente");
  });

  // Popup tipo
  $('.agregarTipo').click(function() {
    clearForm("formCrearTipo");
  });

  $("#pg_monto").change(function (){
    $(this).val(accounting.formatMoney( accounting.unformat($(this).val()) ));
  });

});


// Inicio obtener clientes
var datosListaClientes;
function obtListaClientes(){
  showLoading("busca_clientes");
  var usuarioIdCreador = 0; //accounting.unformat($("#usuarioIdCreador").val());
  // console.log(usuarioIdCreador);

  $("#id_sel_cliente").val(0);
  var idTabla = "grid_listaclientes";

  var params = {funct: 'tblListaClientes', idTabla:idTabla, idUsuario:usuarioIdCreador};
  ajaxData(params, function(data){
    hideLoading2("busca_clientes");
    // console.log(data);

    if(data.success){
      $("#cont_listaclientes").html(data.tblListaClientes);
      $('#modalListaClientes').modal('show');
      //grid
      var datosLista = initGridBTListas(idTabla);

      //Accion para tomar el seleccionado
      $('#'+idTabla+' tbody').on('click', 'tr', function() {
        var data = datosLista.row(this).data();
        datosListaClientes = data;
        $("#id_sel_cliente").val(data[0]);

        $("table tr").removeClass('bg_tr_selected');
        $(this).addClass('bg_tr_selected');
      });
    }else{
      alertify.error("No existe ning&uacute;n registro para mostrar.");
    }
  });
}
function btnObtIdCliente(){
  var selRow = accounting.unformat($("#id_sel_cliente").val());

  if(selRow>0){
    $("#c_idcliente").val(selRow);
    $("#c_cliente").val(datosListaClientes[1]);
    $('.modal').modal('hide');
  }else{
    alertify.error("Debe seleccionar alg&uacute;n registro.");
  }
}
// Fin obtener clientes

// Inicio obtener titulares
var datosListaTitulares;
function obtListaTitulares(){
  showLoading("busca_titular");
  var usuarioIdCreador = 0; //accounting.unformat($("#usuarioIdCreador").val());
  // console.log(usuarioIdCreador);

  $("#id_sel_titular").val(0);
  var idTabla = "grid_listatitulares";

  var params = {funct: 'tblListaTitulares', idTabla:idTabla, idUsuario:usuarioIdCreador};
  ajaxData(params, function(data){
    hideLoading2("busca_titular");
    // console.log(data);

    if(data.success){
      $("#cont_listatitulares").html(data.tblListaTitulares);
      $('#modalListaTitulares').modal('show');
      //grid
      var datosLista = initGridBTListas(idTabla);

      //Accion para tomar el seleccionado
      $('#'+idTabla+' tbody').on('click', 'tr', function() {
        var data = datosLista.row(this).data();
        datosListaTitulares = data;
        $("#id_sel_titular").val(data[0]);

        $("table tr").removeClass('bg_tr_selected');
        $(this).addClass('bg_tr_selected');
      });
    }else{
      alertify.error("No existe ning&uacute;n registro para mostrar.");
    }
  });
}
function btnObtIdTitular(){
  var selRow = accounting.unformat($("#id_sel_titular").val());

  if(selRow>0){
    $("#c_idtitular").val(selRow);
    $("#c_titular").val(datosListaTitulares[1]);
    $('.modal').modal('hide');
  }else{
    alertify.error("Debe seleccionar alg&uacute;n registro.");
  }
}
// Fin obtener titulares

// Crear y editar caso
function crearCaso(){
  var validator = $("#formCaso").validate({ });
  //Validar formulario
  if($("#formCaso").valid()){
    var htmlOriginal = showLoading('btnCrearCaso');

    var datosForm = $("#formCaso").serializeJSON();
    console.log(datosForm);
    params = paramsB64(datosForm);
    params['funct'] = 'crearCaso';
    // console.log(params);
    // return false;
    ajaxData(params, function(data){
      console.log(data);

      if(data.success){
        let c_id = ( accounting.unformat($("#c_id").val()) > 0)?"editado":"creado";
        alertify.success("Registro "+c_id+" correctamente.");
        setTimeout(function(){
          location.href="frmCasoEdit.php?id="+data.id+"";
        }, 500);
      }else{
        alertify.error("El registro no fue "+c_id+", intentar nuevamente.");
      }
    });
  }else{
    validator.focusInvalid();
    return false;
  }
}

// Popup para crear el cliente
function btnCrearCliente() {
  var validator = $("#formCrearCliente").validate({ });
  //Validar formulario
  if($("#formCrearCliente").valid()){
    // var htmlOriginal = showLoading('btnCrearCliente');

    var datosForm = $("#formCrearCliente").serializeJSON();
    // console.log(datosForm);
    params = paramsB64(datosForm);
    params['funct'] = 'crearCliente';
    console.log(params);
    // return false;
    ajaxData(params, function(data){
      console.log(data);

      $('.modal').modal('hide');
      if(data.success){
        alertify.success("Registro creado correctamente.");
      }else{
        alertify.error("El registro no fue creado, intentar nuevamente.");
      }
    });
  }else{
    validator.focusInvalid();
    return false;
  }
}

// Popup para crear tipo
function btnCrearTipo() {
  var validator = $("#formCrearTipo").validate({ });
  //Validar formulario
  if($("#formCrearTipo").valid()){
    // var htmlOriginal = showLoading('btnCrearCliente');

    var datosForm = $("#formCrearTipo").serializeJSON();
    // console.log(datosForm);
    params = paramsB64(datosForm);
    params['funct'] = 'crearTipo';
    // console.log(params);
    // return false;
    ajaxData(params, function(data){
      console.log(data);

      $('.modal').modal('hide');
      if(data.success){
        let opcion = data.opcion;
        // Agregar opciones tipo
        $("#c_tipo").append('<option value="'+opcion.id+'">'+opcion.val+'</option>');
        alertify.success("Registro creado correctamente.");
      }else{
        alertify.error("El registro no fue creado, intentar nuevamente.");
      }
    });
  }else{
    validator.focusInvalid();
    return false;
  }
}


// Popup crear y editar accion
function popupCreaEditaAccion(casoId, idAccion){
  clearForm("formCrearAccion");
  // console.log(idAccion);
  $('#pa_idaccion').val( idAccion );
  $('#popup_modalCrearAccion').modal('show');

  if(idAccion>0){
    //Recuperar datos para la edicion
    let params = {funct: 'obtDatosAccion', idAccion:idAccion};
    ajaxData(params, function(data){
      // console.log(data);
      if(data.success){
        $("#pa_fechaaccion").val(data.datos.fechaAlta2);
        $("#pa_accion").val(convertHTMLEntity(data.datos.nombre));
        $("#pa_comentario").val(convertHTMLEntity(data.datos.comentarios));
      }
    });

    //Cargar lista de gastos
    showLoading("cont_listagastos");
    setTimeout(function(){
      obtListaGastos();
    }, 800);
  }else{
    $("#cont_gastos").hide();
  }
}

// Popup para crear accion
function btnCreaEditaAccion() {
  var validator = $("#formCrearAccion").validate({ });
  //Validar formulario
  if($("#formCrearAccion").valid()){
    // var htmlOriginal = showLoading('btnCrearCliente');

    var datosForm = $("#formCrearAccion").serializeJSON();
    console.log(datosForm);
    params = paramsB64(datosForm);
    params['funct'] = 'creaEditaAccion';
    // console.log(params);
    // return false;
    ajaxData(params, function(data){
      console.log(data);

      $('.modal').modal('hide');
      if(data.success){
        caso_acciones.refresh();
        caso_acciones.commit();
        alertify.success("Registro creado correctamente.");
      }else{
        alertify.error("El registro no fue creado, intentar nuevamente.");
      }
    });
  }else{
    validator.focusInvalid();
    return false;
  }
}

// Inicio obtener grid de gastos
var datosListaGastos;
function obtListaGastos(){
  // showLoading("cont_listagastos");
  let usuarioIdCreador = 0; //accounting.unformat($("#usuarioIdCreador").val());
  let idAccion = accounting.unformat($("#pa_idaccion").val());
  let colAccion = accounting.unformat($("#c_colaccion").val());
  // console.log(idAccion);
  // console.log(colAccion);

  var idTabla = "grid_listagastos";

  var params = {funct: 'tblListaGastos', idTabla:idTabla, idUsuario:usuarioIdCreador, idAccion:idAccion, colAccion:colAccion};
  ajaxData(params, function(data){
    hideLoading2("cont_listagastos");
    // console.log(data);

    if(data.success){
      $("#cont_listagastos").html(data.tblListaGastos);
      $("#cont_gastos").show();
      //grid
      var datosLista = initGridBTListas(idTabla);

      //Accion para tomar el seleccionado
      $('#'+idTabla+' tbody').on('click', 'tr', function() {
        var data = datosLista.row(this).data();
        datosListaGastos = data;
        $("table tr").removeClass('bg_tr_selected');
        // $(this).addClass('bg_tr_selected');
      });
    }else{
      alertify.error("No existe ning&uacute;n registro para mostrar.");
    }
  });
}
// Fin obtener grid de gastos


// Popup crear y editar gasto
function popupCreaEditaGasto(idGasto, casoId, idAccion, accion){
  clearForm("formCrearGasto");
  $("#pg_accion").val(accion);
  $("#pg_idaccion").val(idAccion);
  $("#pg_idgasto").val(idGasto);
  $('#popup_modalCrearGasto').modal('show');

  if(idGasto>0){
    //Recuperar datos para el gasto
    let params = {funct: 'obtDatosGasto', idGasto:idGasto};
    ajaxData(params, function(data){
      console.log(data);
      if(data.success){
        $("#pg_fechagasto").val(data.datos.fechaAlta2);
        $("#pg_idconcepto").val(data.datos.conceptoId);
        $("#pg_monto").val( accounting.formatMoney(accounting.unformat(data.datos.monto)) );
      }
    });
  }
}
// Crear y editar gasto
function btnCreaEditaGasto(){
  let idAccion = accounting.unformat($("#pg_idaccion").val());
  // console.log(idAccion);

  var validator = $("#formCrearGasto").validate({ });
  //Validar formulario
  if($("#formCrearGasto").valid()){
    // var htmlOriginal = showLoading('btnCrearGasto');
    // showLoading("btnCrearGasto");

    var datosForm = $("#formCrearGasto").serializeJSON();
    // console.log(datosForm);
    params = paramsB64(datosForm);
    params['funct'] = 'creaEditaGasto';
    // console.log(params);
    // return false;
    ajaxData(params, function(data){
      console.log(data);
      // hideLoading2("btnCrearGasto");

      // $('.modal').modal('hide');
      $('#popup_modalCrearGasto').modal('hide');
      if(data.success){
        caso_acciones.refresh();
        caso_acciones.commit();
        //Recargar gastos
        showLoading("cont_listagastos");
        obtListaGastos();
        obtTotalGastos(accounting.unformat($("#c_id").val()));
        alertify.success("Registro creado correctamente.");
      }else{
        alertify.error("El registro no fue creado, intentar nuevamente.");
      }
    });
  }else{
    validator.focusInvalid();
    return false;
  }
}

// Eliminar gasto
function eliminargasto(idGasto){
  alertify.confirm("<strong> Desea borrar este registro?</strong>", function(){
    let params = {funct: 'eliminarGasto', idGasto:idGasto};

    ajaxData(params, function(data){
      // console.log(data);
      if(data.success){
        caso_acciones.refresh();
        caso_acciones.commit();
        //Recargar gastos
        obtListaGastos();
        obtTotalGastos(accounting.unformat($("#c_id").val()));
        alertify.success("Registro eliminado correctamente.");
      }
    });
  },function(){
  }).set({labels:{ok:'Aceptar', cancel: 'Cancelar'}, padding: false});
}

// Eliminar accion
function eliminarAccion(idAccion){
  alertify.confirm("<strong> Desea borrar este registro, si confirma se eliminar&aacute;n sus gastos asociados?</strong>", function(){
    let params = {funct: 'eliminarAccion', idAccion:idAccion};

    ajaxData(params, function(data){
      // console.log(data);
      if(data.success){
        caso_acciones.refresh();
        caso_acciones.commit();
        obtTotalGastos(accounting.unformat($("#c_id").val()));
        alertify.success("Registro eliminado correctamente.");
      }
    });
  },function(){
  }).set({labels:{ok:'Aceptar', cancel: 'Cancelar'}, padding: false});
}

// Obtener el total general de los gastos
function obtTotalGastos(idCaso){
  let params = {funct: 'obtTotalGastos', idCaso:idCaso};
  ajaxData(params, function(data){
    // console.log(data);
    if(data.success){
      $("#c_tgastos").val(data.tGastos);
    }
  });
}