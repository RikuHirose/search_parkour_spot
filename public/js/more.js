(function() {
  'use strict';

  var listContents = $('.content_list #content_list').length
  console.log(listContents)

  $('.content_list').each(function(){
    var Num = 10,
      gtNum = Num-1;

    //最初はmoreボタン表示にし、
    $(this).find('#more_btn').show();
    $(this).find('#close_btn').hide();
    //10行目まで表示
    $(this).find("li:not(:lt("+Num+"))").hide();

    //moreボタンがクリックされた時
      $('#more_btn').click(function(){

         //Numに+10ずつしていく = 3行ずつ追加する
          Num +=10;
          $(this).parent().find("li:lt("+Num+")").slideDown();
          //liの個数よりNumが多い時、
          if(listContents <= Num){
              $('#more_btn').hide();
              $('#close_btn').show();

              //「閉じる」がクリックされたら、
              $('#close_btn').click(function(){
                $(this).parent().find("li:gt("+gtNum+")").slideUp();//11行目以降は非表示にし、
                $(this).hide();//閉じるボタンを非表示
                $('#more_btn').show();//moreボタン表示に
              });
          }
      });

  })

})();