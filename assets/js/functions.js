//PACKAGES
const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 4000,
	timerProgressBar: true,
	didOpen: (toast) => {
	  toast.addEventListener('mouseenter', Swal.stopTimer)
	  toast.addEventListener('mouseleave', Swal.resumeTimer)
	}
})

//GENERAL
var lang = typeof lang != "undefined" ? lang : 'en';
moment.locale(lang);

//SLEEP
function sleep(ms=300) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

//SHARE
function nativeShare(share=null) {
	if (navigator.share) {
		if(share==null){
      		share = [];
			share["title"] = document.title;
			share["url"] = document.querySelector('link[rel=canonical]') ? document.querySelector('link[rel=canonical]').href : document.location.href;
		}
		navigator.share({
				title: share["title"],
				url: share["url"],
			})
			.then()
			.catch((error) => console.log("Error sharing", error));
	} else {
		alert("Device doesn't support Sharing");
	}
}


//PAGE LOADING
const loading = document.getElementById("loading");
document.addEventListener("DOMContentLoaded", function(event) {
  loadingEnter();
});
window.onpageshow = function(event) {
  if (event.persisted) {
    loadingEnter();
  }
};
function loadingGoToUrl(url) {
  gsap.to(loading, {display:"flex", opacity: 1});
  setTimeout(function(){
    window.location.href = url;
  }, 500);
}
function loadingEnter(){
//   setTimeout(function(){
//     gsap.to(loading, {opacity: 0, display:"none"});
//   }, 500);
}


//JS VANILLA
function DayNight(){
	var hour = moment().format('HH');
	return (hour > 16 && hour < 06) ? 'night' : 'day';
}
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
	return array;
}

function mobile() {
	let check = false;
	(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
};

function getFileType(file) {
	if(file==null || file=='') return null;
	if (typeof file === 'string' || file instanceof String) {
		var ext = file.split('.').pop();
		if(['jpg','jpeg','png','gif','webp'].includes(ext)) return 'image';
		if(['m4v','avi','mp4','mov'].includes(ext)) return 'video';
		if(['mp3'].includes(ext)) return 'audio';
		return 'raw';
	}
	if(file.type.match('image.*')) return 'image';
	if(file.type.match('video.*')) return 'video';
	if(file.type.match('audio.*')) return 'audio';
	return 'raw';
}

function scrollFix(action = null, element = 'body') {
	if (action == 'open') {
		document.querySelector(element).classList.add("body-fix");
	} else if (action == 'close') {
		document.querySelector(element).classList.remove("body-fix");
	} else {
		document.querySelector(element).classList.toggle("body-fix");
	}
}
function goToUrl(url) {
	window.location.href = url;
}
//TEST
function isset(element) {
	if (typeof element !== "undefined") {
		return true;
	}
	return false;
}
function checkInsideIframe() {
    if (window.top !== window.self) window.top.location.replace(window.self.location.href);
}
function inputFileChange(element_id, event) {
	var fileName = event.target.files[0];
	alert('updated' + ' - ' + fileName);
	document.getElementById(element_id).innerHTML = fileName.name;
}
function str_limit(string, size = 30) {
	if (!string) return '';
	string = string.toString();
	if (string.length <= size) {
		return string;
	}
	return string.substr(0, size) + '...';
}
function initials(string) {
	return string.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
}

function click_spinner(element_id,time=3500,block=false) {
	var element = document.getElementById(element_id);
	var original_string = element.innerHTML;
	element.classList.add("disabled");
	element.innerHTML += " <i class='fal fa-circle-notch fa-spin ml-1'></i>";
	setTimeout(function() {
		element.innerHTML = original_string;
		if(block == false) {
			element.classList.remove("disabled");
		}
	}, time);
}

function button_link_click(element_id) {
	var element = document.getElementById(element_id);
	element.classList.add("disabled");
	element.innerHTML += " <i class='fal fa-circle-notch fa-spin ml-1'></i>";
	setTimeout(function() { location.href = element.getAttribute("href"); }, 500);
}

function button_submit_form(target_element) {
	var buttons = document.querySelectorAll('.'+target_element);
	buttons.forEach(function(button) {
	  button.classList.add("disabled");
	  button.innerHTML += " <i class='fal fa-circle-notch fa-spin ml-1'></i>";
	});
	setTimeout(function() { document.getElementById(target_element).submit(); }, 500);
}

function confirm_link_click(element_id, message='Are you sure?') {
  Swal.fire({
	title: message,
	icon: 'warning',
	showCancelButton: true,
	confirmButtonText: 'Yes'
  }).then((result) => {
	if (result.isConfirmed) {
		var element = document.getElementById(element_id);
		setTimeout(function() { location.href = element.getAttribute("href"); }, 500);
	}
  })
}

function confirm_submit_form(target_element, message='Are you sure?') {
  Swal.fire({
	title: message,
	icon: 'warning',
	showCancelButton: true,
	confirmButtonText: 'Yes'
  }).then((result) => {
	if (result.isConfirmed) {
		var buttons = document.querySelectorAll('.'+target_element);
		buttons.forEach(function(button) {
		  button.classList.add("disabled");
		  button.innerHTML += " <i class='fal fa-circle-notch fa-spin'></i>";
		});
		setTimeout(function() { document.getElementById(target_element).submit(); }, 500);
	}
  })
}

function fileIcon(imageURL,cloudURL) {
  var fileExt = imageURL.split('.').pop().split(/\#|\?/)[0];
  if(fileExt==='jpeg' || fileExt==='jpg' || fileExt==='png' || fileExt==='gif' || fileExt==='webp') {
	return imageURL;
  } else if(fileExt==='pdf') {
	return '/assets/img/icons/file-pdf.svg';
  } else if(fileExt==='excel') {
	return '/assets/img/icons/file-excel.svg';
  } else if(fileExt==='doc' || fileExt==='docx') {
	return '/assets/img/icons/file-word.svg';
  } else {
	return '/assets/img/icons/file-text.svg';
  }
}


function suggest_language_change(page_lang) {
	if("preferences" in sessionStorage) { return; }
	var browser_lang = navigator.languages && navigator.languages[0] || navigator.language || navigator.userLanguage || 'en';
	var browser_lang = browser_lang.substr(0,2);
	sessionStorage.setItem("preferences",browser_lang);
    if(browser_lang == 'es' && page_lang == 'en') {
		var alternate = document.querySelector("link[rel='alternate']").getAttribute("href");
		Toast.fire({
			html: 'Hay una <b class="color-primary">versión en Español</b><br>' + '<a href="'+alternate+'" class="btn btn-primary btn-sm mt-3">Cambiar</a>'
		});
    } else if(browser_lang == 'en' && page_lang == 'es') {
		var alternate = document.querySelector("link[rel='alternate']").getAttribute("href");
		Toast.fire({
			html: 'We have a <b class="color-primary">English version</b><br> you might prefer<br>' + '<a href="'+alternate+'" class="btn btn-primary btn-sm mt-3">Change</a>'
		});
    }
}


//ALPINE 3
document.addEventListener('alpine:init', () => {

	//USE IF HOVER FOR EXAMPLE, ELSE USE DIRECTIVE
	//@click="$clipboard('copy something')"
	//@click="$clipboard()" copy content
	//@click="$clipboard(null,true)" copy content AND alert
	Alpine.magic('clipboard', (el) => (value,notify) => {
		if (!value){ value = el.textContent; }
		if (notify){ alert(value); }
		navigator.clipboard.writeText(value);
	});

	//x-clipboard  copy content NO alert
	//x-clipboard:alert="copy something"
	Alpine.directive('clipboard', (el, { value, expression }) => {
		const handleClick = () => {
			if (!expression){ expression = el.textContent; }
			if (value){ Toast.fire({text: expression}) }
			navigator.clipboard.writeText(expression);
		}
		el.addEventListener('click', handleClick);
	});

	Alpine.magic('formatDate', (el) => (string) => {
		return moment(string).format('MMM D YYYY');
	});
	
	Alpine.directive('formatDate', (el, { value, expression }) => {
		//date = el.textContent;
		//locale(lang).
		el.textContent = moment(expression).format('MMM D YYYY');
	});
	
	Alpine.directive('formatDateDB', el => {
		date = el.textContent;
		el.textContent = moment(value).format('YYYY-MM-DD');;
	});
	
	Alpine.directive('formatMoney', el => {
		amount = numeral(el.textContent).format('0,0.00');
		el.textContent = amount.replace(/\.00$/, '');
	});

	//x-uppercase
	Alpine.directive('uppercase', el => {
		el.textContent = el.textContent.toUpperCase()
	});

	//x-firstCapital
	Alpine.directive('firstCapital', el => {
		string = el.textContent;
		string.toLowerCase().charAt(0).toUpperCase() + string.slice(1);
	});

	//x-stringLimit:60
	Alpine.directive('stringLimit', (el, {value}) => {
		length = typeof value != "undefined" ? value : 30;
		string = el.textContent.toString();
		if (string.length <= length) { return; }
		el.textContent = string.substr(0, length) + '...';
	});

	//TOGGLER
	//<div x-data="toggler"><button x-bind="trigger">SHOW IT</button><div x-show="open" x-transition>info</div></div>
	Alpine.data('toggler', (el) => ({
		open: false,
		clicked: false,
		trigger: {
			['@click']() {
				if(!this.open) { this.open = this.clicked = true;
				} else { this.open = this.clicked = false; }
			},
			['@click.outside']() {
				this.open = this.clicked = false;
			},
			['@mouseover']() {
				this.open = true;
			},
			['@mouseleave']() {
				if(!this.clicked) { this.open = false; }
			}
		}
	}));

	Alpine.data('modal', (el) => ({
		openModal: false,
		players: null,
		init() {
			this.players = Plyr.setup('.player');
		},
		activateTrigger(action=true) {
			if(action) {
				this.openModal = true;
				document.querySelector('body').classList.add("body-fix");
			} else {
				this.openModal = false;
				document.querySelector('body').classList.remove("body-fix");
				//const players = Plyr.setup('.player');
				this.players.forEach(function(player) {
					player.pause();
				});
			}
		},
		trigger: {
			['@click']() {
				this.openModal = !this.openModal;
				this.activateTrigger(this.openModal);
			}
		},
		modal: {
			['x-show']() { return this.openModal },
			['x-transition.duration.500ms']() {},
		},
		modalDialog: {
			['x-on:click.outside.prevent']() {
				this.activateTrigger(false);
			},
            ["@keydown.window.prevent.esc"]() {
				this.activateTrigger(false);
			}
		},
	}));


	Alpine.data('navigatorX', () => ({
		nav_main: false,
		nav_services_dropdown: false,
		nav_help_dropdown: false,
		nav_user_dropdown: false,
		scrollY: 0,
		navTrigger: {
			['@click']() {
				this.nav_main = !this.nav_main;
				if (this.nav_main) {
					document.querySelector('body').classList.add("body-fix");
				} else {
					document.querySelector('body').classList.remove("body-fix");
				}
			}
		},
		navScroll: {
			['@scroll.window']() {
				this.scrollY = window.scrollY;
			}
		},
		itemsTrigger: {
			['@mouseover']() {
				this.nav_services_dropdown = true;
			},
			['@mouseleave']() {
				this.nav_services_dropdown = false;
			}
		},
		helpTrigger: {
			['@mouseover']() {
				this.nav_help_dropdown = true;
			},
			['@mouseleave']() {
				this.nav_help_dropdown = false;
			}
		},
		userTrigger: {
			['@click']() {
				this.nav_user_dropdown = !this.nav_user_dropdown;
			},
			['@mouseover']() {
				this.nav_user_dropdown = true;
			},
			['@mouseleave']() {
				this.nav_user_dropdown = false;
			},
			['@click.outside']() {
				this.nav_user_dropdown = false;
			}
		}
	}));

});