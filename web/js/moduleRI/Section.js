function Section (name){
    this.name = name;
    this.content = document.createElement('div');
    this.content.className = 'section-ri'
}

Section.prototype.add = function(category){
    if(category instanceof Category) {
        this.content.appendChild(category.category);
    }else {
        throw 'It isn\'t Category object';
    }
};

Section.prototype.delete = function(category){
    if(!this.categories){
        throw 'No categories is set';
    }

    if(category instanceof Category) {
        this.content.removeChild(category);
    }else {
        throw 'It isn\'t Category object';
    }


}