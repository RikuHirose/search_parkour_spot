(function() {
  'use strict';
  if($('#lat-input').val() == '' && $('#lat-input').val() == '') {
  	no_input()
  }

  // if($('#lat-input').val() != '' && $('#lat-input').val() != '') {
  // 	able_input()
  // }
  console.log($('#lat-input').find('input[name=lat]'))

  // $('#lat-input').find('input[name=lat]').change(function() {
  // 	console.log(11)
  // 	able_input()
  // })




  function no_input(){
  	$('#btn_id').prop('disabled', true)
  }

  function able_input(){
  	$('#btn_id').prop('disabled', false)
  }



})();