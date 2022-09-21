<?php
namespace Maksuco\Helpers\Traits;
use OzdemirBurak\Iris\Color\Hex;
use OzdemirBurak\Iris\Color\Hexa;

trait Colors {


    public function gradientCSS($firstColor,$secondColor=false,$angle=160,$percentage=20,$opacity=0,$amount=15) {
        $firstColor = $this->checkHEX($firstColor); 
        if($firstColor==false){ return false; };
        if($secondColor==false){
            $secondColor = $this->spinColor($firstColor,15,$amount)->fadeOut($opacity);
        }
        return 'linear-gradient('.$angle.'deg, '.$firstColor.' '.$percentage.'%, '.$secondColor.' 100%)';
    }

    public function gradientCSS2($color,$color2=false,$opacity=0) {
        $color = $this->checkHEX($color); 
        if($color==false){ return false; };
        $secondColor = $this->spinColor($color,30,1)->fadeOut($opacity);
        if($color2) {
            $temp_radial1 = new Hexa($color2);
            $radial1_dist = 100;
        } else {
            $temp_radial1 = new Hexa($color);
            $radial1_dist = 150;
        }
        $radial1 = $temp_radial1->spin(180)->fade(50);

        //$radial1 = $this->spinColor($color,30,70);
        $radial2 = $this->spinColor($color,30,30)->lighten(70)->fade(50);
        // $radial1Out = $radial1->fade(0);
        // $radial2Out = $radial2->fade(0);
        return <<<HTML
            radial-gradient(circle at $radial1_dist% 65%, $radial1 0%, transparent 70%), 
            radial-gradient(circle at -40% 30%, $radial2 0%, transparent 80%), 
            linear-gradient(180deg, $color 0%, $secondColor 99.72%);
        HTML;
    }

    public function spinColor($color,$value=30,$change=0) {
        $color = new Hexa($color);
        if($color->isLight()){
            return $color->darken($change)->spin($value*.5);
        }
        return $color->lighten($change)->spin($value);
    }

    public function mixColor($firstColor,$secondColor,$value=50) {
        $firstColor = $this->checkHEX($firstColor); 
        if($firstColor==false){ return false; };
        $color = new Hex($firstColor);
        return $color->mix(new Hex($secondColor), $value);
    }

    public function alphaColor($color,$opacity=0) {
        $color = $this->newColor($color); 
        if($color==false){ return false; };
        return $color->fadeIn($opacity);
    }

    public function color($color,$function='fade',$amount=0) {
        $color = $this->newColor($color);
        return $color->$function($amount);
    }

    public function checkHEX($color) {
        $color = str_replace("#", "", $color);
        if($color=='transparent') {
            $color = 'FFFFFF00';
        }
        if(ctype_xdigit($color) && strlen($color)>5){
            return str_starts_with($color, '#')? $color : '#'.$color;
        }
        return false;
    }
    public function newColor($color) {
        $color = str_replace("#", "", $color);
        if($color=='transparent') {
            $color = 'FFFFFF00';
        }
        if(ctype_xdigit($color) && strlen($color)>5){
            $color = str_starts_with($color, '#')? $color : '#'.$color;
        }
        if(strlen($color)>7){
            return new Hexa($color);
        } else {
            return new Hex($color);
        }
        return false;
    }

    public function bgBlur($color,$blur=10,$gradient=false) {
        $color = $this->color($color,'fade',20);
        // $color = new Hex($color);
        // $color = $color->fade(20);
        $blur = $blur.'px';
        $colorCSS = ($gradient)? 'background-image:'.$this->gradientCSS($color) : 'background-color:'.$color;
        return <<<HTML
            $colorCSS !important;
            -webkit-backdrop-filter: blur($blur);
            backdrop-filter: blur($blur);
        HTML;
    }

    public function bgBlend($color,$opacity,$gradient=false) {
        $color = str_replace("#", "", $color);
        if(ctype_xdigit($color) && strlen($color)>5){
            return str_starts_with($color, '#')? $color : '#'.$color;
        }
        return false;
    }



}
