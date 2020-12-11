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

  // Popup accion
  $('.agregarAccion').click(function() {
    clearForm("formCrearAccion");
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
      alertify.error("No existe ning&uacute;n cliente para mostrar.");
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
      alertify.error("No existe ning&uacute;n cliente para mostrar.");
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

function crearCaso(){
  var validator = $("#formCaso").validate({ });
  //Validar formulario
  if($("#formCaso").valid()){
    // var htmlOriginal = showLoading('btnCrearCaso');

    var datosForm = $("#formCaso").serializeJSON();
    console.log(datosForm);
    params = paramsB64(datosForm);
    params['funct'] = 'crearCaso';
    console.log(params);
    // return false;
    ajaxData(params, function(data){
      console.log(data);

      if(data.success){
        alertify.success("Registro creado correctamente.");
        setTimeout(function(){
          location.href="frmCasoEdit.php?id="+data.id+"";
        }, 1000);
      }else{
        alertify.error("El registro no fue creado, intentar nuevamente.");
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

// Popup para crear accion
function btnCrearAccion() {
  var validator = $("#formCrearAccion").validate({ });
  //Validar formulario
  if($("#formCrearAccion").valid()){
    // var htmlOriginal = showLoading('btnCrearCliente');

    var datosForm = $("#formCrearAccion").serializeJSON();
    console.log(datosForm);
    params = paramsB64(datosForm);
    params['funct'] = 'crearAccion';
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
