<?php  

ini_set("session.save_handler", "files"); 
ini_set('session.use_trans_sid', false);
ini_set('session.use_cookies', true);
ini_set('url_rewriter.tags',''); 

session_start();
header("Cache-control: private"); // a placer pour que le history.back n'efface pas le contenu du formulaire

$DOSSIER_TMP="/E/livres/web/tmp";
$DOSSIER_DATA="/E/livres/web/data";
$DOSSIER_WEB="/E/livres/web";
$EMAIL_ADMIN="yves@viapalma.fr";
$EMAIL_NOTIF="yves@viapalma.fr";
$NOTIF_CLIENT=0;

$WEB="www.livre-et-moi.fr";

$titre_principal="Livre-et-moi.fr";




?>
