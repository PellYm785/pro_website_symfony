function Category(name, img) {
    var nameNode = document.createTextNode(name);

    this.category = document.createElement('div');
    this.icon = document.createElement('img');
    this.title = document.createElement('h2');
    this.list = document.createElement('ul');

    this.category.className = 'category-ri';
    this.icon.setAttribute('src', img);
    this.title.appendChild(nameNode);

    this.category.appendChild(this.icon);
    this.category.appendChild(this.title);
    this.category.appendChild(this.list);
}

Category.prototype.add = function(item){
    if(item instanceof Item) {
        this.list.appendChild(item.item);
    }else {
        throw 'It isn\'t Item object';
    }
};

Category.prototype.delete = function(item){
    if(!this.items){
        throw 'No items is set';
    }
    if(item instanceof Item) {
        throw 'It isn\'t Item object';
    }

    return this.list.removeChild(item);
};

