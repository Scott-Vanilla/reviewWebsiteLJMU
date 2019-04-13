<?php
require_once ("oo_bll.inc.php");
require_once ("oo_pl.inc.php");

// ===========RENDER BUSINESS LOGIC OBJECTS=======================================================================

// ----------STAFF RENDERING------------------------------------------

function renderStaffTable(BLLStaff $pstaff) {
	$trowdata = "";
	foreach ( $pstaff->stafflist as $tp )
	 $trowdata.=<<<ROW
<tr>
   <td width="110px" class="col-lg-3"><img width="100px" class=" rotateimg90" src="img/staff/{$tp->imgsrc}"/></td>
   
   <td class="col-lg-3">{$tp->role}</td>
   <td class="col-lg-3">{$tp->firstname}</td>
   <td class="col-lg-3">{$tp->surname}</td>
   <td class="col-lg-3"><a class="btn btn-secondary" href="staffprofile.php?id={$tp->id}">Find Out More>>></a></td>
</tr>
ROW;

	 $ttable = <<<TABLE
<table class="table table-striped table-hover">
	<thead class="table-secondary">
		<tr>
			<th>Image</th>
			<th>Job Title</th>
			<th>First Name</th>
			<th>Surname</th>
			<th> </th>
		</tr>
	</thead>
	<tbody>
	{$trowdata}
	</tbody>
</table>
TABLE;
	return $ttable;
}

function renderEmployeeOverview(BLLStaff $tp) {
	$timgref = "img/staff/{$tp->imgsrc}";
	$timg = $timgref;
	$tbio = file_get_contents ( "data/html/bios/{$tp->biographyhref}" );
	$toverview = <<<OV
    <article>

  		<h2 class="card-title">{$tp->firstname} {$tp->surname}</h2>
  		<div class="row">
<div class="col-lg-3">
<br>
<br>
 	<img class="img-thumbnail rotateimg90" src="$timg" width="256" />
  </div>

<div class="col-xl-5">
  <div class="card border-secondary mb-3">
  <div class="card-header">Employee Biography:</div>
  <div class="card-body">
  <p class="card-text">{$tbio}</p>
  		<div class="card border-secondary mb-3">
  <div class="card-header">Job Title</div>
  <div class="card-body">
  <p class="card-text">{$tp->role}</p>
  </div>
</div>
</div>
</div>
</div>


  		
 <div class="col-lg-3">
<br>
 	<img src="img/staff/sociallinks/socialemail.png" width="20px" height="20px" />
  		<p> {$tp -> email} </p>
  		<br>
  	<img src="img/staff/sociallinks/socialphone.png" width="20px" height="20px" />
  		<p> {$tp -> phone} </p>
  </div>
  </div>
  				</div>
  		
  		
  		

    </article>
OV;
	return $toverview;
}





// ----------REVIEWTABLE RENDERING---------------------------------------
function renderReviewTable(BLLRevList $plist) {
	$trowdata = "";
	foreach ( $plist->gamelist as $tp )
	 $trowdata.=<<<ROW
<tr>
   <td>{$tp->gamename}</td>
   <td>{$tp->agerating}</td>
   <td>{$tp->platform}</td>
   <td><a class="btn btn-secondary" href="review.php?id={$tp->id}">Read>>></a></td>
</tr>
ROW;
	
	$ttable = <<<TABLE
<table class="table table-striped table-hover">
	<thead class="table-secondary">
		<tr>
			<th id="sort-name">Game</th>
			<th id="sort-ageno">Age Rating</th>
			<th>Platform</th>
			<th> </th>
		</tr>
	</thead>
	<tbody>
	{$trowdata}
	</tbody>
</table>
TABLE;
	return $ttable;
}

function renderReviewOverview(BLLGame $pg) {
	$timgref = "img/covers/{$pg->id}.jpg";
	$timg = $timgref;
	$tfullreview = file_get_contents ( "data/html/{$pg->id}.html" );
	$texternalreview = file_get_contents ( "data/html/externalreviews/{$pg->id}.html" );
	$toverview = <<<OV
    <article>
    
        <h2> ReviewGO! Gaming Review </h2>
        
  		<h2 class="card-title">{$pg->gamename}</h2>
  		<div class="row">
<div class="col-lg-3">
<br>
   <div class="card border-secondary mb-3">
   <div class="card-body">
 	<img class="img-thumbnail" src="$timg" width="256" />
  </div>
  </div>
</div>
  <div class="col-lg-4">
  <br>
  <div class="card border-secondary mb-3">
  <div class="card-header">Age Rating:</div>
  <div class="card-body">
  <p class="card-text">{$pg->agerating}</p>
  </div>
  <div class="card-header">Platform:</div>
  <div class="card-body">
  <p class="card-text">{$pg->platform}</p>
  </div>
  <div class="card-header">Genre:</div>
  <div class="card-body">
  <p class="card-text">{$pg->genre}</p>
  </div>
</div>
</div>

	<div class="col-lg-4">
	<a class="twitter-timeline"  href="{$pg->twitterlink}" data-widget-id="{$pg->twitterid}">#{$pg->gamename} Tweets</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          
	</div>

  </div>
            		
  <div class="card border-secondary mb-3">
  <div class="card-header">Editorial Review:</div>
  <div class="card-body">
  <p class="card-text">{$tfullreview}</p>
  </div>
  </div>
    		
    <div class="card border-secondary mb-3">
  <div class="card-header">External Review:</div>
  <div class="card-body">
  <p class="card-text">{$texternalreview}</p>
  </div>
  		
    </article>
OV;
	return $toverview;
}



// =============RENDER PRESENTATION LOGIC OBJECTS==================================================================
function renderUICarousel(array $pimgs, $pimgdir, $pid = "mycarousel") {
	$tci = "";
	$count = 0;
	
	// -------Build the Images---------------------------------------------------------
	foreach ( $pimgs as $titem ) {
		$tactive = $count === 0 ? " active" : "";
		$thtml = <<<ITEM
        <div class="item{$tactive}">
            <img class="img-responsive" src="{$pimgdir}/{$titem->img_href}">
            <div class="container">
                <div class="carousel-caption">
                    <h1>{$titem->title}</h1>
                    <p class="lead">{$titem->lead}</p>
		        </div>
			</div>
	    </div>
ITEM;
		$tci .= $thtml;
		$count ++;
	}
	
	// --Build Navigation-------------------------
	$tdot = "";
	$tdotset = "";
	$tarrows = "";
	
	if ($count > 1) {
		for($i = 0; $i < count ( $pimgs ); $i ++) {
			if ($i === 0)
				$tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\" class=\"active\"></li>";
			else
				$tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\"></li>";
		}
		$tdotset = <<<INDICATOR
        <ol class="carousel-indicators">
        {$tdot}
        </ol>
INDICATOR;
	}
	if ($count > 1) {
		$tarrows = <<<ARROWS
		<a class="left carousel-control" href="#{$pid}" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#{$pid}" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
ARROWS;
	}
	
	$tcarousel = <<<CAROUSEL
    <div class="carousel slide" id="{$pid}">
            {$tdotset}
			<div class="carousel-inner">
				{$tci}
			</div>
		    {$tarrows}
    </div>
CAROUSEL;
	return $tcarousel;
}
function renderUITabs(array $ptabs, $ptabid) {
	$count = 0;
	$ttabnav = "";
	$ttabcontent = "";
	
	foreach ( $ptabs as $ttab ) {
		$tnavactive = "";
		$ttabactive = "";
		if ($count === 0) {
			$tnavactive = " class=\"active\"";
			$ttabactive = " active in";
		}
		$ttabnav .= "<li{$tnavactive}><a href=\"#{$ttab->tabid}\" data-toggle=\"tab\">{$ttab->tabname}</a></li>";
		$ttabcontent .= "<article class=\"tab-pane fade{$ttabactive}\" id=\"{$ttab->tabid}\">{$ttab->content}</article>";
		$count ++;
	}
	
	$ttabhtml = <<<HTML
        <ul class="nav nav-tabs">
        {$ttabnav}
        </ul>
    	<div class="tab-content" id="{$ptabid}">
			  {$ttabcontent}
		</div>
HTML;
	return $ttabhtml;
}
function renderUIQuote(PLQuote $pquote) {
	$tquote = <<<QUOTE
    <blockquote>
    {$pquote->quote}
    <small>{$pquote->person} in <cite title="{$pquote->source}">{$pquote->pub}</cite></small>
	</blockquote>
QUOTE;
	return $tquote;
}
function renderUIHomeArticle(PLHomeArticle $phome, $pwidth = 6) {
	$thome = <<<HOME
    <article class="col-lg-{$pwidth}">
		<h2>{$phome->heading}</h2>
		<h4>
			<span class="label label-success">{$phome->tagline}</span>
		</h4>
		<div class="home-thumb">
			<img src="img/{$phome->storyimg_href}" />
		</div>
		<div>
		  <strong>
			{$phome->summary}
		  </strong>
		</div>
        <div>
		    {$phome->content}
        </div>
        <div class="options details">
			<a class="btn btn-info" href="{$phome->link}">{$phome->linktitle}</a>
        </div>
	</article>
HOME;
	return $thome;
}
function renderUIKeyPlayersList(array $pkeyplayers) {
	$tkeylist = "";
	foreach ( $pkeyplayers as $tkey ) {
		$tli = <<<LI
        <section class="list-group-item">
            <h4 class="list-group-item-heading">
                <a href="player.php?name={$tkey->key_href}">{$tkey->name}</a>
            </h4>
            <p class="list-group-item-text">{$tkey->desc}</p>
        </section>            
LI;
		$tkeylist .= $tli;
	}
	
	$tpanel = <<<PANEL
    <div class="panel panel-default">
        <div class="panel-heading">Key Players</div>
        <div class="panel-body">
        <div class="list-group">
        {$tkeylist}   
        </div>        
PANEL;
	return $tpanel;
}
function renderUIStatistics(array $pstats) {
	$tstats = "";
	foreach ( $pstats as $tstat ) {
		$tstats .= <<<STAT
        <li class="list-group-item">
            <span class="badge">{$tstat->value}</span>
            <strong>{$tstat->stat}: </strong>
            <a href="player.php?name={$tstat->ref}">{$tstat->holder}</a>
        </li>
STAT;
	}
	
	$tpanel = <<<PANEL
    <div class="well well-lg">
        <ul class="list-group">
            {$tstats}
        </ul>
    </div>

PANEL;
	return $tpanel;
}
function renderUIGoogleMap($plong, $plat) {
	$tmaphtml = <<<MAP
    <iframe width="100%" height="100%"
                        frameborder="1" scrolling="no" marginheight="0"
                        marginwidth="0"
                        src="http://maps.google.com/maps?f=q&amp;
                        source=s_q&amp;hl=en&amp;
                        geocode=&amp;q={$plong},{$plat}
                        &amp;output=embed"></iframe>
MAP;
	return $tmaphtml;
}

?>