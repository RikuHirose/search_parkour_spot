$(function(){


     //（１）ページの概念・初期ページを設定
     var page=0;

     //（２）イメージの数を最後のページ数として変数化
     var lastPage =parseInt($("#slide img").length-1);

     //（３）最初に全部のイメージを一旦非表示にします
     $("#slide img").css("display","none");

     //（４）初期ページを表示
     $("#slide img").eq(page).css("display","block");

     //（５）ページ切換用、自作関数作成
     function changePage(){
          $("#slide img").fadeOut(1000);
          $("#slide img").eq(page).fadeIn(1000);
     };

     //（９）「次へ」をクリック
     $("#nav-r a").click(function() {
          if(page === lastPage){
               page = 0;
               changePage();
          }else{
               page ++;
               changePage();
          };
     });

     //「戻る」をクリック
     $("#nav-l a").click(function() {

          if(page === 0){
               page = lastPage;
               changePage();
          }else{
               page --;
               changePage();
          };
     });

});


