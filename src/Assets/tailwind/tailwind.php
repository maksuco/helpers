<?php
include 'functions.php';
$config = prepareArray($config);
?>


:theme {
    --colors-light: <?= $configBase['light']['bg'] ?>;
    --colors-light-box: <?= $configBase['light']['box'] ?>;
    --colors-light-title: <?= $configBase['light']['title'] ?>;
    --colors-light-subtitle: <?= $configBase['light']['subtitle'] ?>;
    --colors-light-body: <?= $configBase['light']['body'] ?>;
    --colors-light-label: <?= $configBase['light']['label'] ?>;
    --colors-light-form-basic-bg: <?= $configBase['light']['form-basic-bg'] ?>;
    --colors-light-form-basic-border: <?= $configBase['light']['form-basic-border'] ?>;
    --colors-light-form-muted-bg: <?= $configBase['light']['form-muted-bg'] ?>;
    --colors-light-light: <?= $configBase['light']['light'] ?>;
    --colors-dark: <?= $configBase['dark']['bg'] ?>;
    --colors-dark-box: <?= $configBase['dark']['box'] ?>;
    --colors-dark-title: <?= $configBase['dark']['title'] ?>;
    --colors-dark-subtitle: <?= $configBase['dark']['subtitle'] ?>;
    --colors-dark-body: <?= $configBase['dark']['body'] ?>;
    --colors-dark-label: <?= $configBase['dark']['label'] ?>;
    --colors-dark-form-basic-bg: <?= $configBase['dark']['form-basic-bg'] ?>;
    --colors-dark-form-basic-border: <?= $configBase['dark']['form-basic-border'] ?>;
    --colors-dark-form-muted-bg: <?= $configBase['dark']['form-muted-bg'] ?>;
    --colors-dark-light: <?= $configBase['dark']['light'] ?>;
}

@layer base {
    * {
        @apply transition duration-200;
    }
    body {
        @apply antialiased;
        color: <?= $config['light']['body'] ?>;
    }
    .dark {
        color: <?= $config['dark']['body'] ?>;
        body {
            color: <?= $config['dark']['body'] ?>;
        }
    }
}

@layer components {
    [x-cloak] {
        visibility: hidden !important;
        overflow: hidden !important;
        display: none !important;
    }
    .grecaptcha-badge {
        visibility: hidden !important;
    }
    .container, .container-min, .container-max, .container-full {
        width: 100%;
        @apply relative flex mx-auto px-2 md:px-3;
        flex-wrap: wrap;
    }

    @screen md {
        .container, .container-min, .container-max, .container-full {
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
    }

    h1, h2, h3, h4, h5, h6 {
        @apply leading-tight tracking-tighter lg:leading-[1.1];
        color: <?= $config['light']['title'] ?>;
    }

    h1 {
        @apply font-<?= $config['headingFont1'] ?> font-<?= $config['headingWeight1'] ?> text-5xl md:text-6xl lg:text-7xl;
    }

    h2 {
        @apply font-<?= $config['headingFont2'] ?> font-<?= $config['headingWeight2'] ?> text-4xl md:text-5xl lg:text-6xl;
    }

    h3 {
        @apply font-<?= $config['headingFont3'] ?> font-<?= $config['headingWeight3'] ?> text-3xl md:text-4xl lg:text-5xl;
    }

    h4 {
        @apply font-<?= $config['headingFont4'] ?> font-<?= $config['headingWeight4'] ?> text-2xl md:text-3xl lg:text-4xl;
    }

    h5 {
        @apply font-<?= $config['headingFont5'] ?> font-<?= $config['headingWeight4'] ?> text-xl md:text-2xl lg:text-3xl;
    }

    h6 {
        @apply font-<?= $config['headingFont6'] ?> font-<?= $config['headingWeight6'] ?> text-lg md:text-xl lg:text-2xl;
    }
    .text-muted {
        @apply text-brand-400 opacity-95 tracking-tight uppercase;
        color: <?= $config['light']['subtitle'] ?>;
    }

    .subtitle {
        @apply max-w-[750px] text-lg sm:text-xl;
        color: <?= $config['light']['subtitle'] ?>;
    }
    .dark {
        h1, h2, h3, h4, h5, h6 {
            color: <?= $config['dark']['title'] ?>;
        }
        .text-muted {
            color: <?= $config['dark']['subtitle'] ?>;
        }
        .subtitle {
            color: <?= $config['dark']['subtitle'] ?>;
        }
    }

    .text-gradient {
        @apply inline-block text-transparent bg-clip-text bg-gradient-to-br from-brand-500 to-brand-300 pr-0.5;
    }


    .bg-custom {
        @apply relative flex min-h-screen flex-col justify-center overflow-hidden py-6 sm:py-12;
    }

    <?php 
        include 'utilities.php';
        include 'btn-badges.php';
        include 'forms.php';
        include 'boxes.php';
        include 'dropdowns.php';
        include 'other.php';
        if($configBase['backend']){
            include 'backend.php';
        }
    ?>

}