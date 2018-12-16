function Item(text, details) {
    var textNode = document.createTextNode(text);

    this.item = document.createElement('li');
    this.item.className = 'item-ri';

    this.content = document.createElement('p');
    this.content.appendChild(textNode);

    this.details = document.createElement('div');
    this.details.className = 'details-ri';

    this.item.appendChild(this.content);
    this.item.appendChild(this.details);

    this.details.innerHTML += details;
}

Item.prototype.addContent = function(text){
    this.content.innerText = text;
};

Item.prototype.deleteContent = function(){
  	this.content.innerText = "";
};

Item.prototype.addDetails = function(details){
    if(!this.details){
        this.details = document.createElement('div');
        this.details.className = 'details-ri';
        this.item.appendChild(this.details);
    }

    this.details.innerHTML += details;
};

Item.prototype.deleteDetails = function(){
    if(!this.details){
        throw 'No details is set'
    }
	this.details.remove();
};