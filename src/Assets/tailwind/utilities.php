@layer utilities {
    //BORDERS
    .border-3 {
        border-width: 3px;
    }
    .border-5 {
        border-width: 5px;
    }
    .body-fix {
        overflow: hidden;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
  	}
		.scroll-x {
  		overflow-x: auto;
  		overflow-y: hidden;
  		width: 100%;
  		white-space: nowrap;
			flex-wrap: nowrap;
      -ms-overflow-style: none;  /* IE and Edge */
      scrollbar-width: none;  /* Firefox */
		}
		.scroll-x::-webkit-scrollbar {
      display: none;
    }
}