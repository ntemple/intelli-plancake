var PLANCAKE = PLANCAKE || {};

PLANCAKE.supportsHtml5Storage = function() {
  try {
    return 'localStorage' in window && window['localStorage'] !== null;
  } catch (e) {
    return false;
  }
};        

PLANCAKE.isLocalDatastoreAvailable  = function () {
    var isLocalDatastoreAvailable = false;
    if (PLANCAKE.supportsHtml5Storage() && 
            localStorage.getItem('tasks') && 
            localStorage.getItem('startupData')) {
        isLocalDatastoreAvailable = true;
    }
    
    return isLocalDatastoreAvailable;
};

PLANCAKE.redirectToMobileApp = function () {
    var url = document.URL;
    var accountRegExp = /account(_dev|_staging)?.php/gi;
    if (! url.match(accountRegExp)) { // we make sure not to generate an infinite loop
        window.location = 'https://www.plancake.com/account.php/mobile';
    }    
};
