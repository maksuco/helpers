.avatar {
    @apply size-12 bg-cover bg-center aspect-square <?=$config['btnRadius']?> border border-white;
    @apply flex justify-center items-center font-extrabold text-2xl text-opacity-90;
}

.breadcrumb {
    @apply flex flex-wrap items-center bg-transparent text-xs pr-3 py-2;
  list-style: none;
  .breadcrumb-item {
    @apple pr-1.5;
    &:nth-child(n+2) {
      &:before {
        @apple pr-1.5 inline-block text-gray-200;
        content: "/";
      }
    }
    a {
    @apple font-light text-gray-500;
      &:hover {
        @apple text-brand;
      }
    }
    .active {
        @apple text-brand;
    }
  }
}


.price-row {
    @apply relative flex justify-center items-start pl-4;
    div:first-child {
        @apply opacity-90;
        font-size: clamp(1.2rem, 25%, 2.5rem);
        line-height: 1.2;
    }
    div:nth-child(2) {
        @apply font-extrabold tracking-tighter;
        font-size: clamp(2.4rem, 100%, 20rem);
        line-height: 70%;
    }
    div:nth-child(3) {
        @apply opacity-95 text-sm text-left mt-1 ml-1;
        font-size: clamp(0.6rem, 13%, 1.2rem);
        line-height: 1;
        span {
            display: block;
        }
    }
}


<?php
//BRAND COLORS
$brandColors = [
    'facebook' => '#3b57a1',
    'twitter' => '#4aa0eb',
    'x' => '#000000',
    'google' => '#D93D2C',
    'whatsapp' => '#35B83F',
    'linkedin' => '#0B66C2',
    'instagram' => '#e4405f'
];
?>
<?php 
  foreach($brandColors as $key => $row) { 
?>
    .bg-<?= $key ?> {
        background-color: <?= $row ?>;
    }

<?php } ?>


.x-scroll {
  @apple inline-flex items-center;
  overflow-y: hidden;
   overflow-x: auto;
  white-space: nowrap;
  -ms-overflow-style: none;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  &::-webkit-scrollbar {
    display: none;
  }
}

@media (max-width: theme('screens.md')) {
  .sm\:x-scroll {
    @apple inline-flex items-center;
    overflow-y: hidden;
    overflow-x: auto;
    white-space: nowrap;
    -ms-overflow-style: none;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    max-width: 100%;
    &::-webkit-scrollbar {
      display: none;
    }
  }
}

.shadow-panel {
    @apply relative;
    z-index: 1;
}
.shadow-panel:before, .shadow-panel:after {
    @apply absolute shadow backdrop-blur;
    content: "";
    background-color: var(--bg-color, inherit);
    border-radius: var(--border-radius, inherit);
}
.shadow-panel:before {
    width: 84%;
    left: 8%;
    top: 90%;
    bottom: var(--distance, -2.2%);
    opacity: 0.35;
    z-index: -1;
}
.shadow-panel:after {
    width: 72%;
    left: 14%;
    top: 90%;
    bottom: var(--distance2, -3.8%);
    opacity: 0.25;
    z-index: -2;
}