<?php
// Disqus comment thread Extension for Bolt

namespace PDFpreview;

class PDFpreviewException extends \Exception {};
class Extension extends \Bolt\BaseExtension
{
    function info()
    {

        $data = array(
            'name' =>"PDFpreview",
            'description' => "Generates a preview image form a PDF File with <code> {{ pdfpre( filename, width, hight ) }} </code>",
            'author' => "blockmurder",
            'link' => "http://blockmurder.ch",
            'version' => "1",
            'required_bolt_version' => "1.0",
            'highest_bolt_version' => "1.0",
            'type' => "Twig function",
            'first_releasedate' => "2014-09-29",
            'latest_releasedate' => "2014-09-29",
        );

        return $data;

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






