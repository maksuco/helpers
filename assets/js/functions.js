//GENERAL
var lang = lang ?? 'en';
moment.locale(lang);


//JS VANILLA
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
function inputFileChange(element_id, event) {
	var fileName = event.target.files[0];
	alert('updated' + ' - ' + fileName);
	document.getElementById(element_id).innerHTML = fileName.name;
}
function str_limit(value, size = 30) {
	if (!value) return '';
	value = value.toString();
	if (value.length <= size) {
		return value;
	}
	return value.substr(0, size) + '...';
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
		length = value ?? 30;
		string = el.textContent.toString();
		if (string.length <= length) { return; }
		el.textContent = string.substr(0, length) + '...';
	});

	//AUTH  CHECK
	//<div x-data="authCheck"><h1 x-text="user.name"></h1><div x-show="open" x-transition>Your login</div></div>
    //<h1 x-data="authCheck('{{env('CLOUD_URL').env('SHOWAVATAR_PATH')}}')" x-cloak><div x-show="user" x-transition><span x-text="user.name"></span> Your login<img x-bind:src="avatar()"></div><div x-show="!user">Not login</div></h1>
	Alpine.data('authCheck', (storage_url) => ({
		user: null,
		init(){
			this.fetchUser();
		},
		fetchUser() {
            fetch('/ajax/authCheck')
                .then(res => res.json())
                .then(data => {
                    this.user = data;
                }).catch((error) => {
                    console.error('Error:', error);
                    return;
                });
		},
        avatar(){
            //setTimeout(() => {  console.log("World!"); }, 2000);
			if(this.user.avatar) {
				if( this.user.avatar.indexOf("http") == 0 ) {
					return this.user.avatar;
				} else {
					return storage_url + this.user.avatar;
				}
                //document.getElementById('avatar').src = this.avatar;
			} else {
                return storage_url + "/assets/img/avatar.png";
            }
        }
	}))


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
	}))

});