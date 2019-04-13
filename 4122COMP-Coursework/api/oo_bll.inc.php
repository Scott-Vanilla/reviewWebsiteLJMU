<?php

class BLLGame 
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $gamename;
    public $agerating;
    public $platform;
    public $genre;
    public $fullreview;
    public $twitterlink;
    public $twitterid;
    
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLListItem
{
    //-------CLASS FIELDS------------------
	public $id = null;
	public $gamename;
    
	
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLStaff
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $imgsrc;
    public $firstname;
    public $surname;
    public $role;
    public $biographyhref;
    public $email;
    public $phone;
    
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLRevList
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $gamelist;
    public $agerating;
    public $platform;
    
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

?>