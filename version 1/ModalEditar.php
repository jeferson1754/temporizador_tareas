<div class="modal fade" id="edit<?php echo $ID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          Actualizar Información
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="recib_Update.php" id="mi-formulario">

        <input type="hidden" name="id" value="<?php echo $ID; ?>">
        <div class="modal-body" id="cont_modal">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $ID ?></label>

            <textarea name="nombre" class="form-control" rows="3" cols="50" required="true"><?php echo $ID; ?></textarea>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $ID ?></label>
            <input type="text" name="tiempo" class="form-control" value="<?php echo $ID; ?>">
          </div>
         

          <div class="modal-footer">
            <button type="button" id="boton-guardar" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="submit-button">Guardar Cambios</button>
          </div>
        </div>
      </form>


    </div>
  </div>
</div>

<!---fin ventana Update --->