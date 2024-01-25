@layer base {
}

label {
    @apply text-sm text-<?=$config['labelColor']?> tracking-tight py-1;
}
.form-basic, .form-muted {
    @apply w-full leading-6 border-<?=$config['btnBorderColor']?> <?=$config['btnRadius']?> shadow-sm;
}

.form-basic {
    @apply bg-white;
}

.form-muted {
    @apply bg-<?=$config['btnBgColor']?> focus:bg-white border-<?=$config['btnBgColor']?>;
}
.form-muted [type='select'] {
}
.form-muted [type='checkbox'] {
    @apply bg-white;
}
.form-muted [type='radio'] {
}


.custom-file-upload {
    @apply relative inline-block text-sm py-1 px-2 cursor-pointer overflow-hidden;
    svg {
        fill: inherit;
    }
    &* {
        pointer-events: none;
    }
    label {
        cursor: pointer;
    }
    &:hover {
        @apply text-white bg-primary;
        svg {
        fill: white;
        }
    }
    input {
        @apply opacity-0 absolute inset-0;
    }
}


.form-switch {
  width: 46px;
  height: 26px;
  display: inline-block;
  vertical-align: -26%;
  border-radius: 16px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  position: relative;
  cursor: pointer;
  -ms-flex-item-align: center;
  -webkit-align-self: center;
  align-self: center;
  outline: 0;

  input[type="checkbox"] {
    width: 46px;
    height: 26px;
    border-radius: 16px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    background: #e5e5e5;
    z-index: 0;
    margin: 0;
    padding: 0;
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    appearance: none;
    border: none;
    cursor: pointer;
    position: relative;
    -webkit-transition-duration: 300ms;
    transition-duration: 300ms;
    outline: 0
  }

  input[type="checkbox"]:before {
    content: ' ';
    width: 43px;
    height: 24px;
    position: absolute;
    left: 2px;
    top: 2px;
    border-radius: 16px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    background: $white;
    z-index: 1;
    -webkit-transition-duration: 300ms;
    transition-duration: 300ms;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1)
  }

  input[type="checkbox"]:after {
    content: ' ';
    height: 22px;
    width: 22px;
    border-radius: 22px;
    background: #fff;
    position: absolute;
    z-index: 2;
    top: 2px;
    left: 2px;
    -webkit-box-shadow: 0 2px 5px rgba($black, 0.4);
    box-shadow: 0 2px 5px rgba($black, 0.4);
    -webkit-transform: translate3d(0, 0, 0);
    -ms-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    -webkit-transition-duration: 300ms;
    transition-duration: 300ms
  }

  input[type="checkbox"]:checked {
    background: $form-selected;
  }
  
  input[type="checkbox"]:checked:before {
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0)
  }
  
  input[type="checkbox"]:checked:after {
    -webkit-transform: translate3d(20px, 0, 0);
    -ms-transform: translate3d(20px, 0, 0);
    transform: translate3d(20px, 0, 0)
  }

  &.form-xxsm {
    width: 23px;
    height: 13px;
    transform: scale(0.8);
    input[type="checkbox"] {
      width: 23px;
      height: 13px;
      border-radius: 16px;
    }
    input[type="checkbox"]:before {
      width: 23px;
      height: 13px;
      border-radius: 16px;
    }
    input[type="checkbox"]:after {
      width: 11px;
      height: 11px;
      border-radius: 16px;
      top: 1px;
      -webkit-box-shadow: 0 2px 5px rgba($black, 0.4);
      box-shadow: 0 2px 5px rgba($black, 0.4);
    }
    input[type="checkbox"]:checked:after {
      -webkit-transform: translate3d(9px, 0, 0);
      -ms-transform: translate3d(9px, 0, 0);
      transform: translate3d(9px, 0, 0)
    }
  }
  &.form-sm {
    transform: scale(0.7);
  }
  &.form-xs {
    transform: scale(0.5);
  }
}
