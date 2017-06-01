
////////////////////////////////////////////////////////////////////////////////
//
//              Prototype et helpers
//
////////////////////////////////////////////////////////////////////////////////

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

Request.prototype.send = function(){
  if(!this.opened){
    console.warn("Objet XHR ouvert automatiquement");
    this.open();
  }

  //Si données en string ou en json
  // if(this.data){
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

function setPrefix(key,value){
  var pre = ["moz", "ms", "o", "webkit"];
  var result = "";
  for(i=0; i<pre.length; i++){
    result+="-"+pre[i]+"-"+key+":"+value+";";
  }
  return result;
}

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




function setPrefix(key,value){
  var pre = ["moz", "ms", "o", "webkit"];
  var result = "";
  for(i=0; i<pre.length; i++){
    result+="-"+pre[i]+"-"+key+":"+value+";";
  }
  return result;
}


////////////////////////////////////////////////////////////////////////////////
//
//                SNAP POINT
//
////////////////////////////////////////////////////////////////////////////////


var isScrollSnapSupported = 'scrollSnapType' in document.documentElement.style ||
        'webkitScrollSnapType' in document.documentElement.style;

if (!isScrollSnapSupported) {
  var elem = document.createElement('p'),
      txt  = document.createTextNode('Your browser does not support CSS Scroll Snap Points :( '),
      local = document.body;

  elem.appendChild(txt);
  elem.classList.add('warning');
  local.insertBefore(elem, local.firstChild);
}



////////////////////////////////////////////////////////////////////////////////
//
//                Awesome Panel
//
////////////////////////////////////////////////////////////////////////////////


AwesomePanel = {
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

  updateTimelineActive:function(){
    var c = document.querySelector(".timeline-item.active");
    var n = document.querySelector(".timeline-item[data-target='"+this.currentAnchor+"']")
    if(c) c.classList.remove("active");
    if(n) n.classList.add("active");
    if(n) this.activeBtn.setAttribute("style", setPrefix("transform", "translateY("+n.offsetTop+"px)"));
  },

  resizeEvent:function(){
    setTimeout(function(){
      var c = document.querySelector(".timeline-item.active");
      console.log(c, c.offsetTop);
      AwesomePanel.activeBtn.setAttribute("style", setPrefix("transform", "translateY("+c.offsetTop+"px)"));
    }, 300)
  },


  hideTimeline:function(){
    if( !this.timeline.className.match("no-hide") ){
      this.timeline.classList.add("hide-state");
      self.timelineDisplay = false;
    }
  },

  displayTimeline:function(){
    this.timeline.classList.remove("hide-state");
    self.timelineDisplay = true;
  },

  updateCurrentAnchor:function(anchor, isSnaping){
    if(anchor != this.currentAnchor || isSnaping){
      this.currentAnchor = anchor;
      if(this.config.enableTimeline !== false){
        this.updateTimelineActive();
      }
    }
  },

  initItemsEvents:function(el){
    var self = this;
    el.addEventListener("click", function(e){
      e.preventDefault();
      console.log(el, this.getAttribute("data-target"));

      AwesomePanel.moveTo(this.getAttribute("data-target"), "scale-min")
      return false;
    }, false)
  },

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

  scrollEvent:function(){
    var self = AwesomePanel;
    var scrollTop = window.scrollTop;

    if( self.config.enableTimeline ){
      if(scrollTop < (self.panels[0].getPosition().y/2)){
        self.hideTimeline();
      } else if(scrollTop > (self.panels[0].getPosition().y/2)){
        self.displayTimeline();
      }
    }

    var nearest = self.getNearest(scrollTop);
    self.updateCurrentAnchor("#"+nearest.el.getAttribute("id"), false)

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

  init:function(args){
    this.config = {};
    this.panelParent = document.querySelector(".loop-archive");
    this.panels = document.querySelectorAll(".awesome-panel-item");
    this.activeBtn = document.querySelector(".timeline .active-point");
    if(args){
      this.config.enableTimeline = (args.enableTimeline) ? args.enableTimeline : true;
      this.config.snapping = (args.snapping || args.snapping == false) ? args.snapping : true;
    }

    if(this.panels){
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
//                XHR Manage
//
////////////////////////////////////////////////////////////////////////////////

Callback = {
  abonnement: function(response){
    alert(response)
  }
}



XhrManage = {
  request : [],
  initEvent:function(el){
    console.log(el);
    var self = this;
    el.addEventListener("click", function(e){
      var action = this.getAttribute("data-wpxhr");
      if( action == "abonnement_form") {
        var callback = Callback.abonnement;
      }
      jQuery.post(
        ajaxurl, {
          'action': action,
          'param': 'coucou'
        }, function(response){
            alert(response)
        }
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

    this.container = this.carousel.querySelector(".carousel-container");
    this.items = this.carousel.querySelectorAll(".carousel-container .carousel-item");
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
  scrollToTop();
  manageProductCarousel();
  var carousel = new MakeCarousel(document.querySelector("#main-carousel"));
  // perspectivecorner.init();
  XhrManage.init();


}, false)
