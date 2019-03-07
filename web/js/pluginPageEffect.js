const Switch = (function () {
    const parser = new DOMParser();

    Switch.prototype.switcherLeftHTML = parser.parseFromString('<div class="switcher-right"><svg shape-rendering="geometricPrecision" height="40" width="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><polygon points="3,3 33,18 3,33" fill="rgba(255,255,255,0.5)" stroke="black" stroke-width="2"/></svg></div>', 'text/html').getElementsByTagName('div')[0];
    Switch.prototype.switcherRightHTML = parser.parseFromString('<div class="switcher-left"><svg shape-rendering="geometricPrecision" height="40" width="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><polygon points="33,3 3,18 33,33" fill="rgba(255,255,255,0.5)" stroke="black" stroke-width="2"/></svg></div>', 'text/html').getElementsByTagName('div')[0];

    function Switch(className) {
        this.className = className;
        this.switcherRight = null;
        this.switcherLeft = null;
        this.activeElementIndex = 0;
        this.elements = null;
        this.built = false;
        this.isEnable = false;
        this.animation = false;
    }

    Switch.prototype.switchLeft = function (switcher) {
        let activeElement = switcher.elements[switcher.activeElementIndex];

        this.fadeOutSlideRight(activeElement);
        switcher.activeElementIndex--;

        activeElement = switcher.elements[switcher.activeElementIndex];
        this.fadeInSlideRight(activeElement);

        if (switcher.activeElementIndex === 0) {
            switcher.switcherLeft.style.display = 'none';
        } else {
            switcher.switcherLeft.style.display = 'block';
            switcher.switcherRight.style.display = 'block';
        }
    }

    Switch.prototype.switchRight = function (switcher) {
        let activeElement = switcher.elements[switcher.activeElementIndex];

        this.fadeOutSlideLeft(activeElement);
        switcher.activeElementIndex++;

        activeElement = switcher.elements[switcher.activeElementIndex];
        this.fadeInSlideLeft(activeElement);

        if (switcher.activeElementIndex === switcher.elements.length - 1) {
            switcher.switcherRight.style.display = 'none';
        } else {
            switcher.switcherLeft.style.display = 'block';
            switcher.switcherRight.style.display = 'block';
        }
    }

    Switch.prototype.build = function () {
        if (!this.built) {
            this.elements = document.getElementsByClassName(this.className);
            const activeElement = this.elements[this.activeElementIndex];

            hideAll(this.elements);

            activeElement.style.display = 'block';

            const parent = activeElement.parentElement;
            parent.appendChild(this.switcherLeftHTML);
            parent.appendChild(this.switcherRightHTML);

            this.switcherLeft = activeElement.parentElement.getElementsByClassName('switcher-left')[0];
            this.switcherRight = activeElement.parentElement.getElementsByClassName('switcher-right')[0];

            this.switcherLeft.style.display = 'none';
            const object = this;

            this.switcherLeft.addEventListener('click', function () {
                this.switchLeft(object);
            }.bind(object));
            this.switcherRight.addEventListener('click', function () {
                this.switchRight(object);
            }.bind(object));

            Array.prototype.forEach.call(this.elements, function (section) {
                let dataOffset = {
                    defaultDiffX: 0,
                    prevX: 0,
                    element: section
                };

                const handlerMouseTouch = this.handlerMove(dataOffset);

                section.addEventListener('mousedown', function (event) {
                    if (this.isEnable && !this.animation) {
                        dataOffset.element.style.top = dataOffset.element.offsetTop + 'px';
                        dataOffset.element.style.left = dataOffset.element.offsetLeft + 'px';
                        dataOffset.defaultDiffX = parseInt(section.style.left) - event.clientX;
                        dataOffset.prevX = event.clientX;
                        dataOffset.defaultX = dataOffset.element.offsetLeft;

                        dataOffset.element.style.position = 'absolute';
                        document.body.style.overflow = 'hidden';

                        section.addEventListener('mousemove', handlerMouseTouch);
                        document.addEventListener('mouseup', this.handleMouseUp(handlerMouseTouch, dataOffset), {'once': true});
                    }
                }.bind(this));

                section.addEventListener('touchstart', function (event) {
                    if (this.isEnable && !this.animation) {
                        dataOffset.element.style.top = dataOffset.element.offsetTop + 'px';
                        dataOffset.element.style.left = dataOffset.element.offsetLeft + 'px';
                        dataOffset.defaultDiffX = parseInt(section.style.left) - event.touches[0].clientX;
                        dataOffset.prevX = event.touches[0].clientX;
                        dataOffset.defaultX = dataOffset.element.offsetLeft;

                        dataOffset.element.style.position = 'absolute';
                        document.body.style.overflow = 'hidden';

                        section.addEventListener('touchmove', handlerMouseTouch);
                        document.addEventListener('touchend', this.handleTouchEnd(handlerMouseTouch, dataOffset), {'once': true});
                    }
                }.bind(this));
            }.bind(object));

            this.built = true;
        }
    }
//Handlers Mouse
    Switch.prototype.handleMouseUp = function (handlerMouseTouch, dataOffset) {
        return function (event) {

            let section = dataOffset.element;
            section.removeEventListener('mousemove', handlerMouseTouch);
            document.body.style.overflow = 'auto';

            if (parseFloat(section.style.left) <= 15 && this.switcherRight.style.display !== 'none') {
                this.switchRight(this);
            } else if (parseFloat(section.style.left) >= section.parentNode.clientWidth - section.clientWidth - 15 && this.switcherLeft.style.display !== 'none') {
                this.switchLeft(this);
            } else {
                if (section.offsetLeft > (section.parentNode.clientWidth / 2 - section.clientWidth / 2)) {
                    this.slideToOriginFromRight(section, dataOffset.defaultX);
                } else {
                    this.slideToOriginFromLeft(section, dataOffset.defaultX);
                }
            }
        }.bind(this)
    }

    Switch.prototype.handleTouchEnd = function (handlerMouseTouch, dataOffset) {
        return function (event) {
            let section = dataOffset.element;
            section.removeEventListener('touchmove', handlerMouseTouch);
            document.body.style.overflow = 'auto';

            if (parseFloat(section.style.left) <= 15 && this.switcherRight.style.display !== 'none') {
                this.switchRight(this);
            } else if (parseFloat(section.style.left) >= section.parentNode.clientWidth - section.clientWidth - 15 && this.switcherLeft.style.display !== 'none') {
                this.switchLeft(this);
            } else {
                if (section.offsetLeft > (section.parentNode.clientWidth / 2 - section.clientWidth / 2)) {
                    this.slideToOriginFromRight(section, dataOffset.defaultX);
                } else {
                    this.slideToOriginFromLeft(section, dataOffset.defaultX);
                }
            }
        }.bind(this)
    }

    Switch.prototype.handlerMove = function (dataOffset) {
        return function (event) {
            let element = dataOffset.element;
            let x = event.clientX || event.touches[0].clientX;
            let direction = dataOffset.prevX - x < 0 ? 'right' : 'left';


            if (!((parseFloat(dataOffset.element.style.left) <= -dataOffset.element.clientWidth / 2 && direction === 'left') || (parseFloat(dataOffset.element.style.left) >= element.parentNode.clientWidth - dataOffset.element.clientWidth / 2 && direction === 'right'))) {
                dataOffset.element.style.left = (dataOffset.defaultDiffX + x) + 'px';
                dataOffset.prevX = x;
            }

            dataOffset.element.style.opacity = 1 - (Math.abs(x - element.parentNode.offsetLeft - element.parentNode.clientWidth / 2) * 0.3 / (element.parentNode.clientWidth / 2));
            dataOffset.element.style.transform = 'scale(' + (1 - (Math.abs(x - element.parentNode.offsetLeft - element.parentNode.clientWidth / 2) * 0.5 / (element.parentNode.clientWidth / 2))) + ')';
        }
    }

    Switch.prototype.disable = function () {
        if (this.built) {
            this.switcherLeft.style.display = 'none';
            this.switcherRight.style.display = 'none';
            this.isEnable = false;
            displayAll(this.elements);
        }
    }

    Switch.prototype.enable = function () {
        if (this.built) {
            const activeElement = this.elements[this.activeElementIndex];

            hideAll(this.elements);
            activeElement.style.display = 'block';

            this.switcherLeft.style.display = 'block';
            this.switcherRight.style.display = 'block';

            if (this.activeElementIndex === 0) {
                this.switcherLeft.style.display = 'none';
            } else if (this.activeElementIndex === this.elements.length - 1) {
                this.switcherRight.style.display = 'none';
            }
            this.isEnable = true;
        }
    }

    Switch.prototype.destroy = function () {
        if (this.built) {
            displayAll(this.elements);
            this.switcherLeft.remove();
            this.switcherLeft = null;
            this.switcherRight.remove();
            this.switcherRight = null;
            this.built = false;
            this.isEnable = false;
        }
    }
//Animation
    Switch.prototype.fadeOutSlideRight = function (section) {
        const offsetLeft = section.offsetLeft;
        const offsetTop = section.offsetTop;
        const step = offsetLeft / 20;
        const end = section.parentNode.clientWidth - section.clientWidth;
        const object = this;

        section.style.position = 'absolute';
        section.style.top = offsetTop + 'px';
        section.style.left = offsetLeft + 'px';
        section.style.opacity = '1';
        section.style.transform = 'scale(1)';
        this.animation = true;

        (function slideRight() {
            const left = parseFloat(section.style.left);
            const stepOp = 0.7 / 20;
            const stepScale = 0.2 / 20;
            const regexScale = /scale\((\d+(\.\d+)?)\)/;
            const scale = parseFloat(regexScale.exec(section.style.transform)[1]);

            section.style.left = (left + step) + 'px';
            section.style.opacity = parseFloat(section.style.opacity) - stepOp;
            section.style.transform = 'scale(' + (scale - stepScale) + ')';

            if (left < end) {
                setTimeout(slideRight.bind(this), 10);
            } else {
                section.style.display = 'none';
                section.style.position = 'static';
                section.style.transform = 'scale(1)';
                section.style.opacity = '1';
                this.animation = false;
            }
        }.bind(object))();
    }

    Switch.prototype.fadeInSlideLeft = function (section) {
        section.style.display = 'block';
        const offsetLeft = section.offsetLeft;
        const offsetTop = section.offsetTop;
        const start = section.parentNode.clientWidth - section.clientWidth;
        const step = (start - offsetLeft) / 20;
        const object = this;

        section.style.position = 'absolute';
        section.style.top = offsetTop + 'px';
        section.style.left = start + 'px';
        section.style.opacity = '0.3';
        section.style.transform = 'scale(0.8)';
        this.animation = true;

        (function slideLeft() {
            const left = parseFloat(section.style.left);
            const stepOp = 0.7 / 20;
            const stepScale = 0.2 / 20;
            const regexScale = /scale\((\d+(\.\d+)?)\)/;
            const scale = parseFloat(regexScale.exec(section.style.transform)[1]);

            section.style.left = (left - step) + 'px';
            section.style.opacity = parseFloat(section.style.opacity) + stepOp;
            section.style.transform = 'scale(' + (scale + stepScale) + ')';

            if (left > offsetLeft) {
                setTimeout(slideLeft.bind(this), 10);
            } else {
                section.style.position = 'static';
                this.animation = false;
            }
        }.bind(object))();
    }

    Switch.prototype.fadeOutSlideLeft = function (section) {
        const offsetLeft = section.offsetLeft;
        const offsetTop = section.offsetTop;
        const step = offsetLeft / 20;
        const object = this;

        section.style.position = 'absolute';
        section.style.top = offsetTop + 'px';
        section.style.left = offsetLeft + 'px';
        section.style.opacity = '1';
        section.style.transform = 'scale(1)';
        this.animation = true;


        (function slideLeft() {
            const left = parseFloat(section.style.left);
            const stepOp = 0.7 / 20;
            const stepScale = 0.2 / 20;
            const regexScale = /scale\((\d+(\.\d+)?)\)/;
            const scale = parseFloat(regexScale.exec(section.style.transform)[1]);

            section.style.left = (left - step) + 'px';
            section.style.opacity = parseFloat(section.style.opacity) - stepOp;
            section.style.transform = 'scale(' + (scale - stepScale) + ')';

            if (left > 0) {
                setTimeout(slideLeft.bind(this), 10);
            } else {
                section.style.display = 'none';
                section.style.position = 'static';
                section.style.transform = 'scale(1)';
                section.style.opacity = '1';
                this.animation = false;
            }
        }.bind(object))();
    }

    Switch.prototype.fadeInSlideRight = function (section) {
        section.style.display = 'block';
        const offsetLeft = section.offsetLeft;
        const offsetTop = section.offsetTop;
        const step = offsetLeft / 20;
        const object = this;
        this.animation = true;


        section.style.position = 'absolute';
        section.style.top = offsetTop + 'px';
        section.style.left = '0px';
        section.style.opacity = '0.3';
        section.style.transform = 'scale(0.8)';

        (function slideLeft() {
            const left = parseFloat(section.style.left);
            const stepOp = 0.7 / 20;
            const stepScale = 0.2 / 20;
            const regexScale = /scale\((\d+(\.\d+)?)\)/;
            const scale = parseFloat(regexScale.exec(section.style.transform)[1]);

            section.style.left = (left + step) + 'px';
            section.style.opacity = parseFloat(section.style.opacity) + stepOp;
            section.style.transform = 'scale(' + (scale + stepScale) + ')';

            if (left < offsetLeft) {
                setTimeout(slideLeft.bind(this), 10);
            } else {
                section.style.position = 'static';
                this.animation = false;
            }
        }.bind(object))();
    }

    Switch.prototype.slideToOriginFromLeft = function (section, origin) {
        const length = origin - section.offsetLeft;
        const regexScale = /scale\((\d+(\.\d+)?)\)/;
        const scale = parseFloat(regexScale.exec(section.style.transform)[1]);
        const stepLeft = (length) / 20;
        const stepOp = (1 - section.style.opacity) / 20;
        const stepScale = (1 - scale) / 20;
        const intervall = length * 10 / (section.parentNode.clientWidth / 2);
        const object = this;
        this.animation = true;

        (function slideToOrigin() {
            const left = section.offsetLeft;
            const scale = parseFloat(regexScale.exec(section.style.transform)[1]);

            console.log(stepLeft);

            if (section.offsetLeft < origin && stepLeft > 0.5) {
                section.style.left = (left + stepLeft) + 'px';
                section.style.opacity = parseFloat(section.style.opacity) + stepOp;
                section.style.transform = 'scale(' + (scale + stepScale) + ')';
                setTimeout(slideToOrigin.bind(this), intervall);
            } else {
                section.style.position = 'static';
                section.style.transform = 'scale(1)';
                section.style.opacity = '1';
                section.style.left = origin;
                this.animation = false;
            }
        }.bind(object))();
        console.log(this.animation);
    }

    Switch.prototype.slideToOriginFromRight = function (section, origin) {
        const length = section.offsetLeft - origin;
        const regexScale = /scale\((\d+(\.\d+)?)\)/;
        const scale = parseFloat(regexScale.exec(section.style.transform)[1]);
        const stepLeft = (length) / 20;
        const stepOp = (1 - section.style.opacity) / 20;
        const stepScale = (1 - scale) / 20;
        const intervall = length * 10 / (section.parentNode.clientWidth / 2);
        const object = this;
        this.animation = true;


        (function slideToOrigin() {
            const left = section.offsetLeft;
            const scale = parseFloat(regexScale.exec(section.style.transform)[1]);

            if (section.offsetLeft > origin && stepLeft > 0.5) {
                section.style.left = (left - stepLeft) + 'px';
                section.style.opacity = parseFloat(section.style.opacity) + stepOp;
                section.style.transform = 'scale(' + (scale + stepScale) + ')';
                setTimeout(slideToOrigin.bind(this), intervall);
            } else {
                section.style.position = 'static';
                section.style.transform = 'scale(1)';
                section.style.opacity = '1';
                section.style.left = origin;
                this.animation = false;
            }
        }.bind(object))();
    }

    function displayAll(elements) {
        Array.prototype.forEach.call(elements, function (element) {
            element.setAttribute('style', '');
        });
    }

    function hideAll(elements) {
        Array.prototype.forEach.call(elements, function (element) {
            element.style.display = 'none';
        });
    }

    return Switch;
})();

const switcher = new Switch('section-cv');

if ($(window).width() > 1655) {
    switcher.disable();
    
    $('#CV').removeClass('switcher-container');
} else {
    $('#CV').addClass('switcher-container');
    switcher.build();
    switcher.enable();
    
}

$(window).resize(function () {
    if ($(window).width() > 1655) {
        switcher.disable();
        
        document.getElementById('CV').classList.remove('switcher-container');
    } else {
        document.getElementById('CV').classList.add('switcher-container');
        switcher.build();
        switcher.enable();
        
    }
});



