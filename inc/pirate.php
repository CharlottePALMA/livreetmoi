<?php

function pirate()
{
$mail=0;
$headers = "MIME-Version: 1.0\r\n";
if (!file_exists("/E/logs/pirate_".date("Ymd-H").".tmp"))
        $mail=1;
file_put_contents("/E/logs/pirate_".date("Ymd-H").".tmp",date("d/m/Y H:i")." ".$_SERVER['SERVER_NAME']." ".$_SERVER['REQUEST_URI']." ".$_SERVER['QUERY_STRING']." ".$_SERVER['REMOTE_ADDR']."\n\n",FILE_APPEND);

file_put_contents("/E/logs/pirate_".date("Ymd-H").$_SERVER['REMOTE_ADDR'].".tmp","x",FILE_APPEND);


if ($mail==1)
        mail("yves@viapalma.fr", "INJECTION SQL !!!", file_get_contents("/E/logs/pirate_".date("Ymd-H").".tmp"), $headers);
die();
}

//This stops SQL Injection in POST vars
foreach ($_POST as $key => $value) {
$u=strtolower($value);
if (strstr($u,"union")!=NULL)
if (strstr($u,"select")!=NULL)
if (strstr($u,"concat")!=NULL)
        pirate();

if (strstr($u,"table_name")!=NULL) pirate();
if (strstr($u,"information_schema")!=NULL) pirate();

if (strstr($u,"%20select")!=NULL)
        if (strstr($u,"swiss")==NULL)
                pirate();

if (strstr($u," select ")!=NULL) pirate();
if (strstr($u,"ascii%")!=NULL) pirate();
if (strstr($u,"database%")!=NULL) pirate();
if (strstr($u,"union+all")!=NULL) pirate();
if (strstr($u,"select+concat")!=NULL) pirate();
if (strstr($u,"concat%")!=NULL) pirate();
if (strstr($u,"column_name")!=NULL) pirate();
if (strstr($u,"hex%28")!=NULL) pirate();
if (strstr($u,"%28select")!=NULL) pirate();
if (strstr($u,"%3cscript")!=NULL) pirate();
if (strstr($u,"<script")!=NULL) pirate();
if (strstr($u,"domxssExecutionSink")!=NULL) pirate();
if (strstr($u,"select pg_sleep")!=NULL) pirate();
if (strstr($u,"/etc/passwd")!=NULL) pirate();
if (strstr($u,"WEB-INF/web.xml")!=NULL) pirate();

}

//This stops SQL Injection in GET vars
foreach ($_GET as $key => $value) {
$u=strtolower($value);
if (strstr($u,"union")!=NULL)
if (strstr($u,"select")!=NULL)
if (strstr($u,"concat")!=NULL)
        pirate();

if (strstr($u,"table_name")!=NULL) pirate();
if (strstr($u,"information_schema")!=NULL) pirate();
if (strstr($u,"%20select")!=NULL) pirate();
if (strstr($u," select ")!=NULL) pirate();
if (strstr($u,"ascii%")!=NULL) pirate();
if (strstr($u,"database%")!=NULL) pirate();
if (strstr($u,"union+all")!=NULL) pirate();
if (strstr($u,"select+concat")!=NULL) pirate();
if (strstr($u,"concat%")!=NULL) pirate();
if (strstr($u,"column_name")!=NULL) pirate();
if (strstr($u,"hex%28")!=NULL) pirate();
if (strstr($u,"%28select")!=NULL) pirate();
if (strstr($u,"%3cscript")!=NULL) pirate();
if (strstr($u,"<script")!=NULL) pirate();
if (strstr($u,"domxssExecutionSink")!=NULL) pirate();
if (strstr($u,"select pg_sleep")!=NULL) pirate();
if (strstr($u,"/etc/passwd")!=NULL) pirate();
if (strstr($u,"WEB-INF/web.xml")!=NULL) pirate();
}


if (file_exists("/E/logs/pirate_".date("Ymd-H").$_SERVER['REMOTE_ADDR'].".tmp")) die();



?>
