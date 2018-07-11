(function() {
  'use strict';

  $('#markasread').on('click', function() {
  	var notificationCount = $('#badge').html()

    markNotificationAsRead(notificationCount)
  });

  function markNotificationAsRead(notificationCount){
    if(notificationCount !== '0') {
      $.get('/markAsRead')
    }

  }


})();