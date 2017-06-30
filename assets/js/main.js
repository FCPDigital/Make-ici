
// Prototype permettant à un élément de se supprimer du DOM lui même
Node.prototype.remove = function(){
  var parent = this.parentNode;
  if(parent){
    parent.removeChild(this);
  }
}

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
//              Prototype et helpers
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
//                Awesome Panel
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

  //Attend un peu et replace l'item actif de la timeline (callback window.onresize)
  resizeEvent:function(){
    setTimeout(function(){
      var c = document.querySelector(".timeline-item.active");
      AwesomePanel.activeBtn.setAttribute("style", setPrefix("transform", "translateY("+c.offsetTop+"px)"));
    }, 300)
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
    if( this.timeline &&  !this.timelineBlocked ){
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
//               Perspective Corner
//
////////////////////////////////////////////////////////////////////////////////

perspectivecorner = {
  intensity: 1, //Deg
  mouseLeave :function(event){
    if(this.initialStyle) {
      this.setAttribute("style", this.initialStyle+ ";" +setPrefix("transform", "rotate3d(1, 1, 1, 0deg) scale3d(1,1,1)")+"box-shadow: 0px 0px 30px rgba(0,0,0,.5)" );
    } else {
      this.setAttribute("style", setPrefix("transform", "rotate3d(1, 1, 1, 0deg) scale3d(1,1,1)")+"box-shadow: 0px 0px 30px rgba(0,0,0,.5)" );
    }
    self.currentEl = null;
  },
  mouseEnter:function(event){
    var self = perspectivecorner;
    self.currentEl = this;
  },
  mouseMove:function(event){

    var rX, rY, signX, signY,
    midW = window.innerWidth/2, midH = this.innerHeight/2,
    self = perspectivecorner;

    rY = event.layerX > midW ? ((event.layerX - midW)/midW) : ((event.layerX - midW)/midW);
    rX = event.layerY > midH ? ((event.layerY - midH)/midH) : ((event.layerY - midH)/midH);

    console.log(rX, rY);
    // rY *= -1;
    rX *= -1;

    var scale = "scale(1)";

    console.log(self.currentEl.initialStyle );
    if(self.currentEl.initialStyle) {
      self.currentEl.setAttribute("style", self.currentEl.initialStyle+";" + setPrefix("transform", "rotate3d("+rX+", "+rY+", 0, "+self.intensity+"deg) translateZ(-50px) scale3d(1,1,1)")+"box-shadow: "+(-1*rY*self.intensity)+"px "+(rX*self.intensity)/2+"px 100px rgba(0,0,0,.5)" );
    } else {
      self.currentEl.setAttribute("style", setPrefix("transform", "rotate3d("+rX+", "+rY+", 0, "+self.intensity+"deg) translateZ(-50px) scale3d(1,1,1)")+"box-shadow: "+(-1*rY*self.intensity)+"px "+(rX*self.intensity)/2+"px 100px rgba(0,0,0,.5)" );
    }


    event.stopImmediatePropagation();
    if(event.stopPropagation) {
      event.stopPropagation();

    } else {
      event.cancelBubble = true;
    }
  },
  initEvent:function(el){
    if(el.getAttribute("data-perspective-effect")){
      el.effectiveChild = el.querySelector(el.getAttribute("data-perspective-effect"));
      el.effectiveChild.classList.add("data-perspective-child-effect");
    }
    el.initialStyle = el.getAttribute("style");
    el.addEventListener("mouseenter", perspectivecorner.mouseEnter, true);
    el.addEventListener("mouseleave", perspectivecorner.mouseLeave, false);

  },
  init:function(){
    this.els = document.getElementsByClassName("perspective-corner");
    for(i=0; i<this.els.length; i++){
      this.initEvent(this.els[i]);
    }
    window.addEventListener("mousemove", perspectivecorner.mouseMove, true);
  }
}


////////////////////////////////////////////////////////////////////////////////
//
//                POPIN MANAGE
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
//                XHR Manage
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
    console.log(el);
    var self = this;
    el.addEventListener("click", function(e){
      var action = this.getAttribute("data-wpxhr");
      var arg = this.getAttribute("data-xhrarg");
      var get = (this.getAttribute("data-getarg")) ? "?"+this.getAttribute("data-getarg") : "";

      if( action == "abonnement_form" || action == "contact_form" || action=="classic_form") {
        var callback = Callback.form ;
      }

      var value = ( action == "classic_form" ) ? this.innerHTML : null;
      if( value ){
        var id = arg;
        var arg = {  id: id, value: value };
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
//                Carousel
//
////////////////////////////////////////////////////////////////////////////////

//Carousel des formations
function MakeCarousel(el){
  this.carousel = el;
  this.currentItem= 0;
  this.nbItemRow = 3;

  if(this.carousel && this.carousel.className.match("active-control")){

    this.body = this.carousel.querySelector(".carousel-body");
    this.control = {
      left: this.carousel.querySelector(".carousel-control .carousel-control-btn[data-direction='left']"),
      right: this.carousel.querySelector(".carousel-control .carousel-control-btn[data-direction='right']")
    }
    this.items = this.carousel.querySelectorAll(".carousel-container .carousel-item");
    this.container = this.carousel.querySelector(".carousel-container");

    var self = this;
    this.control.left.addEventListener("click", function(e){
      e.preventDefault();
      self.move(this.getAttribute("data-direction"));
    })
    this.control.right.addEventListener("click", function(e){
      e.preventDefault();
      self.move(this.getAttribute("data-direction"));
    })

    self.updateSize();
    window.addEventListener("resize", function(){
      self.updateSize();
    })
  }
}
MakeCarousel.prototype.move = function(direction){
  this.updateSize();



  if(direction == "right"){
    if(this.items.length - this.currentItem > this.nbItemRow ) this.currentItem++;
  } else if(direction == "left"){
    if(this.currentItem > 0) this.currentItem--;
  }
  var t = -1*(100/this.items.length*this.currentItem);  console.log(t);
  this.container.setAttribute("style", "width: "+this.width+";"+setPrefix("transform", "translateX("+t+"%)"))
  this.manageSelector();
}

MakeCarousel.prototype.updateSize=function(){
  if(window.innerWidth < 1160 && window.innerWidth > 800 && this.nbItemRow != 2){
    this.nbItemRow = 2;
  }


  if(window.innerWidth > 1160){
    this.nbItemRow = 3;
  }
  if(window.innerWidth < 800 && this.nbItemRow != 1){
    this.nbItemRow = 1;
  }
  this.manageSelector();
  this.width = this.items.length*(100/this.nbItemRow)+"%";
  this.container.style.width = this.width;
}

MakeCarousel.prototype.manageSelector = function(){
  if(this.currentItem == 0) {
    this.control.left.classList.add("hide");
  } else {
    this.control.left.classList.remove("hide");
  }

  if(this.items.length - this.currentItem == this.nbItemRow ){
    this.control.right.classList.add("hide")
  } else {
    this.control.right.classList.remove("hide");
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
//                Scroll To Top
//
////////////////////////////////////////////////////////////////////////////////

function scrollToTop(){
  var scrollBtn = document.querySelector(".scroll-to-top");
  window.addEventListener("scroll", function(){
    if(window.scrollTop < window.innerHeight/2 && !scrollBtn.className.match("hide")) {
      scrollBtn.classList.add("hide");
    } else if(window.scrollTop > window.innerHeight/2 && scrollBtn.className.match("hide")){
      scrollBtn.classList.remove("hide");
    }
  }, false)
}


////////////////////////////////////////////////////////////////////////////////
//
//                Header Manage
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
//                Window load
//
////////////////////////////////////////////////////////////////////////////////


window.addEventListener("load", function(){
	smoothScroll.init({
    offset: 40
  });
  AwesomePanel.init({
    snapping: false
  });
  Popin.init();
  scrollToTop();
  manageProductCarousel();
  var carousel = new MakeCarousel(document.querySelector("#main-carousel"));
  XhrManage.init();
  HeaderScroll.init();


}, false)
