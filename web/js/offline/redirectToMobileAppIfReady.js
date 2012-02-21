if (window.location.href.indexOf("ignorelocalstorage=1") < 0) { // this if statement gives a chance to force the login to refresh the session
    if (jQuery.browser.mobile && PLANCAKE.isLocalDatastoreAvailable()) {
        PLANCAKE.redirectToMobileApp();
    };
}