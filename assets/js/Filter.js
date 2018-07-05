function Filter(element, manager){
	this.element = element;
	this.manager = manager;
	this.config = JSON.parse(this.element.getAttribute("data-filters"));
	this.name = this.element.getAttribute("name");
	this.initEvents();
}

Filter.prototype = {
	initEvents: function(){
		var self = this;
		this.element.addEventListener("change", function() {
			self.manager.update(this.name, this.value);
		})
	}
}

function FilterItem(element){
	this.element = element;
	this.config = JSON.parse(this.element.getAttribute("data-filters-ref"));
}

function FilterManager(container) {	
	if( container ){
		this.container = container;
		this.filters = {};
		this.registerFilters();	
	}
}

FilterManager.prototype = {
	registerFilters: function(){
		var self = this;
		var filters = document.querySelectorAll("*[data-filters]");
		filters.forEach(function(filter) {
			var filter = new Filter(filter, self);
			this.filters[filter.name] = filter;
		}) 
	},

	update: function(name, value){

	}
}
