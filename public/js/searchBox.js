(function() {
  'use strict';
  var updateDiableStatus = function(value) {
    $('#btn_id').prop('disabled', value.trim() === '')
  }

  $('#pac-input').on('keyup', function() {
    updateDiableStatus($(this).val())
  });
  updateDiableStatus($('#pac-input').val())

})();