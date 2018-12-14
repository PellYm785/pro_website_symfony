Switch.prototype.switcherLeftHTML = '<div class="switcher-right" style="position: absolute;"><svg shape-rendering="geometricPrecision" height="40" width="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><polygon points="3,3 33,18 3,33" fill="rgba(255,255,255,0.5)" stroke="black" stroke-width="2"/></svg></div>';
Switch.prototype.switcherRightHTML = '<div class="switcher-left" style="position: absolute;"><svg shape-rendering="geometricPrecision" height="40" width="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><polygon points="33,3 3,18 33,33" fill="rgba(255,255,255,0.5)" stroke="black" stroke-width="2"/></svg></div>';

function Switch(className){
    this.className = className;
    this.switcherRight = null;
    this.switcherLeft = null;
    this.activeElementIndex = 0;
    this.elements = null;
    this.built = false;
}

Switch.prototype.build = function () {
	if(!this.built){
	    var positionElement = null,
	        heightElement = 0,
	        widthElement = 0;
	
	    this.elements = $(this.className);
	    var activeElement = this.elements.eq(this.activeElementIndex);
	    this.elements.hide();
	
	    activeElement.show();
	    positionElement = activeElement.offset();
	    heightElement = activeElement.height();
	    widthElement = activeElement.width();
	
	    activeElement.before(this.switcherLeftHTML);
	    activeElement.after(this.switcherRightHTML);
	
	    this.switcherLeft = activeElement.parent().find('.switcher-left');
	    this.switcherRight = activeElement.parent().find('.switcher-right');
	
	    this.switcherLeft.hide();
	    this.switcherLeft.css('top', positionElement.top+heightElement/2);
	    this.switcherLeft.css('left', positionElement.left-30-25);
	
	    this.switcherRight.css('top', positionElement.top+heightElement/2);
	    this.switcherRight.css('left', positionElement.left+widthElement+25);
	
	    var object = this;
	    
	    this.switcherLeft.click(function(){switch_left(object);});
	    this.switcherRight.click(function(){switch_right(object);});
	    
	    this.built = true;
	}
}

Switch.prototype.disable = function(){
    if(this.built){
        this.switcherLeft.hide();
        this.switcherRight.hide();
        this.elements.show();
    }
}

Switch.prototype.enable = function(){
    if(this.built){
       var activeElement = this.elements.eq(this.activeElementIndex);

       this.elements.hide();
       activeElement.show();

       this.switcherLeft.show();
       this.switcherRight.show();

        if(this.activeElementIndex == 0){
            this.switcherLeft.hide();
        }else if(this.activeElementIndex == this.elements.length-1){
            this.switcherRight.hide();
        }else{
            this.switcherLeft.show();
            this.switcherRight.show();
        }
    }
}


Switch.prototype.replace = function(){
	if(this.built){
	    var activeElement = null,
	    	positionElement = null,
        	heightElement = 0,
        	widthElement = 0;

		activeElement = this.elements.eq(this.activeElementIndex);

	    positionElement = activeElement.offset();
	    heightElement = activeElement.height();
	    widthElement = activeElement.width();

	    this.switcherLeft.css('top', positionElement.top+heightElement/2);
	    this.switcherLeft.css('left', positionElement.left-30-25);

	    this.switcherRight.css('top', positionElement.top+heightElement/2);
	    this.switcherRight.css('left', positionElement.left+widthElement+25);
	}
}

Switch.prototype.destroy = function (){
	if(this.built){
		this.elements.show();
		this.switcherLeft.remove();
		this.switcherLeft = null;
		this.switcherRight.remove();
		this.switcherRight = null;
		this.built = false;
	}
}


function switch_left(switcher) {
    var activeElement = switcher.elements.eq(switcher.activeElementIndex);

    activeElement.hide();
    switcher.activeElementIndex--;

    activeElement = switcher.elements.eq(switcher.activeElementIndex);
    activeElement.animate();
    activeElement.show();
    if(switcher.activeElementIndex == 0){
    	switcher.switcherLeft.hide();
    }else{
    	switcher.switcherLeft.show();
    	switcher.switcherRight.show();
    }
}

function switch_right(switcher) {
    var activeElement = switcher.elements.eq(switcher.activeElementIndex);

    activeElement.animate();
    activeElement.hide();
	switcher.activeElementIndex++;

    activeElement = switcher.elements.eq(switcher.activeElementIndex);
    activeElement.animate();
    activeElement.show();

    if(switcher.activeElementIndex == switcher.elements.length-1){
    	switcher.switcherRight.hide();
    }else{
    	switcher.switcherLeft.show();
    	switcher.switcherRight.show();
    }
}