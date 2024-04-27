.btn {
    width: fit-content;
    cursor: pointer;
    @apply select-none inline-flex items-center justify-center <?=$config['btnRadius']?> font-<?=$config['btnWeight']?> transition;
    @apply disabled:pointer-events-none disabled:opacity-60;
    @apply py-[<?=$config['btnPaddingY'] * 0.25 ?>rem] px-[<?=$config['btnPaddingX'] * 0.25 ?>rem];
    @apply <?=$config['btnBorder']?> <?=$config['btnRing']?> <?=$config['btnShadow']?>;
    .svg-icon {
        @apply w-[1.2em] h-[1.2em];
    }
}

.btn-block {
    width: 100%;
}

@media (max-width: theme('screens.md')) {
  .sm\:btn-block {
    width: 100%;
  }
}

@screen md {
  .md\:btn-block {
    width: 100%;
  }
}

.badge {
    width: fit-content;
    @apply select-none inline-flex justify-center items-center text-sm <?=$config['badgeRadius']?> font-semibold line-clamp-1 py-1 px-2.5;
    .svg-icon {
        @apply w-[1.1em] h-[1.1em];
    }
}

.btn-xxs {
    @apply text-xs py-0.5 px-1.5;
    font-size: .65rem;
}
.btn-xs {
    @apply text-xs py-[<?= minPadding($config['btnPaddingY'],1.5,0.12) ?>rem] px-[<?= minPadding($config['btnPaddingX'],3.8,$min=0.25,1.6) ?>rem];
}
.btn-sm {
    @apply text-sm py-[<?= minPadding($config['btnPaddingY'],1,0.2) ?>rem] px-[<?= minPadding($config['btnPaddingX'],3,0.35,2.2) ?>rem];
}
.btn-lg {
    @apply text-lg py-[<?=($config['btnPaddingY'] + 0.4) * 0.25 ?>rem] px-[<?=($config['btnPaddingX'] + 2) * 0.25 ?>rem];
}
.btn-xl {
    @apply text-xl py-[<?=($config['btnPaddingY'] + 1.3) * 0.25 ?>rem] px-[<?=($config['btnPaddingX'] + 3.2) * 0.25 ?>rem];
}
.btn-2xl {
    @apply text-2xl py-[<?=($config['btnPaddingY'] + 1.3) * 0.25 ?>rem] px-[<?=($config['btnPaddingX'] + 3.2) * 0.25 ?>rem];
}
.badge-xxs {
    padding: 0 0.65rem;
    font-size: 0.68rem;
    line-height: 1rem;
}
.badge-xs {
    @apply text-xs py-0.5 px-1.5;
}
.badge-sm {
    @apply text-sm py-1 px-3;
}
.badge-lg {
    @apply text-lg py-1.5 px-4;
}
.badge-xl {
    @apply text-xl py-2.5 px-6;
}



<?php 
    foreach($config['colors'] as $key => $row) { 
        $bg = $config['colors'][$key]['bg'];
        $border = $config['colors'][$key]['bg'];
        $bgVariant = $row['bgVariant'];
?>

    .btn-<?= $key ?> {
        @apply bg-<?= $key ?>-<?= $bg ?> border-<?= $key.'-'.$border ?> text-<?=$key?>-50 hover:text-white hover:bg-<?= $key ?>-600;
        @apply ring-<?= $key ?>-900/5 shadow-<?= $key ?>-500/50;
        @apply hover:bg-<?= $key ?>-<?= $bg ?>/90;
    }

    .btn-<?= $key ?>-outline {
        @apply border-<?= $key.'-'.$border ?> text-<?= $key ?>-500 hover:text-<?= $key ?>-300;
        @apply ring-<?= $key ?>-900/5 shadow-<?= $key ?>-500/50;
        @apply hover:border-<?= $key.'-'.$border ?>/90;
    }

    .label-<?= $key ?> {
        @apply bg-<?= $key ?>-<?= $bgVariant ?> border-<?= $key.'-'.$border ?> text-<?= $key ?>-500 hover:text-<?= $key ?>-600;
        @apply shadow-<?= $key ?>-500/10;
    }

<?php } ?>

<?php
$basicColors = [
    'white' => ['text' => 'dark','bg' => 'white','border' => 'gray-100'],
    'black' => ['text' => 'white','bg' => 'black','border' => 'gray-900'],
    'light' => ['text' => 'dark','bg' => 'gray-100','border' => 'gray-900'],
    'dark' => ['text' => 'light','bg' => 'gray-100','border' => 'gray-900'],
];
?>
<?php 
    foreach($basicColors as $key => $row) { 
    $text = $basicColors[$key]['text'];
    $bg = $basicColors[$key]['bg'];
    $border = $basicColors[$key]['border'];
?>
    .btn-<?= $key ?> {
        @apply bg-<?=$key?> border-<?=$border?> text-<?=$text?>;
        @apply ring-<?= $key ?>/5 shadow-<?= $key ?>/50;
        &:hover {
            opacity: 0.95;
        }
    }

    .btn-<?= $key ?>-outline {
        @apply border-<?= $text ?> text-<?= $text ?>;
        @apply ring-<?= $key ?>/5 shadow-<?= $key ?>/50;
        &:hover {
            opacity: 0.95;
        }
    }

    .label-<?= $key ?> {
        @apply bg-<?= $key ?> border-<?= $key ?> text-<?= $text ?>;
        @apply shadow-<?= $key ?>/10;
        &:hover {
            opacity: 0.95;
        }
    }

<?php } ?>


.btn-light, .badge-light {
    background-color: <?= $config['light']['light'] ?>;
}
.dark {
    .btn-light, .badge-light {
        color:  <?= $config['light']['light'] ?>;
        background-color: <?= $config['dark']['light'] ?>;
    }
}
.btn-transparent {
    @apply bg-transparent dark:bg-transparent text-gray-500 dark:text-light;
}


.btn-group {
    @apply relative flex items-center gap-x-1 px-0 py-0 overflow-hidden;
    > * {
        @apply bg-transparent border-0 rounded-none;
        position: relative;
        border: none !important;
        // styles for the line between child elements
        &:not(:last-child)::after {
            @apply block absolute;
            content: '';
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            border-right: 1px solid white;
        }
    }
    * {
        &:not(:last-child)::after {
            @apply block absolute;
            content: '';
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            border-right: 1px solid white;
        }
    }
}

.hover-zoom { 
  transition: all .2s ease-in-out;
  &:hover { 
    transform: scale(1.03); 
  }
}