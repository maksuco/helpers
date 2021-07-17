// @codekit-prepend "../packages/alpine/alpinev2.js";

// @codekit-prepend "assets/packages/apexcharts/locales/es.json";
// @codekit-prepend "assets/packages/apexcharts/apexcharts.min.js";

// @codekit-prepend "assets/packages/flickity/flickity.js";

// @codekit-prepend "assets/packages/highlights/highlights.js";

// @codekit-prepend "assets/packages/moment/moment-with-locales.js";

// @codekit-prepend "assets/packages/numeral/numeral.min.js";

// @codekit-prepend "assets/packages/plyr/dist/plyr.min.js";

// @codekit-prepend "assets/packages/cleave.js";


//JS VANILLA
function modalFix(action=null,element='body') {
    if(action=='open'){
      document.querySelector(element).classList.add("body-fix");
    } else if(action=='close'){
      document.querySelector(element).classList.remove("body-fix");
    } else {
      document.querySelector(element).classList.toggle("body-fix");
    }
}

function goToUrl(url) {
  window.location.href = url;
}

function inputFileChange(element_id,event){
  var fileName =  event.target.files[0];
  alert('updated'+' - '+fileName);
  document.getElementById(element_id).innerHTML = fileName.name;
}



//ALPINE JS
document.addEventListener('alpine:init', () => {

    Alpine.magic('clipboard', () => value => {
      alert(value);
      navigator.clipboard.writeText(value)
    });

    Alpine.directive('uppercase', el => {
        el.textContent = el.textContent.toUpperCase()
    });
    
});