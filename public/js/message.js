(function() {
  'use strict';

  $('.alert').fadeIn(500).delay(1500).fadeOut(1000);
  $('.alert .close').on('click', function() {
      $(this).parents('.alert').hide();
  });

})();