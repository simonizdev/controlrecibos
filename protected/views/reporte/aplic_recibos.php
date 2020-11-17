<h3>Aplicación de recibos</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'reporte-form',
  // Please note: When you enable ajax validation, make sure the corresponding
  // controller action is handling ajax validation correctly.
  // There is a call to performAjaxValidation() commented in generated controller code.
  // See class documentation of CActiveForm for details on this.
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
));

?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i>Realizado</h4>
      <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<?php echo $form->hiddenField($model,'recibos', array('class' => 'form-control', 'autocomplete' => 'off')); ?>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label>Ruta / Recibo</label>
            <?php echo $form->textField($model,'ruta', array('class' => 'form-control', 'maxlength' => '60', 'autocomplete' => 'off')); ?>
        </div>
    </div>  
</div>
<div class="btn-group" style="padding-bottom: 2%">
  <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtro</button>
  <button type="button" class="btn btn-success" onclick="buscarrecibos();"><i class="fa fa-search"></i> Buscar</button>
</div>  

<?php

echo $form->error($model,'recibos', array('class' => 'pull-right badge bg-red'));
echo '<div id="contenido"></div>'; 

?>

<div class="btn-group" style="padding-bottom: 2%">
  <button type="button" class="btn btn-success" onclick="window.location.reload();"><i class="fa fa-refresh"></i> Actualizar vista</button>
  <button type="submit" class="btn btn-success" onclick="return valida_opciones(event);" id="btn_submit"><i class="fa fa-check"></i> Aplicar recibo(s) seleccionado(s)</button>
</div>


<?php $this->endWidget(); ?>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body text-center">

            </div>
        </div>
    </div>
</div>

<script>

$(function() {

  $(".form-control").keydown(function(event) {
    if (event.keyCode == 13) {
      event.preventDefault();
    }
  });

  $('#btn_submit').hide();
  cargarrecibosaplic(0); 

});

function rotateimage(id){
  $('.ajax-loader').fadeIn('fast');
  var data = {id: id}
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('controlrecibos/rotateimage'); ?>",
    data: data,
    dataType: 'json',
    success: function(id){
      var url = "<?php echo Yii::app()->createUrl('controlRecibos/ViewRecibo&id='); ?>";
      $('.modal-body').load(url+id,function(){
        $('#myModal').modal({show:true});
      }); 
      $('.ajax-loader').fadeOut('fast');
    }
  });
}

function check_uncheck_all(){

  $('input:checkbox.checks').each(function(){
    if (this.checked) {
      $(this).prop('checked', false);
    } else {
      $(this).prop('checked', true);
    }
  });
}

function buscarrecibos(){
  //se buscan los recibos por el filtro
  var filtro = $('#Reporte_ruta').val();

  if(filtro == ''){
    cargarrecibosaplic(0);  
  }else{
    cargarrecibosaplic(filtro);
  }

}

function cargarrecibosaplic(filt){
  //funcion para cargar los recibos por verificar
  $('#contenido').html('');
  $('#btn_submit').hide();
  $('.ajax-loader').fadeIn('fast');
  var data = {filtro: filt}
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('controlrecibos/CargarRecibosAplic'); ?>",
    data: data,
    dataType: 'json',
    success: function(data){

      $('#contenido').html(data.info);
      $('.ajax-loader').fadeOut('fast');

      if(data.opc == 1){
        //hay info
        $('#btn_submit').show();   
      }   
    }
  });
}

function resetfields(){
  $('#Reporte_ruta').val('');
  cargarrecibosaplic(0); 
}

function viewrecibo(id){
  var url = "<?php echo Yii::app()->createUrl('controlRecibos/ViewRecibo&id='); ?>";
  $('.modal-body').load(url+id,function(){
    $('#myModal').modal({show:true});
  });
}


function valida_opciones(){
  var ids_selected = '';    
    $('input:checkbox.checks').each(function(){
        if (this.checked) {
            ids_selected += $(this).val()+',';
        }
    });
    
    var cadena_ids = ids_selected.slice(0,-1);
    
    $('#Reporte_recibos').val(cadena_ids);
  
    return true;  
}

</script>



