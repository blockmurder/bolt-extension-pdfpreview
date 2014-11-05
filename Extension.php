<?php
// Disqus comment thread Extension for Bolt

namespace Bolt\Extension\blockmurder\pdfPreview;

use Bolt\Application;

class Extension extends \Bolt\BaseExtension
{
    public function getName()
    {
        return "pdfPreview";
    }

    function initialize()
    {

        $this->addTwigFunction('pdfpre', 'pdfpre');
        if (empty($this->config['thumbnail_folder'])) { $this->config['thumbnail_folder'] = "pdf_temp/"; }
    }


    function pdfpre($file="", $width=100, $height=0)
    {
    

        $thumb_path = $this->app['paths']['filespath'].'/'.$this->config['thumbnail_folder'];
        if(!is_dir($thumb_path)) {
            mkdir($thumb_path , 0777);
        }        
        
        $path_parts = pathinfo($this->app['paths']['filespath'].$file);
        $filename = $path_parts['filename'];
        $filepath = $path_parts['dirname'];
        
        if (!file_exists($thumb_path.$filename.'.jpg')) {   
            exec('convert "'.$this->app['paths']['filespath'].'/'.$file.'[0]" -colorspace RGB -density 300 -quality 95 -background white -alpha remove -geometry '.$width.' -border 2x2 -bordercolor "#efefef" '.$thumb_path.$filename.'.jpg');
        }
        
        $html = <<< EOM
        <img src="%src%" alt="%alt%"> 

EOM;


        $html = str_replace("%src%", $this->app['paths']['files'].$this->config['thumbnail_folder'].$filename.'.jpg', $html);
        $html = str_replace("%alt%", $filename, $html);

        return new \Twig_Markup($html, 'UTF-8');

    }


}






