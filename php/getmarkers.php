    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "markers";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT lat, lng FROM markers";
$array = array();
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $i=0;
    while($row = $result->fetch_assoc()) {
        $array = array($row);
        // echo $array[$i]['lat'].$array[$i]['lng']."<br>";
        // $i=$i+1;
        //echo "lat: " . $row["lat"]. " - lng: " . $row["lng"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
<html>
<style >
    /* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
#map {
  height: 100%;
}
/* Optional: Makes the sample page fill the window. */
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}
</style>
<body>
<div id='map'></div>


<script>

        function initMap() {
        
map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 74.8602},
          zoom: 10
        });

        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            lat1 = position.coords.latitude;
        long1 = position.coords.longitude;

            infoWindow.setPosition(pos);
            infoWindow.setContent('Ur Current Position');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

        var infoWindow = new google.maps.InfoWindow;
        var markers = <?php echo json_encode($array) ?>;
        for(var i=0;i < markers.length; i++){
            // Change this depending on the name of your PHP or XML file
              var point = new google.maps.LatLng(
                  parseFloat(markers[i].lat),
                  parseFloat(markers[i].lng));
              var marker = new google.maps.Marker({
                map: map,
                position: point,
              });
              marker.addListener('click', function() {
                infoWindow.setContent('');
                infoWindow.open(map, marker);
              });
            }
        }

        window.onload = initMap;

</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgeITuGMxOlYhEH1Z_bR_DQVIwtX8diBc&callback=initMap">
    </script>
    </body>
</html>
  
