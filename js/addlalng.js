var map, infoWindow,geocoder,marker;
var lat,lng;
      function initMap() {
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            map = new google.maps.Map(document.getElementById('map'), {
                center: pos,
                zoom: 17
            });
           
             marker =new google.maps.Marker({
                position: pos,
                map:map
              });
              infowindow = new google.maps.InfoWindow({
                content: "<p>ตำแหน่งปัจจุบัน(lat,lng):" + marker.getPosition() + "</p>"
              });
              infowindow.open(map, marker);
            // infoWindow.setPosition(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
         geocoder = new google.maps.Geocoder();
      
         
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }

      
 function inputaddress() {
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
        // console.log("Lat"+results[0].geometry.location.lat());
        // console.log(results[0].address_components[0].short_name);
        infowindow = new google.maps.InfoWindow({
            content: "<p>Marker Location(lat,lng):" + marker.getPosition() + "</p>"
          });
          infowindow.open(map, marker); 
          // console.log("name"+results[0].geometry.name);
          document.getElementById('getname').value = results[0].address_components[0].short_name;
          document.getElementById('getlat').value = results[0].geometry.location.lat();
          document.getElementById('getlng').value = results[0].geometry.location.lng();
          // lng  = results[0].geometry.location.lng();
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }


  function searchposition(pid) {
    // console.log(pid);
    $('#exampleModal').modal('show'); //เผื่อ modal ไม่ขึ้นนะครับ
    setTimeout(function() {
      document.getElementById("poid").value = pid;
    }, 200); // setTimeout เพราะว่าเผื่อเวลาที่ใช้ในการเปิด modal ครับ
  }
function save(){

  let pid =  document.getElementById('poid').value
  let name =  document.getElementById('getname').value
  let lat = document.getElementById('getlat').value
  let lng = document.getElementById('getlng').value
  // document.getElementById('lon').innerHTML = lng
  let locationname = 'name'+pid;
  let locationlat = 'lat'+pid;
  let locationlng = 'lng'+pid;
  // console.log(locationname);
  document.getElementById(locationname).value = name
  document.getElementById(locationlat).value = lat
  document.getElementById(locationlng).value = lng
  $('#exampleModal').modal('hide');
  document.getElementById('address').value=""
}