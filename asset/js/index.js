$(document).ready(function() {
    // Effet de parrallaxe sur les images en haut et en bas
    $('.parallax').parallax();

    // Initialize collapse button
    $(".button-collapse").sideNav({
        edge: 'left'
    });

    // Initialize collapsible
    $('.collapsible').collapsible();
    $(document).ready(function() {
        $('.scrollspy').scrollSpy();
    });

    // gestion du suivi de la table des matieres
    $('.table-of-contents').pushpin({
        top: 500
    });

    // Gestion des dropdowns
    $(document).ready(function(){
        $('.dropdown-button').dropdown();
    });

    // Initialisation des tooltips
    $(document).ready(function(){
        $('.tooltipped').tooltip({delay: 50});
    });

    
  $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
  });
      
    // Gestion du gmap
    if ($('#gmap-section').length != 0) {
        gmap();
    }

    // Gestion du changement de locale
    $('.locale').each(function () {
        $(this).click(function() {
            var locale = $(this).attr('id');

            $.ajax({
                url: "locale/" + locale
            }).done(function() {
                location.reload();
            });
        });
    });
});
$(window).scroll(function() {
    // The total height of the jumbotron
    var scrollTop = $('.parallax-container').outerHeight(true);
    // If the user scrolls down
    if ($(window).scrollTop() > scrollTop) {
        // Fix to top
        $("#navbar").addClass("navbar-fixed-top");
        // And padding-top to the body so the content does not jump up (50px is the height of the now fixed to top navbar)
        $("body").css("padding-top", "50px");
    }
    // If the user scrolls back up
    if ($(window).scrollTop() < scrollTop) {
        // Undo
        $("#navbar").removeClass("navbar-fixed-top");
        $("body").css("padding-top", "0px");
    }
})

function gmap() {
    // Initialize objects
    var geocoder;
    var map;
    var infowindow;

    function initialize() {
        var mapOptions = {
            center: {
                lat: 37.905653,
                lng: -18.327142
            },
            zoom: 2,
            panControl: false,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            },
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false,
            rotateControle: false
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        geocoder = new google.maps.Geocoder();
        infowindow = new google.maps.InfoWindow({
            content: ''
        })
        google.maps.event.addListener(map, 'zoom_changed', function() {
            if (map.getZoom() < 2) {
                map.setZoom(2);
            } else if (map.getZoom() > 5) {
                map.setZoom(5);
            }
        });
        // Set all the markers
        codeAddress("Scotland", "Scotland");
        codeAddress("Spain", "Scotland");
        codeAddress("Portugal", "Scotland");
        codeAddress("Italy", "Scotland");
        codeAddress("Tunisia", "Scotland");
        codeAddress("Australia", "Scotland");
        codeAddress("New Zealand", "Scotland");
        codeAddress("Bali", "Scotland");
        codeAddress("New Caledonia", "Scotland");
        codeAddress("Thailand", "Scotland");
    }

    function codeAddress(address, content) {
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    icon: 'asset/images/marker.png'
                }); // get icon on http://flaticons.net/customize.php?dir=Mobile%20Application&icon=Location-Marker.png
               /* var contentString = '<div id="content"><div id="siteNotice"></div><h5 id="firstHeading" class="firstHeading">' + address + '</h5><div id="bodyContent"><p>' + content + '</p></div></div>';
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent(contentString);
                    infowindow.open(map, marker);
                });*/
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
}