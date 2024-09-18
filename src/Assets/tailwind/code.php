//WINDOW

.token {
	.tag {
		@apply text-indigo-400 opacity-70;
	}
	&.string {
		@apply text-orange-400 opacity-90;
	}
	&.function {
		@apply text-teal-400 opacity-90;
	}
	&.parameter {
		@apply text-indigo-400 opacity-80;
	}
}
.hljs-comment {
		@apply text-gray-400 opacity-90;
}
.hljs-name {
		@apply text-orange-400 opacity-80;
}
.hljs-tag {
		@apply text-indigo-400 opacity-80;
}
.hljs-string {
		@apply text-orange-400 opacity-90;
}
.hljs-title {
		@apply text-teal-400 opacity-90;
}
.hljs-keyword {
		@apply text-teal-200 opacity-90;
}

.code-box, .code-window, .code-single {
  @apply relative inline-grid w-full border-0 bg-dark text-light box-sm text-left;
  outline: none !important;
  tab-size: 2;
  direction: ltr;
  -webkit-hyphens: none;
  hyphens: none;
  &::-webkit-scrollbar {
    width: 0px;
  }
  code {
    @apply block text-white;
    overflow-x: auto;
    &::-webkit-scrollbar {
      width: 0px;
    }
  }
  .copy-icon {
    @apply block absolute top-1 right-1 opacity-0 rounded bg-white/80 text-gray-500 px-3 py-1.5;
    content: '';
    z-index: 30;
    width: 25px;
    height: 25px;
    cursor: pointer;
    background-size: 60%;
    background-position: center;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg width='370' height='449' viewBox='0 0 370 449' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M355.941 60.941L304.059 14.059C295.057 5.05724 282.848 6.65676e-05 281.118 0H153C126.49 0 105 21.49 105 48V91H48C21.49 91 0 112.49 0 139V401C0 427.51 21.49 449 48 449H249C275.51 449 297 427.51 297 401V368H322C348.51 368 370 346.51 370 320V94.882C370 82.1516 364.943 69.9427 355.941 60.941ZM274 32.491C276.813 33.1852 279.383 34.6359 281.431 36.686L333.313 83.569C335.363 85.617 336.814 88.1867 337.508 91H274V32.491ZM265 401C265 409.822 257.822 417 249 417H48C39.178 417 32 409.822 32 401V139C32 130.178 39.178 123 48 123H105V320C105 346.51 126.49 368 153 368H265V401ZM338 320C338 328.822 330.822 336 322 336H153C144.178 336 137 328.822 137 320V48C137 39.178 144.178 32 153 32H242V99C242 112.2 252.8 123 266 123H338V320Z' fill='black'/%3E%3C/svg%3E%0A");
  }
  .tabs {
    position: absolute;
    top: 9px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    &::-webkit-scrollbar {
      display: none;
    }
    display: block;
    overflow-x: auto;
    overflow-y: hidden;
    width: calc(100% - 80px);
    white-space: nowrap;
    -moz-user-select: none;
    user-select: none;
    .tab {
      @apply inline-block text-light bg-brand/20;
      line-height: 1.8rem;
      padding: 0 1rem;
      font-size: 0.7rem;
      cursor: pointer;
      -moz-user-select: none;
      user-select: none;
      &:hover {
        @apply text-light bg-brand/40;
      }
      &.tab-active {
        @apply text-white bg-brand/70;
      }
    }
  }
  &:hover {
    .copy-icon {
      opacity: 1;
    }
  }
  @media (max-width: theme('screens.lg')) {
    .tabs {
      .tab {
        line-height: 1.4rem;
        padding: 0 0.6rem;
      }
    }
  }

}

.code-window, .code-box {
  overflow-wrap: break-word !important;
  word-break: break-all !important;
  code {
    // overflow-wrap: break-word !important;
    // word-break: break-all !important;
    // overflow-x: scroll;
    // white-space: nowrap;
    //to break words
    //display: inline-block;
    //word-wrap:break-word;
    //white-space: normal;
  }
}

.code-box {
  padding: 0.1rem 1.2rem 1.2rem 1.5rem;
}

.code-window {
  padding: 1.6rem 1.2rem 1.2rem 1.5rem;
  background-image: url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" width="54" height="14" viewBox="0 0 54 14"><g fill="none" fillRule="evenodd" transform="translate(1 1)"><circle cx="6" cy="6" r="6" fill="%23FF5F56" stroke="%23E0443E" strokeWidth=".5" /><circle cx="26" cy="6" r="6" fill="%23FFBD2E" stroke="%23DEA123" strokeWidth=".5" /><circle cx="46" cy="6" r="6" fill="%2327C93F" stroke="%231AAB29" strokeWidth=".5" /></g></svg>');
  background-repeat: no-repeat;
  background-position: 16px 16px;
  overflow-wrap: break-word !important;
  word-break: break-all !important;

  .tabs {
    top: 9px;
    left: 80px;
    .tab {
    }
  }

  @media (max-width: theme('screens.lg')) {
    background-size: 37px auto;
    background-position: 18px 15px;
    max-width: 100% !important;
    padding: 2rem 1.1rem 1.2rem 1.1rem;
    .tabs {
      top: 5px;
      left: 70px;
      .tab {
      }
    }
  }
}


//PRE CODE CSS
.code-single {
  @apply !flex flex-wrap items-stretch min-h-6 box-sm p-0;
  code {
    overflow-wrap: break-word !important;
    word-break: break-all !important;
    //padding: 1.1rem 1rem .9rem 1.2rem;
    line-height: 1.1rem;
    //margin: 0 2rem 0 0;
    padding: 0.3rem 2rem 0.3rem 1.8rem;
    overflow-x: scroll;
    flex: 1;
  }
	&:has(label) {
		code {
  		padding-left: 1rem;
		}
	}
  label {
    @apply flex justify-center items-center text-center font-bold uppercase label opacity-70 m-0 text-gray-600 bg-white/90 border-r border-white/60;
		@apply w-[43px] lg:w-[48px];
    vertical-align: middle;
    padding: 0px 0.6rem 0px 0.8rem;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    pointer-events: none;
  }
  @media (max-width: theme('screens.lg')) {
    label {
      font-size: .7rem;
    }
    code {
      font-size: .8rem;
    	padding: 0.1rem 1.8rem 0.1rem 0.8rem;
    }
  }
}


.code-all {
  code {
    @apply relative inline-block text-dark bg-light/90 rounded;
    top: -1px;
    padding: .15em .34em;
    padding-bottom: .08em;
  }
  mark {
    padding: 0 .25em;
  }
}