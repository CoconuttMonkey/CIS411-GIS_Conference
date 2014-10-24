<?php
	require_once("../models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("../models/header.php");
?>
<body>
	<?php include("../models/main-nav.php"); ?>
	<section class="container">
		<h1>Contact Us</h1>
		<div class="row">
			<article class="col-lg-8 col-md-8 col-sm-8">
				<div id='googlemap'></div>
			</article>
			<article class="col-lg-4 col-md-4 col-sm-4">
				<form method="post" action="<? $_SERVER['PHP_SELF'] ?>" class="forms">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						  <input type="text" class="form-control" name="name" placeholder="Name" required>
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
						  <input type="text" class="form-control" name="email" placeholder="Email Address" required>
						</div>
						<br>
				    <div class="input-group">
				      <div class="input-group-btn">
				        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Subject <span class="caret"></span></button>
				        <ul class="dropdown-menu" role="menu">
				          <li><a href="#">General Questions</a></li>
				          <li><a href="#">Presentation</a></li>
				          <li><a href="#">Exhibit</a></li>
				          <li class="divider"></li>
				          <li><a href="#">Sponsorship</a></li>
				        </ul>
				      </div><!-- /btn-group -->
				      <input type="text" class="form-control">
				    </div><!-- /input-group -->
						<br>
				    <div class="form-group">
						  <textarea class="form-control" rows="8" id="comment" placeholder="Write you message here!"></textarea>
						</div>
				    <button type="submit" class="btn btn-success">Send</button>
				</form>
			</article>
		</div>
	</section>
	<?php include("../models/footer.php"); ?>
	<script src='https://maps.googleapis.com/maps/api/js?key=&sensor=false&extension=.js'></script> 
 
<script> 
		$('#navbar-contact').addClass("active");
    google.maps.event.addDomListener(window, 'load', init);
    var map;
    function init() {
        var mapOptions = {
            center: new google.maps.LatLng(41.207395,-79.380399),
            zoom: 14,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.DEFAULT,
            },
            disableDoubleClickZoom: true,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            },
            scaleControl: true,
            scrollwheel: true,
            panControl: true,
            streetViewControl: true,
            draggable : true,
            overviewMapControl: true,
            overviewMapControlOptions: {
                opened: false,
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [
    {
        "featureType": "water",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#b5cbe4"
            }
        ]
    },
    {
        "featureType": "landscape",
        "stylers": [
            {
                "color": "#efefef"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#83a5b0"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#bdcdd3"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#e3eed3"
            }
        ]
    },
    {
        "featureType": "administrative",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "lightness": 33
            }
        ]
    },
    {
        "featureType": "road"
    },
    {
        "featureType": "poi.park",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "lightness": 20
            }
        ]
    },
    {},
    {
        "featureType": "road",
        "stylers": [
            {
                "lightness": 20
            }
        ]
    }
],
        }
        var mapElement = document.getElementById('googlemap');
        var map = new google.maps.Map(mapElement, mapOptions);
        var locations = [
['gmarker', 'undefined', 'undefined', 'undefined', 'undefined', 41.208392, -79.3789371, 'https://mapbuildr.com/assets/img/markers/default.png']
        ];
        for (i = 0; i < locations.length; i++) {
			if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
			if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
			if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
           if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
           if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
            marker = new google.maps.Marker({
                icon: markericon,
                position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                map: map,
                title: locations[i][0],
                desc: description,
                tel: telephone,
                email: email,
                web: web
            });
     }

}
</script>
<style>
    #googlemap {
    	width: 100%;
    	float: left;
    	height: 400px;
    	display: block;
        border: 4px solid #fff;
        margin-bottom: 1em;
    }
    .gm-style-iw * {
        display: block;
        width: 100%;
    }
    .gm-style-iw h4, .gm-style-iw p {
        margin: 0;
        padding: 0;
    }
    .gm-style-iw a {
        color: #4272db;
    }
</style>
</body>
</html>
