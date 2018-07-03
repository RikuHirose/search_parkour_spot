(function() {
  'use strict';

  $('#content-block').show();
  $('#result-index').addClass('switch-bottom');
  $('#map-block').hide();

  $('#result-map').on('click', function() {
    $('#result-index').removeClass('switch-bottom');
    $('#result-map').addClass('switch-bottom');

    $('#content-block').hide();
    $('#map-block').show();

  });

  $('#result-index').on('click', function() {
    $('#result-index').addClass('switch-bottom');
    $('#result-map').removeClass('switch-bottom');
    $('#content-block').show();
    $('#map-block').hide();

  })


})();