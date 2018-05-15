// JavaScript Document


//////////////////////////////////////////////////////////////////////
//
// Fenetre javascript de confirmation de suppression d'un compte
//
function confirme_suppression_compte(objet,id)
{
if (confirm("Souhaitez vous supprimer cet identifiant : "+objet))
	window.location="comptes_del.php?id="+id;
}	

function confirme_suppression_livre(objet,id)
{
if (confirm("Souhaitez vous supprimer ce livre : "+objet))
	window.location="livres.php?del="+id;
}	

function confirme_suppression_editeur(objet,id)
{
if (confirm("Souhaitez vous supprimer cet éditeur : "+objet))
	window.location="editeurs.php?del="+id;
}	

function confirme_suppression_auteur(objet,id)
{
if (confirm("Souhaitez vous supprimer cet auteur : "+objet))
	window.location="auteurs.php?del="+id;
}	

function confirme_suppression_question(objet,id)
{
if (confirm("Souhaitez vous supprimer cette question : "+objet))
	window.location="questions.php?del="+id;
}	



//////////////////////////////////////////////////////////////////////
//
// Effectue un appel Ajax pour récupérér la liste des clients correspondant aux critères lors de la recherche d'un client
// Affiche cette liste sous le formulaire de recherche
//
function maj_liste_recherche_clients()
{
groupe=$("#groupe option:selected").val();
ville=$("#ville").val();
contact=$("#contact").val();
pays=$("#pays").val();
	
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: { quoi:'recherche_client',groupe: groupe, ville: ville,contact:contact,pays:pays }
}).done(function( msg ) {
		$( "#liste" ).html(msg);
		});
	
}

//////////////////////////////////////////////////////////////////////
//
// Effectue un appel Ajax pour récupérér la liste des clients correspondant aux critères lors de la recherche d'un client
// Affiche cette liste sous le formulaire de recherche
//
function maj_liste_recherche_clients_facture_globale()
{
societe=$("#societe").val();
ville=$("#ville").val();
contact=$("#contact").val();
numero=$("#numero").val();
	
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: { quoi:'recherche_client_facture_globale',societe: societe, ville: ville,contact:contact,numero:numero }
}).done(function( msg ) {
		$( "#liste" ).html(msg);
		});
	
}


function choix_client(id,nom,numero)
{
$('#societe').val(nom);
$('#numero').val(numero);
$('#clid').val(id);
}


//////////////////////////////////////////////////////////////////////
//
// Effectue un appel Ajax pour récupérér la liste des clients correspondant aux critères lors de la recherche d'un client
// au moment de la création d'un nouveau devis
// Affiche cette liste sous le formulaire de recherche
//
function maj_liste_recherche_clients_nouveau_devis()
{
societe=$("#societe").val();
ville=$("#ville").val();
contact=$("#contact").val();
numero=$("#numero").val();
	
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: { quoi:'recherche_client_nouveau_devis',societe: societe, ville: ville,contact:contact,numero:numero }
}).done(function( msg ) {
		$( "#liste" ).html(msg);
		});
	
}


//////////////////////////////////////////////////////////////////////
//
// Effectue un appel Ajax pour récupérér la liste des devis correspondant aux critères lors de la recherche d'un devis
// Affiche cette liste sous le formulaire de recherche
//
// le paramètre type indique le type de commande à rechercher (D)evis (C)ommande (T) (A)

function maj_liste_recherche_devis(type)
{
numero=$("#numero").val();
date1=$("#date1").val();
date2=$("#date2").val();
type2=$("#type2").val();
	
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: { quoi:'recherche_devis',numero:numero, date1:date1, date2:date2,type2:type2,type:type }
}).done(function( msg ) {
		$( "#liste" ).html(msg);
		});
	
}

//////////////////////////////////////////////////////////////////////
//
// Effectue un toggle des éléments donc la classe est "c"
// v peut être slow, fast 
//
function swap_class(c,v)
{
$("."+c).toggle(v);	
}

//////////////////////////////////////////////////////////////////////
//
// Effectue un toggle des éléments donc l'id est "c"
// v peut être slow, fast 
//
function swap_id(c,v)
{
$("#"+c).toggle(v);	
}


//////////////////////////////////////////////////////////////////////
//
// Affiche le formulaire d'un contact
// si idcontact=0 alors le formulaire sera vierge, sinon, il sera pré rempli avec les infos du contact n°idcontact
//
function modification_contact(idclient,idcontact)
{
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: { quoi:'modification_contact',idclient:idclient, idcontact:idcontact }
}).done(function( msg ) {
		$( "#leCadre" ).html(msg);
		$( "#leCadre" ).show('fast');
		});
}


//////////////////////////////////////////////////////////////////////
//
// Valide le formulaire de création/modification de contact
//
function valide_modification_contact()
{
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: $("#formModifContact").serialize()
}).done(function( msg ) {
		if (msg=="ERREUR")
			{
			alert("Veuillez saisir le nom du contact");
			}
		else
			{
			$( "#leCadre" ).hide('fast');
			$("#listeContacts").append(msg);
			}
		});
}


//////////////////////////////////////////////////////////////////////
//
// Affiche le formulaire d'un contact
// si idcontact=0 alors le formulaire sera vierge, sinon, il sera pré rempli avec les infos du contact n°idcontact
//
function modification_client(idclient)
{
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: { quoi:'modification_client',idclient:idclient }
}).done(function( msg ) {
		if (idclient==0)
			{
			$( "#liste" ).html(msg);
			$( "#liste" ).show('fast');
			}
		else
			{
			$( "#leCadre" ).html(msg);
			$( "#leCadre" ).show('fast');
			}
		});
}


//////////////////////////////////////////////////////////////////////
//
// Valide le formulaire de création/modification de client
//
function valide_modification_client()
{
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: $("#formModifClient").serialize()
}).done(function( msg ) {
		if (msg=="ERREUR")
			{
			alert("Veuillez saisir le nom du client");
			}
		else
		if (msg=="ERREUR1")
			{
			alert("Veuillez saisir une adresse e-mail");
			}
		else
		if (msg=="ERREUR2")
			{
			alert("Cette adresse e-mail est déjà utilisée par un autre client");
			}
		else
			{
			document.location.reload(true);
			}
		});
}



//////////////////////////////////////////////////////////////////////
//
// Valide le formulaire de creation de client
//
function valide_creation_client()
{
$.ajax({
  type: "POST",
  url: "ajax.php",
  data: $("#formModifClient").serialize()
}).done(function( msg ) {
		if (msg=="ERREUR")
			{
			alert("Veuillez saisir le nom du client");
			}
		else
		if (msg=="ERREUR1")
			{
			alert("Veuillez saisir une adresse e-mail");
			}
		else
		if (msg=="ERREUR2")
			{
			alert("Cette adresse e-mail est déjà utilisée par un autre client");
			}
		else
			{
			document.location="/admin/clients_fiche.php?id="+msg;
			}
		});
}


//////////////////////////////////////////////////////////////////////
//
// Sur le formulaire d'un devis, pour le champs "Mise à disposition", affichage ou non de la seconde heure dans le cas d'un interval
//
function majmad()
{
s=document.getElementById('mad');
if (s.options[s.selectedIndex].value=='entre')
	{
	document.getElementById('dmad').style.position="static";
	document.getElementById('dmad').style.visibility="visible";
	}
else
	{
	document.getElementById('dmad').style.visibility="hidden";
	document.getElementById('dmad').style.position="absolute";
	}
}

//////////////////////////////////////////////////////////////////////
//
// Sur le formulaire d'un devis, pour le champs "Retour", affichage ou non de la seconde heure dans le cas d'un interval
//
function majmar()
{
s=document.getElementById('mar');
if (s.options[s.selectedIndex].value=='entre')
	{
	document.getElementById('dmar').style.position="static";
	document.getElementById('dmar').style.visibility="visible";
	}
else
	{
	document.getElementById('dmar').style.visibility="hidden";
	document.getElementById('dmar').style.position="absolute";
	}
}
