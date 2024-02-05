.box-xs, .box-sm, .box, .box-lg, .box-xl, .box-xxl {
    width: 100%;
    //@apply relative bg-white dark:bg-dark-box ring-1 ring-gray-900/5;
    @apply relative ring-1 ring-gray-900/5;
    background-color: <?= $config['light']['box'] ?>;
}
.dark {
    .box-xs, .box-sm, .box, .box-lg, .box-xl, .box-xxl {
        background-color: <?= $config['dark']['box'] ?>;
    }
}
.box-xs {
    @apply px-2.5 pt-2 pb-1.5 md:px-3 md:pt-3 md:pb-2.5 rounded-xl;
}
.box-sm {
    @apply px-4 pt-4 pb-3 md:px-5 md:pt-4 md:pb-4 rounded-2xl;
}
.box {
    @apply px-5 pt-5 pb-4 md:px-6 md:pt-5 md:pb-5 <?=$config['boxRadius']?>;
}
.box-lg {
    @apply px-6 pt-6 pb-5 md:px-7 md:pt-6 md:pb-6 rounded-[2rem];
}
.box-xl {
    @apply px-7 pt-7 pb-6 md:px-8 md:pt-8 md:pb-7 rounded-[2.5rem];
}
.box-xxl {
    @apply px-9 pt-9 pb-9 md:px-10 md:pt-10 md:pb-10 rounded-[3rem];
}

//BENTOS
.bento-2 {
    @apply grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6;
}

.bento-3 {
    @apply grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6;
}

.bento-4 {
    @apply grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6;
}

.bento-5 {
    @apply grid grid-cols-1 md:grid-cols-5 gap-4 md:gap-6;
}

.bento-6 {
    @apply grid grid-cols-1 md:grid-cols-6 gap-4 md:gap-6;
}

.bento-10 {
    @apply grid grid-cols-1 md:grid-cols-10 gap-4 md:gap-6;
}

.bento-12 {
    @apply grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6;
}

.bento-item {
    @apply row-span-1;
    min-height: 200px;
}

.bento-formula-3 {
    @apply bento-3;
    .bento-item:nth-child(4) {
        @apply md:col-span-2 md:row-span-2;
    }
    .bento-item:nth-child(8) {
        @apply md:col-span-2;
    }
}

.bento-formula-4 {
    @apply bento-4;
    .bento-item:nth-child(1) {
        @apply md:row-span-2;
    }
    .bento-item:nth-child(4) {
        @apply md:row-span-2;
    }
    .bento-item:nth-child(5) {
        @apply md:col-span-2 md:row-span-2;
    }
    .bento-item:nth-child(7) {
        @apply md:row-span-2;
    }
    .bento-item:nth-child(8) {
        @apply md:col-span-2;
    }
}

.bento-formula-5 {
    @apply bento-5;
    .bento-item:nth-child(4) {
        @apply md:col-span-2;
    }
    .bento-item:nth-child(6) {
        @apply md:col-span-3;
    }
    .bento-item:nth-child(7) {
        @apply md:row-span-2;
    }
    .bento-item:nth-child(8) {
        @apply md:col-span-2;
    }
}

.bento-formula-10 {
    @apply bento-10;
    .bento-item {
        @apply md:col-span-2;
    }
    .bento-item:nth-child(1) {
        @apply md:col-span-2 md:row-span-2;
    }
    .bento-item:nth-child(2) {
        @apply md:col-span-3;
    }
    .bento-item:nth-child(3) {
        @apply md:col-span-3;
    }
    .bento-item:nth-child(5) {
        @apply md:col-span-4 md:row-span-2;
    }
    .bento-item:nth-child(6) {
        @apply md:col-span-2;
    }
    .bento-item:nth-child(7) {
        @apply md:col-span-2 md:row-span-2;
    }
    .bento-item:nth-child(8) {
        @apply md:col-span-2 md:row-span-2;
    }
    .bento-item:nth-child(11) {
        @apply md:col-span-6 md:row-span-2;
    }
    .bento-item:nth-child(12) {
        @apply md:col-span-4;
    }
}