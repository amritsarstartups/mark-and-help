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
<body>
<div id="map"></div>
</body>
</html>
<script>
var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 31,
            lng: 74
        },
        zoom: 8
    });
}
function initMap(){
	var arr=<?php echo json_encode($array) ?>;
    document.write("hello");
var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: new google.maps.LatLng(32, 75),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow({});

    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

    </script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgeITuGMxOlYhEH1Z_bR_DQVIwtX8diBc&callback=initMap">
    </script>
