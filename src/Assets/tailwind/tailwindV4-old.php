//:theme {}
@theme {
    --color-brand: #ac4ffd;
    --color-brand-50: #faf5ff;
    --color-brand-100: #f4e7ff;
    --color-brand-200: #ead3ff;
    --color-brand-300: #dab1ff;
    --color-brand-400: #c37fff;
    --color-brand-500: #ac4ffd;
    --color-brand-600: #982cf1;
    --color-brand-700: #8c1fe2;
    --color-brand-800: #6e1cad;
    --color-brand-900: #5b188b;
    --color-brand-950: #3d0368;
    --color-light: <?= $config['light']['bg'] ?>;
    --color-light-box: <?= $config['light']['box'] ?>;
    --color-light-title: <?= $config['light']['title'] ?>;
    --color-light-subtitle: <?= $config['light']['subtitle'] ?>;
    --color-light-body: <?= $config['light']['body'] ?>;
    --color-light-label: <?= $config['light']['label'] ?>;
    --color-light-form-basic-bg: <?= $config['light']['form-basic-bg'] ?>;
    --color-light-form-basic-border: <?= $config['light']['form-basic-border'] ?>;
    --color-light-form-muted-bg: <?= $config['light']['form-muted-bg'] ?>;
    --color-light-light: <?= $config['light']['light'] ?>;
    --color-dark: <?= $config['dark']['bg'] ?>;
    --color-dark-box: <?= $config['dark']['box'] ?>;
    --color-dark-title: <?= $config['dark']['title'] ?>;
    --color-dark-subtitle: <?= $config['dark']['subtitle'] ?>;
    --color-dark-body: <?= $config['dark']['body'] ?>;
    --color-dark-label: <?= $config['dark']['label'] ?>;
    --color-dark-form-basic-bg: <?= $config['dark']['form-basic-bg'] ?>;
    --color-dark-form-basic-border: <?= $config['dark']['form-basic-border'] ?>;
    --color-dark-form-muted-bg: <?= $config['dark']['form-muted-bg'] ?>;
    --color-dark-light: <?= $config['dark']['light'] ?>;
}

@layer base {
    a {
        @apply transition duration-100;
    }
    body {
        @apply antialiased;
        color: <?= $config['light']['body'] ?>;
        background-color: <?= $config['light']['bg'] ?>;
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

    @screen md {
        .container, .container-min, .container-max, .container-full {
        }
        .container {
            @apply max-w-xl;
        }
        .container-min {
            @apply max-w-lg;
        }
        .container-max {
            @apply max-w-2xl;
        }
        .md\:absolute-tl, .md\:absolute-tc, .md\:absolute-tr {
            @apply absolute top-0;
        }
        .md\:absolute-tl { left: 0; }
        .md\:absolute-tc {
            left: 50%;
            transform: translateX(-50%);
        }
        .md\:absolute-tr { right: 0; }
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
    }

    h1, h2, h3, h4, h5, h6 {
        @apply leading-tight tracking-tighter lg:leading-[1.1];
        color: <?= $config['light']['title'] ?>;
    }

    h1 {
        @apply font-<?= $config['headingFont1'] ?> <?= $config['headingSize1'] ?>;
    }

    h2 {
        @apply font-<?= $config['headingFont2'] ?> font-<?= $config['headingWeight2'] ?> <?= $config['headingSize2'] ?>;
    }

    h3 {
        @apply font-<?= $config['headingFont3'] ?> font-<?= $config['headingWeight3'] ?> <?= $config['headingSize3'] ?>;
    }

    h4 {
        @apply font-<?= $config['headingFont4'] ?> font-<?= $config['headingWeight4'] ?> <?= $config['headingSize4'] ?>;
    }

    h5 {
        @apply font-<?= $config['headingFont5'] ?> font-<?= $config['headingWeight4'] ?> <?= $config['headingSize5'] ?>;
    }

    h6 {
        @apply font-<?= $config['headingFont6'] ?> font-<?= $config['headingWeight6'] ?> <?= $config['headingSize6'] ?>;
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
        @apply inline-block text-transparent dark:text-transparent bg-clip-text bg-gradient-to-br dark:bg-gradient-to-br from-brand-500 to-brand-300 pb-0.5 pr-0.5;
    }

    <?php
    $sizesHelpers = [50,60,70,80,90,100,150,200,250,300,350,400,500,600,700,800,900,1000];
    foreach($sizesHelpers as $row) { 
    ?>
        .w-<?= $row ?> { width: <?= $row ?>px; };
        .min-w-<?= $row ?> { min-width: <?= $row ?>px; };
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
            .md\:min-w-<?= $row ?> { min-width: <?= $row ?>px; };
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
            .lg\:min-w-<?= $row ?> { min-width: <?= $row ?>px; };
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

    <?php
    ?>

}