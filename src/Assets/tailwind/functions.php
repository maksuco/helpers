<?php
function prepareArray($config){
    //COLORES
    $configBase['colors'] = [
        'brand' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'slate' => ['text' => 500,'bg' => 400,'border' => 600,'bgVariant' => 100],
        'gray' => ['text' => 500,'bg' => 400,'border' => 600,'bgVariant' => 50],
        'zinc' => ['text' => 500,'bg' => 400,'border' => 600,'bgVariant' => 50],
        'neutral' => ['text' => 500,'bg' => 400,'border' => 600,'bgVariant' => 50],
        'stone' => ['text' => 500,'bg' => 400,'border' => 600,'bgVariant' => 50],
        'red' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'orange' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 100],
        'amber' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'yellow' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 100],
        'lime' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 100],
        'green' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'emerald' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'teal' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'cyan' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'sky' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'blue' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'indigo' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'violet' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'purple' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'fuchsia' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'pink' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
        'rose' => ['text' => 500,'bg' => 500,'border' => 400,'bgVariant' => 50],
    ];
    //THEME
    $dark = $config['darkColor'] ?? '#101827';
    $hex = new \OzdemirBurak\Iris\Color\Hex($dark);
    $configBase['bg'] = $hex->lighten(96)->desaturate(15);
    $configBase['box'] = $hex->lighten(97)->desaturate(5);
    $configBase['title'] = $hex->shade(10);
    $configBase['subtitle'] = $hex->lighten(50)->desaturate(35)->tint(5);
    $configBase['body'] = $hex->lighten(25)->desaturate(17)->darken(4);
    $configBase['label'] = $hex->lighten(15)->saturate(20)->tint(40);
    $configBase['form-basic-bg'] = '#ffffff';
    $configBase['form-basic-border'] = $hex->lighten(50)->tint(70);
    $configBase['form-muted-bg'] = $hex->lighten(85);

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
    //CONTAINERS
    $configBase["containerMinWidth"] = "max-w-screen-lg";
    $configBase["containerWidth"] = "max-w-screen-xl";
    $configBase["containerMaxWidth"] = "max-w-screen-2xl";
    //HEADINGS
    $configBase['headingColor'] = 'text-['.$configBase['light']['title'].']';
    $configBase['headingFont'] = 'sans';
    $configBase['headingWeight'] = 'bold';
    for ($i = 1; $i <= 6; $i++) {
        $configBase["headingFont{$i}"] = $config['headingFont'] ?? $configBase['headingFont'];
        $configBase["headingWeight{$i}"] = $config['headingWeight'] ?? $configBase['headingWeight'];
    }
    $configBase["headingSize1"] = "text-5xl md:text-6xl lg:text-7xl";
    $configBase["headingSize2"] = "text-4xl md:text-5xl lg:text-6xl";
    $configBase["headingSize3"] = "text-3xl md:text-4xl lg:text-5xl";
    $configBase["headingSize4"] = "text-2xl md:text-3xl lg:text-4xl";
    $configBase["headingSize5"] = "text-xl md:text-2xl lg:text-3xl";
    $configBase["headingSize6"] = "text-lg md:text-xl lg:text-2xl";
    //BTN
    $configBase['btnRadius'] = 'rounded';
    $configBase['badgeRadius'] = $configBase['btnRadius'];
    $configBase['btnShadow'] = '';
    $configBase['btnRing'] = '';
    $configBase['btnBorder'] = 'border';
    $configBase['btnBorderColor'] = 'brand-200';
    $configBase['btnBgColor'] = 'gray-400';
    $configBase['btnPaddingY'] = 1.5;
    $configBase['btnPaddingX'] = 4;
    $configBase['btnWeight'] = 'normal';
    $configBase['btnExtras'] = '';
    //FORMS
    $configBase['formText'] = 'gray-500'; //"slate-50"
    $configBase['formTextDark'] = 'gray-200'; //"slate-50"
    $configBase['labelColor'] = $configBase['formText'];
    $configBase['labelCSS'] = '';
    $configBase['labelColorDark'] = 'gray-300';
    $configBase['formBG'] = 'slate-100'; //"light"
    $configBase['formBGDark'] = 'slate-600'; //"light"
    $configBase['formRadius'] = $configBase['btnRadius'];
    $configBase['formBorder'] = 'border';
    $configBase['formBorderColor'] = 'gray-300';
    $configBase['formBorderColorDark'] = 'gray-500';
    //BOXES
    $configBase['boxRadius'] = 'rounded-3xl';
    //DROPDOWN
    $configBase['dropdownRadius'] = 'rounded-xl';
    $configBase['dropdownTextColor'] = 'gray';
    $configBase['dropdownItemsBG'] = 'light'; //"slate-50"
    //BACKEND
    $configBase['backend'] = false;
    $configBase['components'] = false;
    $configBase['extraFiles'] = [];
    //EMAILS
    $configBase['emails'] = false;
    $configBase['email-text'] = 'text-gray-600';
    $configBase['email-bg'] = 'bg-light';
    $configBase['email-padding'] = 'p-1 md:p-2';
    $configBase['email-content'] = 'bg-white p-4';
    $configBase['email-align'] = 'text-center';
    $configBase['email-logo-height'] = 'max-w-[90px] max-h-[60px]';
    return array_merge($configBase, $config);
}


function backendConfig($config){
    $base = (is_array($config['backend']))? $config['backend'] : [];
    $backend = [];
    $backend["bg"] = '#f8fafc';
    $backend["body"] = '#19212B';
    $backend["headerHeight"] = '60px';
    $backend["headerLogoHeight"] = ((float) $backend['headerHeight'] * 0.8) . 'px';
    $backend["headerBody"] = '#e1e1e1';
    $backend["headerBG"] = '#f8fafc';
    $backend["headerRadius"] = '10px';
    $backend["sidebarBG"] = 'transparent';
    $backend["sidebarWidth"] = '250px';
    $backend["xs_sidebarBG"] = $backend['sidebarBG'];
    $backend["xs_sidebarWidth"] = '60px';
    $backend["sidebarPadding"] = (((float) $backend['sidebarWidth'] * 0.15) / 2) . 'px';
    $backend["sidebarLinksHover"] = 'transparent';
    $backend["sidebarLinksPadding"] = '0.5rem';
    $backend["articleMargin"] = $backend['sidebarWidth'];
    return array_merge($backend, $base);
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