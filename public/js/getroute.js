 $(document).ready(function(lat,lng){
    var lat = lat;
    var lng = lng;
    var currentLat = $('#currentLat').val();
    var currentLng = $('#currentLng').val();
    var agent = navigator.userAgent;

    if(agent.search(/iPhone/) != -1 || agent.search(/iPad/) != -1){
     //iOSは標準のマップアプリ
        $("#js-access-map a").attr("href", "http://maps.apple.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16");
    }else{
    //iOS以外はGoogleマップアプリ
        $("#js-access-map a").attr("href", "http://maps.google.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16");
    }
});