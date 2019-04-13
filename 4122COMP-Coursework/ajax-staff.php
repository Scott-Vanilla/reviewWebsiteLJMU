<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----PAGE GENERATION LOGIC---------------------------

function createStaffElement()
{     
    //Get Business Logic Data we need - in this case, build a list of staff/employees.
    $tstaff = new BLLStaff();
    $tstaff->stafflist = jsonLoadAllStaff();
    
    //Render the HTML for our Table and our Pagination Controls
    $tstafftable = renderStaffTable($tstaff);
  
//Generate our Squad Table
$tcontent = <<<PAGE
	{$tstafftable}
PAGE;
	

return $tcontent;
}

$tcurrpage = $_REQUEST["page"] ?? 1;
$tcurrpage = is_numeric($tcurrpage) ? $tcurrpage: 1;
$tsortmode = $_REQUEST["sortmode"] ?? "id";
$tsortorder = $_REQUEST["sortorder"] ?? "asc";

if(isset($_REQUEST["ajax"])){
$tajaxresponse = createReviewListElement($tcurrpage,$tsortmode,$tsortorder);
echo $tajaxresponse;
}
?>