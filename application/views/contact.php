<section>
    <div style="height: 380px; margin-left: auto; margin-right: auto; width: 80%">
        <div style="width: 70%; height: 60%;"id="map-canvas"></div>
        <div>
        <h2>"Suwoda" Ayurvedic Medical Centre</h2>
        <h3>Gopallawa Road</h3>
        <h3>Gokarella</h3>
        <h3>Tel: +94372250563 / +94718439361</h3>
        <h3>email: info_suwodamedical@gmail.com</h3>
        </div>
      
     <script>
      function initialize() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          center: new google.maps.LatLng(7.593692, 80.481296),
          zoom: 10,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    </div>
</section>
