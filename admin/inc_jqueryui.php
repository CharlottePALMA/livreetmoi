<?php
/**************************************************************************************************

Les inclusions de JQueryUI, utilisé pour les dates picker

**************************************************************************************************/
?>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
<script>
$(document).ready(function() {
	$( ".datepicker" ).datepicker({dateFormat: "dd/mm/yy"});
	$( ".datepicker" ).datepicker( "option", "monthNames", ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"] );
	$( ".datepicker" ).datepicker( "option", "dayNamesMin", ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"] );
	$( ".datepicker" ).datepicker( "option", "firstDay", 1 );
});
</script>