/**
 * 
 */
function RI(){
	this.sections = null;
}

RI.prototype.add = function(section){
    if(section instanceof Section) {
        if (this.sections) {
            this.sections.push(section);
        } else {
            this.sections = [section];
        }
    }else {
        throw 'It isn\'t Section object';
    }
};

RI.prototype.delete = function(section){
	if(!this.sections){
        throw 'No items is set';
    }

    switch(typeof section){
        case 'number':
            this.sections.splice(section,1);
            break;
        case 'object':
            if(section instanceof Section) {
                var index = this.sections.indexOf(section);
                this.sections.splice(section,index);
            }else{
                throw 'It isn\'t Section object';
            }
            break;
        case 'string':
            var i = 0;
            var found = false;

            while(i < this.sections.length && !found){
                if(this.sections[i] === item){
                    found = true;
                }
                i++;
            }
            if(found) {
                this.sections.splice(item, i);
            }else {
                throw 'Section doesn\'t exist';
            }
            break;
    }
}

RI.prototype.build = function(){
	if(!this.sections){
        throw 'No items is set';
    }
	
	var ri = document.createElement('div');
	ri.className = "ri";
	
	
	this.sections.forEach(function(section){
		ri.appendChild(section.build());
	});
	
	return ri;
}

