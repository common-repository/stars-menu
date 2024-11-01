/**
 * StarsMenu jquery plugin
 * requirement : jquery and underscore and transition-events and hammer and jquery.easing
 * created By StarsMenu Team
 * http://www.stars-menu.com
 * @StarsMenu package
 */
(function ($) {

    /**
     * StarsMenuFactory Class
     *
     * @TODO Improve Mobile Events For Responsive Mode
     *
     * @param element
     * @param options
     * @constructor
     */
    var StarsMenuFactory = function(element, options) {

        this.$element = $(element);

        this.stickyTopOffset = 0;

        this.touchenabled = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0);

        this.options  = $.extend({}, {
            // These are the defaults.
            isSticky                    : true,
            stickyTopOffset             : 0,
            stickyMobileTopOffset       : 0,
            activeMobileSticky          : false,
            stickyAnimateDelay          : 500 ,
            mobileWrapperZIndex         : 100000 ,
            mobileElementsDesign        : [] ,
            trigger                     : 'hover', // click || hover
            delay                       : 500,
            hamburgerMenuOpenTrigger    : "click" ,
            design                      : "modern-horizontal" ,
            //scroll animate for anc    hor (scroll To anchor with easing animate like #intro)
            scrollAnimate               : "easeInOutQuint" ,
            scrollAnimateDuration       : 2000 ,
            breakpoint                  : 910 ,
            submenuShiftDuration        : 500 ,
            hamburgerMenuCloseHoverDelay : 200 ,
            dropdownCloseHoverDelay     : 500
        }, options);


        if( this.touchenabled ){

            this.$element.addClass( 'starsmenu-touch' );

            this.options.trigger = "click";

            this.options.hamburgerMenuOpenTrigger = "click";

        }else{

            this.$element.addClass('starsmenu-notouch');

        }

        var deviceAgent = navigator.userAgent.toLowerCase();

        this.responsive = $(window).width() < this.options.breakpoint;

        this.addElementsDivider();

        this.initResponsiveMenuElements = false;

        this.responsiveElementsOrders = this.options.mobileElementsDesign;

        if( this.responsive === true ){

            this.responsiveMenuElements( "go" );

            this.fixResponsiveWindowHeight();

        }

        this.menuOffsetTop = this.$element.offset().top;

        this.menuHeight = this.$element.outerHeight(true);

        this.shiftTransitionMode = false;

        this.submenuShiftTimer = null;

        this.initialize();

    };

    /**
     * Dropdown
     * Responsive & vertical mode
     * toch
     * Sub Menu Width && height
     * parallax scroll animate for #
     * Sticky
     *
     * @type {{initialize: StarsMenuFactory.initialize, initEvents: StarsMenuFactory.initEvents, render: StarsMenuFactory.render, setPageMenuTrail: StarsMenuFactory.setPageMenuTrail, goToNextLevel: StarsMenuFactory.goToNextLevel, goToBackLevel: StarsMenuFactory.goToBackLevel, stickyMenu: StarsMenuFactory.stickyMenu}}
     */
    StarsMenuFactory.prototype = {

        initialize : function(){

            //Current Menu Items Selector with .starsmenu-mobile-submenu-back
            this.activeItemsSelector = '.starsmenu-active-item:not(.starsmenu-mobile-submenu-back-bottom)';

            this.submenuSelector = '.starsmenu-submenu';

            //this.submenuVisibleClass = 'starsmenu-mobile-submenu-visible';

            //this.topLevelItemsSelector = '.stars-menu-bar > ul > li';

            //this.topLevelItemsHasChildrenSelector = '.stars-menu-bar > ul > li.menu-item-has-children';

            this.submenuWrapperSelector = '.starsmenu-submenu-wrapper';

            this.submenuToggleSelector = '.starsmenu-mobile-submenu-toggle, .starsmenu-mobile-submenu-toggle-bottom, .starsmenu-mobile-submenu-toggle-combined';

            this.backItemsSelector = '.starsmenu-mobile-submenu-back, .starsmenu-mobile-submenu-back-bottom';

            this.dropdownToggleSelector = '.starsmenu-dropdown-toggle';

            this.wpAdminBarSelector = '#wpadminbar';

            //this.menuBarSelector = '.stars-menu-bar';

            this.hamburgerMenuOpenTrigger = this.options.hamburgerMenuOpenTrigger; //click or hover

            this.isOpenedDropdown = false;

            this.render();

        },

        render : function(){

            this.dropdownInit();

            this.serachElementInit();

            this.wooCartElementInit();

            this.hamburgerModeInit();

            this.scrollAnimateToAnchor();

            this.submenuShiftNavInit();

            this.setPageMenuTrail();

            if( this.options.isSticky === true )
                this.stickyMenu();

            this.setStickyTopOffset();

            this.responsiveMenuTest();

        },

        addElementsDivider : function(){

            var self = this ,
                elementWrappers = [ '.stars-menu-left-wrapper' , '.stars-menu-center-wrapper' , '.stars-menu-right-wrapper' , '.starsmenu-main-area' ];

            $.each(elementWrappers, function (idx, selector) {

                var areaChildren = self.$element.find(selector).children('.starsmenu-elitem-wrapper'),
                    areaChildrenNum = areaChildren.length;

                if( areaChildrenNum > 1 ) {

                    areaChildren.each(function (index, el) {

                        if( index != ( areaChildrenNum - 1 ) ){

                            $( '<div class="starsmenu-element-divider starsmenu-elitem-wrapper"></div>' ).insertAfter( $(this) );
                        }

                    });

                }

            });

            $(".starsmenu-element-divider.starsmenu-elitem-wrapper").each(function (index, el) {

                var nextEl = $(this).next('.starsmenu-elitem-wrapper');

                if( nextEl.hasClass('starsmenu-hide-in-sticky') ){
                    $(this).addClass("starsmenu-hide-in-sticky");
                }

                if( nextEl.hasClass('starsmenu-elitem-hamburger') ){
                    $(this).addClass("starsmenu-elitem-divider-hamburger");
                }

            });

        },

        hamburgerModeInit : function( reInit ){
            var self = this;

            reInit = _.isUndefined( reInit ) ? false : reInit;

            if( this.hamburgerMenuOpenTrigger == "hover" && this.responsive === false ) {

                this.$element.find('.starsmenu-trigger').on( "mouseenter.starsmenu.hamburgerMode" ,function () {
                    mode = "add";
                    self.openCloseHamburgerMode("add");

                    return false;

                });

                var showTimer = null;
                var mode = "remove";

                this.$element.on( "mouseenter.starsmenu.hamburgerMode" ,function () {

                    mode = "add";

                    //self.openCloseHamburgerMode( "add" );

                    return false;

                }).on( "mouseleave.starsmenu.hamburgerMode" , function () {

                    mode = "remove";

                    if (showTimer)//if there is already such event this cancels the setTimeout()
                        clearTimeout(showTimer);


                    var delay = self.options.hamburgerMenuCloseHoverDelay;

                    if( self.isOpenedDropdown === true ) {

                        delay += self.shiftTransitionMode === true ? ( self.options.dropdownCloseHoverDelay + self.options.submenuShiftDuration + 300 ) : self.options.dropdownCloseHoverDelay;

                    }

                    showTimer = setTimeout(function () //executes a code some time in the future
                    {
                        if (mode == "remove")
                            self.openCloseHamburgerMode("remove");

                    }, delay );

                    return false;

                });

            }else if( this.hamburgerMenuOpenTrigger == "click" || this.responsive === true ){

                this.$element.find('.starsmenu-trigger').on( "click.starsmenu.hamburgerMode" , function () {

                    var modeType = ( !self.$element.hasClass("stars-menu-hz-hamburger-active") ) ? "add" : "remove";

                    self.openCloseHamburgerMode( modeType );

                    return false;

                });

            }

            if( reInit === false ){

                $( document ).on( "click.starsmenu.mobile" , function (e) {

                    if( self.$element.hasClass('has-mobile-starsmenu-expanded') && !$(e.target).hasClass('starsmenu-main-area') && $(e.target).parents( '.starsmenu-main-area').length == 0 ) {

                        self.openCloseHamburgerMode( "remove" );

                    }

                });

            }

        },

        openCloseHamburgerMode : function( type ){
            var self = this;

            if( type == "add" ) {

                if( self.responsive === true ) {

                    self.$element.addClass('has-mobile-starsmenu-expanded');

                    self.$element.css({
                        zIndex    :   self.options.mobileWrapperZIndex
                    });

                    self.setVerticalSubmenuTop();

                }

                self.$element.addClass("stars-menu-hz-hamburger-active");

                if( self.responsive === false && self.$element.hasClass('starsmenu-bg-opened') ){

                    self.$element.addClass("starsmenu-bg-enabled-active");

                }

            }else{

                self.$element.removeClass("stars-menu-hz-hamburger-active");

                if( self.responsive === false && self.$element.hasClass('starsmenu-bg-opened') ){

                    self.$element.removeClass("starsmenu-bg-enabled-active");

                }

                if( self.responsive === true ) {

                    self.$element.removeClass('has-mobile-starsmenu-expanded');

                    self.$element.find(".starsmenu-main-area").one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {

                        self.$element.css({
                            zIndex    :   ''
                        });

                        self.setVerticalSubmenuTop("reset");

                    });

                }

            }

        },

        wooCartElementInit : function(){
            var self = this;

            this.$element.find(".starsmenu-woo-cart-element .starsmenu-mobile-dropdown-toggle-combined").on("click",function() {

                if( self.responsive === true ){

                    $(this).parents(".starsmenu-dropdownmenu-wrapper:first").addClass("starsmenu-mobile-dropdown-visible");

                    self.$element.addClass("starsmenu-mobile-dropdown-open");

                }

            });

            this.$element.find(".starsmenu-woo-cart-element .starsmenu-mobile-dropdown-back").on("click",function() {

                if( self.responsive === true ) {

                    $(this).parents(".starsmenu-dropdownmenu-wrapper:first").removeClass("starsmenu-mobile-dropdown-visible");

                    self.$element.removeClass("starsmenu-mobile-dropdown-open");

                }

            });

        },

        serachElementInit : function(){
            var self = this;

            /**
             * Serach Element
             */
            this.$element.find(".starsmenu-search-open").on("click",function(){

                self.$element.addClass("starsmenu-search-bar-active");

            });

            this.$element.find(".starsmenu-search-close").on("click",function(){

                self.$element.removeClass("starsmenu-search-bar-active");

            });

            this.$element.find(".starsmenu-search-button").on("click",function() {

                $( this ).parent("form:first").submit();

            });

        },

        /**
         * All Dropdowns Trigger Handle ( Menu Items && dropdown elemnts )
         */
        dropdownInit : function() {
            var self = this;

            var dropdownMode = "add",
                closeDropdownTimer = null;

            var _openDropdown = function( e , $this ){

                self.setActiveSubmenuHeight("reset");

                _clearDropdowns(e);

                self.setPageMenuTrail();

                $this.addClass("starsmenu-submenu-open");

                self.isOpenedDropdown = true;

                var currDepth = parseInt($this.attr('data-submenu-depth'));

                if (currDepth == 1) {
                    self.currentActiveSubmenu = $this.find(self.submenuSelector + ':first');
                }

                self.setActiveSubmenuHeight();

            };

            var _closeDropdown = function( e , $this ){

                $this.removeClass("starsmenu-submenu-open");

                self.isOpenedDropdown = false;

                self.setActiveSubmenuHeight("reset");

            };

            var _clearDropdowns = function (e) {

                $( self.dropdownToggleSelector ).each(function () {

                    var relatedTarget = { relatedTarget: this };

                    if ( ! $(this).hasClass('starsmenu-submenu-open') ) {
                        return ;
                    }

                    $(this).trigger(e = $.Event('hide.starsmenu.dropdown', relatedTarget));

                    if ( e.isDefaultPrevented() ) {
                        return ;
                    }

                    $(this).removeClass('starsmenu-submenu-open').trigger('hidden.starsmenu.dropdown', relatedTarget);

                });

            };

            this.$element.find( this.dropdownToggleSelector ).hover(function (e) {

                if( self.responsive === false && $(this).hasClass("starsmenu-dropdown-trigger-hover") ) {

                    dropdownMode = "add";

                    if( $(this).hasClass("starsmenu-submenu-open") ){
                        return ;
                    }

                    var $this = $(this);

                    _openDropdown( e , $this );

                }

            }, function (e) {

                if( self.responsive === false && $(this).hasClass("starsmenu-dropdown-trigger-hover") ) {

                    dropdownMode = "remove";

                    var $this = $(this);

                    var delay = self.shiftTransitionMode === true ? ( self.options.dropdownCloseHoverDelay + self.options.submenuShiftDuration + 300 ) : self.options.dropdownCloseHoverDelay;

                    if (closeDropdownTimer)//if there is already such event this cancels the setTimeout()
                        clearTimeout(closeDropdownTimer);

                    closeDropdownTimer = setTimeout(function () //executes a code some time in the future
                    {

                        if( dropdownMode == "remove" ) {

                            _closeDropdown( e , $this );

                        }

                    }, delay);

                }

            });

            this.$element.find( this.dropdownToggleSelector ).on( "click.starsmenu.dropdown" , function (e) {

                if( self.responsive === false && $(this).hasClass("starsmenu-dropdown-trigger-click") ) {

                    e.preventDefault();

                    var $this = $(this);

                    if( !$(this).hasClass("starsmenu-submenu-open") ) {

                        _openDropdown( e , $this );

                    }else {

                        _closeDropdown( e , $this );

                    }

                }

            });

            $( document ).on( "click.starsmenu" , function (e) {

                if( self.responsive === false && !$(e.target).hasClass('starsmenu-dropdown-toggle') && $(e.target).parents( self.dropdownToggleSelector ).length == 0 ) {
                    _clearDropdowns(e);
                }

            });

            this.$element.find( this.dropdownToggleSelector + " > .starsmenu-submenu-wrapper" ).on( "click" , function(e){
                e.stopPropagation();
            });

            this.$element.find( this.dropdownToggleSelector + " > .starsmenu-dropdown-wrapper" ).on( "click" , function(e){
                e.stopPropagation();
            });

        },

        responsiveMenuTest : function() {

            var self = this, _lazyTest;

            _lazyTest = _.debounce(function(){

                if( self.$element.hasClass("stars-menu-hz-hamburger-active") ) {

                    self.openCloseHamburgerMode( "remove" );

                }

                var newResponsiveMode = $(window).width() < self.options.breakpoint;

                var changeResponsiveMode = self.responsive !== newResponsiveMode;

                self.responsive = newResponsiveMode;

                self.setPageMenuTrail();

                if( self.responsive === true ){

                    self.$element.removeClass("starsmenu-bg-enabled-active");

                    self.responsiveMenuElements( "go" );

                }else{

                    self.responsiveMenuElements( "back" );

                }

                if( self.hamburgerMenuOpenTrigger == "hover" && changeResponsiveMode === true ) {

                    if (self.responsive === true) {

                        self.$element.find('.starsmenu-trigger').unbind("mouseenter.starsmenu.hamburgerMode");
                        self.$element.unbind("mouseenter.starsmenu.hamburgerMode");
                        self.$element.unbind("mouseleave.starsmenu.hamburgerMode");

                        self.hamburgerModeInit(true);

                    } else {

                        self.$element.find('.starsmenu-trigger').unbind("click.starsmenu.hamburgerMode");

                        self.hamburgerModeInit(true);

                    }

                }

                self.setStickyTopOffset();

                self.fixResponsiveWindowHeight();

                self.menuOffsetTop = self.$element.offset().top;

                self.menuHeight = self.$element.outerHeight(true);
                
            }, 10);

            $(window).on("resize.starsMenuResponsiveTest" , function(){
                _lazyTest();
            });

        },

        responsiveMenuElements : function( type ) {

            type = typeof type == "undefined" ? "go" : type; // go || back

            var self = this ,
                elementWrappers = [ '.stars-menu-left-wrapper' , '.stars-menu-center-wrapper' , '.stars-menu-right-wrapper' , '.starsmenu-main-area' ];

            if( this.initResponsiveMenuElements === false ) {

                $.each(elementWrappers, function (idx, selector) {

                    self.$element.find(selector).children('.starsmenu-elitem-wrapper').each(function (index, el) {

                        $(this).data("stmenuOriginalOrder", index);

                        $(this).attr("stmenu_original_order", index);

                        if( selector != ".starsmenu-main-area" ){

                            $(this).data("stmenuOriginalWrapper", selector);

                            $(this).data("stmenuOutOfMain", true);

                        }

                    });

                });

                this.initResponsiveMenuElements = true;

            }

            var $logo = self.$element.find( '.starsmenu-elitem-stars-logo' );

            var $search = self.$element.find( '.starsmenu-elitem-stars-search' );

            if( type == "go" ){

                $.each( [$logo , $search]  , function( idx , $el ) {

                    if ( ! $el.data( "stmenuOutOfMain") ) {

                        if( $el.find(" ~ .starsmenu-elitem-menu-bar").length == 1 ){

                            $el.appendTo( self.$element.find( '.stars-menu-left-wrapper' ) );

                        }else{

                            $el.prependTo( self.$element.find( '.stars-menu-right-wrapper' ) );

                        }

                    }

                });

                $.each( this.responsiveElementsOrders , function( idx , elId ){

                    self.$element.find( '.starsmenu-elitem-' + elId ).appendTo( self.$element.find('.starsmenu-main-area') );

                });

            }else{

                var stmenuOutOfMainElements = [],
                    stmenuMainInnerElements = [];

                $.each( [$logo , $search]  , function( idx , $el ) {

                    if ( ! $el.data( "stmenuOutOfMain") ) {

                        $el.appendTo( self.$element.find( '.starsmenu-main-area' ) );

                    }

                });

                self.$element.find('.starsmenu-main-area').children('.starsmenu-elitem-wrapper').each(function(){

                    if( $(this).data( "stmenuOutOfMain") ){

                        stmenuOutOfMainElements.push( $(this) );

                    }else{

                        stmenuMainInnerElements.push( $(this) );

                    }

                });


                if( stmenuOutOfMainElements.length > 0 ){


                    stmenuOutOfMainElements.sort(function( aEl , bEl ){

                        var a = parseInt( aEl.data("stmenuOriginalOrder") ),
                            b = parseInt( bEl.data("stmenuOriginalOrder") );

                        return a-b;

                    });

                    $.each( stmenuOutOfMainElements , function( idx , $el ){

                        var order = parseInt( $el.data("stmenuOriginalOrder") ) ,
                            $wrapper = $el.data("stmenuOriginalWrapper");

                        if( order == 0 ){

                            $el.prependTo( self.$element.find( $wrapper ) );

                        }else{

                            $el.insertAfter( self.$element.find( $wrapper + ' > [stmenu_original_order="' + (order - 1) + '"]' ) );

                        }

                    });

                }

                stmenuMainInnerElements.sort(function( aEl , bEl ){

                    var a = parseInt( aEl.data("stmenuOriginalOrder") ),
                        b = parseInt( bEl.data("stmenuOriginalOrder") );

                    return a-b;

                });

                $.each( stmenuMainInnerElements , function( idx , $el ){

                    $el.appendTo( self.$element.find( '.starsmenu-main-area' ) );

                });

            }

        },

        fixResponsiveWindowHeight : function(){

            var $selector = '.stars-menu-bar-wrapper.has-mobile-starsmenu-expanded:before,';

            $selector += '.starsmenu-main-area ,';
            $selector += '.starsmenu-dropdownmenu-wrapper .starsmenu-dropdown-wrapper,';
            $selector += '.stars-menu-bar li .starsmenu-submenu-wrapper,';
            $selector += '.starsmenu-dropdownmenu-wrapper .starsmenu-dropdown,';
            $selector += '.stars-menu-bar li .starsmenu-submenu-wrapper .starsmenu-submenu';

            if( this.responsive === true ) {
                $($selector).height($(window).height());
            }else{
                $($selector).css({
                    "height" : ""
                });
            }

        },

        submenuShiftNavInit : function(){

            var self = this;

            var body = new Hammer(document.body);

            body.on("swipeleft", function() {

                self.openCloseHamburgerMode( "remove" );

            });

            this.$element.find( this.submenuToggleSelector ).on( 'click' , function (e) {

                e.preventDefault();

                self.goToNextLevel( e , $(this) );

                //return false;

            });

            this.$element.find( this.backItemsSelector ).on('click', function (e) {

                e.preventDefault();

                self.goToBackLevel( e , $(this) );

                //return false;

            });

            var _lazySticky = _.debounce(function(e){ console.log( e );

                if( self.isVerticalMode() === true ){
                    self.setVerticalSubmenuTop();
                }

            }, 50);

            self.$element.find(".starsmenu-main-area").on("scroll.starsMenuTop" , function( e ){
                _lazySticky( e );
            });

            /*self.$element.find( self.submenuWrapperSelector ).transitionEnd( function(e) {
                //console.log(e.propertyName + ' ' + e.elapsedTime);

                if( e.propertyName == "opacity" || e.propertyName == "transform" || e.propertyName == "max-height" ) {
                    self.setActiveSubmenu();

                }

            });*/

        },

        isVerticalMode : function(){

            return this.responsive === true || this.options.design == "modern-vertical";

        },

        setVerticalSubmenuTop : function( type ){

            type = _.isUndefined( type ) ? "set" : type;

            var self = this;

            if( type == "set" ) {

                self.$element.find(".starsmenu-submenu.menu-depth-1").each(function () {

                    var _top = $(this).parents(".stars-menu-bar:first").position().top;//$(this).parents(".stars-menu-bar:first").offset().top  - self.$element.find(".starsmenu-main-area").scrollTop();

                    $(this).parents(".starsmenu-submenu-wrapper:first").css({
                        top: -_top + "px"
                    });

                });

                self.$element.find(".starsmenu-dropdown-wrapper").each(function () {

                    var _top = $(this).parents(".starsmenu-dropdown-element:first").position().top;//$(this).parents(".starsmenu-dropdown-element:first").offset().top  - self.$element.find(".starsmenu-main-area").scrollTop();

                    $(this).css({
                        top: -_top + "px"
                    });

                });

            }else{

                self.$element.find(".starsmenu-submenu.menu-depth-1").each(function(){

                    $(this).parents(".starsmenu-submenu-wrapper:first").css({
                        top : ''
                    });

                });

                self.$element.find(".starsmenu-dropdown-wrapper").each(function () {

                    $(this).css({
                        top : ''
                    });

                });

            }

        },

        //TODO Add Hidden Scrolling For Vertical & Responsive Mode
        verticalHiddenScroll : function(){

            //mousewheel For Desktop
            self.$element.bind('mousewheel', '.starsmenu-submenu , .starsmenu-main-area' , function(event) {
                event.preventDefault();
                var scrollTop = this.scrollTop;
                this.scrollTop = (scrollTop + ((event.deltaY * event.deltaFactor) * -1));
                //console.log(event.deltaY, event.deltaFactor, event.originalEvent.deltaMode, event.originalEvent.wheelDelta);
            });



        },

        setPageMenuTrail : function(){

            //this.$element.find( '.' + this.submenuVisibleClass ).removeClass( this.submenuVisibleClass );
            this.$element.find( '.starsmenu-submenu-open' ).removeClass( 'starsmenu-submenu-open' );

            var deepestActiveMenus = this.$element.find( this.activeItemsSelector + ":last" ).parents( this.submenuSelector );

            var currentMenuItems = this.$element.find( this.activeItemsSelector + ":last" ).parents('.menu-item');

            if( this.responsive === true ){

                currentMenuItems.addClass("starsmenu-submenu-open");

            }else{

                currentMenuItems.each( function( index , el){

                    if( index != ( currentMenuItems.length - 1 ) ) {
                        $(this).addClass("starsmenu-submenu-open");
                    }

                });

            }

            //var currentHasSubMenu = deepestActiveMenus.length > 0 && this.$element.find( this.activeItemsSelector + ":last" ).hasClass("menu-item-has-children");

            var depth = deepestActiveMenus.length - 1;

            depth = depth < 1 ? 1 : depth;

            depth = ( this.responsive === true && deepestActiveMenus.length > 1 ) ? depth + 1 : depth;

            var parentLi = currentMenuItems.last();

            if( depth > 1 && !parentLi.parents('.stars-menu-bar:first').hasClass("stars-menu-bar-mobile-active") ){
                parentLi.parents('.stars-menu-bar:first').addClass("stars-menu-bar-mobile-active");
            }

            this.currentActiveSubmenu = this.$element.find( this.activeItemsSelector + ":last" ).parents( this.submenuSelector + ":first" );

            //if( this.responsive === true ) {
                //$('.' + this.submenuVisibleClass).parents(".menu-item:first").addClass("starsmenu-submenu-open");
            //}

            //this.setActiveSubmenu();

            //alert( this.$element.find( this.activeItemsSelector + ":last" ).parents('.menu-item').length );
            //this.topLevelItemsSelector
            this.$element.find( this.dropdownToggleSelector ).each(function (delta, menuItem) {

                if (menuItem == parentLi[0]) {

                    $(menuItem).attr('data-submenu-depth', depth);

                } else {

                    $(menuItem).attr('data-submenu-depth', 1);

                }

            });

            this.$element.attr('data-submenu-depth', depth );

        },

        goToNextLevel : function ( e , $el ) {

            // Get the parent and the new depth.
            var parentLi = $(e.target).parents('.menu-item').last(),
                depth = parseInt( parentLi.attr('data-submenu-depth') ) + 1;

            if ( $(e.target).parents('.menu-item').length == 1 && this.isVerticalMode() === false ) {
                return false;
            }

            if(!$(e.target).parents('.stars-menu-bar:first').hasClass("stars-menu-bar-mobile-active")){
            	$(e.target).parents('.stars-menu-bar:first').addClass("stars-menu-bar-mobile-active");
            }

            var nextSubMenu = $el.parents(".starsmenu-item-inner:first").siblings( this.submenuWrapperSelector ).find('>' + this.submenuSelector );

            // Add Submenu Visible Class To this submenu And All Parent Submenus
            //nextSubMenu.addClass( this.submenuVisibleClass ).parents( this.submenuSelector ).addClass( this.submenuVisibleClass );

            this.currentActiveSubmenu = nextSubMenu;

            if( nextSubMenu.parents(".menu-item:first").hasClass("starsmenu-submenu-open") ){
                return ;
            }

            nextSubMenu.parents(".menu-item").addClass("starsmenu-submenu-open");

            parentLi.attr('data-submenu-depth', depth);
            this.$element.attr('data-submenu-depth', depth);

            this.setActiveSubmenuHeight();

            this.setShiftTransitionMode();

        },

        goToBackLevel : function ( e , $el ) {

            var self = this;

            //$el.parent().removeClass( this.submenuVisibleClass );

            this.$element.removeClass('has-mobile-submenu-active');

            this.currentActiveSubmenu = $el.parent().parents(self.submenuSelector + ":first");

            if( !$el.parent().parents(".menu-item:first").hasClass("starsmenu-submenu-open") ){
                return ;
            }

            $el.parent().parents(".menu-item:first").removeClass("starsmenu-submenu-open");

            // Get the parent and the new depth.
            var parentLi = $(e.target).parents('.menu-item').last();

            var depth = parseInt( parentLi.attr('data-submenu-depth') )  - 1;

            parentLi.attr('data-submenu-depth', depth);

            this.$element.attr('data-submenu-depth', depth);
            
            if(depth == 1){    
            	$(e.target).parents('.stars-menu-bar:first').removeClass("stars-menu-bar-mobile-active");
            }

            this.setActiveSubmenuHeight();

            this.setShiftTransitionMode();

        },

        setShiftTransitionMode : function(){

            var self = this;

            this.shiftTransitionMode = true;

            if (this.submenuShiftTimer)//if there is already such event this cancels the setTimeout()
                clearTimeout(this.submenuShiftTimer);

            this.submenuShiftTimer = setTimeout(function () //executes a code some time in the future
            {

                self.shiftTransitionMode = false;

            }, this.options.submenuShiftDuration);

        },

        /*setActiveSubmenu : function(){

            var self = this;

            self.$element.find( self.submenuWrapperSelector ).removeClass('starsmenu-current-submenu-active');

            self.currentActiveSubmenu.parents( self.submenuWrapperSelector + ":first" ).addClass("starsmenu-current-submenu-active");

        },*/

        setActiveSubmenuHeight : function( type ){

            if( this.responsive === true ){
                return ;
            }

            type = _.isUndefined( type ) ? "set" : type;

            if( type == "set" ) {

                var topSubmenuWrapper = this.currentActiveSubmenu.parents(this.submenuWrapperSelector + ":last"),
                    oldHeight = topSubmenuWrapper.height(),
                    _height = this.currentActiveSubmenu.outerHeight(true);

                if( oldHeight >= _height && topSubmenuWrapper.hasClass("starsmenu-top-submenu-wrapper-animated") ){

                    topSubmenuWrapper.removeClass("starsmenu-top-submenu-wrapper-animated");

                }

                if( oldHeight < _height && !topSubmenuWrapper.hasClass("starsmenu-top-submenu-wrapper-animated") ){

                    topSubmenuWrapper.addClass("starsmenu-top-submenu-wrapper-animated");

                }

                //set Top Submenu Wrapper height
                topSubmenuWrapper.css({
                    height      : _height + "px",
                    maxHeight   : _height + "px"
                });

            }else if( type == "reset" ){

                //this.currentActiveSubmenu.parents(this.submenuWrapperSelector + ":last")
                this.currentActiveSubmenu.parents(this.submenuWrapperSelector + ":last").css({
                    height      : "",
                    maxHeight   : ""
                });

                this.$element.find( ".starsmenu-top-submenu-wrapper-animated" ).removeClass("starsmenu-top-submenu-wrapper-animated");


            }

        },

        setStickyTopOffset : function(){

            var sticky_top = ( this.responsive === false ) ? this.options.stickyTopOffset : this.options.stickyMobileTopOffset ,
                wpadminbar = $( this.wpAdminBarSelector ),
                _position = wpadminbar.css("position");

            if( wpadminbar.length > 0 && _position == "fixed" ) {
                sticky_top += wpadminbar.outerHeight();
            }

            this.stickyTopOffset = sticky_top;

        },

        stickyMenu : function(){

        },

        scrollAnimateToAnchor : function(){
            var self = this;

            this.$element.find('a[href*=#]').each(function(){
                if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
                    && location.hostname == this.hostname
                    && this.hash.replace(/#/,'') ) {

                    var targetId = $(this.hash),
                        targetAnchor = $('[name=' + this.hash.slice(1) + ']') ,
                        target = targetId.length ? targetId : targetAnchor.length ? targetAnchor : false ,
                        targetOffsetTop;

                    if( target ){
                        $(this).click(function(e){
                            e.preventDefault();

                            targetOffsetTop = target.offset().top;

                            if( self.options.isSticky === true ){
                                targetOffsetTop -= self.$element.outerHeight(true);
                            }

                            if( $( self.wpAdminBarSelector ).length > 0 ) {
                                targetOffsetTop -= $( self.wpAdminBarSelector ).outerHeight();
                            }

                            self.goToByScroll(targetOffsetTop);

                        });
                    }

                }
            });

        },

        goToByScroll : function ( targetOffset ) {

            if( _.isUndefined( jQuery.easing ) || !this.options.scrollAnimate  )
                $('html, body').animate({scrollTop: targetOffset}, this.options.scrollAnimateDuration );
            else{
                var scrollAnimate = this.options.scrollAnimate ? this.options.scrollAnimate : 'easeInOutQuint';
                $('html, body').animate({
                    scrollTop: targetOffset
                }, this.options.scrollAnimateDuration , scrollAnimate);
            }

        }

    };

    $.fn.starsmenu = function (option) {

        var slice = Array.prototype.slice ,
            args = slice.call( arguments, 1 );

        if (typeof option == 'string' && option == "option" && args.length == 1 ){
            var data = this.data('stars.starsmenu');
            if(typeof data == "undefined" || typeof data[option] == "undefined" )
                return ;

            return data[option].apply(data , args );
        }

        return this.each(function () {
            var $this   = $(this);
            var data    = $this.data('stars.starsmenu') ;

            if (!data && option == 'destroy') return ;

            if(option == "destroy"){
                $this.data('stars.starsmenu').destroy();
                return ;
            }

            var options = typeof option == 'object' && option;
            if (!data) $this.data('stars.starsmenu', (data = new StarsMenuFactory(this, options)));
            if (typeof option == 'string') data[option].apply(data , args );
        });

    };

    $(document).ready(function( $ ) {

        //var _starsMenuconfigs = window._starsMenuJsConfigs;

        $.each( window._starsMenuJsConfigs , function( key , config ){
            $( "#" + config.wrapperId ).starsmenu( config.params );
        });

    });

}( jQuery ));