<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($preview)
{
	$tgamereview = "";
	foreach($preview as $tg)
	{
		$tgamereview .= renderReviewOverview($tg);
	}
	$tcontent = <<<PAGE
      {$tgamereview}
	<div id="disqus_thread"></div>
<script>

var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};

(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://reviewgo-1.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<script id="dsq-count-scr" src="//reviewgo-1.disqus.com/count.js" async></script>                   
PAGE;
      return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$treviews = [];
$tid = $_REQUEST["id"] ?? -1;
$tname = $_REQUEST["name"] ?? "";


//Handle our Requests and Search for reviews
if (is_numeric($tid) && $tid > 0)
{
	$treview = jsonLoadOneGame($tid);
	$treviews[] = $treview;
}
else if (!empty($tname))
{
	//Filter the name
	$tname = processRequest($tname);
	$tgamelist = jsonLoadAllGames();
	foreach ($tgamelist as $tg)
	{
		if (strtolower($tg->gamename) === strtolower($tname))
		{
			$treviews[] = $tg;
		}
	}
}

//Page Decision Logic - Have we found a review?
if (count($treviews)===0)
{
	header("Location: app_error.php");
}
else
{
	//We've found our review
	$tpagecontent = createPage($treviews);

	$tpagetitle = "Review Page";
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