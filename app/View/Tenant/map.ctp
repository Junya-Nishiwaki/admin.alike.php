<?php
$this->Html->script(array('jquery-1.8.3.min', 
                        // TODO 共通化
                        'https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ7gwODnP65tpL5OALXnZRilx-SArBrY4&sensor=false&libraries=geometry'
        ),
        array('inline' => false));
?>
<html>
    <head>
        <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ7gwODnP65tpL5OALXnZRilx-SArBrY4&sensor=false&libraries=geometry"></script>
    </head>
    <body>
        <div id="map" style="width: 100%; height: 100%;"></div>
        <input id="lat" name="lat" value="<?php echo $lat; ?>" style="display: none;"> 
        <input id="lng" name="lng" value="<?php echo $lng; ?>" style="display: none;"> 
    </body>
</html>

<script>
    var map = null;
    var marker = null;
    $(function() {
        var latlng = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>);
        
        map = new google.maps.Map(document.getElementById('map'), {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: latlng,
            zoom: 16,
            panControl: true,
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: true,
            streetViewControl: true,
            overviewMapControl: false
        });

         marker = new google.maps.Marker({
            map: map,
            position: latlng
        });

        google.maps.event.addListener(map, 'drag', function() {
            $('#lat').val(map.getCenter().lat()).change();
            $('#lng').val(map.getCenter().lng()).change();
        });
        
        $('#lat,#lng').change(function() {
            marker.setPosition(new google.maps.LatLng($('#lat').val(), $('#lng').val()));
        })
    });
</script>