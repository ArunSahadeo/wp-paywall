window.onload = function() {
    var app = new App();
};

var App = function() {
    this.init();
};

App.prototype = { 
    init: function() {
        if (this.elementExists('.nav-tabs a[data-tab]')) {
            var navTabs = document.querySelectorAll('.nav-tabs a[data-tab]');
            for (var i = 0; i < navTabs.length; i++)
            {
                var navTab = navTabs[i];
                this.setupNavTabs(navTab);
            }
        };

        if (this.elementExists('[data-visibility-toggle-target]')) {
            var visibilityToggleElems = document.querySelectorAll('[data-visibility-toggle-target]');

            for (var i = 0; i < visibilityToggleElems.length; i++)
            {
                var visibilityToggleElem = visibilityToggleElems[i];
                this.setupVisibilityToggle(visibilityToggleElem);
            }
        };

        if (this.elementExists('.contains-radios')) {
            var radioParents = document.querySelectorAll('.contains-radios');

            for (var i = 0; i < radioParents.length; i++)
            {
                var radioParent = radioParents[i];
                this.setupRadioHandler(radioParent);
            }
        };

        if (this.elementExists('input[type="text"]')) {
            var textInputs = document.querySelectorAll('input[type="text"]');

            for (var i = 0; i < textInputs.length; i++)
            {
                var textInput = textInputs[i];
                textInput.addEventListener('input', this.autoscaleInput);
            }
        };

        if (this.elementExists('[data-input-event-target]')) {
            var inputEventElements = document.querySelectorAll('[data-input-event-target]'); 

            for (var i = 0; i < inputEventElements.length; i++)
            {
                var inputEventElement = inputEventElements[i];
                inputEventElement.addEventListener('input', this.toggleInputTargetVisibility);
            }
        }
    },

    elementExists: function(selector) {
        selector = document.querySelectorAll(selector);
        return selector.length > 0; 
    },

    parents: function(selector, parentSelector) {
        if (parentSelector === undefined)
        {
            parentSelector = document;
        }

        var parents = [],
            parent = selector.parentNode;

        while (parent !== parentSelector)
        {
            var parentElem = parent;
            parents.push(parentElem);
            parent = parentElem.parentNode;
        }

        parents.push(parentSelector);

        return parents;
    },

    toggleInputTargetVisibility: function() {
        var selector = event.target || event.srcElement,
            target = selector.dataset.inputEventTarget;

        var self = window.App.prototype;

        if (!self.elementExists(target))
        {
            return;
        }

        target = document.querySelector(target);

        if (selector.value < 1)
        {
            if (!target.classList.contains('display-none'))
            {
                target.classList.add('display-none'); 
            }
        }

        else
        {
            target.classList.remove('display-none');
        }
    },

    visibilityToggleState: function() {
        var selector = event.target || event.srcElement,
            target = selector.dataset.visibilityToggleTarget;
    
        var self = window.App.prototype;

        if (!self.elementExists('.visibility-field'))
        {
            return;
        }

        if (self.elementExists('.visibility-field.active'))
        {
            var targetActive = document.querySelector('.visibility-field.active');
            targetActive.classList.remove('active');
            targetActive.classList.add('display-none');

        }

        target = document.querySelector(target);
        target.classList.remove('display-none');
        target.classList.add('active'); 
        
    },

    autoscaleInput: function(event) {
        var input = event.target || event.srcElement;

        input.setAttribute('size', input.value.length);
    },

    navTabClick: function(event) {
        var self = window.App.prototype;
        event.preventDefault();
        var navTab = event.target || event.srcElement,
            tab = navTab.dataset.tab;

        if (tab.length < 0 || !self.elementExists('[data-tab-section="' + tab + '"')) {
            return;
        }

        var tabSections = document.querySelectorAll('[data-tab-section]');
        for (var i = 0; i < tabSections.length; i++)
        {
            var tabSection = tabSections[i];
            if (!tabSection.classList.contains('display-none'))
            {
                tabSection.classList.add('display-none');
            }
        }

        document.querySelector('.nav-tab.active').classList.remove('active');
        document.querySelector('.cursor-not-allowed').classList.remove('cursor-not-allowed');
        navTab.classList.add('active');
        navTab.parentNode.classList.add('cursor-not-allowed');

        var tabSection = document.querySelector('[data-tab-section="' + tab + '"');

        if (tabSection.classList.contains('display-none')) 
        {
            tabSection.classList.remove('display-none');
        }

    },

    toggleRadioState: function(event) {
        event.preventDefault();
        var self = window.App.prototype;

        var radio = event.target || event.srcElement,
            parents = self.parents(radio),
            parent;

        for (var i = 0; i < parents.length; i++)
        {
            var parentElem = parents[i];
            if (!parentElem.classList || !parentElem.classList.contains('contains-radios'))
            {
                continue;
            }

            var parent = parentElem;
            break;
        }

        /*

        var parent = parents.filter(
            function (element)
            {
                return element.classList && element.classList.contains('contains-radios');
            }
        );

        */

        if (typeof parent === 'undefined')
        {
            return;
        }

        var nestedRadios = parent.querySelectorAll('input[type="radio"]');

        for (var i = 0; i < nestedRadios.length; i++)
        {
            var nestedRadio = nestedRadios[i];
            if (nestedRadio === radio)
            {
                continue;
            }

            nestedRadio.checked = false;
        }

    },
    
    setupNavTabs: function(selector) {
        var tab = selector.dataset.tab;
        selector.addEventListener('click', this.navTabClick);
    },

    setupVisibilityToggle: function(selector) {

        if (!this.elementExists(selector.dataset.visibilityToggleTarget))
        {
            return;
        }

        selector.addEventListener('change', this.visibilityToggleState);

    },

    setupRadioHandler: function(selector) {
        var radios = selector.querySelectorAll('input[type="radio"]');

        if (radios.length === 0)
        {
            return;
        }

        for (var i = 0; i < radios.length; i++)
        {
            var radio = radios[i];
            radio.addEventListener('change', this.toggleRadioState);
        }
    }
}
