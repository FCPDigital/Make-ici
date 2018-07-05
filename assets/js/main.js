if(!$) {
	window.$ = jQuery 
}

// Prototype permettant à un élément de se supprimer du DOM lui même
Node.prototype.remove = function(){
	var parent = this.parentNode;
	if(parent){
		parent.removeChild(this);
	}
}

window.mobilecheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};

// Méthode permettant de définir les préfix webkit-moz-o-ms automatiquement pour un couple clé valeur
function setPrefix(key,value){
	var pre = ["moz", "ms", "o", "webkit"];
	var result = "";
	for(i=0; i<pre.length; i++){
		result+="-"+pre[i]+"-"+key+":"+value+";";
	}
	return result;
}

// Objet de notification
function Notification(message, config){
	if( message ){
		var self = this;
		this.message = message;
		this.class = (config && config.class) ? config.class : "success";
		this.confirm = (config && config.confirm !== false) ? true : false;
		this.timeout = (config && config.timeout) ? config.timeout : null;
		this.el = document.createElement("div");
		this.el.setAttribute("id", "notification")
		this.el.setAttribute("class", this.class);
		var content = document.createElement("p");
		content.innerHTML = this.message;
		if( this.confirm ){
			var action = document.createElement("a");
			action.innerHTML = "Ok";
			action.className = "action btn btn-colored";
			action.id = "notif-close-btn";
		}
		this.el.appendChild(content);
		document.body.appendChild(this.el);
		if(action) {
			this.el.appendChild(action);
			action.addEventListener("click", function(){
				self.el.remove();
			})
		}
		if(this.timeout){
			setTimeout(function(){
				self.el.remove();
			}, this.timeout)
		}
	} else {
		console.warn("Vous n'avez pas rentrez de message");
	}
}

////////////////////////////////////////////////////////////////////////////////
//
//							Prototype et helpers
//
////////////////////////////////////////////////////////////////////////////////

//Renvoi un objet XHR pour des requête Ajax en crossbrowser
function getXhrObject(){
	// ### Construction de l’objet XMLHttpRequest selon le type de navigateur
	if(window.XMLHttpRequest){
		return new XMLHttpRequest();
	}	else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		// XMLHttpRequest non supporté par le navigateur
		console.log("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;
	}
}

// Objet Request permettant de gérer les requêtes ajax
function Request(args){
	if(args.url){
		this.target = args.target;
		this.url = args.url;
	}
	if(args.method){
		this.method = args.method;
	} else {
		this.method = "GET";
	}
	if(args.json || args.json===false){
		this.json = args.json;
	} else {
		this.json = true;
	}
	if(args.callback){
		this.callback = args.callback;
	}
	if(args.target){
		this.target = args.target;
	}
	if(args.data){
		this.data = args.data;
	} else if(args.formData){
		this.formData = args.formData;
	}
	this.additionnalData = args.additionnalData;
	this.xhr = getXhrObject();
}

// Prototype ouvrantune nouvelle requête et initialisant les callback de ces dernières
Request.prototype.open = function(){
	var self = this;
	this.xhr.open(this.method, this.url, true);
	this.opened = true;
	this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	this.xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

	this.xhr.onreadystatechange = function() {
		if(this.readyState === 4 && this.status === 200) {
			var response = this.responseText;
			self.success = true;
			if(typeof self.callback === "function") {
				self.callback(response);
			} else {
				console.log("Response successfull but no callback");
			}
		}
	}
	return this;
}

// Prototype servant à envoyer la requête
Request.prototype.send = function(){
	if(!this.opened){
		console.warn("Objet XHR ouvert automatiquement");
		this.open();
	}

	//Si données en string ou en json
	var data = "";
	if(this.data && this.json){
		console.log(this.data);
		data = "json="+JSON.stringify(this.data);
	} else {
		console.log(typeof this.data);
		if(this.data && typeof this.data === "string"){
			data = this.data;
		}
	}

	this.xhr.send(data);
	return this;
}


//Prototype retournant la position d'un élément par rapport au haut de la page
Node.prototype.getPosition = function(isCenter){
	var left = 0;
	var top = 0;
	var e = this;

	if (isCenter == true) {
			console.log("center")
			left = e.offsetWidth / 2;
			top = e.offsetWidth / 2;
	}

	/*Tant que l'on a un élément parent*/
	while (e.offsetParent != undefined && e.offsetParent != null) {
			/*On ajoute la position de l'élément parent*/
			left += e.offsetLeft + (e.clientLeft != null ? e.clientLeft : 0);
			top += e.offsetTop + (e.clientTop != null ? e.clientTop : 0);
			e = e.offsetParent;
	}

	return {
			x: left,
			y: top
	};
}


// Surcharge les getter et setter de window.scrollTop pour le crossbrowser
Object.defineProperties(window, {
	scrollTop: {
		get: function() {
			return (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
		},
		set: function(value) {
			var scrollTop = ((document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop);
			scrollTop = value;
			window.scrollTo(0, scrollTop)
		}
	}
});

// Permet de réaliser un callback sur la transition d'un élément
function whichTransitionEvent(){
		var t;
		var el = document.createElement('fakeelement');
		var transitions = {
			'transition':'transitionend',
			'OTransition':'oTransitionEnd',
			'MozTransition':'transitionend',
			'WebkitTransition':'webkitTransitionEnd'
		}

		for(t in transitions){
				if( el.style[t] !== undefined ){
						return transitions[t];
				}
		}
}
var transitionEvent = whichTransitionEvent();


////////////////////////////////////////////////////////////////////////////////
//
//								Awesome Panel
//
////////////////////////////////////////////////////////////////////////////////

// Permet de gérer la navigation de panneau en panneau
AwesomePanel = {
	timelineBlocked:false, //Block timeline position

	// A la fin d'une transition
	callbackTransitionEnd:function(){
		var self = AwesomePanel;
		var anchor = this.animParams.anchor;
		var anim = this.animParams.anim;
		var transitionEvent = this.animParams.transitionEvent;
		transitionEvent && self.panelParent.removeEventListener(transitionEvent, AwesomePanel.callbackTransitionEnd)
		console.log(anchor);
		smoothScroll.animateScroll(null, anchor, {
			callback: function(){
				self.panelParent.classList.remove(anim);
				setTimeout(function(){
					self.isMoving = false;
					if( self.isSnaping ){
						self.isSnaping = false;
					}
				}, 150)
			} ,
			offset: 40
		});
	},

	// Change de panneau selon le selecteur "anchor"
	moveTo:function(anchor, anim){
		if(this.isMoving != true){
			anim = (anim) ? anim: "scale-min";
			this.isMoving = true;
			if(this.currentAnchor != anchor || this.isSnaping){
				this.currentAnchor = anchor;
				var self = this;
				this.panelParent.classList.add(anim);
				this.panelParent.animParams = {
					anchor: anchor,
					anim: anim,
					transitionEvent: transitionEvent
				}
				transitionEvent && this.panelParent.addEventListener(transitionEvent, AwesomePanel.callbackTransitionEnd);
			} else {
				this.isMoving = false;
			}
		}
	},

	//Change la position du curseur actif
	updateTimelineActive:function(){
		var c = document.querySelector(".timeline-item.active");
		var n = document.querySelector(".timeline-item[data-target='"+this.currentAnchor+"']")
		if(c) c.classList.remove("active");
		if(n) n.classList.add("active");
		if(n) this.activeBtn.setAttribute("style", setPrefix("transform", "translateY("+n.offsetTop+"px)"));
	},


	//Cache la timeline
	hideTimeline:function(){
		if( this.timeline && !this.timeline.className.match("no-hide" && !this.timelineBlocked) ){
			this.timeline.classList.add("hide-state");
			self.timelineDisplay = false;
		}
	},

	//Affiche la timeline
	displayTimeline:function(){
		if( this.timeline &&	!this.timelineBlocked ){
			this.timeline.classList.remove("hide-state");
			self.timelineDisplay = true;
		}
	},

	//Met à jour le panneau actif sur la timeline (en cas de scroll naturel)
	updateCurrentAnchor:function(anchor, isSnaping){
		if(anchor != this.currentAnchor || isSnaping){
			this.currentAnchor = anchor;
			if(this.config.enableTimeline !== false){
				this.updateTimelineActive();
			}
		}
	},

	//Au clique sur un item, on récupère sa cible et on lance le déplacement vers la cible
	initItemsEvents:function(el){
		var self = this;
		el.addEventListener("click", function(e){
			e.preventDefault();
			console.log(el, this.getAttribute("data-target"));

			AwesomePanel.moveTo(this.getAttribute("data-target"), "scale-min")
			return false;
		}, false)
	},

	//Calcul
	calcSnap:function(){
		var nearest = this.getNearest(window.scrollTop);
		if(nearest.absDiff > nearest.el.offsetHeight/4) {
			console.log(nearest.absDiff, nearest.el.offsetHeight/4);
			this.isSnaping = true;
			AwesomePanel.moveTo("#"+nearest.el.getAttribute("id"), "scale-min")
		}
	},

	getNearest:function(scrollTop){
		var nearestEl=this.panels[0];
		var y = nearestEl.getPosition().y;
		for(i=0; i<this.panels.length; i++){
			if(Math.abs(scrollTop - this.panels[i].getPosition().y) < Math.abs(scrollTop - y) ){
				nearestEl = this.panels[i];
				y = nearestEl.getPosition().y;
			}
		}
		return {
			el: nearestEl,
			absDiff: Math.abs(scrollTop - y)
		};
	},

	//Attend un peu et replace l'item actif de la timeline (callback window.onresize)
	resizeEvent:function(){
		setTimeout(function(){
			var c = document.querySelector(".timeline-item.active");
			AwesomePanel.activeBtn.setAttribute("style", setPrefix("transform", "translateY("+c.offsetTop+"px)"));
		}, 300)
	},


	// Evenemnt de scroll
	scrollEvent:function(){
		var self = AwesomePanel;
		var scrollTop = window.scrollTop;

		//Si le système de timeline est fonctionnel
		if( self.config.enableTimeline ){
			//On gère son apparition en fonction de la valeur du scroll
			if(scrollTop < (self.panels[0].getPosition().y/1.5)){
				self.hideTimeline();
			} else if(scrollTop > (self.panels[0].getPosition().y/1.5)){
				self.displayTimeline();
			}
		}

		//On récupère le panneau le plus proche de la ligne de flottaison
		var nearest = self.getNearest(scrollTop);
		self.updateCurrentAnchor("#"+nearest.el.getAttribute("id"), false)

		//ça ça marche pas
		if( !self.isMoving && self.snapping ){
			setTimeout(function(){
				var isScrolling = (scrollTop === window.scrollTop) ? false : true ;
				if(!isScrolling){
					var direction = (scrollTop > window.scrollTop) ? "top" : "bottom";
					self.calcSnap();
				}
			}, 100)
		}
	},

	//Initialisation de l'objet
	init:function(args){
		this.config = {};
		this.panelParent = document.querySelector(".loop-archive");
		this.panels = document.querySelectorAll(".awesome-panel-item");
		this.activeBtn = document.querySelector(".timeline .active-point");
		if(args){
			this.config.enableTimeline = (args.enableTimeline) ? args.enableTimeline : true;
			this.config.snapping = (args.snapping || args.snapping == false) ? args.snapping : true;
		}

		if(this.panels && this.panels.length > 0){
			if(this.config.enableTimeline){
				this.timeline = document.querySelector(".timeline");
				this.timelineItems = document.querySelectorAll(".timeline-item");
				this.headersItems = document.querySelectorAll(".panel-head-item a[data-target]");
				for(i=0; i<this.timelineItems.length; i++){
					if(!this.timelineItems[i].className.match("prevent-timeline-action")){
						this.initItemsEvents(this.timelineItems[i]);
					}
				}
			}
			window.addEventListener("scroll", this.scrollEvent, false);
			window.addEventListener("resize", this.resizeEvent, false);
			this.scrollEvent();
		}
	}
}


////////////////////////////////////////////////////////////////////////////////
//
//								POPIN MANAGE
//
////////////////////////////////////////////////////////////////////////////////

Popin = {
	get content(){ return this.contentEl.innerHTML; },
	set content(arg){ this.contentEl.innerHTML = arg; },
	open:function(){
		Popin.el.classList.remove("hide");
		AwesomePanel.hideTimeline();
		AwesomePanel.timelineBlocked = true;
	},
	close:function(){
		Popin.el.classList.add("hide");
		AwesomePanel.timelineBlocked = false;
		AwesomePanel.displayTimeline();
	},
	initEvent:function(){ if(this.closeEl) this.closeEl.addEventListener("click", this.close); },
	init:function(){
		this.el = document.querySelector("#popin");
		if (this.el){
			this.closeEl = this.el.querySelector(".close-popin");
			this.contentEl = this.el.querySelector(".content-popin");
			this.initEvent();
		}
	}
}

////////////////////////////////////////////////////////////////////////////////
//
//								XHR Manage
//
////////////////////////////////////////////////////////////////////////////////

//Ensemble des callback
Callback = {
	success: function(){
		Popin.close();
		new Notification("Votre e-mail a bien été envoyé !", {confirm: true})
	},

	form: function(form){
		Popin.content = form;
		Popin.open();
		if(form) document.querySelector(".btn.loading[data-wpxhr]").classList.remove("loading");
		var form = Popin.contentEl.querySelector(".wpcf7-form");
		var param = form.getAttribute("action").match("admin-ajax.+?(#wpcf7.+)$")[1];
		var action = window.location.href.replace("#.+$", "") + param;
		console.log(action);

		form.setAttribute("action", action)
		form.addEventListener("change", function() {
			var val = $.trim($(this).val());
			// check the scheme part
			if (val && !val.match(/^[a-z][a-z0-9.+-]*:/i)) {
				val = val.replace(/^\/+/, '');
				val = 'http://' + val;
			}
			$(this).val(val);
		})
		form.addEventListener("click", function(){
			wpcf7.toggleSubmit(this);
		})
		form.addEventListener("submit", function(event) {
			if (typeof window.FormData !== 'function') {
				return;
			}
			wpcf7.submit(this);
			event.preventDefault();
		})
	}
}


//Gère les envoie de XHR
XhrManage = {
	request : [],
	initEvent:function(el){
		var self = this;
		el.addEventListener("click", function(e){
			console.log("Click", this)
			var action = this.getAttribute("data-wpxhr");
			var arg = this.getAttribute("data-xhrarg");
			var get = (this.getAttribute("data-getarg")) ? "?"+this.getAttribute("data-getarg") : "";

			if( action == "abonnement_form" || action == "contact_form" || action=="classic_form") {
				var callback = Callback.form ;
			}

			var value = ( action == "classic_form" ) ? this.innerHTML : null;
			if( value ){
				var id = arg;
				var arg = {	id: id, value: value };
			}


			this.classList.add("loading");
			jQuery.post(
				ajaxurl+get, {
					'action': action,
					'param': arg
				}, callback
			);
			e.preventDefault();
		}, false)
	},
	init:function(){
		this.els = document.querySelectorAll("*[data-wpxhr]");
		for(i=0; i<this.els.length; i++){
			this.initEvent(this.els[i]);
		}
	}
}

////////////////////////////////////////////////////////////////////////////////
//
//								Carousel
//
////////////////////////////////////////////////////////////////////////////////

//Carousel des formations
function MakeCarousel(el){
	this.carousel = el;
	this.currentItem= 0;
	this.nbItemRow = 4;
	var self = this;

	if(this.carousel && this.carousel.className.match("active-control")){

		this.body = this.carousel.querySelector(".carousel-body");
		this.items = this.carousel.querySelectorAll(".carousel-container .carousel-item");
		this.container = this.carousel.querySelector(".carousel-container")
		this.control = {
			container: this.carousel.querySelector(".carousel-control"),
			left: this.carousel.querySelector(".carousel-control .carousel-control-btn[data-direction='left']"),
			right: this.carousel.querySelector(".carousel-control .carousel-control-btn[data-direction='right']"),
			label: this.carousel.querySelector(".carousel-control-label")
		}
		this.initEvents();
		self.updateSize();
	}
}

MakeCarousel.prototype = {

	initEvents: function(){
		var self =this;
		this.control.left.addEventListener("click", function(e){
			e.preventDefault();
			self.move(this.getAttribute("data-direction"));
		})
		this.control.right.addEventListener("click", function(e){
			e.preventDefault();
			self.move(this.getAttribute("data-direction"));
		})
		window.addEventListener("resize", function(){
			self.updateSize();
		})
	},

	move: function(direction){
		this.updateSize();
		if(direction == "right"){
			if(this.items.length - this.currentItem > this.nbItemRow ) this.currentItem++;
		} else if(direction == "left"){
			if(this.currentItem > 0) this.currentItem--;
		}
		var t = -1*(100/this.items.length*this.currentItem);	console.log(t);
		var t = -1*(240*this.currentItem); console.log(t)

		this.container.setAttribute("style", "width: "+this.width+";"+setPrefix("transform", "translateX("+t+"px)"))
		this.manageSelector();
	},

	updateSize: function(){
		if(window.innerWidth < 1160 && window.innerWidth > 800 && this.nbItemRow != 3){
			this.nbItemRow = 3;
		}
		if(window.innerWidth > 1160){
			this.nbItemRow = 4;
		}
		if(window.innerWidth < 800 && this.nbItemRow != 1){
			this.nbItemRow = 1;
		}
		this.manageSelector();
		/*this.width = this.items.length*(100/this.nbItemRow)+"%";*/
		this.width = (this.items.length-1)*240+"px";
		this.container.style.width = this.width;
	},

	manageSelector: function(){
		if( this.items.length <= this.nbItemRow ){
			this.control.container.classList.add("hide");
		} else {
			this.control.container.classList.remove("hide");
		}
		if(this.currentItem == 0) {
			this.control.left.classList.add("hide");
		} else {
			this.control.left.classList.remove("hide");
			if(this.control.label) this.control.label.classList.remove("hide");
		}

		if(this.items.length - this.currentItem == this.nbItemRow ){
			this.control.right.classList.add("hide")
		} else {
			this.control.right.classList.remove("hide");
			if(this.control.label) this.control.label.classList.remove("hide");
		}
		
		if (this.items.length <= this.nbItemRow) {
			this.control.left.classList.add("hide");
			this.control.right.classList.add("hide");
			if(this.control.label) this.control.label.classList.add("hide");
			while(this.currentItem > 0) {
				this.move("left");
			}
		}
	}

}


function manageProductCarousel(){
	var carouselEls = document.querySelectorAll(".product-carousel");
	var carousels = [];
	for(i=0; i<carouselEls.length; i++){
		carousels.push(new MakeCarousel(carouselEls[i]));
		console.log(carousels[i]);
	}
}


////////////////////////////////////////////////////////////////////////////////
//
//								Scroll To Top
//
////////////////////////////////////////////////////////////////////////////////

function scrollToTop(){
	var scrollBtns = document.querySelectorAll(".display-scroll");
	var scrollBtn;
	for(var i=0; i<scrollBtns.length; i++) {
		scrollBtn = scrollBtns[i];
		if(window.scrollTop < window.innerHeight/2 && !scrollBtn.className.match("hide")) {
			scrollBtn.classList.add("hide");
		} else if(window.scrollTop > window.innerHeight/2 && scrollBtn.className.match("hide")){
			scrollBtn.classList.remove("hide");
		}
	}
	window.addEventListener("scroll", function(){
		for(var i=0; i<scrollBtns.length; i++) {
			scrollBtn = scrollBtns[i];
			if(window.scrollTop < window.innerHeight/2 && !scrollBtn.className.match("hide")) {
				scrollBtn.classList.add("hide");
			} else if(window.scrollTop > window.innerHeight/2 && scrollBtn.className.match("hide")){
				scrollBtn.classList.remove("hide");
			}
		}
	}, false)
}


////////////////////////////////////////////////////////////////////////////////
//
//								Header Manage
//
////////////////////////////////////////////////////////////////////////////////

HeaderScroll = {
	initScroll:function(){
		var top = window.scrollTop;
		if(top>70) {
			HeaderScroll.el.className = HeaderScroll.el.className.replace("transparent", "");
		} else if ( !HeaderScroll.el.className.match("transparent") ){
			HeaderScroll.el.className += "transparent";
		}
	},
	init:function(){
		this.el = document.querySelector("#main-header");
		if( this.el ){
			this.initScroll();
			window.addEventListener("scroll", this.initScroll, false);
		}
	}
}

////////////////////////////////////////////////////////////////////////////////
//
//								Dynamic Date
//
////////////////////////////////////////////////////////////////////////////////

Bem = {
	safeInstance: function(arg) {		
		if( el instanceof String ) {
			this.el = document.querySelector("el")
		}
	},

	compose(block, element, modifier) {
		element = element ? "__"+element : "";
		modifier = modifier ? "--"+modifier : "";
		return block+element+modifier;
	},

	Element: function(el, block){
		this.el = el; 
		this.block = block;
		this.modifiers = [];
		this.analyze();
	}
}

Bem.Element.prototype = {



	stateExist(state) {
		if( this.modifiers.indexOf(state) >= 0 ) return true;
		return false;
	},

	addState(state) {
		if( !this.stateExist(state) ){
			var stateClass = Bem.compose(this.block, this.element, state);
		}
	},

	removeState(state) {
		if( this.stateExist(state) ){
			var stateClass = Bem.compose(this.block, this.element, state);
		}
	},

	analyze: function(){
		var classes = this.el.className.split(/\s/);
		var reg = new RegExp("^("+this.block+")(?:__(.+?)(?:\-\-(.+?))?)?$");
		for(var i=0; i<classes.length; i++){
			var match = classes[i].match(reg);
			if ( match ){
				this.block = match[1];
				if( match[2] ) this.element = match[2];
				if( match[3] && match[3] !== undefined ) this.modifiers.push(match[3]);
			}
		}
	}
}


var DynamicDate = {

	set display(value){
		if( value === true && !this.list.className.match(/\sdynamic\-date__list\-\-extend/)){
			this.list.className+= " dynamic-date__list--extend";
		}
	},

	get display(){
		return this._display;
	},

	updateDom: function(data){
		for(var i = 0, key; i < this.outputs.length; i++ ){
			key =  this.outputs[i].getAttribute("data-dynamic-date");
			value = data[key];
			if( value ){
				this.outputs[i].innerHTML = value;
			}
		}
	},

	setListItemClick: function(el) {
		var dataLine; 
		var self = this;
		el.addEventListener("click", function(){
			var r = parseInt(this.getAttribute("data-dynamic-date-rank"));
			if( r >= 0 && self.data[r] ){
				self.updateDom(self.data[r]);
			}
		}, false)
	},

	setListItems: function(){
		var collection = [];
		for(var i = 0; i < this.data.length; i++) {

			collection.push(document.createElement('p'));
			collection[i].setAttribute('data-dynamic-date-rank', i);
			collection[i].className = "dynamic-date__list-item";
			collection[i].innerHTML = this.data[i]["formation_start"];
			this.setListItemClick(collection[i]);
			this.list.appendChild(collection[i]);
			console.log(collection[i])
		}
	},

	initEvents: function(){
		this.selector.addEventListener("click", function(){

		}, false)
	},

	init: function(){
		this.dataContainer = document.getElementById("date_data");
		if(this.dataContainer){
			this.outputs = document.querySelectorAll("*[data-dynamic-date]");
			this.selector = document.getElementById("dynamic-date__selector");
			this.list = document.getElementById("dynamic-date__list");
			this.data = JSON.parse(this.dataContainer.textContent);
			if( this.data ){
				this.setListItems();
				this.initEvents();
			}
		}
	}
}


function accordionManage() {
	// Data
	accButtons = document.querySelectorAll('.acc__btn');


	// Functions
	function toggleAccordion() {
	   this.classList.toggle('acc__btn--active');
	}

	// Events
	for(var i=0; i<accButtons.length; i++) {
	  (function(rank){
	    accButtons[rank].addEventListener('click', toggleAccordion);
	  })(i);
	}
}


var Filter = {

	display: function(el){
		el.classList.remove("hidding");
		el.classList.remove("hide");
		var self = this;
		setTimeout(function(){
			self.grid.masonry("layout");
		}, 300);
	},

	hide: function(el){
		el.classList.add("hidding");
		var self =this;
		setTimeout(function(){
			el.classList.add("hide");
			el.classList.remove("hidding");
			self.grid.masonry("layout");
		}, 300)
	},

	update: function(filters){
		var found;
		for(var i=0; i<this.els.length; i++){
			found = false;
			for(var j=0; j<filters.length; j++){
				if( this.els[i].getAttribute("data-filter-ref").split(",").indexOf(filters[j]) >= 0 ){
					found = true;
					break;
				}
			}
			if( found ){
				this.display(this.els[i]);
			} else {
				this.hide(this.els[i]);
			}
		}	
	},

	initEvent: function(el){
		var self = this;
		el.addEventListener("click", function(){
			self.currentFilter.classList.remove("filter__item--active");
			self.currentFilter = this;
			this.classList.add("filter__item--active");
			var filters = el.getAttribute("data-filter").split(",");
			self.update(filters);
		})		
	},

	init: function(masonry){
		this.grid = masonry; 
		this.els = document.querySelectorAll("*[data-filter-ref]");
		this.filters = document.querySelectorAll("*[data-filter]");
		this.currentFilter = this.filters[0];
		for(var i=0; i<this.filters.length; i++){
			this.initEvent(this.filters[i])
		}
	}
}



function loadMasonry(){
	var $grid = $('.masonry'); 
	$grid.masonry({
	  // options...
	  itemSelector: '.masonry__item',
	  columnWidth: 300,
	  gutter: 25,
	  horizontalOrder: false,
	  isFitWidth: true
	});
	Filter.init($grid);
}


function FilterInput(element, manager){
	this.element = element;
	this.manager = manager;
	this.config = JSON.parse(this.element.getAttribute("data-filters"));
	this.name = this.element.getAttribute("name");
	this.initEvents();
}

FilterInput.prototype = {
	initEvents: function(){
		var self = this;
		self.manager.update(this.element.name, this.element.value, true);
		this.element.addEventListener("change", function() {
			self.manager.update(this.name, this.value, true);
		})
	}
}

function FilterItem(element, manager){
	this.element = element;
	this.manager = manager;
	this._visible = true;
	this.terms = JSON.parse(this.element.getAttribute("data-filters-terms"));
}

FilterItem.prototype = {
	set visible(visible){
		if(visible) {
			this.element.classList.remove(this.manager.modifier);
		} else {
			this.element.classList.add(this.manager.modifier);
		}
		this._visible = visible;
	},

	get visible(){
		return this._visible;
	}
}

function FilterManager(container, args) {	
	if(!args) args = {};
	if( container ){
		this.container = container;
		this.filters = {};
		this.filtersSelected = {};
		this.items = [];
		this.itemsVisible = [];
		this.onChange = args.onChange ? args.onChange : null;
		this.modifier = args.modifier ? args.modifier : "hidden";
		this.registerFilters();	
		this.registerItems();
	} else {
		return false;
	}
}

FilterManager.prototype = {
	registerFilters: function(){
		var self = this;
		var filters = this.container.querySelectorAll("*[data-filters]");
		filters.forEach(function(filter) {
			var filter = new FilterInput(filter, self);
			self.filters[filter.name] = filter;
		});
	},

	registerItems: function(){
		var self = this;
		var items = this.container.querySelectorAll("*[data-filters-terms]");
		items.forEach(function(item) {
			var item = new FilterItem(item, self);
			self.items.push(item);
		}) 
	},

	refresh: function(){
		var self = this;
		this.itemsVisible = [];
		this.items.forEach(function(item){
			var filtersResponse = [], accept;
			
			// For each filter registered
			for(var i in self.filtersSelected){
				accept = false;
				
				// If current filter is disable, item is accepted
				if(!self.filtersSelected[i]){
			 	  accept = true;

			 	// If current filter not exist in current item, item is refused
			 	} else if(!item.terms[i]) {
			 	  accept = false;

			 	// Classic behaviour : Item and Filter has terms, we compare them
			 	} else {
			 		// for each term
			 		for(var j=0; j<self.filtersSelected[i].length; j++){
			 			if( item.terms[i].indexOf(self.filtersSelected[i][j]) >= 0 ){
			 				accept = true;
			 			}
			 		}
			 	}

			 	filtersResponse.push(accept);
			}

			if(filtersResponse.indexOf(false) >= 0){
				item.visible = false;
			} else {
				item.visible = true;
				self.itemsVisible.push(item);	
			}
		})

		if(this.onChange) this.onChange.call(this, this);
	},

	update: function(name, value, replace){
		if(!refresh) var refresh = false;

		// If value is false => Disable filter
		if(value === "false") {
			this.filtersSelected[name] = false;

		// If filter is not registered yet	
		} else if(!this.filtersSelected[name]) {
			this.filtersSelected[name] = [value];
		} else {
			// If we replace all the precendent value
			if( replace ){
				this.filtersSelected[name] = [value];
			// Else if term not register yet, push
			} else if(this.filtersSelected[name].indexOf(value) < 0) {
				this.filtersSelected[name].push(value);
			}
		}

		this.refresh();
	}
}


////////////////////////////////////////////////////////////////////////////////
//
//								Window load
//
////////////////////////////////////////////////////////////////////////////////


window.addEventListener("load", function(){
	smoothScroll.init({ offset: 40 });
	AwesomePanel.init({ snapping: false });
	Popin.init();
	scrollToTop();
	loadMasonry();
	manageProductCarousel();
	var carousel = new MakeCarousel(document.querySelector("#main-carousel"));
	XhrManage.init();
	HeaderScroll.init();
	DynamicDate.init();
	accordionManage();
	if(window.mobilecheck()) document.querySelector('#bgvid').remove();

	if( document.querySelector("#residents-filter")) {
		var $residentGrid = $('#masonry-resident');
		$residentGrid.masonry({
			itemSelector: '.masonry__item',
			columnWidth: 300,
			gutter: 25,
			horizontalOrder: false,
			isFitWidth: true
		}); 
		var emptyMessageElement = document.querySelector("#residents-empty-message");
		var residentFilter = new FilterManager(document.querySelector("#residents-filter"));
		residentFilter.onChange = function(e){
			setTimeout(function(){
				$residentGrid.masonry("layout")
				if(e.itemsVisible.length > 0){
					emptyMessageElement.classList.add("hidden");
				} else {
					emptyMessageElement.classList.remove("hidden");
				}
			}, 20)
		}
	}
	
}, false)
