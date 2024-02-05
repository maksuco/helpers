<?php
$backend = [
    "bg" => '#f8fafc',
    "body" => '#19212B',
    "headerHeight" => '60px',
    "headerLogoHeight" => ((float)$backend['headerHeight'] * 0.8) . 'px',
    "headerBody" => 'xxxxx',
    "headerBG" => '#f8fafc',

    "sidebarBG" => 'white',
    "sidebarWidth" => '250px',
    "xs_sidebarBG" => $backend['sidebarBG'],
    "xs_sidebarWidth" => '60px',
    "sidebarPadding" => (((float)$backend['sidebarWidth'] * 0.15) / 2) . 'px',
    "sidebarLinksHover" => 'transparent',
    "sidebarLinksPadding" => '0.5rem',

    "articleMargin" => $backend['sidebarWidth'],
];
$backend = array_merge($backend, $config['backend']);
?>


<!-- $backend-header-height: 60px !default;
$backend-header-logo-height: ($backend-header-height * 0.8) !default;
$backend-body: $body !default;
$backend-bg: #f8fafc !default;
$backend-sidebar-bg: white !default;
$backend-sidebar-width: 250px !default;
<?=$backend['xs_sidebarBG']?>: $backend-sidebar-bg !default;
<?=$backend['xs_sidebarWidth']?>: 60px !default;
<?=$backend['sidebarPadding']?>: calc(($backend-sidebar-width * 0.15) / 2) !default; -->
<!-- $backend-article-margin: $backend-sidebar-width !default; -->
$backend-sidebar-links: #2a5164 !default;
$backend-sidebar-links-hover: transparent !default;
$backend-sidebar-links-padding: 0.5rem !default;

$backend-sidebar-active-color: $white !default;
$backend-sidebar-active-bg: $primary !default;
$backend-top-box-radius: 25px !default;

body {
  @apply text-[$backend-body];
  background: linear-gradient(90deg, rgba(<?=$backend['bg']?>, 0.8) 30%, <?=$backend['bg']?> 70%);
}
main {
  @apply relative px-8;
}
main.rounded-full {
  @apply rounded-[40px];
}
@screen lg {
  main {
    @apply px-[0.2rem];
  }
}
.bg-backend {
  @apply bg-[<?=$backend['bg']?>];
}
.backend-sidebar-w {
  @apply w-[<?=$backend['sidebarWidth']?>];
}
.backend-sidebar-p {
  @apply pt-[<?=$backend['sidebarPadding']?>] pr-[<?=$backend['sidebarPadding']?>] pb-[<?=$backend['sidebarPadding']?>] pl-[<?=$backend['sidebarPadding']?>];
}
.backend-sidebar-px {
  @apply pl-[<?=$backend['sidebarPadding']?>] pr-[<?=$backend['sidebarPadding']?>];
}
.dropdown-menu,
.dropdown-menu-right {
  @apply rounded-[$backend-dropdown-radius];
}
.nav-header {
  @apply h-[$backend-header-height];
}
.nav-header .nav-logo {
  @apply pl-[<?=$backend['sidebarPadding']?>] pr-[<?=$backend['sidebarPadding']?>] w-[$backend-sidebar-width] max-w-[$backend-sidebar-width];
  margin-inline: 1rem;
}
.nav-header .nav-logo .nav-logo-complete {
  @apply max-h-[$backend-header-logo-height] mx-auto my-0;
}
.nav-header .nav-logo .nav-logo-icon {
  @apply max-h-[($backend-header-logo-height_*_0.8)] hidden mx-auto my-0;
}
.nav-header .nav-text {
  @apply pl-4;
}
.nav-header .nav-top-box {
  @apply inline-flex absolute z-[1] text-right rounded-[$backend-top-box-radius] text-[$gray] px-1.5 py-[5px] right-3 top-2;
  background: <?=$backend['xs_sidebarBG']?>;
}
.nav-header .nav-top-box .element {
  @apply cursor-pointer flex justify-center items-center text-center w-[30px] h-10 mx-[5px] my-0;
}
.nav-header .nav-top-box .element .fa-search {
  @apply text-[1.2rem] text-[$gray];
}
.nav-header .nav-top-box img {
  @apply cursor-pointer rounded-[$backend-top-box-radius_*_0.98] w-10 h-10;
}
.nav-header .nav-searchBox {
  @apply fixed z-[999] p-4 inset-0;
  background: <?=$backend['xs_sidebarBG']?>;
}
@media (max-width: $container) {
  .nav-header .nav-logo {
    @apply w-[<?=$backend['xs_sidebarWidth']?>] max-w-[<?=$backend['xs_sidebarWidth']?>] p-0;
    margin-inline: 1rem; //margin-left: 0.8rem;//margin-right: 1.2rem;
  }
  .nav-header .nav-logo .nav-logo-complete {
    @apply hidden;
  }
  .nav-header .nav-logo .nav-logo-icon {
    @apply block;
  }
}
@screen sm {
  .nav-header .nav-logo {
    @apply hidden;
  }
  .nav-header .nav-text {
    @apply pl-2;
  }
  .nav-header .nav-top-box {
    @apply right-2;
  }
  .nav-header .nav-top-box .element {
    @apply mx-1 my-0;
  }
}
.nav-article {
  @apply min-h-[80vh] w-[calc(100%_-_275px)] max-w-[1330px] pl-0;
}
@media (min-width: map-get($container-max-widths, "md")) {
  .nav-article {
    @apply px-4;
  }
}
@mixin xs-sidebar() {
  max-width: <?=$backend['xs_sidebarWidth']?>;
  background-color: <?=$backend['xs_sidebarBG']?>;
  border-radius: $btn-radius;
  .nav-sidebar-content {
    @apply p-[0.4rem];
  }
  .nav-sidebar-content ul {
    @apply p-0;
  }
  .nav-sidebar-content ul li {
    @apply leading-[0] py-[0.15rem];
  }
  .nav-sidebar-content ul li a {
    @apply text-center text-[0] rounded-[$btn-radius] px-[0.3rem] py-[0.4rem] hover:bg-[darken(<?=$backend['xs_sidebarBG']?>,5%)];
  }
  .nav-sidebar-content ul li i {
    @apply block text-[1.3rem] mx-auto my-0 p-0;
  }
  .nav-sidebar-content ul li svg {
    @apply h-[22px] w-[22px] opacity-100 mx-auto my-0;
  }
  .nav-sidebar-content ul li .badge {
    @apply leading-none text-[0.6rem] p-[0.24rem] left-[70%] right-auto -top-0.5;
  }
}
.nav-sidebar {
  @apply relative max-w-[$backend-sidebar-width] bg-[$backend-sidebar-bg] top-0; /* required */
  margin-inline: 1rem;
}
.nav-sidebar .nav-sidebar-content {
  @apply relative clear-both;
}
.nav-sidebar .nav-sidebar-content ul {
  @apply text-[13px] w-full align-middle pt-[<?=$backend['sidebarPadding']?>] pr-[<?=$backend['sidebarPadding']?>] pb-[<?=$backend['sidebarPadding']?>] pl-[<?=$backend['sidebarPadding']?>];
  list-style: none;
}
.nav-sidebar .nav-sidebar-content ul li {
  @apply block my-[0.1rem];
}
.nav-sidebar .nav-sidebar-content ul li a {
  @apply relative text-[$backend-sidebar-links] text-[0.96rem] font-[$font-weight-regular] flex items-center no-underline w-full rounded-[$btn-radius] hover:opacity-80;
  padding: $backend-sidebar-links-padding ($backend-sidebar-links-padding * 0.8)
    $backend-sidebar-links-padding ($backend-sidebar-links-padding * 1.6);
}
.nav-sidebar .nav-sidebar-content ul li a:hover {
  background: <?=$backend['xs_sidebarBG']?>;
}
.nav-sidebar .nav-sidebar-content ul li i {
  @apply w-[27px] text-center pr-2.5;
}
.nav-sidebar .nav-sidebar-content ul li svg {
  @apply text-[1.3em] opacity-80 -ml-1 mr-[9px];
}
.nav-sidebar .nav-sidebar-content ul li .badge {
  @apply absolute top-[($backend-sidebar-links-padding_*_1.2)] right-[($backend-sidebar-links-padding_*_0.8)] font-[$font-weight-bold];
  padding: ($btn-padding-y * 0.4) ($btn-padding-x * 0.2);
}
.nav-sidebar .nav-sidebar-content ul li .active {
  @apply cursor-default text-[rgba($backend-sidebar-active-color,0.9)] hover:opacity-100;
  background: $backend-sidebar-active-bg !important;
}
.nav-sidebar.sticky {
  @apply sticky z-[1];
  position: -webkit-sticky;
}
.nav-sidebar.full-h {
  @apply min-h-screen;
}
@media (min-width: map-get($container-max-widths, "md")) and (max-width: $container) {
  .nav-sidebar {
    @include xs-sidebar;
  }
}
@media (max-width: map-get($container-max-widths, "md")) {
  .nav-sidebar {
    @apply fixed w-full z-[900] bg-[<?=$backend['xs_sidebarBG']?>] shadow-[6px_0_15px_-8px_rgba($primary,0.2)] left-2 inset-y-4;
    margin-inline: 0;
  }
}
.nav-sidebar.xs-sidebar {
  @include xs-sidebar;
}
@media (min-width: map-get($container-max-widths, "md")) {
  .compressSideBar .nav-header .nav-logo {
    @apply max-w-[60px] pl-[0.8rem];
  }
  .compressSideBar .nav-header .nav-logo .nav-logo-complete {
    @apply hidden;
  }
  .compressSideBar .nav-header .nav-logo .nav-logo-icon {
    @apply block;
  }
  .compressSideBar .nav-sidebar {
    @include xs-sidebar;
  }
  .compressSideBar .nav-sidebar .hidden {
    @apply hidden;
  }
  .compressSideBar .nav-article {
    @apply max-w-full;
  }
  .compressSideBar .nav-article main {
    @apply max-w-full;
  }
}
.breadcrumb {
  @apply py-0;
}
header {
  @apply flex flex-wrap w-auto box-border relative;
}
header .header-title {
  @apply flex items-center gap-2 min-h-[65px] px-0 py-[0.1rem];
}
header .header-title h1 {
  @apply text-[clamp(38px,5.4vw,47px)];
}
header .header-title h2 {
  @apply text-[clamp(34px,5.2vw,40px)];
}
header .header-title h3 {
  @apply text-[clamp(30px,5vw,30px)];
}
header .header-title .v-div {
  @apply h-[90%] w-0.5 bg-[color:var(--gray)] opacity-50 mx-[1.6rem];
}
@media (max-width: map-get($container-max-widths, "md")) {
  header .header-title {
    @apply w-full flex-wrap min-h-[55px] mb-[0.2rem];
  }
  header .header-title h1,
  header .header-title h2,
  header .header-title h3 {
    @apply mb-[0.1rem] pr-[0.6rem]; //width: 100%;
  }
  header .header-title .v-div {
    @apply hidden;
  }
  header .header-title input {
    @apply w-full leading-[normal];
  }
}
@media (min-width: map-get($container-max-widths, "md")) {
  header .header-title {
    @apply min-h-[65px] mb-2;
  }
  header .header-title h1,
  header .header-title h2,
  header .header-title h3 {
    @apply max-w-[750px];
  }
  header .header-title input {
    @apply w-40 leading-[1.4];
  }
}
header .options button {
  @apply leading-[1.3] text-[0.8rem] tracking-[0.08px] text-[$light] bg-[$primary] font-[$font-weight-regular] rounded-[$btn-radius] cursor-pointer ml-1 mr-0 mt-1 mb-0 px-[0.55rem] py-[0.24rem];
}
header .options button i {
  @apply text-[$white] text-base align-middle ml-[3px];
}
header .btn {
  @apply px-4;
}
header .dropdown-menu-right {
  @apply -top-px;
}
@media (min-width: map-get($container-max-widths, "md")) {
  header {
    @apply mt-0 mb-[0.8rem] mx-0;
  }
  header .row {
    @apply gap-[5px];
  }
}
@media (max-width: map-get($container-max-widths, "md")) {
  header {
    @apply mx-[0.6rem] my-[0.1rem];
  }
  header .row {
    @apply gap-1;
  }
  header .options button {
    @apply px-[0.6rem] py-[0.35rem];
  }
  header .options button span {
    @apply hidden;
  }
  header .options button i {
    @apply text-[0.9rem] ml-0;
  }
  header .btn {
    @apply px-2;
  }
}
footer {
  @apply flex-[0_0_100%] w-full text-[0.8rem] opacity-50 mt-5 m-0 px-8 py-4;
}
@screen lg {
  footer {
    @apply px-4;
  }
}
.search-input input {
  @apply text-[2rem] text-[$dark] caret-[$primary];
}
.search-input input:focus {
  //border-bottom: 2px solid $light;
}
.search-input input::placeholder {
  @apply text-[$gray] pl-[0.1rem];
}
.modal--backdrop {
  @apply fixed z-[900] bg-[rgba($light,0.86)] w-full h-full left-0 top-0;
}
.search-results {
  @apply fixed z-[99999] w-[90%] max-w-[450px] min-h-[100px] bg-[$white] pt-4 pb-6 px-6 rounded-2xl right-[50px] top-2.5;
  background: $white !important;
}
.search-results .search-result-item {
  @apply flex flex-wrap items-center w-full bg-[color:var(--white)] text-[$dark] rounded border transition-[0.3s] leading-[0.9] mt-1 p-2 border-solid border-[$light] hover:border hover:border-solid hover:border-[$primary];
}
@media (max-width: map-get($container-max-widths, "md")) {
  .search-results {
    @apply w-[95%] pt-2 pb-[0.8rem] px-[0.8rem] inset-x-2.5;
  }
}
h1 {
  @apply text-[clamp(2.8rem,7vw,3.5rem)] leading-[0.9];
}
h2 {
  @apply text-[clamp(2.5rem,4.7vw,3rem)] leading-[0.9];
}
h3 {
  @apply text-[clamp(1.8rem,3.3vw,2.4rem)] leading-none;
}
h4 {
  @apply text-[clamp(1.6rem,2.2vw,1.9rem)] leading-none;
}
h5 {
  @apply text-[clamp(1.1rem,1.5vw,1.2rem)] leading-none;
}
.single-upload {
  @apply relative flex flex-wrap w-full z-[2];
}
.single-upload .preview-container {
  @apply relative mr-[0.8rem];
}
.single-upload .preview-container .preview-img {
  @apply min-w-[80px] w-[150px] h-[105px] object-contain bg-[white] rounded-[$btn-radius] border border-[color:var(--gray-300)] border-solid; // width: 100%;// height: 100%;
}
.single-upload .preview-container .percent-circle {
  @apply absolute -translate-x-2/4 -translate-y-2/4 h-[50px] w-[50px] left-2/4 top-2/4;
}
.single-upload .preview-container .delete-btn {
  @apply absolute border border-solid border-[rgba($white,0.3)] right-[3px] top-[3px];
}
.single-upload .custom-file-upload {
  @apply min-h-[47px] bg-[$white] hover:text-[$white] hover:bg-[$primary];
}
.single-upload .custom-file-upload input {
  @apply min-h-[47px];
}
.single-upload .custom-file-upload:hover svg {
  @apply fill-[$white];
}
.single-upload .message-row {
  @apply gap-[5px] min-h-[25px];
  --gap: 5px;
}
.single-upload .message-row .btn,
.single-upload .message-row .form-select-btn {
  @apply border border-solid border-[rgba($gray,0.3)];
}
.single-upload .badge {
  @apply border border-[color-mix(in_srgb,currentColor_10%,transparent)] border-solid;
}
@media (max-width: map-get($container-max-widths, "md")) {
  .single-upload .preview-container {
    @apply mr-0 mb-2;
  }
  .single-upload .preview-container .preview-img {
    @apply w-full max-w-[400px] h-[120px];
  }
  .single-upload .message-row {
    @apply min-h-[unset];
  }
}
.color-picker {
  @apply min-w-[2rem];
  outline: none;
}
.color-picker:focus {
  outline: none;
}
.color-picker .current-color {
  @apply w-full h-full min-w-[15px] min-h-[20px] inline border border-[color:var(--light-600,$gray)] border-solid;
  outline: none;
}
.color-picker .current-color:focus {
  outline: none;
}
.color-picker .color-selected {
  @apply relative after:absolute after:z-10 after:top-[-3px] after:right-[-3px] after:text-[$green] after:font-black after:content-["\f058"] after:bg-slate-50 after:rounded-[50%];
}
.color-picker .color-selected:after {
  font-family: "Font Awesome 5 Pro";
}
.color-picker .color-box {
  @apply block relative w-6 h-6 cursor-pointer rounded border m-1 p-2 border-solid border-[rgba($gray,0.3)];
}
.color-picker .color-box.color-selected {
  @apply shadow-[0_1px_3px_0_rgba($primary,0.5)] after:right-px after:top-px;
}
.color-picker .color-box {
  outline: none;
}
.color-picker .color-box:focus {
  outline: none;
}
.color-picker .color-default {
  @apply border pl-[0.4rem] pr-[0.2rem] border-solid border-[rgba($gray,0.3)];
}
.color-picker .color-dot {
  @apply inline-block w-[18px] h-[18px] align-middle ml-px rounded-[5rem];
}
.color-picker .color-selected-box {
  @apply border rounded-[$btn-radius_*_0.6] border-solid border-[rgba($gray,0.1)];
}
.color-picker .gradient-box {
  @apply w-10 h-[30px] cursor-pointer rounded-[0.3rem];
}
.color-picker .tippy-box,
.color-picker .tippy-content {
  @apply z-[999999];
}
.title-link {
  @apply flex items-center w-full text-[color:var(--gray-100)] transition-[0.6s] cursor-pointer hover:text-[color:var(--gray-600)];
}

$checkout-color: #687189 !default;
$checkout-bg: #f1f5ff !default;
#checkout .checkout-color {
  @apply text-[$checkout-color];
}
#checkout .checkout-bg {
  @apply bg-[$checkout-bg];
}
#checkout .checkout-bg-o {
  @apply bg-[rgba($checkout-bg,0.5)];
}
#checkout .text-muted {
  @apply font-[$font-weight-bold] text-[$checkout-color];
}
#checkout .checkout-extra {
  @apply flex flex-wrap border px-6 py-[0.05rem] rounded-[1.4rem] border-solid border-[$primary];
}
#checkout .form-panel label {
  @apply w-full border m-0 px-6 py-[0.05rem] rounded-[1.4rem];
  background: rgba($white, 0.6);
}
#checkout .form-panel input:checked + label {
  @apply bg-[color:var(--form-panel-bg,$form-selected)] text-[white];
}
#checkout .form-panel .h-badge {
  @apply flex justify-center items-center h-6 mx-0 my-[0.4rem];
}
#checkout .form-panel .h-badge .badge {
  @apply text-[0.55rem] px-[0.8rem] py-[0.35rem] rounded-[50rem];
}
#checkout .form-panel:hover label {
  background: $white;
}
#checkout aside {
  @apply bg-[lighten($checkout-bg,1.5)];
}
#checkout aside ul li {
  @apply flex items-center justify-between bg-[$white] shadow-[0px_1px_2px_rgba($gray,0.47)] font-[$font-weight-bold] mt-4;
}
#checkout aside ul li .checkout_item {
  @apply text-[$checkout-color];
}
#checkout aside ul li .checkout_price {
  @apply text-[$checkout-color] bg-[rgba($checkout-bg,0.9)] px-[0.8rem] py-[0.35rem];
}
#checkout .secure {
  @apply flex justify-center items-center text-[$checkout-color] text-[0.7rem] opacity-60;
}
.scroll-box {
  @apply text-center px-[0.1em] py-[0.3em];
}
.scroll-box label {
  @apply rounded-[$badge-radius_*_0.9] ml-0 mb-0;
}
.scroll-box img {
  @apply rounded-[$badge-radius_*_0.9] border border-[color:var(--light-200)] bg-[$white] text-center p-[3px] border-solid;
}
.scroll-box input:checked + label {
  @apply bg-transparent text-inherit;
}
.scroll-box div {
  @apply block text-[0.8rem] text-[color:var(--gray-500)] text-center mx-auto my-0;
}
@media (max-width: map-get($container-max-widths, "md")) {
  .scroll-box label {
    @apply p-[0.3rem];
  }
}
.map-picker .gm-style .gm-style-mtc button {
  @apply text-sm h-auto px-1.5 py-1;
}
.map-picker .gm-style .gm-zoom-in {
  @apply mr-[5px];
}
.map-picker .gm-style .gm-zoom-out {
  @apply ml-[5px];
}
#onboarding #onboarding_modal {
  @apply fixed z-[1050] flex w-screen inset-0; //align-items: stretch;outline: 0;
}
#onboarding #onboarding_modal #onboarding_content {
  @apply relative flex flex-wrap w-screen overflow-y-auto bg-[$white];
  align-items: start;
}
#onboarding #onboarding_menu {
  @apply bg-[$primary] transition-[background-color] duration-300 ease-linear;
  -webkit-transition: background-color 300ms linear;
}
#onboarding #onboarding_menu h2 {
  @apply text-[$white];
}
#onboarding #onboarding_menu .change_p {
  @apply text-[$light];
}
#onboarding #onboarding_menu .change_btn {
  @apply text-[color:var(--paragraph-color,#9697a4)] bg-[$white] border-[$white];
}
#onboarding #onboarding_menu.final {
  @apply bg-[$white];
}
#onboarding #onboarding_menu.final h2 {
  @apply text-[$heading-color];
}
#onboarding #onboarding_menu.final .change_p {
  @apply text-[color:var(--paragraph-color,#9697a4)];
}
#onboarding #onboarding_menu.final .change_btn {
  @apply text-[$white] bg-[$primary] border-[$primary];
}
#onboarding #onboarding_right {
  @apply bg-[$white] transition-[background-color] duration-300 ease-linear;
  -webkit-transition: background-color 300ms linear;
}
#onboarding #onboarding_right.final {
  @apply bg-[$primary];
}
@media (min-width: map-get($container-max-widths, "md")) {
  #onboarding #onboarding_modal #onboarding_content {
    @apply items-stretch min-h-screen;
  }
}
@media (min-width: map-get($container-max-widths, "md")) and (max-width: map-get($container-max-widths, "lg")) {
  #onboarding #onboarding_menu h2 {
    @apply text-[2rem];
  }
}
@media (max-width: map-get($container-max-widths, "lg")) {
  #onboarding #onboarding_menu h5 {
    @apply text-[$body] font-[$font-weight-bold] text-[clamp(1rem,1.5vw,1.1rem)];
  }
}
@media (max-width: map-get($container-max-widths, "md")) {
  #onboarding #onboarding_menu {
    @apply max-h-[280px];
  }
  #onboarding #onboarding_right {
    @apply min-h-[calc(100%_-_280px)];
  }
}
