document.observe('dom:loaded', function () {
    if ($('type')) {
        Event.observe($('type'), "change", function () {
            checkTypes()
        });
        checkTypes();
    }
});

function checkTypes() {
    var chosenType = $('type').value;
    var supportedSettings = $('supported_settings_' + chosenType).value.split('');
    var allSettings = $('supported_settings_all').value.split('');
    for (i = 0; i < allSettings.length; i++) {
        if(supportedSettings.indexOf(allSettings[i]) == -1) {
            $('settings_' + allSettings[i]).checked = false;
            $('settings_' + allSettings[i]).parentNode.hide();
        } else {
            $('settings_' + allSettings[i]).parentNode.show();
        }
    }
}
