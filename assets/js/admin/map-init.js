window.addEventListener('load', function () {
    function addDraggableMarker(map, behavior){

        var marker = new H.map.Marker({lat:wpVars.buildings.lat, lng:wpVars.buildings.lng}, {
            // mark the object as volatile for the smooth dragging
            volatility: true
        });
        // Ensure that the marker can receive drag events
        marker.draggable = true;
        map.addObject(marker);

        // disable the default draggability of the underlying map
        // and calculate the offset between mouse and target's position
        // when starting to drag a marker object:
        map.addEventListener('dragstart', function(ev) {
            var target = ev.target,
                pointer = ev.currentPointer;
            if (target instanceof H.map.Marker) {
                var targetPosition = map.geoToScreen(target.getGeometry());
                target['offset'] = new H.math.Point(pointer.viewportX - targetPosition.x, pointer.viewportY - targetPosition.y);
                behavior.disable();
            }
        }, false);


        // re-enable the default draggability of the underlying map
        // when dragging has completed
        map.addEventListener('dragend', function(ev) {
            var target = ev.target;
            if (target instanceof H.map.Marker) {
                behavior.enable();
                var coordinates = target.b;
                jQuery('#lc_trainee_building_lat').val(coordinates.lat);
                jQuery('#lc_trainee_building_long').val(coordinates.lng);
            }
        }, false);

        // Listen to the drag event and move the position of the marker
        // as necessary
        map.addEventListener('drag', function(ev) {
            var target = ev.target,
                pointer = ev.currentPointer;
            if (target instanceof H.map.Marker) {
                target.setGeometry(map.screenToGeo(pointer.viewportX - target['offset'].x, pointer.viewportY - target['offset'].y));
            }
        }, false);

        behavior.disable(H.mapevents.Behavior.WHEELZOOM);
    }

    /**
     * Calculates and displays the address details of 200 S Mathilda Ave, Sunnyvale, CA
     * based on a free-form text
     *
     *
     * A full list of available request parameters can be found in the Geocoder API documentation.
     * see: http://developer.here.com/rest-apis/documentation/geocoder/topics/resource-geocode.html
     *
     * @param   {H.service.Platform} platform    A stub class to access HERE services
     * @param  address Searchable address
     */
    function geocode(platform,address) {
        var geocoder = platform.getGeocodingService(),
            geocodingParameters = {
                searchText: address,
                jsonattributes : 1
            };

        geocoder.geocode(
            geocodingParameters,
            onSuccess,
            onError
        );

        behavior.disable(H.mapevents.Behavior.WHEELZOOM);
    }
    /**
     * This function will be called once the Geocoder REST API provides a response
     * @param  {Object} result          A JSONP object representing the  location(s) found.
     *
     * see: http://developer.here.com/rest-apis/documentation/geocoder/topics/resource-type-response-geocode.html
     */
    function onSuccess(result) {
        var locations = result.response.view[0].result;
        /*
         * The styling of the geocoding response on the map is entirely under the developer's control.
         * A representitive styling can be found the full JS + HTML code of this example
         * in the functions below:
         */
        addLocationsToMap(locations);
        // addLocationsToPanel(locations);
        // ... etc.
    }

    /**
     * This function will be called if a communication error occurs during the JSON-P request
     * @param  {Object} error  The error message received.
     */
    function onError(error) {
        return Swal.fire(wpVars.translations.errorTitle, wpVars.translations.mapsServerError, 'error');
    }

    /**
     * Boilerplate map initialization code starts below:
     */

//Step 1: initialize communication with the platform
// In your own code, replace variable window.apikey with your own apikey
    var platform = new H.service.Platform({
        'apikey': wpVars.hereMapsKey
    });
    var defaultLayers = platform.createDefaultLayers();

//Step 2: initialize a map - this map is centered over California
    var map = new H.Map(document.getElementById('mapContainer'),
        defaultLayers.vector.normal.map,{
            center: {lat:wpVars.buildings.lat, lng:wpVars.buildings.lng},
            zoom: 18,
            pixelRatio: window.devicePixelRatio || 1
        });
// add a resize listener to make sure that the map occupies the whole container
    window.addEventListener('resize', () => map.getViewPort().resize());

    var locationsContainer = document.getElementById('panel');

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
    var ui = H.ui.UI.createDefault(map, defaultLayers);

// Hold a reference to any infobubble opened
    var bubble;

    /**
     * Opens/Closes a infobubble
     * @param  {H.geo.Point} position     The location on the map.
     * @param  {String} text              The contents of the infobubble.
     */
    function openBubble(position, text){
        if(!bubble){
            bubble =  new H.ui.InfoBubble(
                position,
                {content: text});
            ui.addBubble(bubble);
        } else {
            bubble.setPosition(position);
            bubble.setContent(text);
            bubble.open();
        }
    }

    /**
     * Creates a series of H.map.Markers for each location found, and adds it to the map.
     * @param {Object[]} locations An array of locations as received from the
     *                             H.service.GeocodingService
     */
    function addLocationsToMap(locations){
        var group = new  H.map.Group(),
            position;

        // Add a marker for each location found
        position = {
            lat: locations[0].location.displayPosition.latitude,
            lng: locations[0].location.displayPosition.longitude
        };
        var marker = new H.map.Marker(position, {volatility: true});
        marker.label = locations[0].location.address.label;
        marker.draggable = true;
        group.addObject(marker);

        group.addEventListener('dragstart', function(ev) {
            var target = ev.target,
                pointer = ev.currentPointer;
            if (target instanceof H.map.Marker) {
                var targetPosition = map.geoToScreen(target.getGeometry());
                target['offset'] = new H.math.Point(pointer.viewportX - targetPosition.x, pointer.viewportY - targetPosition.y);
                behavior.disable();
            }
        }, false);


        // re-enable the default draggability of the underlying map
        // when dragging has completed
        group.addEventListener('dragend', function(ev) {
            var target = ev.target;
            if (target instanceof H.map.Marker) {
                behavior.enable();
                var coordinates = target.b;
                jQuery('#lc_trainee_building_lat').val(coordinates.lat);
                jQuery('#lc_trainee_building_long').val(coordinates.lng);
            }
        }, false);

        // Listen to the drag event and move the position of the marker
        // as necessary
        group.addEventListener('drag', function(ev) {
            var target = ev.target,
                pointer = ev.currentPointer;
            if (target instanceof H.map.Marker) {
               target.setGeometry(map.screenToGeo(pointer.viewportX - target['offset'].x, pointer.viewportY - target['offset'].y));
            }
        }, false);


        group.addEventListener('tap', function (evt) {
            if(window.innerWidth >= 601) {
                map.setCenter(evt.target.getGeometry());
                openBubble(
                    evt.target.getGeometry(), evt.target.label);
            }  else {
                jQuery('#mapMobilePopup').modal('show');
            }

        }, false);

        // Add the locations group to the map
        map.addObject(group);
        map.setCenter(group.getBoundingBox().getCenter());
    }

// Now use the map as required...
//     geocode(platform, 'Skopje');
    addDraggableMarker(map, behavior);

    jQuery('body').on('click', '#searchMap', function (e) {
        e.preventDefault();
        var street = jQuery('#address').val();
        var city = jQuery('#city').val();

        if(city === '' || street === '') {
            return Swal.fire(wpVars.translations.errorTitle, wpVars.translations.requiredFields, 'error');
        }

        var address = street + ' ' + city
        geocode(platform, address);
    });
});