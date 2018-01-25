var Bem = {

	safeInstance: function(arg){
		switch(arg.constructor) {
			case "String" : 
			case "Node"
		}
		if( el instanceof String ) {
			this.el = document.querySelector("el")
		}
	}




	Element: function(el, block){
		this.el = el; 
		this.block = block;

		this.analyze();
	},





	Block: function(arg) {
		
		this.elements = [];
		this.modifers = [];
	},

	Modifier: function(arg){
		this.parent;
	}
}

Bem.Element.prototype = {
	analyze: function(){
		var classes = this.el.className.split(/\s/);
		var reg = new RegExp("^"+this.block+"__(.+?)(?:\-\-(.+?))?$");
		for(var i=0; i<classes.length; i++){
			var match = classes[i].match(reg);
			if ( match ){
				this.element = match[1];
				this.modifier = match[2];
			}
		}
	}
}