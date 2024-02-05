.dropdown {
  @apply absolute z-10 mt-1 w-auto min-w-56 divide-y divide-<?=$config['dropdownTextColor']?>-100 <?=$config['dropdownRadius']?> bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden;
  span {
    @apply leading-none;
  }
  img, svg {
    @apply h-6 w-6 -ml-1 flex-none <?=$config['btnRadius']?> text-<?=$config['dropdownTextColor']?>-500 bg-<?=$config['dropdownItemsBG']?> p-0.5;
  }
  .dropdown-item {
    @apply flex items-center gap-x-2 text-<?=$config['dropdownTextColor']?>-700 block mx-1 py-1.5 px-2 <?=$config['btnRadius']?> hover:bg-<?=$config['dropdownItemsBG']?>;
    font-size: 0.92rem;
  }

  .dropdown-container {
    @apply flex items-center gap-x-2 block py-1.5 px-3 bg-<?=$config['dropdownItemsBG']?>;
  }

  .dropdown-title {
    @apply block py-2 px-2.5 text-sm font-medium uppercase text-<?=$config['dropdownTextColor']?>-400 dark:text-<?=$config['dropdownTextColor']?>-400;
    font-size: 0.82rem;
  }
}

.dropdown-right {
  @apply right-0 origin-top-right;
}

.dropdown-center {
  right: unset;
  left: 50%;
  transform: translateX(-50%);
  @apply  origin-top;
}

.dropdown-left {
  right: unset;
  @apply  left-0 origin-top-left;
}