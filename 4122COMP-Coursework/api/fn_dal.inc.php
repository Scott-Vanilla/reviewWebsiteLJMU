<?php
//Include the Other Layers Class Definitions
require_once("oo_bll.inc.php");
require_once("oo_pl.inc.php");

//---------JSON HELPER FUNCTIONS-------------------------------------------------------

function jsonOne($pfile,$pid)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek($pid-1);
    $tdata = json_decode($tsplfile->current());
    return $tdata;
}

function jsonAll($pfile)
{
    $tentries = file($pfile);
    $tarray = [];
    foreach($tentries as $tentry)
    {
        $tarray[] = json_decode($tentry);
    }
    return $tarray;
}

function jsonNextID($pfile)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek(PHP_INT_MAX);
    return $tsplfile->key() + 1;
}

//---------ID GENERATION FUNCTIONS-------------------------------------------------------

function jsonNextPlayerID()
{
    return jsonNextID("data/json/reviews.json");
}

//---------JSON-DRIVEN OBJECT CREATION FUNCTIONS-----------------------------------------

function jsonLoadOneEmployee($pid) : BLLStaff
{
	$temployee = new BLLStaff();
	$temployee->fromArray(jsonOne("data/json/employee.json",$pid));
	return $temployee;
}

function jsonLoadOneGame($pid) : BLLGame
{
    $treview = new BLLGame();
    $treview->fromArray(jsonOne("data/json/reviews.json",$pid));
    return $treview;
}

function jsonLoadAllGame() : array
{
    $tarray = jsonAll("data/json/reviews.json");
    return array_map(function($a){ $tc = new BLLGame(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllStaff(): array
{
    $tarray = jsonAll("data/json/employee.json");
    return array_map(function($a){ $tc = new BLLStaff(); $tc->fromArray($a); return $tc; },$tarray);
}
?>