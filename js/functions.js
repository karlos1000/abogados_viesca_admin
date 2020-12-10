/*
 * Date: 5/05/2017
 * Actualizado: 07/12/2020
 * Funciones generales y especificas de javascript
 */

$(document).ready(function(){
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
    console.log(data);

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
    console.log(data);

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
function btnObtIdCliente(){
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