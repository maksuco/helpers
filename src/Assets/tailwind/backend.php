.backend-body {
  //color: <?=$backend["body"]?>;
  //background: linear-gradient(90deg, rgba(<?=$backend['bg']?>, 0.8) 30%, <?=$backend['bg']?> 70%);
  @apply bg-[<?=$backend['bg']?>] dark:bg-dark dark:text-light;
}
main {
  @apply relative px-1 md:px-8;
  .rounded-full {
    @apply rounded-[40px];
  }
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

.dark {
}


//HEADER
.nav-header {
  @apply relative flex items-center w-full h-[<?=$backend["headerHeight"]?>] lg:bg-white/20 dark:lg:bg-[#FFFFFF0B] rounded mb-3 z-10;
  flex: 0 0 auto;
  .nav-logo {
    @apply hidden flex items-center justify-center w-[55px];
    margin-inline: 1rem;
    .nav-logo-icon {
      @apply my-0;
      max-width: calc(<?=$backend["headerLogoHeight"]?> * 0.8);
    }
    .nav-logo-complete {
      @apply hidden max-w-[180px] max-h-[<?=$backend["headerLogoHeight"]?>] my-0;
    }
  }
  .nav-text {
    @apply flex items-center pl-2;
    .badge {
      @apply !rounded;
    }
  }
  .nav-top-box {
    @apply inline-flex items-center gap-1 fixed lg:relative lg:ml-auto z-[1] text-right rounded-[<?=$backend['headerRadius']?>] text-gray-500 px-2 py-[5px] right-3 top-2.5 lg:top-0;
    @apply bg-white/80;
    .nav-element {
      @apply cursor-pointer flex justify-center items-center text-center w-[30px] h-10 ml-[4px] my-0;
    }
    img {
      @apply cursor-pointer w-10 h-10 border border-light;
      border-radius: calc(<?=$backend['headerRadius']?> * 0.98);
    }
  }
  .nav-searchBox {
    @apply fixed z-[999] p-4 inset-0;
    background: <?=$backend['xs_sidebarBG']?>;
  }
}


@screen lg {
  .nav-header {
    .nav-logo {
      display: flex;
      .nav-logo-icon {
        display: block;
      }
    }
  } 
}

@screen xl {
  .nav-header {
    .nav-logo {
      @apply w-[240px] justify-start pl-2;
      .nav-logo-complete {
        display: block;
      }
      .nav-logo-icon {
        display: none;
      }
    }
  } 
}
@media (max-width: theme('screens.md')) {
  .nav-header {
    .nav-logo {
      @apply hidden;
    }
    .nav-text {
      @apply pl-2;
    }
    .nav-top-box {
      @apply right-2;
      .nav-element {
        @apply ml-1 my-0;
      }
    }
  }
}
.nav-article {
  @apply relative w-full min-h-[80vh] pl-0;
  //width: calc(100% - 275px);
  flex: 1 0 0%;
}
@media (min-width: theme('screens.md')) {
  .nav-article {
    @apply px-4;
  }
}

//SIDEBAR
.nav-sidebar {
  @apply relative;
  margin-inline: 0.8rem;
  position: sticky;
  position: -webkit-sticky;
  z-index: 1;

  .nav-sidebar-content {
    @apply relative clear-both p-1;
    ul {
      @apply w-full align-middle space-y-0;
      list-style: none;
      li {
        @apply leading-[0] py-[0.23rem];
        a {
          @apply relative font-normal flex lg:justify-center xl:justify-start items-center no-underline w-full <?=$config['btnRadius']?> opacity-80 px-[0.8rem] py-[0.6rem];
          @apply hover:opacity-100 hover:bg-white/80;
          line-height: 1.05;
        }
        svg {
          @apply !h-[1.4rem] !w-[1.4rem] opacity-100 my-0;
        }
        .nav-sidebar-active {
          @apply cursor-default !bg-brand !text-brand-50 !opacity-100;
        }
      }
    }
  }
}

.nav-sidebar-desktop {
    @apply w-[55px] bg-white dark:bg-white dark:text-gray-500 rounded-lg mt-1;
    position: sticky;
    position: -webkit-sticky;
    z-index: 1;
    top: 0.5rem;
    .nav-sidebar-content {
      font-size: 0;
      ul {
        li {
          a {
            @apply dark:text-gray-600;
          }
        }
      }
    }
}

.nav-sidebar-mobile {
  @apply !fixed top-3 w-full max-w-[310px] bg-white dark:bg-white shadow-2xl rounded-xl px-2 pt-4 pb-5;
  z-index: 9999;
  .nav-sidebar-logo {
      @apply flex justify-start p-2 mb-4;
      img {
        @apply max-h-[30px];
      }
  }
  .nav-sidebar-content {
    ul {
      li {
        a {
          @apply dark:text-gray-600;
          svg {
            @apply mr-2;
          }
        }
      }
    }
  }
}
@screen lg {
  .nav-sidebar-mobile {
    display: none;
  }
}

@screen xl {
  .nav-sidebar-desktop {
    @apply w-[240px] bg-transparent dark:bg-transparent;
    .nav-sidebar-content {
      font-size: 1rem;
      ul {
        li {
          a {
             @apply hover:bg-white/50 hover:dark:bg-white/10 dark:text-light;
          }
          svg {
            @apply -ml-1 mr-[9px] my-0;
          }
        }
      }
    }
  }
}

@media (max-width: theme('screens.lg')) {
  .nav-sidebar-desktop {
    display: none;
  }
}

//FORCE COMPRESS SIDEBAR
.compressSideBar {
  .nav-sidebar-desktop {
    @apply w-[55px] bg-white dark:bg-white text-gray-500 dark:text-gray-500;
    .nav-sidebar-content {
      font-size: 0;
      ul {
        li {
          a {
            justify-content: center !important;
            @apply hover:bg-light/70 text-gray-600;
            svg {
              @apply mx-0;
            }
          }
        }
      }
    }
  }
  .nav-article {
    @apply lg:pl-2;
  }
}

.breadcrumb {
  @apply py-0;
}
header {
  @apply flex flex-wrap w-auto box-border relative;
  .header-title {
    @apply flex items-center gap-2 min-h-[65px] px-0 py-[0.1rem];
    h1 {
      @apply text-[clamp(34px,4vw,47px)];
    }
    h2 {
      @apply text-[clamp(30px,3.5vw,40px)];
    }
    h3 {
      @apply text-[clamp(25px,3vw,30px)];
    }
    .v-div {
      @apply h-[90%] w-0.5 bg-gray-400 opacity-50 mx-[1.6rem];
    }
  }
}

@media (max-width: theme('screens.md')) {
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
@media (min-width: theme('screens.md')) {
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
  @apply leading-[1.3] text-[0.8rem] tracking-[0.08px] text-light bg-brand font-normal rounded-[<?=$backend['headerRadius']?>] cursor-pointer ml-1 mr-0 mt-1 mb-0 px-[0.55rem] py-[0.24rem];
}
header .options button i {
  @apply text-white text-base align-middle ml-[3px];
}
header .btn {
  @apply px-4;
}
header .dropdown-menu-right {
  @apply -top-px;
}

@screen md {
  header {
    @apply mt-0 mb-[0.8rem] mx-0;
  }
  header .row {
    @apply gap-[5px];
  }
}

@media (max-width: theme('screens.md')) {
  header {
    @apply mx-[0.6rem] my-[0.1rem];
    .row {
      @apply gap-1;
    }
    .btn {
      @apply px-2;
    }
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
}
footer {
  @apply w-full text-xs opacity-50 mt-5 m-0 px-8 py-4;
  flex: 0 0 100%;
}
@screen lg {
  footer {
    @apply px-4;
  }
}
.search-input input {
  @apply text-[2rem] text-dark caret-brand;
  outline: none;
  max-width: 100%;
}
.search-input input::placeholder {
  @apply text-gray-500 pl-[0.1rem];
}
.search-results {
  @apply fixed z-[99999] w-[90%] max-w-[450px] min-h-[100px] bg-white pt-4 pb-6 px-6 rounded-2xl right-[50px] top-2.5;
}
.search-results .search-result-item {
  @apply flex flex-wrap items-center w-full bg-white text-dark rounded border transition-[0.3s] leading-[0.9] mt-1 p-2 border-solid border-light hover:border hover:border-solid hover:border-brand;
}

@media (max-width: theme('screens.md')) {
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
