<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($preview)
{
	$tstaffprofile = "";
	foreach($preview as $tg)
	{
		$tstaffprofile .= renderEmployeeOverview($tg);
	}
	$tcontent = <<<PAGE
      {$tstaffprofile}
PAGE;
      return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tmployee = [];
$tid = $_REQUEST["id"] ?? -1;
$tname = $_REQUEST["name"] ?? "";


//Handle our Requests and Search for reviews
if (is_numeric($tid) && $tid > 0)
{
	$temployee = jsonLoadOneEmployee($tid);
	$temployees[] = $temployee;
}
else if (!empty($tname))
{
	//Filter the name
	$tname = processRequest($tname);
	$temployeelist = jsonLoadAllGames();
	foreach ($temployeelist as $tg)
	{
		if (strtolower($tg->firstname) === strtolower($tname))
		{
			$treviews[] = $tg;
		}
	}
}

//Page Decision Logic - Have we found a review?
if (count($temployees)===0)
{
	header("Location: app_error.php");
}
else
{
	//We've found our review
	$tpagecontent = createPage($temployees);

	$tpagetitle = "Staff Profile";
	$tpagelead = "";
	$tpagefooter = "";

	// ----BUILD OUR HTML PAGE----------------------------
	// Create an instance of our Page class
	$tpage = new MasterPage($tpagetitle);
	// Set the Three Dynamic Areas (1 and 3 have defaults)
	if (! empty($tpagelead))
		$tpage->setDynamic1($tpagelead);
		$tpage->setDynamic2($tpagecontent);
		if (! empty($tpagefooter))
			$tpage->setDynamic3($tpagefooter);
			// Return the Dynamic Page to the user.
			$tpage->renderPage();
}
?>