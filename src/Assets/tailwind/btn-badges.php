<?php
function minPadding($value,$variant,$min=0.25,$max=false){
    $x = (($value > $variant)? $value - $variant : 1) * 0.25;
    $x = ($x > $min)? $x : $min;
    if($max){
        $x = ($x < $max)? $x : $max;
    }
    return $x;
}
?>
.btn {
    width: fit-content;
    @apply select-none inline-flex items-baseline justify-center whitespace-nowrap <?=$config['btnRadius']?> font-bold transition-colors disabled:pointer-events-none disabled:opacity-50;
    @apply py-[<?=$config['btnPaddingY'] * 0.25 ?>rem] px-[<?=$config['btnPaddingX'] * 0.25 ?>rem];
    @apply <?=$config['btnBorder']?> <?=$config['btnRind']?> <?=$config['btnShadow']?> hover:bg-opacity-90;
}

.btn-block {
    width: 100%;
}

.badge {
    width: fit-content;
    @apply select-none inline-flex justify-center items-center text-sm <?=$config['badgeRadius']?> font-semibold line-clamp-1 py-1 px-2.5;
}

.badge .svg-icon {
    @apply w-5 h-5;
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
?>

    .btn-<?= $key ?> {
        @apply bg-<?= $key ?>-<?= $bg ?> border-<?= $key.'-'.$border ?> text-<?= $key ?>-50 hover:text-white hover:bg-<?= $key ?>-600;
        @apply ring-<?= $key ?>-900/5 shadow-<?= $key ?>-500/50;
    }

    .btn-<?= $key ?>-outline {
        @apply border-<?= $key.'-'.$border ?> text-<?= $key ?>-500 hover:text-<?= $key ?>-300;
        @apply ring-<?= $key ?>-900/5 shadow-<?= $key ?>-500/50;
    }

    .label-<?= $key ?> {
        @apply bg-<?= $key ?>-50 border-<?= $key.'-'.$border ?> text-<?= $key ?>-500 hover:text-<?= $key ?>-600;
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
    $border = $basicColors[$key]['border'];
?>
    .btn-<?= $key ?> {
        @apply bg-<?= $key ?> border-<?= $border ?> text-<?= $text ?>;
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