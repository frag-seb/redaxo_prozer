<?php

$subpage = rex_request('subpage', 'string');


require $REX['INCLUDE_PATH'] . '/layout/top.php';

rex_title($I18N->msg('prozer'), $REX['ADDON']['pages']['prozer']);



switch($subpage){
    case 'setup' :
        require $REX['INCLUDE_PATH'] . '/addons/prozer/pages/setup/index.inc.php';
        break;

    case 'about' :
        require $REX['INCLUDE_PATH'] . '/addons/prozer/pages/about/index.inc.php';
        break;
    default:
        require $REX['INCLUDE_PATH'] . '/addons/prozer/pages/setup/index.inc.php';
        break;

}



require $REX['INCLUDE_PATH'] . '/layout/bottom.php';
