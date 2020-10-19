<div id="confirmModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title text-center">Avboka</h3>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-muted">Är du säker på att du vill avboka detta pass?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancel_unbook" class="booking-btn confirm-btn" data-dismiss="modal">Nej, avboka inte</button>
        <button type="button" id="confirm_unbook" class="booking-btn confirm-btn">Ja, avboka</button>
        <div id="confirm-modal-error" class="text-danger">
          <?php
            global $error_handler;
            echo '<span id="confirm-modal-error-response" hidden>'.$error_handler->get_error('could_not_unbook_shift').'</span>';
            echo '<span id="confirm-modal-error-disabled" hidden>'.$error_handler->get_error('can_not_unbook_shift').'</span>';
          ?>
        </div>
      </div>
    </div>
  </div>
</div>