<?php
function prepareArray($config){
    //HEADINGS
    $configBase['headingFont'] = 'sans';
    $configBase['headingWeight'] = 'bold';
    $configBase['extraFile'] = false;
    for ($i = 1; $i <= 6; $i++) {
        $configBase["headingFont{$i}"] = $configBase['headingFont'];
        $configBase["headingWeight{$i}"] = $configBase['headingWeight'];
    }
    //BTN
    $configBase['btnRadius'] = 'rounded';
    $configBase['badgeRadius'] = 'rounded-full';
    $configBase['btnShadow'] = '';
    $configBase['btnRing'] = '';
    $configBase['btnBorder'] = 'border';
    $configBase['btnBorderColor'] = 'brand-200';
    $configBase['btnBgColor'] = 'gray-400';
    $configBase['btnPaddingY'] = 2;
    $configBase['btnPaddingX'] = 5;
    $configBase['btnWeight'] = 'normal';
    //FORMS
    $configBase['formText'] = 'gray-500'; //"slate-50"
    $configBase['formTextDark'] = 'gray-200'; //"slate-50"
    $configBase['labelColor'] = $configBase['formText'];
    $configBase['labelColorDark'] = 'gray-300';
    $configBase['formBG'] = 'slate-100'; //"light"
    $configBase['formBGDark'] = 'slate-600'; //"light"
    $configBase['formBorder'] = 'border';
    $configBase['formBorderColor'] = 'gray-300';
    $configBase['formBorderColorDark'] = 'gray-500';
    //BOXES
    $configBase['boxRadius'] = 'rounded-3xl';
    //DROPDOWN
    $configBase['dropdownRadius'] = 'rounded-xl';
    $configBase['dropdownTextColor'] = 'gray';
    $configBase['dropdownItemsBG'] = 'light'; //"slate-50"
    //COLORES
    $configBase['colors'] = [
        'brand' => ['text' => 500,'bg' => 500,'border' => 400],
        'slate' => ['text' => 500,'bg' => 400,'border' => 600],
        'gray' => ['text' => 500,'bg' => 400,'border' => 600],
        'zinc' => ['text' => 500,'bg' => 400,'border' => 600],
        'neutral' => ['text' => 500,'bg' => 400,'border' => 600],
        'stone' => ['text' => 500,'bg' => 400,'border' => 600],
        'red' => ['text' => 500,'bg' => 500,'border' => 400],
        'orange' => ['text' => 500,'bg' => 500,'border' => 400],
        'amber' => ['text' => 500,'bg' => 500,'border' => 400],
        'yellow' => ['text' => 500,'bg' => 500,'border' => 400],
        'lime' => ['text' => 500,'bg' => 500,'border' => 400],
        'green' => ['text' => 500,'bg' => 500,'border' => 400],
        'emerald' => ['text' => 500,'bg' => 500,'border' => 400],
        'teal' => ['text' => 500,'bg' => 500,'border' => 400],
        'cyan' => ['text' => 500,'bg' => 500,'border' => 400],
        'sky' => ['text' => 500,'bg' => 500,'border' => 400],
        'blue' => ['text' => 500,'bg' => 500,'border' => 400],
        'indigo' => ['text' => 500,'bg' => 500,'border' => 400],
        'violet' => ['text' => 500,'bg' => 500,'border' => 400],
        'purple' => ['text' => 500,'bg' => 500,'border' => 400],
        'fuchsia' => ['text' => 500,'bg' => 500,'border' => 400],
        'pink' => ['text' => 500,'bg' => 500,'border' => 400],
        'rose' => ['text' => 500,'bg' => 500,'border' => 400],
    ];
    //THEME
    $dark = $config['darkColor'] ?? '#101827';
    $hex = new \OzdemirBurak\Iris\Color\Hex($dark);
    $configBase['light'] = [
        'bg' => $hex->lighten(96)->desaturate(15),
        'box' => $hex->lighten(97)->desaturate(5),
        'title' => $hex->shade(10),
        'subtitle' => $hex->lighten(50)->desaturate(35)->tint(5),
        'body' => $hex->lighten(25)->desaturate(17)->darken(4),
        //'body-light' => $hex->lighten(30)->brighten(22),
        'label' => $hex->lighten(15)->saturate(20)->tint(40),
        'form-basic-bg' => '#ffffff',
        'form-basic-border' => $hex->lighten(50)->tint(70),
        'form-muted-bg' => $hex->lighten(85),
        'light' => $hex->lighten(85)->brighten(2)
    ];
    $configBase['light']['form-basic-text'] = $configBase['light']['form-muted-text'] = $configBase['light']['body'];
    $configBase['dark'] = [
        'bg' => $dark,
        'box' => $hex->lighten(5)->desaturate(5)->__toString(),
        'title' => $hex->tint(40)->lighten(43)->brighten(8),
        'subtitle' => $hex->lighten(35)->desaturate(5)->brighten(18),
        'body' => $hex->tint(20)->lighten(35)->desaturate(5)->brighten(18),
        //'body-light' => $hex->lighten(30)->brighten(18),
        'label' => $hex->lighten(80)->shade(10),
        'form-basic-bg' => $hex->lighten(18)->desaturate(25),
        'form-basic-border' => $hex->lighten(30)->brighten(15),
        'form-muted-bg' => $hex->lighten(14)->desaturate(14),
        'light' => $hex->lighten(10)->desaturate(15)
    ];
    $configBase['dark']['form-basic-text'] = $configBase['dark']['form-muted-text'] = $configBase['dark']['body'];
    //BACKEND
    $configBase['backend'] = false;
    return array_merge($configBase, $config);
}

function minPadding($value,$variant,$min=0.25,$max=false){
    $x = (($value > $variant)? $value - $variant : 1) * 0.25;
    $x = ($x > $min)? $x : $min;
    if($max){
        $x = ($x < $max)? $x : $max;
    }
    return $x;
}
?>