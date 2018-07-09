(function() {
  'use strict';

  $('#like_store').on('click', function() {
    var contentid = $('#like_store').val();
    var userid = $('#user_info').val();

    storelike(contentid, userid);
  });

  $('#like_delete').on('click', function() {
    var contentid = $('#like_delete').val();
    var likeid = $('#like_info').val();
    var userid = $('#user_info').val();
    // $('#like_store').css('display','block');

    deletelike(contentid, likeid, userid);
  })

  function storelike(contentid,userid) {
      var _token = $('meta[name="csrf-token"]').attr('content');

      $.post('/api/content/{content}/likes', {contentid: contentid, userid: userid, _token: _token}, function (match) {
        document.getElementById('likes').innerHTML = match.likes_count;
        $('#like_info').val(match.likeid);
        $('#like_delete').show()
        $('#like_store').hide()
      });
  }

  function deletelike(contentid, likeid, userid) {
    var _token = $('meta[name="csrf-token"]').attr('content');

    $.post('/api/likes/delete', {contentid: contentid, likeid: likeid, userid: userid, _token: _token}, function (match) {
        $('#like_store').show()
        $('#like_delete').hide()
        match = match - 1;
        document.getElementById('likes0').innerHTML = match;
        // console.log(match);
    });
  }

})();