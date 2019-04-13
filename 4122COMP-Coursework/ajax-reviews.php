<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----SORTING FUNCTIONS-------------------------------
function reviewsortbyno($a,$b)
{
    if($a->id > $b->id)
        return 1;
    else if($a->id < $b->id)
        return -1;
    else 
        return 0;
}

function reviewsortbyname($a,$b)
{
    return strcmp($a->gamename,$b->gamename);
}

$tsortfunc="";
if($psortmode == "agerating")
{
	$tsortfunc = "reviewsortbyno";
}
else if($psortmode == "gamename")
{
	$tsortfunc = "reviewsortbyname";
}

//Only sort the function if we have a valid func name
if (!empty($tsortfunc))
{
	usort($tlist->gamelist,$tsortfunc);
}
//----PAGE GENERATION LOGIC---------------------------
function createPagination($pno,$pcurr)
{
    if($pno <= 1)
        return "";    
    $titems = "";
    $tld= $pcurr == 1 ? " class=\"disabled\"" : "";
    $trd = $pcurr == $pno ? " class=\"disabled\"" : "";
    
    $tprev = $pcurr - 1;
    $tnext = $pcurr + 1;
    
    $tprevitem = "<li$tld><a href=\"reviewlist.php?page={$tprev}\">&laquo;</a></li>";
    for($i = 1; $i <=$pno; $i++)
    {   
        $ta = $pcurr == $i? " class=\"active\"" : "";
        $titems .= "<li$ta><a id=\"sq-{$i}\" href=\"reviewlist.php?page={$i}\">{$i}</a></li>"; 
    }
    $tnextitem = "<li$trd><a href=\"reviewlist.php?page={$tnext}\">&raquo;</a></li>";
    
    $tmarkup = <<<NAV
    <div>
    
    <ul class="pagination">
    
    <li id="sq-prev">
    <button class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Previous Page >>">
    	{$tprevitem}
    </button>
    </li>
    
    <li id="sq-page">
    <button class="btn btn-secondary">
        {$titems}
    </button>
    </li>
 
    <li id="sq-next">
    <button class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Next Page >>">
        {$tnextitem}
    </button>
    </li>
        		
    </ul>
    </div>
NAV;
    return $tmarkup;
}

function createReviewListElement($pcurrpage,$psortmode,$psortorder)
{     
    //Get Business Logic Data we need - in this case, build a list of reviews
    $tlist = new BLLRevList();
    $tlist->gamelist = jsonLoadAllGame();
    
    //We need to sort the review list using our custom class-based sort function
    
    //The pagination working out how many elements we need and
    $tnoitems  = sizeof($tlist->gamelist);
    $tperpage  = 5;
    $tnopages  = ceil($tnoitems/$tperpage);
    
    //Create a Pagniated Array based on the number of items and what page we want.
    $tfiltergames = paginateArray($tlist->gamelist,$pcurrpage,$tperpage);
    $tlist->gamelist = $tfiltergames;
    
    //Render the HTML for our Table and our Pagination Controls
    $treviewtable = renderReviewTable($tlist);
    $tpagination = createPagination($tnopages,$pcurrpage);
  
//Generate our Squad Table
$tcontent = <<<PAGE
	{$treviewtable}
	{$tpagination}
	<div id="ajax-fields" hidden>
	   <span id="ajax-page">$pcurrpage</span>
	   <span id="ajax-sm">$psortmode</span>
	   <span id="ajax-so">$psortorder</span>
	</div>	
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