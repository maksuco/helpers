.single-upload {
  @apply relative flex flex-wrap gap-2 w-full z-[2];
  .preview-container {
    @apply relative mr-[0.8rem];
    .preview-img {
      @apply min-w-[80px] w-[150px] h-[105px] object-contain bg-[white] rounded-[<?=$backend['headerRadius']?>] border border-gray-300 border-solid; // width: 100%;// height: 100%;
    }
    .percent-circle {
      @apply absolute -translate-x-2/4 -translate-y-2/4 h-[50px] w-[50px] left-2/4 top-2/4;
    }
    .delete-btn {
      @apply absolute border border-solid border-white/30 right-[3px] top-[3px];
    }
  }
  .custom-file-upload {
    @apply flex items-center min-h-[47px] text-dark bg-white hover:text-white hover:bg-brand;
    input {
      @apply min-h-[47px];
    }
    &:hover svg {
      @apply fill-white;
    }
  }
  .message-row {
    @apply gap-[5px] min-h-[25px];
    --gap: 5px;
  }
  .btn, .form-select-btn {
    @apply border border-solid border-gray-500;
  }
  .form-select-btn {
    @apply border border-solid border-gray-500;
  }
}

@media (max-width: theme('screens.md')) {
  .single-upload {
    .preview-container {
      @apply mr-0 mb-2;
      .preview-img {
        @apply w-full max-w-[400px] h-[120px];
      }
    }
    .message-row {
      @apply min-h-[unset];
    }
  }
}


//COLOR PICKER
.color-picker {
  @apply block;
  outline: none;
  //z-index: 15;
  &:focus {
    outline: none;
  }
  .current-color {
    @apply border border-slate-200 w-8 h-full;
    min-width: 20px;
    min-height: 20px;
    display: inline;
    outline: none;
    &:focus {
      outline: none;
    }
  }
  .color-dropdown {
    @apply box-sm p-1.5 bg-white shadow-lg shadow-brand/30;
    z-index: 150;
    opacity: 1 !important;
    max-width: 280px;
    outline: none;
    overflow: hidden;
    cursor: auto;
  }
  .color-selected {
    position: relative;
    &:after {
      @apply absolute z-10 !top-[-6px];
      @apply w-1 h-1;
      content: "✅";
      font-size: 0.65em;
    }
  }
  .color-box {
    @apply border border-gray-500/30;
    display: block;
    position: relative;
    width: 24px;
    height: 24px;
    cursor: pointer;
    border-radius: 0.25rem;
    margin: 0.25rem;
    padding: 0.5rem;
    &.color-selected {
      @apply shadow shadow-brand;
      &:after {
        top: 1px; right: 1px;
      }
    }
    outline: none;
    &:focus {
      outline: none;
    }
  }
  .color-default {
    @apply border border-gray-500/30;
    //background-image: linear-gradient(90deg, rgba(255,255,255,0) 75%, var(--color_default_bg, #ffffff) 75%);
    padding-left: 0.4rem !important;
    padding-right: 0.2rem !important;
  }
  .color-dot {
    display: inline-block;
    width: 18px;
    height: 18px;
    vertical-align: middle;
    margin-left: 1px;
    border-radius: 5rem;
  }
  .color-selected-box {
    @apply border border-gray-500/10 rounded;
  }
  .gradient-box {
    width: 40px;
    height: 30px;
    cursor: pointer;
    border-radius: 0.3rem;
  }
  .tippy-box, .tippy-content {
    z-index: 999999;
  }
}

.title-link {
  @apply flex items-center w-full text-gray-300 hover:text-gray-500 transition-none duration-0 cursor-pointer;
}

$checkout-color: #687189 !default;
$checkout-bg: #f1f5ff !default;

#checkout .checkout-extra {
  @apply flex flex-wrap border px-6 py-[0.05rem] rounded-[1.4rem] border-solid border-brand;
}
#checkout aside ul li {
  @apply flex items-center justify-between bg-white font-bold mt-4;
}
#checkout .secure {
  @apply flex justify-center md:justify-start items-center text-[0.7rem] opacity-60;
}
.scroll-box {
  @apply text-center px-[0.1em] py-[0.3em];
}
.scroll-box label {
  @apply rounded ml-0 mb-0;
}
.scroll-box img {
  @apply rounded border border-light bg-white text-center p-[3px] border-solid;
}
.scroll-box input:checked + label {
  @apply bg-transparent text-inherit;
}
.scroll-box div {
  @apply block text-[0.8rem] text-center mx-auto my-0;
}

@media (max-width: theme('screens.md')) {
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
  @apply relative flex flex-wrap w-screen overflow-y-auto bg-white;
  align-items: start;
}
#onboarding #onboarding_menu {
  @apply bg-brand transition-[background-color] duration-300 ease-linear;
  -webkit-transition: background-color 300ms linear;
}
#onboarding #onboarding_menu h2 {
  @apply text-white;
}
#onboarding #onboarding_menu .change_p {
  @apply text-light;
}
#onboarding #onboarding_menu .change_btn {
  @apply bg-white border-white;
}
#onboarding #onboarding_menu.final {
  @apply bg-white;
}
#onboarding #onboarding_menu.final .change_btn {
  @apply text-white bg-brand border-brand;
}
#onboarding #onboarding_right {
  @apply bg-white transition-[background-color] duration-300 ease-linear;
  -webkit-transition: background-color 300ms linear;
}
#onboarding #onboarding_right.final {
  @apply bg-brand;
}

@media (min-width: theme('screens.md')) {
  #onboarding #onboarding_modal #onboarding_content {
    @apply items-stretch min-h-screen;
  }
}
@media (min-width: theme('screens.md')) and (max-width: theme('screens.lg')) {
  #onboarding #onboarding_menu h2 {
    @apply text-[2rem];
  }
}
@media (max-width: theme('screens.lg')) {
  #onboarding #onboarding_menu h5 {
    @apply font-bold;
  }
}
@media (max-width: theme('screens.md')) {
  #onboarding #onboarding_menu {
    @apply max-h-[280px];
  }
  #onboarding #onboarding_right {
    min-height: calc(100% - 280px);
  }
}


//TOOLTIP
.tippy-box {
  @apply text-light bg-dark dark:text-light dark:bg-slate-800 rounded-lg;
	font-size: 0.9rem;
  line-height: 1.4;
  white-space: normal;
  padding: 0.5rem 0.8rem;
  max-width: 280px !important;
  z-index: 1;
  &::before {
    @apply absolute-bc bg-dark dark:bg-slate-800 rounded-full;
    content: "";
    bottom: -4px;
    width: 14px;
    height: 14px;
  }
}
// .tippy-arrow{
//   @apply bg-dark dark:bg-slate-800;
//     width:16px;
//     height:16px;
// }
// .tippy-arrow:before{content:"";position:absolute;border-color:transparent;border-style:solid}