.box-xs, .box-sm, .box, .box-lg, .box-xl, .box-xxl {
    width: 100%;
    @apply relative bg-white ring-1 ring-gray-900/5;
}
.box-xs {
    @apply px-2.5 pt-2 pb-1.5 md:px-3 md:pt-3 md:pb-2.5 rounded-xl;
}
.box-sm {
    @apply px-4 pt-4 pb-3 md:px-5 md:pt-4 md:pb-4 rounded-2xl;
}
.box {
    @apply px-5 pt-5 pb-4 md:px-6 md:pt-5 md:pb-5 rounded-3xl;
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