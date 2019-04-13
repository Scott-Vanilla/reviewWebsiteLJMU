<?php

// Include our HTML Page Class
require_once ("oo_page.inc.php");
class MasterPage {
	// -------FIELD MEMBERS----------------------------------------
	private $_htmlpage; // Holds our Custom Instance of an HTML Page
	private $_dynamic_1; // Field Representing our Dynamic Content #1
	private $_dynamic_2; // Field Representing our Dynamic Content #2
	private $_dynamic_3; // Field Representing our Dynamic Content #3
	private $_player_ids;
	
	// -------CONSTRUCTORS-----------------------------------------
	function __construct($ptitle) {
		$this->_htmlpage = new HTMLPage ( $ptitle );
		$this->setPageDefaults ();
		$this->setDynamicDefaults ();
		$this->_player_ids = [ 
				3,
				7,
				8,
				9,
				10,
				11,
				14 
		];
	}
	
	// -------GETTER/SETTER FUNCTIONS------------------------------
	public function getDynamic1() {
		return $this->_dynamic_1;
	}
	public function getDynamic2() {
		return $this->_dynamic_2;
	}
	public function getDynamic3() {
		return $this->_dynamic_3;
	}
	public function setDynamic1($phtml) {
		$this->_dynamic_1 = $phtml;
	}
	public function setDynamic2($phtml) {
		$this->_dynamic_2 = $phtml;
	}
	public function setDynamic3($phtml) {
		$this->_dynamic_3 = $phtml;
	}
	public function getPage(): HTMLPage {
		return $this->_htmlpage;
	}
	
	// -------PUBLIC FUNCTIONS-------------------------------------
	public function createPage() {
		// Create our Dynamic Injected Master Page
		$this->setMasterContent ();
		// Return the HTML Page..
		return $this->_htmlpage->createPage ();
	}
	public function renderPage() {
		// Create our Dynamic Injected Master Page
		$this->setMasterContent ();
		// Echo the page immediately.
		$this->_htmlpage->renderPage ();
	}
	public function addCSSFile($pcssfile) {
		$this->_htmlpage->addCSSFile ( $pcssfile );
	}
	public function addScriptFile($pjsfile) {
		$this->_htmlpage->addScriptFile ( $pjsfile );
	}
	
	// -------PRIVATE FUNCTIONS-----------------------------------
	private function setPageDefaults() {
		$this->_htmlpage->setMediaDirectory ( "css", "js", "fonts", "img", "data" );
		$this->addCSSFile ( "bootstrap.css" );
		$this->addCSSFile ( "site.css" );
		$this->addScriptFile ( "jquery-2.2.4.js" );
		$this->addScriptFile ( "bootstrap.js" );
		$this->addScriptFile ( "holder.js" );
	}
	private function setDynamicDefaults() {
		$tcurryear = date ( "Y" );
		// Set the Three Dynamic Points to Empty By Default.
		$this->_dynamic_1 = "";
		$this->_dynamic_2 = "";
		$this->_dynamic_3 = <<<FOOTER
<p>Scott Hughes: 4122COMP Coursework; {$tcurryear}</p>
FOOTER;
	}
	private function setMasterContent() {
		$tentryhtml = <<<FORM
        <form id="signin" action="" method="post" class="navbar-form navbar-right" role="form">
           <div class="input-group">
               <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
               <input id="email" type="email" class="form-control" name="myname" value="" placeholder="Email"> 
				<input id="password" type="password" class="form-control" name="myname" value="" placeholder="Password">
           		<button type="submit" class="btn btn-secondary">Enter</button>
				</div>
        </form>
FORM;
		
		$texithtml = <<<EXIT
        <a class="btn btn-info navbar-right" href="app_exit.php?action=exit">Exit</a>
EXIT;
		
		$tauth = "";
		if (isset ( $_SESSION ["myuser"] )) {
			$tauth = $texithtml;
		} else {
			$tauth = $tentryhtml;
		}
		$tid = $this->_player_ids [array_rand ( $this->_player_ids, 1 )];
		$tmasterpage = <<<MASTER
<div class="container">
	<div class="header clearfix">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse"
			data-target="#navbarColor02" aria-controls="navbarColor02"
			aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor02">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active"><a class="nav-link" href="index.php">ReviewGO! <span
						class="sr-only">(current)</span></a></li>
				<li class="nav-item"><a class="nav-link" href="reviewlist.php">Game Reviews</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="staff.php">Our Team</a></li>
			</ul>
			{$tauth}
		</div>
	</nav>
	</div>
		{$this->_dynamic_1}
		{$this->_dynamic_2}
    <footer class="footer">
		{$this->_dynamic_3}
	</footer>
</div>        
MASTER;
		$this->_htmlpage->setBodyContent ( $tmasterpage );
	}
}

?>