document.observe('dom:loaded', function () {
    Event.live('.locations-link', 'click', function (el, e) {
       showLocations('link', el.readAttribute('id'));
       e.stop();
    });

    Event.live('.locations-btn', 'click', function (el, e) {
        showLocations('btn', el.readAttribute('id'));
        e.stop();
    });
    
    Event.live('.locations-hide', 'click', function (el, e) {
        hideLocations('hide', el.readAttribute('id'));
        e.stop();
    });
});

function showLocations(type, id) {
    var productid = id.replace('locations_' + type + '_', '');

    if ($('locations_list_' + productid)) {
        $('locations_list_' + productid).show();
        $('locations_hide_' + productid).show();
        $('locations_link_' + productid).hide();
        if ($('locations_btn_' + productid) != undefined) {
           $('locations_btn_' + productid).hide();
        }
    }
}

function hideLocations(type, id) {
    var productid = id.replace('locations_' + type + '_', '');

    if ($('locations_list_' + productid)) {
        $('locations_list_' + productid).hide();
        $('locations_hide_' + productid).hide();
        $('locations_link_' + productid).show();
        if ($('locations_btn_' + productid) != undefined) {
            $('locations_btn_' + productid).show();
        }
    }
}

function toggleBlock(block) {
    if ($(block).previous().hasClassName('active')) {
        $(block).previous().removeClassName('active');
        $(block).previous().addClassName('accordin');
    } else {
        $(block).previous().removeClassName('accordin');
        $(block).previous().addClassName('active');
    }
    $(block).toggle("slow");
}