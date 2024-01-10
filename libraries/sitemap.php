<?php

/**
 * sitemap short summary.
 *
 * sitemap description.
 *
 * @version 1.0
 * @author Mortenaho
 */
class Sitemap
{
    private static $urls=array();
    public $freq;
    public $loc,$priority,$changefreq,$lastmod;
    public function Sitemap()
    {
        $this->freq=new changefreq();
    }

    public function Creat()
    {
        $sitemap='<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach (self::$urls as $item)
        {
        	$sitemap.="<url>";
            $sitemap.="<loc>".$item["loc"]."</loc>";
            $sitemap.="<priority>".$item["priority"]."</priority>";
            $sitemap.="<changefreq>".$item["changefreq"]."</changefreq>";
            $sitemap.="<lastmod>".str_ireplace(array("/","\\"," ",","),"-",$item["lastmod"])  ."</lastmod>";
            $sitemap.="</url>";
        }
        
        $sitemap.='</urlset>';

        return $sitemap;
    }


    public function InsertElement()
    {
        $element=array("loc"=>$this->loc,"priority"=>$this->priority,"changefreq"=>$this->changefreq,"lastmod"=>$this->lastmod);
        array_push(self::$urls,$element);
    }
}


class changefreq
{
    //public $always="always";public $hourly="hourly";
    //public $daily="daily";public $weekly="weekly";
    //public $monthly="monthly";public $yearly="yearly";
    //public $never="never";

    function always()
    {
        return "always";
    }
    
    function hourly()
    {
        return "hourly";
    }
    
    function daily()
    {
        return "daily";
    }
    
    function weekly()
    {
        return "weekly";
    }
    
    function monthly()
    {
        return "monthly";
    }
    
    function yearly()
    {
        return "yearly";
    }
    
    function never()
    {
        return "never";
    }
}

