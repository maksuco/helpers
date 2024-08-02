//:theme {}
:root {
    --colors-light: <?= $config['light']['bg'] ?>; 
    --colors-light-box: <?= $config['light']['box'] ?>;
    --colors-light-title: <?= $config['light']['title'] ?>;
    --colors-light-subtitle: <?= $config['light']['subtitle'] ?>;
    --colors-light-body: <?= $config['light']['body'] ?>;
    --colors-light-label: <?= $config['light']['label'] ?>;
    --colors-light-form-basic-bg: <?= $config['light']['form-basic-bg'] ?>;
    --colors-light-form-basic-border: <?= $config['light']['form-basic-border'] ?>;
    --colors-light-form-muted-bg: <?= $config['light']['form-muted-bg'] ?>;
    --colors-light-light: <?= $config['light']['light'] ?>;
    
    --colors-bg: <?= $config['bg'] ?>;
    --colors-box: <?= $config['box'] ?>
    --colors-title: <?= $config['title'] ?>;
    --colors-subtitle: <?= $config['subtitle'] ?>;
    --colors-body: <?= $config['body'] ?>;
    --colors-label: <?= $config['label'] ?>;
    --colors-form-basic-bg: <?= $config['form-basic-bg'] ?>;
    --colors-form-basic-border: <?= $config['form-basic-border'] ?>;
    --colors-form-muted-bg: <?= $config['form-muted-bg'] ?>;
    
    --colors-dark: <?= $config['dark']['bg'] ?>;
    --colors-dark-box: <?= $config['dark']['box'] ?>;
    --colors-dark-title: <?= $config['dark']['title'] ?>;
    --colors-dark-subtitle: <?= $config['dark']['subtitle'] ?>;
    --colors-dark-body: <?= $config['dark']['body'] ?>;
    --colors-dark-label: <?= $config['dark']['label'] ?>;
    --colors-dark-form-basic-bg: <?= $config['dark']['form-basic-bg'] ?>;
    --colors-dark-form-basic-border: <?= $config['dark']['form-basic-border'] ?>;
    --colors-dark-form-muted-bg: <?= $config['dark']['form-muted-bg'] ?>;
    --colors-dark-light: <?= $config['dark']['light'] ?>;
}

@layer base {
    a {
        @apply transition duration-100;
    }
    body {
        @apply antialiased;
        color: <?= $config['body'] ?>;
        background-color: <?= $config['bg'] ?>;
    }
    .dark {
        color: <?= $config['dark']['body'] ?>;
        body {
            color: <?= $config['dark']['body'] ?>;
        }
    }
    [x-cloak] {
        visibility: hidden !important;
        overflow: hidden !important;
        display: none !important;
    }
    .grecaptcha-badge {
        visibility: hidden !important;
    }
    .disabled {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        user-select: none;
        pointer-events: none;
        opacity: .95;
    }
}

@layer components {
    .container, .container-min, .container-max, .container-full, .container-fluid {
        width: 100%;
        @apply relative flex mx-auto px-2 md:px-3;
        flex-wrap: wrap;
    }
    .row {
        @apply relative w-full flex flex-wrap;
    }

    .absolute-tl, .absolute-tc, .absolute-tr {
        @apply absolute top-0;
    }
    .absolute-tl { left: 0; }
    .absolute-tc {
        left: 50%;
        transform: translateX(-50%);
    }
    .absolute-tr { right: 0; }
    .absolute-cl, .absolute-c, .absolute-cr {
        @apply absolute;
        top: 50%;
        transform: translateY(-50%);
    }
    .absolute-cl { left: 0; }
    .absolute-c {
        left: 50%;
        transform: translateX(-50%);
    }
    .absolute-cr { right: 0; }
    .absolute-bl, .absolute-bc, .absolute-br {
        @apply absolute bottom-0;
    }
    .absolute-bl { left: 0; }
    .absolute-bc {
        left: 50%;
        transform: translateX(-50%);
    }
    .absolute-br { right: 0; }
    
    .absolute-full { position: absolute; top: 0; bottom: 0; left: 0; right: 0; }
    
    @media (max-width: calc(theme('screens.md') - 1px)) {
        .sm-hidden {
            display: hidden !important;
        }
    }
    @media (min-width: theme('screens.md')) and (max-width: calc(theme('screens.lg') - 1px)) {
        .md-hidden {
            display: hidden !important;
        }
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
        .md\:absolute-tl, .md\:absolute-tc, .md\:absolute-tr {
            @apply absolute top-0;
        }
        .md\:absolute-tl { left: 0; }
        .md\:absolute-tc {
            left: 50%;
            transform: translateX(-50%);
        }
        .md\:absolute-tr { right: 0; transform: none; }
        .md\:absolute-cl, .md\:absolute-c, .md\:absolute-cr {
            @apply absolute;
            top: 50%;
            transform: translateY(-50%);
        }
        .md\:absolute-cl { left: 0; }
        .md\:absolute-c {
            left: 50%;
            transform: translateX(-50%);
        }
        .md\:absolute-cr { right: 0; }
        .md\:absolute-bl, .md\:absolute-bc, .md\:absolute-br {
            @apply absolute bottom-0;
        }
        .md\:absolute-bl { left: 0; }
        .md\:absolute-bc {
            left: 50%;
            transform: translateX(-50%);
        }
        .md\:absolute-br { right: 0; }
        .md\:absolute-full { position: absolute; top: 0; bottom: 0; left: 0; right: 0; }
    }

    h1, h2, h3, h4, h5, h6 {
        @apply leading-tight tracking-tighter lg:leading-[1.1] <?= $config['headingColor'] ?>;
    }

    h1 {
        @apply font-<?= $config['headingFont1'] ?> <?= $config['headingSize1'] ?>;
        font-weight: <?= $config['headingWeight1'] ?>;
    }

    h2 {
        @apply font-<?= $config['headingFont2'] ?> <?= $config['headingSize2'] ?>;
        font-weight: <?= $config['headingWeight2'] ?>;
    }

    h3 {
        @apply font-<?= $config['headingFont3'] ?> <?= $config['headingSize3'] ?>;
        font-weight: <?= $config['headingWeight3'] ?>;
    }

    h4 {
        @apply font-<?= $config['headingFont4'] ?> <?= $config['headingSize4'] ?>;
        font-weight: <?= $config['headingWeight4'] ?>;
    }

    h5 {
        @apply font-<?= $config['headingFont5'] ?> <?= $config['headingSize5'] ?>;
        font-weight: <?= $config['headingWeight5'] ?>;
    }

    h6 {
        @apply font-<?= $config['headingFont6'] ?> <?= $config['headingSize6'] ?>;
        font-weight: <?= $config['headingWeight6'] ?>;
    }
    .text-muted {
        @apply opacity-95 tracking-tight uppercase;
    }

    .subtitle {
        @apply max-w-[750px] text-lg sm:text-xl;
        color: <?= $config['light']['subtitle'] ?>;
    }
    .dark {
        h1, h2, h3, h4, h5, h6 {
            color: <?= $config['dark']['title'] ?>;
        }
        .subtitle {
            color: <?= $config['dark']['subtitle'] ?>;
        }
    }

    .text-gradient {
        @apply inline-block text-transparent bg-clip-text bg-gradient-to-br from-brand-500 to-brand-300 pr-0.5;
    }

    <?php
    $sizesHelpers = [50,60,70,80,90,100,150,200,250,300,350,400,500,600,700,800,900,1000];
    foreach($sizesHelpers as $row) { 
    ?>
        .w-<?= $row ?> { width: <?= $row ?>px; };
        .max-w-<?= $row ?> { max-width: <?= $row ?>px; };
        .h-<?= $row ?> { height: <?= $row ?>px; };
        .min-h-<?= $row ?> { min-height: <?= $row ?>px; };
        .max-h-<?= $row ?> { max-height: <?= $row ?>px; };
        .mt-<?= $row ?> { margin-top: <?= $row ?>px; };
        .mb-<?= $row ?> { margin-bottom: <?= $row ?>px; };
        .my-<?= $row ?> { margin-top: <?= $row ?>px; margin-bottom: <?= $row ?>px; };
        .pt-<?= $row ?> { padding-top: <?= $row ?>px; };
        .pb-<?= $row ?> { padding-bottom: <?= $row ?>px; };
        .py-<?= $row ?> { padding-top: <?= $row ?>px; padding-bottom: <?= $row ?>px; };
        @screen md {
            .md\:w-<?= $row ?> { width: <?= $row ?>px; };
            .md\:max-w-<?= $row ?> { max-width: <?= $row ?>px; };
            .md\:h-<?= $row ?> { height: <?= $row ?>px; };
            .md\:min-h-<?= $row ?> { min-height: <?= $row ?>px; };
            .md\:max-h-<?= $row ?> { max-height: <?= $row ?>px; };
            .md\:mt-<?= $row ?> { margin-top: <?= $row ?>px; };
            .md\:mb-<?= $row ?> { margin-bottom: <?= $row ?>px; };
            .md\:my-<?= $row ?> { margin-top: <?= $row ?>px; margin-bottom: <?= $row ?>px; };
            .md\:pt-<?= $row ?> { padding-top: <?= $row ?>px; };
            .md\:pb-<?= $row ?> { padding-bottom: <?= $row ?>px; };
            .md\:py-<?= $row ?> { padding-top: <?= $row ?>px; padding-bottom: <?= $row ?>px; };
        }
        @screen lg {
            .lg\:w-<?= $row ?> { width: <?= $row ?>px; };
            .lg\:max-w-<?= $row ?> { max-width: <?= $row ?>px; };
            .lg\:h-<?= $row ?> { height: <?= $row ?>px; };
            .lg\:min-h-<?= $row ?> { min-height: <?= $row ?>px; };
            .lg\:max-h-<?= $row ?> { max-height: <?= $row ?>px; };
            .lg\:mt-<?= $row ?> { margin-top: <?= $row ?>px; };
            .lg\:mb-<?= $row ?> { margin-bottom: <?= $row ?>px; };
            .lg\:my-<?= $row ?> { margin-top: <?= $row ?>px; margin-bottom: <?= $row ?>px; };
            .lg\:pt-<?= $row ?> { padding-top: <?= $row ?>px; };
            .lg\:pb-<?= $row ?> { padding-bottom: <?= $row ?>px; };
            .lg\:py-<?= $row ?> { padding-top: <?= $row ?>px; padding-bottom: <?= $row ?>px; };
        }
    <?php }; ?>

}