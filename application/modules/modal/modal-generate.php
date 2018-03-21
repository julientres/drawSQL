<?php
    //require_once('forms/ExecutionQuery.php');
?>

<div class="modal fade generateCodeModal" id="generateCodeModal" tabindex="-1" role="dialog" aria-labelledby="generateCodeModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Transformation algébrique vers SQL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <code id="codeSelect"></code><br>
          <code id="codeFrom"></code><br>
          <code id="codeWhere"></code>
      </div>
      <div class="modal-footer">
        <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-primary" id="btdSql">Exécuter la requête</button>
        </div>
      </div>
    </div>
  </div>
</div>