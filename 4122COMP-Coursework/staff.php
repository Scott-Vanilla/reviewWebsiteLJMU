<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----PAGE GENERATION LOGIC---------------------------

function createPage($pimgdir)
{
    include("ajax-staff.php");
    $stafftable = createStaffElement();
    
        
$tcontent = <<<PAGE
		<div >
			<div class="panel panel-primary">
			<div class="panel-body">
				<h2 style="margin:20px">Meet the Team</h2>
				<div id="staff-table">
			    {$stafftable}
		        </div>
		    </div>
			</div>
		</div>
PAGE;

return $tcontent;
}

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();
$tcurrpage = $_REQUEST["page"] ?? 1;
$tcurrpage = is_numeric($tcurrpage) ? $tcurrpage: 1;
$tsortmode = $_REQUEST["sortmode"] ?? "squadno";
$tsortorder = $_REQUEST["sortorder"] ?? "asc";

$tpagetitle = "ReviewGO! Team";
$tpage = new MasterPage($tpagetitle);
$timgdir = $tpage->getPage()->getDirImages();

//Build up our Dynamic Content Items. 
$tpagelead  = "";
$tpagecontent = createPage($timgdir,$tcurrpage,$tsortmode,$tsortorder);
$tpagefooter = "";

//----BUILD OUR HTML PAGE----------------------------
//Set the Three Dynamic Areas (1 and 3 have defaults)
if(!empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
$tpage->setDynamic2($tpagecontent);
if(!empty($tpagefooter))
    $tpage->setDynamic3($tpagefooter);
//Return the Dynamic Page to the user. 
$tpage->addScriptFile("ajax-review.js");
$tpage->renderPage();