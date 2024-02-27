.single-upload {
  @apply relative flex flex-wrap w-full z-[2];
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
    @apply min-h-[47px] bg-white hover:text-white hover:bg-brand;
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
    @apply border border-solid border-light/30;
  }
  .form-select-btn {
    @apply border border-solid border-light/30;
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
.color-picker {
  @apply min-w-[2rem];
  outline: none;
  &:focus {
    outline: none;
  }
  .current-color {
    @apply w-full h-full min-w-[15px] min-h-[20px] inline border border-gray-600 border-solid;
    outline: none;
    &:focus {
      outline: none;
    }
  }
  .color-selected {
    @apply relative after:absolute after:z-10 after:top-[-3px] after:right-[-3px] after:text-green-500 after:font-black after:content-["\f058"] after:bg-slate-50 after:rounded-[50%];
    &:after {

    }
  }
  .color-box {
    @apply block relative w-6 h-6 cursor-pointer rounded border m-1 p-2 border-solid border-gray-500/30;
    outline: none;
    .color-selected {
      @apply shadow-brand after:right-px after:top-px;
    }
    &:focus {
      outline: none;
    }
  }
}


.color-picker .color-default {
  @apply border pl-[0.4rem] pr-[0.2rem] border-solid border-light/30;
}
.color-picker .color-dot {
  @apply inline-block w-[18px] h-[18px] align-middle ml-px rounded-[5rem];
}
.color-picker .color-selected-box {
  @apply border border-solid border-gray-500/15;
  border-radius: calc(<?=$backend['headerRadius']?> * 0.6);
}
.color-picker .gradient-box {
  @apply w-10 h-[30px] cursor-pointer rounded-[0.3rem];
}
.color-picker .tippy-box,
.color-picker .tippy-content {
  @apply z-[999999];
}
.title-link {
  @apply flex items-center w-full text-gray-100 transition-[0.6s] cursor-pointer hover:text-gray-600;
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
