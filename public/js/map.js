// マップを表示させる関数を定義します
function initMap(){

    //マップを表示させる場所を指定(ここでは、id="map"のdivタグ)
    map = document.querySelector('#map');

    // let center_toyama = {lat: 36.868911, lng: 137.214856};
    opt = {
        zoom: 11,
        center: {lat: 36.868911, lng: 137.214856},
        mapId: "6c622d5c6190b365",
    };

    //マップのインスタンスを生成
    mapObj = new google.maps.Map(map, opt);




    //ピンを作成
    new google.maps.marker.AdvancedMarkerElement({
        position: {lat: 36.868911, lng: 137.214856},
        map: mapObj,
        title: "Hello",
    });
};

window.onload = initMap;
