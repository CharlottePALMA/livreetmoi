<?php  

$yves=0;
if ($_SERVER['REMOTE_ADDR']=="193.252.57.43")
	$yves=1;



$gene_titre=" ";
$gene_titre2=" ";
$gene_description=" ";
$gene_keywords=" ";

function datefr2en($mydate){
   @list($jour,$mois,$annee)=explode('/',$mydate);
   return @date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}

function dateen2fr($mydate){
   @list($annee,$mois,$jour)=explode('-',$mydate);
   return @date('d/m/Y',mktime(0,0,0,$mois,$jour,$annee));
}

function isInteger($n) {  if (preg_match("/[^0-^9]+/",$n) > 0) {    return false;  } return true;}

function message($msg)
{
echo "<html><body bgcolor=#FFFFFF><script>";
echo "alert('" , mysql_real_escape_string(stripslashes($msg)) , "'); " ;
echo "history.back();";
echo "</script>" ;
exit;
}

function message_erreur($msg)
{
message($msg);
}

function le_resume($t,$x)
{
$txt=strip_tags($t);
$j=0;
$j=strpos($txt," ",$x);
if ($j>5) $txt2=substr($txt,0,$j);
else $txt2=$txt;
return($txt2);
}


function vignette($f,$x)
{
global $DOSSIER_WEB;
if (strstr($f,"http")==NULL)
	{
	$fic_original=$DOSSIER_WEB."/".$f;
	$fic_vignette=$DOSSIER_WEB."/".$f.$x."_V.jpg";
	$fic=$f.$x."_V.jpg";
	}
else
	{
	$fic_original=$f;
	$fic_vignette=$DOSSIER_WEB."/vignettes/".md5($f).$x."_V.jpg";
	$fic="/vignettes/".md5($f).$x."_V.jpg";
	}

//if (file_exists($fic_original))
if (!file_exists($fic_vignette))
	{
	// Redimensionnement
	$size = getimagesize($fic_original);
	$width= $size[0];
	$height= $size[1];
	if ($size[2]==1) $image = imagecreatefromgif($fic_original);
	if ($size[2]==2) $image = imagecreatefromjpeg($fic_original);
	if ($size[2]==3) $image = imagecreatefrompng($fic_original);

	$new_width=$x;
	$new_height=round($x*$height/$width);
	$image_p = imagecreatetruecolor($new_width, $new_height);
	
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	imagejpeg($image_p, $fic_vignette, 100);
	}
return($fic);
}


function vignette2($f,$x,$y)
{
global $DOSSIER_WEB;

if ($x=="") return($f);

if (strstr($f,"http")==NULL)
	{
	$fic_original=$DOSSIER_WEB."/".$f;
	$fic_vignette=$DOSSIER_WEB."/".$f.$x.$y."_V.jpg";
	$fic=$f.$x.$y."_V.jpg";

	$fic_vignette=$DOSSIER_WEB."/vignettes/".md5($f).$x.$y."_V.jpg";
	$fic="/vignettes/".md5($f).$x.$y."_V.jpg";
	}
else
	{
	$fic_original=$f;
	$fic_vignette=$DOSSIER_WEB."/vignettes/".md5($f).$x.$y."_V.jpg";
	$fic="/vignettes/".md5($f).$x.$y."_V.jpg";
	}
//if (file_exists($fic_original))
if (!file_exists($fic_vignette))
	{
	// Redimensionnement
	$size = getimagesize($fic_original);
	$width= $size[0];
	$height= $size[1];
	if ($size[2]==1) $image = imagecreatefromgif($fic_original);
	if ($size[2]==2) $image = imagecreatefromjpeg($fic_original);
	if ($size[2]==3) $image = imagecreatefrompng($fic_original);

	$r1=$width/$x;
	$r2=$height/$y;
	if ($r1>$r2)
		{
		$new_width=$x;
		$new_height=round($x*$height/$width);
		}
	else
		{
		$new_height=$y;
		$new_width=round($y*$width/$height);
		}
	$image_p = imagecreatetruecolor($new_width, $new_height);
	$white = imagecolorallocate($image_p,  255, 255, 255);
	imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $white);

	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	imagejpeg($image_p, $fic_vignette, 100);
	}

return($fic);
}




function secure($t)
{
return (mysql_real_escape_string(stripslashes($t)));
}



function prepare_csv($txt)
{
$txt=str_replace("\n"," ",$txt);
$txt=str_replace("\r"," ",$txt);
$txt=str_replace("\t"," ",$txt);
$txt=str_replace(";",",",$txt);
return($txt);
}



function is_utf8($string) {
	return !strlen(
	preg_replace(
	  ',[\x09\x0A\x0D\x20-\x7E]'            # ASCII
	. '|[\xC2-\xDF][\x80-\xBF]'             # non-overlong 2-byte
	. '|\xE0[\xA0-\xBF][\x80-\xBF]'         # excluding overlongs
	. '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}'  # straight 3-byte
	. '|\xED[\x80-\x9F][\x80-\xBF]'         # excluding surrogates
	. '|\xF0[\x90-\xBF][\x80-\xBF]{2}'      # planes 1-3
	. '|[\xF1-\xF3][\x80-\xBF]{3}'          # planes 4-15
	. '|\xF4[\x80-\x8F][\x80-\xBF]{2}'      # plane 16
	. ',sS',
	'', $string));
}

function utf8_encode2($t)
{
if (is_utf8($t)) 
	return($t);
else
	return(utf8_encode($t));
}

function utf8_decode2($t)
{
if (is_utf8($t)) 
	return(utf8_decode($t));
else
	return($t);
}





//////////////////////////////////////////////////////////////////////////////////////
//
// Calcule du nombre de jours entre deux dates
//
function calcule_jour($debut,$fin)
{
$nb_jours_location = ( strtotime($fin) - strtotime($debut) )/(3600*24);
return(round($nb_jours_location)+1);
}





//////////////////////////////////////////////////////////////////////////////////////
//
// Gère l'upload de fichiers
// $nom1 correspond au nom du champ de type file du formulaire
// $nom2 correspond au nom du fichier qui sera créé dans le dossier $DOSSIER_DATA (initialisé dans /inc/config.php)
// $maxi correspond à la taille maximum du fichier, en octet
// $extension correpond aux extensions (.doc, .xls, ...) qui peuvent être téléchargées
//
function charge_fichier($nom1,$nom2,$maxi,$extensions)
{
global $DOSSIER_DATA;
if (strlen($_FILES[$nom1]['name'])<1) return("");
$dossier = $DOSSIER_DATA.'/';
$taille_maxi = $maxi; 

$taille = filesize($_FILES[$nom1]['tmp_name']);
$extension = strtolower(strrchr($_FILES[$nom1]['name'], '.')); 
if(!in_array($extension, $extensions))      $erreur = "Ce type de fichier n'est pas accepté : ".$_FILES[$nom1]['name'];
if($taille>$taille_maxi)
     $erreur = "Le fichier est trop volumineux : ".$_FILES[$nom1]['name'];
if(!isset($erreur)) 
	{
     if(!move_uploaded_file($_FILES[$nom1]['tmp_name'], $dossier . $nom2)) 
		message_erreur("Echec de l'upload : ".$_FILES[$nom1]['name']." ".$dossier.$nom2);
	}
else
     message_erreur($erreur);
return($nom2);	 
}




//////////////////////////////////////////////////////////////////////////////////////
//
// Transforme les virgules en points, pour bonne prise en compte des décimaux dans mySQL
//
function virpoint($txt)
{
return(str_replace(",",".",$txt));
}





function BR13($txt)
{
return(str_replace("\n","<br>",$txt));
}


function space13($str) 
{    
$str=str_replace("\r\n"," ",$str);
$str=str_replace("\n"," ",$str);
$str=str_replace("\r"," ",$str);
$str=str_replace("  "," ",$str);
$str=str_replace("  "," ",$str);
return($str);
}



function FilePathToArray($leFichier)
{
      if (!file_exists($leFichier)){
	return false;
      }
      $AboutTheFile=pathinfo($leFichier);
      return array(
	'chemin'	=> $leFichier,
	'nom'	=> $AboutTheFile['filename'],
	'extension'=>$AboutTheFile['extension'],
	'mimeType'=> mime_content_type($leFichier),// mime_content_type est une function obsolète (je sais), mais bien pratique.
	'contenu'	=> chunk_split(base64_encode(file_get_contents($leFichier)))	//ounch les ressources
      );
 
}
function SendEmailwidthJoin($message_txt,$message_html,$destinataire,$expediteur,$fichiersAJoindre,$objet,$replyTo="" )
{
  /*
  * Envoie un e-mail "propre"  avec des pièces jointes
  *
  * Codé par gnieark http://blog-du-grouik.tinad.fr février 2012
  * Distribué sans aucune garantie dans les conditions établies là  http://blog-du-grouik.tinad.fr/pages/Mentions-l%C3%A9gales
  *
  * Vous ne devez pas supprimer ce bloc de commentaires.
  *
  * La création de ce code est en tres grande partie basée sur le tutoriel de Weaponsb qui a sévi sur le site du zéro:
  * "Envoyer un e-mail en PHP" http://www.siteduzero.com/tutoriel-3-35146-e-mail-envoyer-un-e-mail-en-php.html
  * 
  */
 
  /*
  *	*** How to use this function ***
  *	$fichiersAJoindre peut être:
  *		- un  string contenant le chemin vers un seul fichier
  *		- un array sous la forme array('Chemin/Vers/Fichier1.ext','/chemin/vers/fichiers2', etc...);
  *		- un array structuré comme la super variable globale PHP $_FILES:
  *			$array('file1'	=> array('
  *				  'name'     => ,
  *				  'type'     => ,
  *				  'tmp_name' => ,
  *				  'error'    => ,
  *				  'size'     => ),
  *			      'file2' => array(
  *				    (..)etc)
  *			)
  *		/!\ Aucune vérification sur du directory transversal n'est faite au niveau de cette function.
  *		En cas de variables fournies par l'utilisateur, prenez le soin de protéger en amont de cette function.
  *	$message_txt (obligatoire contient le message au format txt)
  *	$message_html facultatif (envoyez une string vide "" si vous ne souhaitez pas envoyer votre message en html) 
  *	$destinataire : 'nom@fai.com' ou '"Nom Prenom<nom@fai.com>"' ou '"Nom1 Prenom1<nom1@fai.com>,Nom2 Prenom2<nom2@fai.com>"'
  *	$expediteur: idem
  *	$replyTo: facultatif, si différent de l'expéditeur.
  */
 
 
   //=== vérifier et préparer les pieces jointes:
  $arrayFiles=array();
  if (is_string($fichiersAJoindre)){
    $lesFichiers[]= FilePathToArray($fichiersAJoindre);
  }
  if (is_array($fichiersAJoindre)){
    //tester si c'est du type $_FILES
    if ((isset($fichiersAJoindre[0])) AND (is_string($fichiersAJoindre[0])) ){
      //un array simple avec des strings 
      foreach($fichiersAJoindre as $stringFile){
	$lesFichiers[]= FilePathToArray($stringFile);
      }
    }else{
	//de type $_FILES
	foreach($fichiersAJoindre as $arrayFiles){
	  $aboutFile=pathinfo($arrayFiles['name']);
	  $lesFichiers[]=array(
	    	'chemin'	=> getenv('TMP')."/".$arrayFiles['tmp_name'],
		'nom'	=> $aboutFile['filename'],
		'extension'=>$aboutFile['extension'],
		'mimeType'=> mime_content_type(getenv('TMP')."/".$arrayFiles['tmp_name']),// mime_content_type est une function obsolète (je sais), mais bien pratique.
		'contenu'	=> chunk_split(base64_encode(file_get_contents($arrayFiles['tmp_name'])))	//ounch les ressources
	  );
	}
    }
  }
 
 
  //===générer les délimiteurs dans l'email ===
  do{
    $leRand=md5(rand());
    $boundary = "-----=".$leRand;
  }while(!strpos($message_txt.$message_html, $leRand) === false); // oui, la vérification là , c'est du zèle.
 
  do{
    $leRand=md5(rand());
    $boundary_alt = "-----=".md5(rand());
    $isOK=true;
    foreach($lesFichiers as $fichier){
      if(!strpos($fichier['contenu'], $leRand) === false){
	$isOK=false;
      }
    }
  }while($isOK==false);//lÃ  en plus d'etre du zele, ça bouffe les ressources
 
  //=== le type de retour à la ligne ===
  if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $destinataire)){
    $passage_ligne = "\r\n";
  }else{
    $passage_ligne = "\n";
  }
  $passage_ligne = "\n";
 
  //=== header ===
  $headers ="From: ".$expediteur.$passage_ligne;
  if ($replyTo==""){
    $headers.= "Reply-to: ".$expediteur.$passage_ligne;
  }else{
    $headers.= "Reply-to: ".$replyTo.$passage_ligne;
  }
 
  $headers.= "MIME-Version: 1.0".$passage_ligne;
  $headers.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"".$boundary."\"".$passage_ligne;
 
  //=====Création du message.
  $message = $passage_ligne."--".$boundary.$passage_ligne;
  $message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
 
  //=====Ajout du message au format texte.
  if ($message_txt!=""){
    $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
//    $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
    $message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
    //$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
    //$message.= $passage_ligne.$message_txt.$passage_ligne;
    $message.= "Content-Transfer-Encoding: base64".$passage_ligne;
    $message.= $passage_ligne.chunk_split(base64_encode($message_txt)).$passage_ligne;
  }
  //==========
 
  //=====Ajout du message au format HTML.
  if ($message_html!=""){
    $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
//    $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
    $message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
    //$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
    $message.= "Content-Transfer-Encoding: base64".$passage_ligne;
    $message.= $passage_ligne.chunk_split(base64_encode($message_html)).$passage_ligne;
    //On ferme la boundary alternative.
    $message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
  }
  //==========
 
  //pièces jointes
  foreach($lesFichiers as $fileArray)
  {
    $message.= $passage_ligne."--".$boundary.$passage_ligne;
 
    $message.="Content-Type: ".$fileArray['mimeType']."; name=\"".$fileArray['nom'].".".$fileArray['extension']."\"".$passage_ligne;
    $message.="Content-Transfer-Encoding: base64".$passage_ligne;
    $message.="Content-Disposition: attachment; filename=\"".$fileArray['nom'].".".$fileArray['extension']."\"".$passage_ligne;
    $message.= $passage_ligne.$fileArray['contenu'].$passage_ligne.$passage_ligne;
  }
  $message.= $passage_ligne."--".$boundary."--".$passage_ligne; 
  //echo $message;
  //Envoi du mail
  mail($destinataire, $objet, $message, $headers);
}



function donne_mois($m)
{
if ($m==1) return("Janvier");
if ($m==2) return("Février");
if ($m==3) return("Mars");
if ($m==4) return("Avril");
if ($m==5) return("Mai");
if ($m==6) return("Juin");
if ($m==7) return("Juillet");
if ($m==8) return("Août");
if ($m==9) return("Septembre");
if ($m==10) return("Octobre");
if ($m==11) return("Novembre");
if ($m==12) return("Décembre");
}

function donne_mois_court($m)
{
if ($m==1) return("Jan");
if ($m==2) return("Fév");
if ($m==3) return("Mar");
if ($m==4) return("Avr");
if ($m==5) return("Mai");
if ($m==6) return("Jun");
if ($m==7) return("Jui");
if ($m==8) return("Aoû");
if ($m==9) return("Sep");
if ($m==10) return("Oct");
if ($m==11) return("Nov");
if ($m==12) return("Déc");
}


function html_encode($text)
{
	$text2 = htmlentities($text, ENT_NOQUOTES, "UTF-8");
	if ($text2=="")
		$text2 = htmlentities($text, ENT_NOQUOTES, "ISO-8859-1");
	
	$text = htmlspecialchars_decode($text2);
	return $text;
}



function update_ajax($table,$champ,$valeur,$id,$area,$date,$label)
{
$alea=rand(1,999999999);
$champ1=$champ.$alea;
?>
<script>
function swap_Ajax<?=$champ1?>()
{
$("#Ajax<?=$champ1?>_1").hide();
$("#Ajax<?=$champ1?>_2").show();
$("#Ajax<?=$champ1?>_3").focus();
}

function swapS_Ajax<?=$champ1?>()
{
v=$("#Ajax<?=$champ1?>_3").val();
<?
if ($area==1)
	{
	?>
	v=v.replace(/\n/g,"<br>");
	<?
	}
?>
$("#Ajax<?=$champ1?>_1").html('<?=$label?>'+v+'&nbsp;');


$.ajax({
  type: "POST",
  url: "/admin/update_ajax.php",
  data: { table: '<?=$table?>', champ:'<?=$champ?>', v:v , id:<?=$id?>}
});


$("#Ajax<?=$champ1?>_2").hide();
$("#Ajax<?=$champ1?>_1").show();
}

</script>
<?
$va=$valeur;
if ($date==1) $va=dateen2fr($va);
if ($area==1) $va=str_replace("\n","<br>",utf8_encode($va));
?>
<div id="Ajax<?=$champ1?>_1" onClick="javascript:swap_Ajax<?=$champ1?>();" style="min-width:200px;"><?=$label?><?=$va?>&nbsp;</div>
<?
$ty="text"; if ($date==1) $ty="date";
if ($area==0)
	{
	?>
	<div id="Ajax<?=$champ1?>_2" style="display:none"><input type="<?=$ty?>" id="Ajax<?=$champ1?>_3" value="<?=$valeur?>"
onKeyPress="if (event.keyCode == 13) swapS_Ajax<?=$champ1?>();"  onBlur="swapS_Ajax<?=$champ1?>();" ></div>
	<?
	}
else
	{
	?>
	<div id="Ajax<?=$champ1?>_2" style="display:none"><textarea style="width:400px; height:200px;" id="Ajax<?=$champ1?>_3" onBlur="swapS_Ajax<?=$champ1?>();" ><?=utf8_encode($valeur)?></textarea></div>
	<?
	}
}



function suppaccents($mot){ 
//  $accents = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ"; 
//$ssaccents = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"; 


$mot=str_replace("à","a",$mot);
$mot=str_replace("â","a",$mot);
$mot=str_replace("ã","a",$mot);
$mot=str_replace("ä","a",$mot);
$mot=str_replace("é","e",$mot);
$mot=str_replace("è","e",$mot);
$mot=str_replace("ê","e",$mot);
$mot=str_replace("ë","e",$mot);
$mot=str_replace("ï","i",$mot);
$mot=str_replace("î","i",$mot);
$mot=str_replace("ô","o",$mot);
$mot=str_replace("ö","o",$mot);
$mot=str_replace("ü","u",$mot);
$mot=str_replace("û","u",$mot);
$mot=str_replace("ù","u",$mot);
$mot=str_replace("ñ","n",$mot);
$mot=str_replace("ç","c",$mot);
return($mot); 
} 	


function prepare_rewrite($titre){
	$titre=trim(suppaccents(str_replace(" ","-",$titre)));
	$titre=str_replace(".","-",$titre);
	$titre=str_replace(",","-",$titre);
	$titre=str_replace(";","-",$titre);
	$titre=str_replace("!","-",$titre);
	$titre=str_replace("?","-",$titre);
	$titre=str_replace(":","-",$titre);
	$titre=str_replace("« ","-",$titre);
	$titre=str_replace(" »","-",$titre);
	$titre=str_replace("«","-",$titre);
	$titre=str_replace("»","-",$titre);
	$titre=str_replace("’","-",$titre);
	$titre=str_replace("°","-",$titre);
	$titre=str_replace("+","-",$titre);
	$titre=str_replace("(","-",$titre);
	$titre=str_replace(")","-",$titre);
	$titre=str_replace("[","-",$titre);
	$titre=str_replace("]","-",$titre);
	$titre=str_replace("#","-",$titre);
	$titre=str_replace("§","-",$titre);
	$titre=str_replace("%","-",$titre);
	$titre=str_replace("|","-",$titre);
	$titre=str_replace("'","-",$titre);
	$titre=str_replace("&amp;","-",$titre);
	$titre=str_replace("&","-",$titre);
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
	for ($i=0;$i<strlen($titre);$i++)
		if (($titre[$i]>='A') && ($titre[$i]<='Z'))
			{}
		else
		if (($titre[$i]>='a') && ($titre[$i]<='z'))
			{}
		else
		if (($titre[$i]>='0') && ($titre[$i]<='9'))
			{}
		else
		if ($titre[$i]=='/')
			{}
		else
			$titre[$i]="-";
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
	$titre=str_replace("--","-",$titre);
			
return($titre);
}


function donne_resume_panier($cmde)
{
global $connexion,$TVA5,$TVA10,$TVA20;

$txt="";

$port=calcul_colissimo($cmde,$_SESSION['pays']);

$q=0; $p=0; $h=0;

if ($_SESSION['user_groupe']==2)
	$req="select sum(qte) as q, sum(qte*prixHT*(1+taux_tva/100)) as p, sum(qte*prixHT) as h from panier where cmde='".secure($cmde)."' and qte<promo_nbre ";
else
	$req="select sum(qte) as q, sum(qte*prixTTC) as p, sum(qte*prixHT) as h from panier where cmde='".secure($cmde)."' and qte<promo_nbre ";

$mysql_result1 = mysql_query($req,$connexion) ;
if ($ligne1 = mysql_fetch_array($mysql_result1))
	{
	$q=$ligne1['q'];
	$p=$ligne1['p'];
	$h=$ligne1['h'];
	}

if ($_SESSION['user_groupe']==2)
	$req="select sum(qte) as q, sum(qte*promo_pht*(1+taux_tva/100)) as p, sum(qte*promo_pht) as h from panier where cmde='".secure($cmde)."' and qte>=promo_nbre ";
else
	$req="select sum(qte) as q, sum(qte*promo_pttc) as p, sum(qte*promo_pttc) as h from panier where cmde='".secure($cmde)."' and qte>=promo_nbre ";

$mysql_result1 = mysql_query($req,$connexion) ;
if ($ligne1 = mysql_fetch_array($mysql_result1))
	{
	$q+=$ligne1['q'];
	$p+=$ligne1['p'];
	$h+=$ligne1['h'];
	}



if ($q==0) $txt= "(vide)";
else
if ($q==1) $txt= "(1 article)";
else $txt= "(".$q." articles)";
$txt.="^";

if ($_SESSION['user_groupe']==2)
	$txt.=number_format($port/(1+$TVA20/100) + $h ,2,",","");
else
	$txt.=number_format($p,2,",","");


$txt.="^";
$txt.=number_format($port,2,",","");
$txt.="^";
$txt.=number_format($p+$port,2,",","");
$txt.="^";
$txt.=number_format($h,2,",","");
$txt.="^";
$txt.=number_format($port/(1+$TVA20/100),2,",","");
$txt.="^";
$txt.=number_format($p-$h +$port*$TVA20/(100+$TVA20),2,",","");

$req="update commandes set ";
$req.="montantHT=".$h.", ";
$req.="montantTTC=".$p.", ";
$req.="portHT=".round($port/(1+$TVA20/100),2).", ";
$req.="portTTC=".$port." where cmde='".secure($cmde)."' ";
$mysql_result1 = mysql_query($req,$connexion) ;
return($txt);
}

function calcul_colissimo($cmde,$pays)
{
global $connexion,$poids,$prix_relais,$TVA5,$TVA10,$TVA20;
$poids=0;

	
$req="select * from panier where cmde='".secure($cmde)."' ";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result))
	{
	$q=$ligne['qte'];
	$req="select * from cata_produits_gammes where id=".$ligne['gamme'];
	$mysql_result0 = mysql_query($req,$connexion) ;
	if ($ligne0 = mysql_fetch_array($mysql_result0))
		{
		$poids+=$q*$ligne0['poids_colis'];
		}
	}


$req="update commandes set ";
$req.="poids=".$poids." where cmde='".secure($cmde)."' ";
$mysql_result1 = mysql_query($req,$connexion) ;


$tht=0;
$ttc=0;
$req="select * from panier where cmde='".secure($cmde)."' ";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result))
	{
	if ($ligne['qte']>=$ligne['promo_nbre'])
		$tht+=$ligne['qte']*$ligne['promo_pht'];
	else
		$tht+=$ligne['qte']*$ligne['prixHT'];

	if ($ligne['qte']>=$ligne['promo_nbre'])
		$ttc+=$ligne['qte']*$ligne['promo_pttc'];
	else
		$ttc+=$ligne['qte']*$ligne['prixTTC'];
	}


if ($_SESSION['user_groupe']==2)
	{
	if ($tht>=450)
		return(0);
	else 
		return(50*(1+$TVA20/100));
	}
else
	{
	if ($ttc>=200)
		{
		$prix_relais=0;
		return(0);
		}
	else 
		{
		$prix_relais=10;
		return(12);
		}
	}

/*
$zone=0;
$req="select * from pays where pays like '".secure($pays)."' ";
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result))
	$zone=$ligne['zone'];

$prix=9999;
$prix_relais=9999;
$req="select * from colissimo where poids_mini<=".$poids." and poids_maxi>=".$poids." and zone=".$zone;
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result))
	{
	$prix=$ligne['montant'];
	$prix_relais=$ligne['montant_relais'];
	}

return($prix);
*/
}


?>