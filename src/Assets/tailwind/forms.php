@layer base {
}

.label {
    @apply flex items-center text-sm tracking-tight py-1 px-1;
    color: <?= $config['light']['label'] ?>;
}

input[type="checkbox"], input[type="radio"] {
    accent-color: var(--form-color, theme('colors.brand.500'));
}
input[type='select'], select {
    @apply !appearance-none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
}
input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus, input:-webkit-autofill:active, input:-webkit-autofill, input:-webkit-autofill-strong-password {
  background-color: transparent !important;
}

.form-basic, .form-muted {
    @apply w-full leading-6 px-4 <?=$config['btnRadius']?> transition shadow-sm disabled:pointer-events-none disabled:opacity-50;
    @apply py-[<?=$config['btnPaddingY'] * 0.25 ?>rem];
    @apply bg-<?=$config['formBG']?> <?=$config['formBorder']?> border-<?=$config['formBorderColor']?>;
    @apply text-base focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent;
    font-size: 1.05rem;
    @apply autofill:transition-colors autofill:duration-[5000000ms];
}

.form-basic {
    @apply focus:bg-white;
    color: <?= $config['light']['form-basic-text'] ?>;
    background-color: <?= $config['light']['form-basic-bg'] ?>;
}

.form-muted {
    @apply focus:bg-white border-0;
    color: <?= $config['light']['form-muted-text'] ?>;
    background-color: <?= $config['light']['form-muted-bg'] ?>;
}

//enclosing div
.form-float {
  @apply relative;
  input {
    @apply pt-[<?=$config['btnPaddingY'] * 0.8 ?>rem];
  }
  label {
    @apply absolute top-0 w-full pl-4;
    font-size: .9em;
    opacity: .75;
    //inset-inline-start: <?=$config['btnPaddingX'] * 0.9 ?>;
  }
  // input {
  //   @apply peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600
  //     focus:pt-6
  //     focus:pb-2
  //     [&:not(:placeholder-shown)]:pt-6
  //     [&:not(:placeholder-shown)]:pb-2
  //     autofill:pt-6
  //     autofill:pb-2;

  // }
  // label {
  //   @apply absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
  //   peer-focus:text-xs
  //   peer-focus:-translate-y-1.5
  //   peer-focus:text-gray-500
  //   peer-[:not(:placeholder-shown)]:text-xs
  //   peer-[:not(:placeholder-shown)]:-translate-y-1.5
  //   peer-[:not(:placeholder-shown)]:text-gray-50;
  // }
}


.form-sm {
    @apply text-sm px-3 py-[<?= minPadding($config['btnPaddingY'],1,0.2) ?>rem];
    background-size: 1.4em 1.4em;
}
.form-lg {
    @apply text-lg px-5 py-[<?=($config['btnPaddingY'] + 0.4) * 0.25 ?>rem];
    background-size: 1.5em 1.5em;
}
.form-xl {
    @apply text-xl px-6 py-[<?=($config['btnPaddingY'] + 1.3) * 0.25 ?>rem];
    background-size: 1.55em 1.55em;
}
.form-2xl {
    @apply text-2xl px-6 py-[<?=($config['btnPaddingY'] + 1.3) * 0.25 ?>rem];
    background-size: 1.55em 1.55em;
}

.form-btn {
    cursor: pointer;
    border: none;
    @apply flex items-center py-1.5 px-2 gap-x-1;
    @apply hover:bg-light hover:bg-opacity-90;
    @apply has-[:checked]:bg-light has-[:checked]:bg-opacity-80;
    @apply text-<?=$config['labelColor']?> tracking-tight;
    label {
        cursor: pointer;
        @apply text-<?=$config['labelColor']?> tracking-tight px-1;
    }
    input {
      border-radius: inherit;
      @apply h-4 w-5 border-gray-300 focus:ring-indigo-500;
      accent-color: var(--form-color, theme('colors.brand.500'));
    }
}



.form-btn-label {
  position: relative;
  cursor: pointer;
  @apply flex items-center px-3 border-0 gap-x-1;
  @apply has-[:checked]:text-light;
  &:has(:checked) {
    background-color: var(--form-color, theme('colors.brand.500'));
  }
  &:has(input:checked)::after {
    content: '\2713';
    color: white;
    position: absolute;
    padding: 0.11rem 0.14rem;
    font-size: 0.6rem;
    font-weight: bold;
    line-height: 1;
    top: -0.25rem;
    right: -0.1rem;
    background-color: theme('colors.green.500');
    border-radius: 2px;
    text-align: center;
  }
  label {
    cursor: pointer;
  }
  input {
    display: none;
  }
}


 .custom-file-upload {
  @apply relative inline-block cursor-pointer overflow-hidden;
  @apply text-<?=$config['labelColor']?> bg-light;
  svg{fill:inherit}
  * {pointer-events:none}
  label{cursor:pointer}
  &:hover{
    color:#fff; background-color:var(--form-color, theme('colors.brand.500'));
    svg{fill:#fff}
  }
  input {
    @apply opacity-0 absolute inset-0;
    width:100%; height:100%;
  }
}

.form-switch {
  @apply appearance-none disabled:opacity-50 disabled:pointer-events-none checked:bg-none;
  @apply relative w-[2.8rem] p-px bg-<?=$config['formBG']?> border-transparent rounded-full cursor-pointer transition;
  @apply checked:text-<?=$config['formBG']?> checked:border-<?=$config['formBG']?> focus:checked:border-<?=$config['formBG']?> dark:bg-dark-input dark:border-<?=$config['formBG']?>;
  @apply before:inline-block before:w-6 before:h-6 before:bg-white before:translate-x-0 checked:before:translate-x-3/4 before:rounded-full before:transform before:transition dark:before:bg-white dark:checked:before:bg-blue-200;
  line-height: .81;
  &:checked{
    background-color: var(--form-color, theme('colors.brand.500')) !important;
  }
  &:checked::before{
    @apply shadow-sm;
    background-color: theme('colors.white');
  }
}


// :is(.dark .form-switch:checked)::before {
//   background-color: theme('colors.white');
// }

.form-switch-sm {
  @apply before:w-5 before:h-5;
  width: 2.3rem;
  line-height: .75;
}

.form-switch-lg {
  @apply w-[3.7rem] p-0.5;
  @apply before:w-8 before:h-8;
  line-height: .8;
}


:root {
  --rounded-box: 1rem;
  --fallback-p: #491eff;
  --fallback-b1: #ffffff;
  --fallback-bc: #1f2937;
  --b1: 1 0 0;
  --bc: 0.278078 0.029596 256.847952;
}


//RANGE
.form-range {
  height: 1.5rem;
  width: 100%;
  --range-shdw: var(--form-color, theme('colors.brand.500'));
  @apply appearance-none cursor-pointer overflow-hidden rounded-full bg-transparent;
  &:focus {
    outline:none
  }
  &:focus-visible::-webkit-slider-thumb {
    --focus-shadow: 0 0 0 6px var(--fallback-b1, oklch(var(--b1)/1)) inset, 0 0 0 2rem var(--range-shdw) inset;
  }
  //LINE
  &::-webkit-slider-runnable-track {
    height: 0.5rem;
    width: 100%;
    @apply bg-<?=$config['formBG']?> rounded-full;
  }
  &::-webkit-slider-thumb {
    position: relative;
    height: 1.5rem;
    width: 1.5rem;
    border-radius: var(--rounded-box, 1rem);
    border-style: none;
    --tw-bg-opacity: 1;
    background-color: var(--fallback-b1,oklch(var(--b1)/var(--tw-bg-opacity)));
    appearance: none;
    -webkit-appearance: none;
    top: 50%;
    color: var(--range-shdw);
    transform: translateY(-50%);
    --filler-size: 100rem;
    --filler-offset: 0.6rem;
    box-shadow: 0 0 0 3px var(--range-shdw) inset,
      var(--focus-shadow, 0 0),
      calc(var(--filler-size) * -1 - var(--filler-offset)) 0 0 var(--filler-size)
  }
}


// .form-range-brand {
//     --range-shdw: var(--fallback-p, oklch(var(--p)/1));
// }



.form-range-xs {
    height: 1rem}
.form-range-xs::-webkit-slider-runnable-track {
    height: 0.25rem}
.form-range-xs::-moz-range-track {
    height: 0.25rem}
.form-range-xs::-webkit-slider-thumb {
    height: 1rem;
    width: 1rem;
    --filler-offset: 0.4rem}
.form-range-xs::-moz-range-thumb {
    height: 1rem;
    width: 1rem;
    --filler-offset: 0.4rem}
.form-range-sm {
    height: 1.25rem}
.form-range-sm::-webkit-slider-runnable-track {
    height: 0.25rem}
.form-range-sm::-moz-range-track {
    height: 0.25rem}
.form-range-sm::-webkit-slider-thumb {
    height: 1.25rem;
    width: 1.25rem;
    --filler-offset: 0.5rem}
.form-range-sm::-moz-range-thumb {
    height: 1.25rem;
    width: 1.25rem;
    --filler-offset: 0.5rem}
.form-range-md {
    height: 1.5rem}
.form-range-md::-webkit-slider-runnable-track {
    height: 0.5rem}
.form-range-md::-moz-range-track {
    height: 0.5rem}
.form-range-md::-webkit-slider-thumb {
    height: 1.5rem;
    width: 1.5rem;
    --filler-offset: 0.6rem}
.form-range-md::-moz-range-thumb {
    height: 1.5rem;
    width: 1.5rem;
    --filler-offset: 0.6rem}
.form-range-lg {
    height: 2rem}
.form-range-lg::-webkit-slider-runnable-track {
    height: 1rem}
.form-range-lg::-moz-range-track {
    height: 1rem}
.form-range-lg::-webkit-slider-thumb {
    height: 2rem;
    width: 2rem;
    --filler-offset: 1rem}



.form-range-vertical {
  @apply relative;
  height: 20rem;
  width: 3rem;
  &::before, &::after {
    @apply block absolute;
    z-index: 99;
    color: #fff;
    width: 100%;
    text-align: center;
    font-size: 1.5rem;
    line-height: 1;
    padding: .75rem 0;
    pointer-events: none;
  }
  &::before {
    content: "+";
  }
  &::after {
    content: "−";
    bottom: 0;
  }

  input[type="range"] {
    @apply appearance-none absolute rounded overflow-hidden;
    background-color: rgba(#fff, .2);
    top: 50%;
    left: 50%;
    margin: 0;
    padding: 0;
    width: 20rem;
    height: 3.5rem;
    transform: translate(-50%, -50%) rotate(-90deg);
    cursor: row-resize;
    
    &[step]{
      background-color: transparent;
      background-image: repeating-linear-gradient(to right, rgba(#fff, .2), rgba(#fff, .2) calc(12.5% - 1px), #05051a 12.5%);
    }

    &::-webkit-slider-thumb {
      -webkit-appearance: none;
      width: 0;
      box-shadow: -20rem 0 0 20rem rgba(#fff, 0.2);
    }

    &::-moz-range-thumb {
      border: none;
      width: 0;
      box-shadow: -20rem 0 0 20rem rgba(#fff, 0.2);
    }
  }
}

//DOTS
.dot {
  @apply inline-block flex-none rounded-full p-1;
  div {
    @apply h-1.5 w-1.5 rounded-full;
  }
}
.dot-brand {
  @apply bg-brand-500/20;
  div {
    @apply bg-brand-500;
  }
}
.dot-red {
  @apply bg-red-500/20 p-1;
  div {
    @apply bg-red-500;
  }
}
.dot-orange {
  @apply bg-orange-500/20 p-1;
  div {
    @apply bg-orange-500;
  }
}
.dot-green {
  @apply bg-emerald-500/20 p-1;
  div {
    @apply bg-emerald-500;
  }
}


//PANEL
.form-panel {
  @apply relative inline-block;
  width: 100%;
  input {
    @apply !absolute h-px w-px border-0 overflow-hidden;
    clip: rect(0, 0, 0, 0);
    &:checked + label {
      background-color: var(--form-color, theme('colors.brand.500'));
      border-color: var(--form-color, theme('colors.brand.500'));
      color: white;
      box-shadow: none;
    }
  }
  label {
    @apply relative inline-block text-xs font-bold text-center border-2 select-none;
    border-color: var(--form-color, theme('colors.brand.500'));
    line-height: 1.1;
    text-shadow: none;
    height: 100%;
    min-height: 142px;
    min-width: 140px;
    transition: all 0.2s ease-in-out;
    // b {
    //   //color: var(--form-panel-bg, $dark);
    //   font-size: 1.3rem;
    // }
    // .h-badge {
    //   @apply flex justify-center items-center;
    //   min-height: 1.2rem;
    //   margin: .4rem 0;
    // }
    // span {
    //   @apply relative mx-auto text-5xl;
    //   //color: var(--form-panel-bg, $dark);
    //   display: table;
    //   line-height: 1;
    //   &::before {
    //     @apply absolute text-2xl font-normal;
    //     content: '$';
    //     top: .5rem;
    //     left: -15px;
    //     line-height: 1;
    //   }
    //   &::after {
    //     @apply absolute text-xs font-light;
    //     content: 'usd';
    //     bottom: .2rem;
    //   }
    // }
    &:hover {
        @apply cursor-pointer;
      //background-color: lighten($primary, 60);
    }
    
  }
  @screen md {
    b {
      font-size: 1.2rem !important;
    }
    label {
      width: 100%;
      padding: 1.1rem 1.5rem;
      min-height: 40px;
      margin-right: 0px;
    }
    span {
      @apply text-2xl;
      &::after {
        @apply text-xs;
      }
    }
  }
}


//DARK
.dark {
  .label {
      //@apply text-<?=$config['labelColorDark']?>;
      color: <?= $config['dark']['label'] ?>;
  }
  .form-basic {
      color: <?= $config['dark']['form-basic-text'] ?>;
      background-color: <?= $config['dark']['form-basic-bg'] ?>;
      border-color: <?= $config['dark']['form-basic-border'] ?>;
  }

  .form-muted {
      color: <?= $config['dark']['form-muted-text'] ?>;
      background-color: <?= $config['dark']['form-muted-bg'] ?>;
  }

  .form-btn {
    @apply text-<?=$config['labelColorDark']?> hover:bg-light !bg-opacity-20 has-[:checked]:bg-<?=$config['formBGDark']?>;
  }

  .form-switch {
    @apply bg-<?=$config['formBGDark']?>;
  }
  .form-range {
    &::-webkit-slider-runnable-track {
      @apply bg-<?=$config['formBGDark']?>;
    }
  }
  .custom-file-upload {
      @apply text-<?=$config['labelColorDark']?> bg-opacity-20 border-<?=$config['labelColorDark']?>;
      background-color: theme('colors.light');
  }
}


.form-error {
  @apply text-xs text-red-500;
  line-height: .8;
}
.form-warning {
  @apply text-xs text-orange-500;
  line-height: .8;
}
