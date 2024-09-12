<div x-data="beforeAfter()" x-init="initStyles()" class="before-after-container">
    <img class="img background-img" src="{{$afterImg}}" alt="After Image">
    <img class="img foreground-img" src="{{$beforeImg}}" alt="Before Image" :style="{ width: sliderPos + '%' }">
    <input type="range" min="1" max="100" x-model="sliderPos" @input="updateSliderButton()"class="slider" name="slider" id="slider">
    <div class="slider-button" x-ref="sliderButton">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 9l7-7 7 7M5 15l7 7 7-7"/>
        </svg>
    </div>
</div>

@pushOnce
<script>
    function beforeAfter() {
      return {
        sliderPos: 50,
        updateSliderButton() {
            this.$refs.sliderButton.style.left = `calc(${this.sliderPos}% - 18px)`;
        },
        initStyles() {
          const styleElement = document.createElement('style');
          styleElement.textContent = `
              .before-after-container {
                  position: relative;
                  width: 100%;
                  max-width: 600px;
                  margin: 0 auto;
              }
              .before-after-container .img {
                  position: absolute;
                  top: 0;
                  left: 0;
                  width: 100%;
                  height: 100%;
              }
              .before-after-container .foreground-img {
                  width: 50%;
                  overflow: hidden;
              }
              .before-after-container .slider {
                  position: absolute;
                  -webkit-appearance: none;
                  appearance: none;
                  width: 100%;
                  height: 100%;
                  background: rgba(0, 0, 0, 0.3);
                  outline: none;
                  margin: 0;
                  transition: all 0.2s;
                  display: flex;
                  justify-content: center;
                  align-items: center;
              }
              .before-after-container .slider::-webkit-slider-thumb {
                  -webkit-appearance: none;
                  appearance: none;
                  width: 36px;
                  height: 36px;
                  background: rgba(255, 255, 255, 0.3);
                  cursor: pointer;
                  border-radius: 50%;
              }
              .before-after-container .slider::-moz-range-thumb {
                  width: 36px;
                  height: 36px;
                  background: rgba(255, 255, 255, 0.3);
                  cursor: pointer;
                  border-radius: 50%;
              }
              .before-after-container .slider-button {
                  position: absolute;
                  left: calc(50% - 18px);
                  top: 50%;
                  width: 36px;
                  height: 36px;
                  border-radius: 50%;
                  background: white;
                  pointer-events: none;
                  display: flex;
                  justify-content: center;
                  align-items: center;
              }
          `;
          document.head.appendChild(styleElement);
        }
      }
    }
</script>
@endpushOnce