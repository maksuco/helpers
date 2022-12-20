<?php
namespace Maksuco\Helpers\Traits;
use OzdemirBurak\Iris\Color\Hex;
use OzdemirBurak\Iris\Color\Hexa;

trait Colors {


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

    public function gradientCSS($firstColor,$secondColor=false,$angle=160,$percentage=20,$opacity=0,$amount=15) {
        if(is_string($firstColor)) {
            $firstColor = $this->checkHEX($firstColor);
            if($firstColor==false){ return false; };
        } elseif($firstColor !== false) {
            $firstColor = $firstColor->toHexa(); 
        }
        if($secondColor==false){
            $secondColor = $this->spinColor($firstColor,15,$amount)->fadeOut($opacity);
        }
        return 'linear-gradient('.$angle.'deg, '.$firstColor.' '.$percentage.'%, '.$secondColor.' 100%)';
    }

    public function gradientCSS2($firstColor,$color2=false,$opacity=0) {
        if(is_string($firstColor)) {
            $firstColor = $this->checkHEX($firstColor);
            if($firstColor==false){ return false; };
        } else {
            $firstColor = $firstColor->toHexa(); 
        }
        $secondColor = $this->spinColor($firstColor,30,1)->fadeOut($opacity);
        if($color2) {
            $temp_radial1 = new Hexa($color2);
            $radial1_dist = 100;
        } else {
            $temp_radial1 = new Hexa($color);
            $radial1_dist = 150;
        }
        $radial1 = $temp_radial1->spin(180)->fade(50);

        //$radial1 = $this->spinColor($color,30,70);
        $radial2 = $this->spinColor($firstColor,30,30)->lighten(70)->fade(50);
        // $radial1Out = $radial1->fade(0);
        // $radial2Out = $radial2->fade(0);
        return <<<HTML
            radial-gradient(circle at $radial1_dist% 65%, $radial1 0%, transparent 70%), 
            radial-gradient(circle at -40% 30%, $radial2 0%, transparent 80%), 
            linear-gradient(180deg, $firstColor 0%, $secondColor 99.72%);
        HTML;
    }

    public function spinColor($color,$value=30,$change=0) {
        $color = new Hexa($color);
        if($color->isLight()){
            return $color->darken($change)->spin($value*.5);
        }
        return $color->lighten($change)->spin($value*.8);
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
        ray('color alphaColor 3',$color->fade(30)->toHexa(),$opacity);
        return $color->fade($opacity)->toHexa();
    }

    public function color($color,$function='fade',$amount=0) {
        $color = $this->newColor($color);
        return $color->$function($amount);
    }
    
    public function newColor($color) {
        $color = str_replace("#", "", $color);
        if($color=='transparent' || empty($color)) {
            $color = 'FFFFFF00';
        }
        if(ctype_xdigit($color) && strlen($color)>5){
            $color = str_starts_with($color, '#')? $color : '#'.$color;
        }
        // ray()->clearAll();
        // ray('color hex',$color);
        // ray()->pause();
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
            box-shadow: 0 0.75rem 2rem 0 rgba(var(--header-bg_color), 0.1);
            border: 1px solid rgba(255, 255, 255, 0.125);
        HTML;
    }

    //use it with .overlay-var
    public function bgBlend($imgUrl,$color,$opacity=60,$gradient=false) {
        //$color = str_replace("#", "", $color);
        $color = $this->color($color,'fade',$opacity);
        // if(ctype_xdigit($color) && strlen($color)>5){
        //     return str_starts_with($color, '#')? $color : '#'.$color;
        // }
        // return ($gradient)? $this->gradientCSS($color) : $color;
        $colorCSS = ($gradient)? $this->gradientCSS($color) : 'linear-gradient('.$color.','.$color.')';
        ray('bgBlend',$gradient,$opacity,$colorCSS,$color,$this->gradientCSS($color));
        return <<<HTML
            $colorCSS, 
            url('$imgUrl');
        HTML;
    }



    public function mesh($firstColor,$color2=false,$opacity=0) {
        $firstColor = new Hexa($firstColor);
        $variant1 = (new Hexa('#FFB879'))->mix($firstColor, 5)->fade(85); //light orange
        //$variant1 = $firstColor->spin(10)->mix($firstColor, 5)->fade(60); //light orange
        $variant2 = (new Hexa('#1CDDFF'))->mix($firstColor, 5)->fade(70); //light blue
        //$variant3 = $firstColor->spin(140)->mix($firstColor, 5)->tint(70)->fade(60); //piel
        $variant3 = (new Hexa('#FFDBDE'))->mix($firstColor, 5)->fade(80); //piel
        //$variant4 = $firstColor->spin(120)->mix($firstColor, 5)->tint(32)->fade(60); //red
        $variant4 = (new Hexa('#FF85AD'))->mix($firstColor, 5)->fade(90); //red
        //$variant5 = $firstColor->spin(15)->mix($firstColor, 5)->tint(12)->fade(60); //blue
        $variant5 = (new Hexa('#6B66FF'))->mix($firstColor, 5)->fade(80); //blue
        //$variant2 = $this->spinColor($firstColor,30,30)->lighten(70)->fade(50);
        return <<<HTML
            background-color: {$firstColor};
            background-image:
            radial-gradient(at 40% 20%, {$variant1} 0px, transparent 50%),
            radial-gradient(at 80% 0%, {$variant2} 0px, transparent 50%),
            radial-gradient(at 0% 50%, {$variant3} 0px, transparent 50%),
            radial-gradient(at 80% 50%, {$variant4} 0px, transparent 50%),
            radial-gradient(at 0% 100%, {$variant1} 0px, transparent 50%),
            radial-gradient(at 80% 100%, {$variant5} 0px, transparent 50%),
            radial-gradient(at 0% 0%, {$variant4} 0px, transparent 50%);
        HTML;
    }


}
