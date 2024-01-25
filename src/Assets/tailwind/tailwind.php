<?php
//WEIGHT
$configBase['headingWeight'] = 'bold';
// $headingWeight = 'bold';
// $configBase['headingWeight1'] = $headingWeight;
// $configBase['headingWeight2'] = $headingWeight;
// $configBase['headingWeight3'] = $headingWeight;
// $configBase['headingWeight4'] = $headingWeight;
// $configBase['headingWeight5'] = $headingWeight;
// $configBase['headingWeight6'] = $headingWeight;
// $h2Weight = (isset($config['headingWeight2']))? $headingWeight2 : $headingWeight;
// $h3Weight = (isset($config['headingWeight3']))? $headingWeight3 : $headingWeight;
// $h4Weight = (isset($config['headingWeight4']))? $headingWeight4 : $headingWeight;
// $h5Weight = (isset($config['headingWeight5']))? $headingWeight5 : $headingWeight;
// $h6Weight = (isset($config['headingWeight6']))? $headingWeight6 : $headingWeight;
//BTN
$configBase['btnRadius'] = 'rounded';
$configBase['badgeRadius'] = 'rounded-full';
$configBase['btnShadow'] = '';
$configBase['btnRind'] = '';
$configBase['btnBorder'] = 'border';
$configBase['labelColor'] = 'gray-500';
$configBase['btnBorderColor'] = 'primary-200';
$configBase['btnBgColor'] = 'gray-400';
$configBase['btnPaddingY'] = 2;
$configBase['btnPaddingX'] = 5;
//FORMS
//COLORES
$configBase['colors'] = [
    'primary' => ['text' => 500,'bg' => 500,'border' => 400],
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
//BACKEND
$configBase['backend'] = false;
$config = array_merge($configBase, $config);
?>

@layer components {
    body {
        @apply antialiased;
    }
    .container, .container-min, .container-max, .container-full {
        width: 100%;
        @apply relative flex mx-auto px-2 md:px-3;
        flex-wrap: wrap;
        flex-direction: column;
    }
    .container {
        @apply max-w-screen-xl;
    }
    .container-min {
        @apply max-w-screen-lg;
    }
    .container-max {
        @apply max-w-screen-2xl;
    }

    @screen md {
        .container, .container-min, .container-max, .container-full {
        }
    }

    h1, h2, h3, h4, h5, h6 {
        @apply font-<?= $config['headingWeight'] ?> leading-tight tracking-tighter lg:leading-[1.1];
    }

    h1 {
        @apply text-5xl md:text-6xl lg:text-7xl;
    }

    h2 {
        @apply text-4xl md:text-5xl lg:text-6xl;
    }

    h3 {
        @apply text-3xl md:text-4xl lg:text-5xl;
    }

    h4 {
        @apply text-2xl md:text-3xl lg:text-4xl;
    }

    h5 {
        @apply text-xl md:text-2xl lg:text-3xl;
    }

    h6 {
        @apply text-lg md:text-xl lg:text-2xl;
    }
    .text-muted {
        @apply text-primary-400 opacity-95 tracking-tight uppercase;
    }

    .subtitle {
        @apply max-w-[750px] text-lg sm:text-xl;
        @apply text-muted;
    }

    .gradient-text {
        @apply w-fit bg-clip-text text-transparent pr-0.5;
    }


    .bg-custom {
        @apply relative flex min-h-screen flex-col justify-center overflow-hidden py-6 sm:py-12;
    }

    <?php 
        include 'btn-badges.php';
        include 'forms.php';
        include 'boxes.php';
        include 'other.php';
        if($configBase['backend']){
            include 'backend.php';
        }
    ?>

}