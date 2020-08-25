window.traineeBubble = false;

// Get Query String parameter
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Set Custom JS Cookie
function traineeSetCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

// Custom JS get Cookie
function traineeGetCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie.replace(/\+/g, ' '));
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// Custom JS delete Cookie
function traineeDeleteCookie( name ) {
    if( traineeGetCookie( name ) ) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
    }
}

function openBubble(position, data, ui){
    if(!window.traineeBubble){
        window.traineeBubble =  new H.ui.InfoBubble(
            position,
            {content: getBubbleContent(data)});
        ui.addBubble(window.traineeBubble);
    } else {
        window.traineeBubble.setPosition(position);
        window.traineeBubble.setContent(getBubbleContent(data));
        window.traineeBubble.open();
    }
}


function addLocationsToMap(map, locations, ui){
    var group = new  H.map.Group(),
        position,
        i;

    // Add a marker for each location found
    for (i = 0;  i < locations.length; i += 1) {
        position = {
            lat: locations[i].meta.lc_trainee_building_lat[0],
            lng: locations[i].meta.lc_trainee_building_long[0]
        };
        marker = new H.map.Marker(position);
        marker.data = locations[i];
        group.addObject(marker);
    }

    group.addEventListener('tap', function (evt) {
        // if(window.innerWidth >= 601) {
        //     map.setCenter(evt.target.getGeometry());
        //     openBubble(
        //         evt.target.getGeometry(), evt.target.data, ui);
        // } else {
            jQuery('#mapMobilePopup .bubble_address span').html(evt.target.data.post_title);
            jQuery('#mapMobilePopup .bubble_investor span').html(evt.target.data.meta.lc_trainee_building_investor[0]);
            jQuery('#mapMobilePopup .bubble_mark span').html(mapMark(evt.target.data.meta.lc_trainee_building_energy_mark_certificate[0]));
            jQuery('#mapMobilePopup .trainee-select-address').attr({
                'data-title' : evt.target.data.post_title,
                'data-street' : evt.target.data.post_title,
                'data-lat' : evt.target.data.meta.lc_trainee_building_lat,
                'data-lng' : evt.target.data.meta.lc_trainee_building_long,
                'data-building-id' : evt.target.data.ID,
                'data-certificate' : mapMark(evt.target.data.meta.lc_trainee_building_energy_mark_certificate[0]),
                'data-certificate-raw' : evt.target.data.meta.lc_trainee_building_energy_mark_certificate[0]

            });
            jQuery('#certLink').attr('href', evt.target.data.meta.lc_trainee_building_certificate[0]);

            jQuery('#mapMobilePopup').modal('show');
        // }

    }, false);

    // Add the locations group to the map
    map.addObject(group);
    // map.setCenter(group.getBoundingBox().getCenter());
    map.setCenter({lat:41.99646, lng:21.43141});
    map.setZoom(11);
}

function getBubbleContent(data) {
    return [
        '<div class="bubble_content">',
        '<h3>'+ data.post_title +'</h3>',
        '<hr>',
        '<div class="bubble_mark">' + window.traineeTranslations.energyMark + ': ' + mapMark(data.meta.lc_trainee_building_energy_mark_certificate[0]) +'</div>',
        '<div class="bubble_investor">' + window.traineeTranslations.investor + ': ' +  data.meta.lc_trainee_building_investor[0] +'</div>',
        '<hr><button data-title="'+ data.post_title +'" data-street="'+ data.post_title +'" data-lat="' + data.meta.lc_trainee_building_lat + '" data-lng="' + data.meta.lc_trainee_building_long + '"  data-building-id="'+ data.ID +'" class="btn btn-primary trainee-select-address">',
        window.traineeTranslations.selectAddress + '</button>',
        '<a href="'+ data.meta.lc_trainee_building_certificate[0] +'" target="_blank" class="btn btn-primary">',
        window.traineeTranslations.viewCertificate + '</a>',
        '</div>'
    ].join('');
}

function mapMark(key) {
    var marks = {
        'a_plus': 'A+',
        'a': 'A',
        'b': 'B',
        'c': 'C',
        'd': 'D',
        'e': 'E',
        'f': 'F',
    }
    return marks[key];
}

// Fire account activation message
window.addEventListener('load', function () {
    var activateCooke = traineeGetCookie('account_activation');
    if(activateCooke) {
       var response = JSON.parse(activateCooke);

       if(response.status === 'failed'){
           Swal.fire(traineeRequest.error.title, response.message, 'error').then(function() {
               traineeDeleteCookie('account_activation');
           });

           return;
       }

        Swal.fire(traineeRequest.error.title, response.message, 'success').then(function() {
            traineeDeleteCookie('account_activation');
        });
    }
});

// Translate cyrilic
function trainee_transliterate(word){
    var a = { 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'ѓ': 'gj', 'е': 'e', 'ж': 'z', 'з': 'z', 'ѕ': 'z', 'и': 'i', 'ј': 'j', 'к': 'k', 'л': 'l', 'љ': 'lj', 'м': 'm', 'н': 'n', 'њ': 'nj', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'ќ': 'k', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'c', 'џ': 'dz', 'ш': 's' }
    var wordLower = word.toLowerCase();
    var translatedWord = wordLower.split('').map(function (char) {
        return a[char] || char;
    }).join("");

    return translatedWord.replace( ' ', '-');
}

//Select change address
function trainee_select_street(coordinates) {
    var lat = coordinates.lat;
    var lng = coordinates.long;

    var map = window.hereMap;

    map.setCenter({lat:lat, lng:lng});
    map.setZoom(18);

    jQuery('#changeStreet').parent().show();
}

//Between range function
function trainee_in_between(number, min, max){
    if(!Number.isInteger(parseInt(max))){
        return number >= min;
    }
    return number >= min && number <= max
}

//Return range points
function trainee_return_range_points(number, ranges) {
    var rangesArray = ranges.split(',');
    var returnPoints;
    rangesArray.some(function (range) {
        if(typeof range != 'undefined'){
            var tempArr = range.split('#');
            var rangeValues = tempArr[0].split(':');
            var points = tempArr[1]

            if(trainee_in_between(number, rangeValues[0], rangeValues[1])){
                returnPoints = points;
                return true;
            }
        }
    });

    return returnPoints;
}

// Generate PDF
function makePDF() {

    html2canvas(document.querySelector('.trainee_pdf_container'),
        { scale: 1, allowTaint:true, scrollY: -window.scrollY, scrollX: -window.scrollX}
    ).then(function(canvas) {
        var imgData = canvas.toDataURL('image/png');
        var imgWidth = 210;
        var pageHeight = 295;
        var imgHeight = canvas.height * imgWidth / canvas.width;
        var heightLeft = imgHeight;

        var doc = new jsPDF('p', 'mm', "a4");
        var position = 0;

        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight+10);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            doc.addPage();
            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight+10);
            heightLeft -= pageHeight;
        }
        doc.save("energy-profile.pdf");
        jQuery('.loadingScreen').css('display', 'none');
    });

    var imgData = canvas.toDataURL('image/png');
    var imgWidth = 210;
    var pageHeight = 295;
    var imgHeight = canvas.height * imgWidth / canvas.width;
    var heightLeft = imgHeight;

    var doc = new jsPDF('p', 'mm', "a4");
    var position = 0;

    doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight+10);
    heightLeft -= pageHeight;

    while (heightLeft >= 0) {
        position = heightLeft - imgHeight;
        doc.addPage();
        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight+10);
        heightLeft -= pageHeight;
    }
    doc.save("Dashboard.pdf");
    jQuery('.loadingScreen').css('display', 'none');
}