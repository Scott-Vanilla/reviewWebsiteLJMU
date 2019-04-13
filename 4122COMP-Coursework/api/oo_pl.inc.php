<?php
class PLQuote extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $person;
    public $pub;
    public $source;
    public $quote_href; //STORE LINKS TO EXTERNAL ITEMS
    public $quote;      //LOAD THE DATA INTO HERE.
}

class PLHomeArticle extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $heading;
    public $tagline;   
    public $content;
    public $summary;
    public $storyimg_href;
    public $article_href;
    public $link;
    public $linktitle;
}

class PLCarouselImage extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $img_href;
    public $title;
    public $lead;
    
    //-------CONSTRUCTOR--------------------
}

class PLKeyPlayerItem extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $name;
    public $key_href;
    public $desc;
}

class PLTab extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $tabid;
    public $tabname;
    public $content;  
    public $content_href;
}

class PLStatistic extends SimpleXMLElement
{
    //-------CLASS FIELDS------------------
    public $stat;
    public $value;
    public $holder;
    public $stat_href;
}
?>