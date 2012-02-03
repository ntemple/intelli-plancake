<?php 
    header("Cache-Control: max-age=0, no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: Wed, 11 Jan 1984 05:00:00 GMT");
    header('Content-type: text/cache-manifest');
?>CACHE MANIFEST

# We don't need to include a versionTimestamp becuase anyway the compressed
# js and css will change between releases.
# If we try and include also a timestamp with PHP date('YmdHis'), that will cause
# problems in Chrome: Application Cache Error event: Manifest changed during update, scheduling retry

CACHE:
https://www.plancake.com/account.php/mobile
/app/common/css/reset.css
/favicon.ico
/app/mobile/img/logo2.png
/app/mobile/img/sync_icon.png
/app/mobile/img/close.gif
/app/mobile/img/error.png
/app/mobile/img/notice.png
/app/mobile/img/success.png
/app/mobile/img/warning.png
/app/common/img/repetition_icon.gif
/app/common/img/note_icon.png
/app/common/img/empty_star_micro.png
/app/common/img/full_star_micro.png
/app/mobile/css/images/icons-18-white.png
/app/mobile/css/images/ajax-loader.png
# this file is used by the offline.html file, used in the fallback section
/js/offline/localDatastore.detection.js 


<?php 
    $indexFilepath = dirname(__FILE__) . '/../../../apps/account/modules/mobile/templates/indexSuccess.php';

    $indexFileContent = file_get_contents($indexFilepath);    
    include_once('../../../lib/generic/generic.php');
    $cssFiles = getAssetsFilenamesFromIndexFile('css', $indexFileContent, true);

    foreach ($cssFiles as $file) {
        echo $file . "\n";
    }   

    $jsFiles = getAssetsFilenamesFromIndexFile('js', $indexFileContent, true);

    foreach ($jsFiles as $file) {
        echo $file . "\n";
    }    
    
    
?>


FALLBACK:
/ /offline.html