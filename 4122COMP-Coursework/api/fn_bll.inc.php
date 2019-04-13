<?php

require_once("oo_bll.inc.php");

function initSessionData()
{
    $tsession = ["name","last-access","fav-club"];
    foreach($tsession as $tsessionkey)
    {
        $_SESSION[$tsessionkey] = "";
    }
}

function destroySession()
{
    //Make a call to session destroy
    session_destroy();
}

function processRequest($pdata)
{
    $tdata = trim($pdata);
    $tdata = stripslashes($tdata);
    $tdata = htmlspecialchars($tdata);
    return $tdata;
}

function paginateArray(array $parray,$ppageno,$pnoitems)
{
        $tpageno = $ppageno < 1 ? 1 : $ppageno;
        $tstart = ($tpageno - 1) * $pnoitems;
        return array_slice($parray, $tstart, $pnoitems);
}

function paginateArray2(array $parray, $ppageno,$pnoitems)
{
    $tarrayofpages = array_chunk($parray, $pnoitems);
    return $ppageno > sizeof($tarrayofpages) ? [] : $tarrayofpages[$ppageno - 1];
}
    
?>