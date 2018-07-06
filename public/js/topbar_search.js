(function() {
  'use strict';

  $('#search-icon').on('click', function() {
    $('#search-content').css('display','block');
  });

  $('#close-icon').on('click', function() {
    $('#search-content').css('display','none');
  })

  $('#tab-right').on('click', function() {
    $('#form-content').hide();
    $('#form-content2').show();
    $('#tab').removeClass('tab -active').addClass('tab');
    $('#tab-right').removeClass('tab').addClass('tab -active');
  })

  $('#tab').on('click', function() {
    $('#form-content2').hide();
    $('#form-content').show();
    $('#tab-right').removeClass('tab -active').addClass('tab');
    $('#tab').removeClass('tab').addClass('tab -active');
  })


  initAutocomplete();

  function initAutocomplete() {
    var input = document.getElementById('pac-input');
    if (!input) { return }


    // Create the search box and link it to the UI element.
    var searchBox = new google.maps.places.SearchBox(input);

    $('#form_id').on('submit', function(e) {
      const form = this
      e.preventDefault()
      setTimeout(() => {
        form.submit()
      }, 300)
      return false
    });


    searchBox.addListener('places_changed', function() {
        // console.log('places_changed!!')
        var places = searchBox.getPlaces();
        if (places.length == 0) {
          return;
        }
        // console.log(places[0].geometry.location.lat(), places[0].geometry.location.lng())
        $('#lat-input').val(places[0].geometry.location.lat())
        $('#lng-input').val(places[0].geometry.location.lng())

    });
  }


})();