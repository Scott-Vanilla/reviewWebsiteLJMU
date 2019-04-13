<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----PAGE GENERATION LOGIC---------------------------

function createPage()
{
	$trailers=file_get_contents("data/html/trailers.html");
	$reviewsum=file_get_contents("data/html/revsum.html");
	$tcontent = <<<PAGE
		
		<div style= "margin-top:20px" class="jumbotron">
  <h1 class="display-3">Welcome to ReviewGO!</h1>
  <p class="lead">ReviewGO! is a hub for all things gaming, with reviews posted every week and regular gaming news updates.</p>
  <hr class="my-4">
  <p>Find out who makes up the ReviewGO! team.</p>
  <p class="lead">
    <a class="btn btn-secondary btn-lg" href="staff.php" role="button">Find out more >>></a>
  </p>
</div>

		<h1> Newly Released Trailers </h1>
		<br>
		
		{$trailers}
	
		{$reviewsum}
			
<br>
PAGE;
return $tcontent;
}

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();

//Build up our Dynamic Content Items. 
$tpagetitle = "Title";
$tpagelead  = "";
$tpagecontent = createPage();
$tpagefooter = "";

//----BUILD OUR HTML PAGE----------------------------
//Create an instance of our Page class
$tpage = new MasterPage($tpagetitle);
//Set the Three Dynamic Areas (1 and 3 have defaults)
if(!empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
$tpage->setDynamic2($tpagecontent);
if(!empty($tpagefooter))
    $tpage->setDynamic3($tpagefooter);
//Return the Dynamic Page to the user.    
$tpage->renderPage();
?>