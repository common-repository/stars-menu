/*! Hammer.JS - v2.0.8 - 2016-04-23
 * http://hammerjs.github.io/
 *
 * Copyright (c) 2016 Jorik Tangelder;
 * Licensed under the MIT license */
window.wp = window.wp || {};
//var _formTableSettings;
/**
 * @file grid
 *
 * Defines the behavior of the grid toggle.
 */
(function ($) {

  "use strict";

  var wp = window.wp;

  $(document).ready(function($){

      var _currentTabPanel = '';

      var _activeSettingsGroup = function( $this ){

          var tab = $this.data("sectionGroup");

          $this.parents(".stmenu-sub-sections:first").find(".stmenu-sub-section-tab").removeClass('stmenu-active');

          $this.addClass("stmenu-active");

          if( tab == "_all" ){

              $(".row-field-container").fadeIn(500);

          }else {

              $(".row-field-container").fadeOut(500);

              var tabFilterClass = ".row-field-container.tab-filter-" + tab;

              if( _currentTabPanel == 'styling' ){
                  tabFilterClass += ".panel-filter-styling";
              }

              $(tabFilterClass).fadeIn(500);
          }

      };

      $(".stmenu-sub-sections .stmenu-sub-section-tab").livequery(function () {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          $(this).on("click" , function(){

              _searchSettingsReset( false );

              _activeSettingsGroup( $(this) );

          });

          if( $(this).hasClass("stmenu-active") ){

              _activeSettingsGroup( $(this) );

          }

      });




      $(".starsmenu-theme-panel-tabs .starsmenu-theme-panel-tab").livequery(function () {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          var _filters = ['styling' , 'settings' , 'designer'];

          $(this).on("click" , function(){

              _currentTabPanel = $(this).data("filter");

              _searchSettingsReset();

              var _currFilter = $(this).data("filter"),
                  _activeGEl = $(".stmenu-sub-sections .stmenu-sub-section-tab.stmenu-active"),
                  activeGroup = ( _activeGEl.length == 0 ) ? "none" : _activeGEl.data("sectionGroup") ,
                  newActiveGroup = '';

              if( _currFilter != 'designer'){

                  if( $.inArray( activeGroup , [ 'none' , 'menu-bar' , 'top_level_items' ] ) > -1 && _currFilter == 'settings' ){

                      newActiveGroup = 'basic';

                  }else if( $.inArray( activeGroup , [ 'none' , 'basic' , 'position' , 'misc' , 'sub-nav-bar' , 'advanced' ] ) > -1 && _currFilter == 'styling' ){

                      newActiveGroup = 'menu-bar';

                  }

              }

              $(".starsmenu-theme-panel-tabs .starsmenu-theme-panel-tab").removeClass("stmenu-active-panel-tab");

              $(this).addClass("stmenu-active-panel-tab");

              _.each( _filters , function(filter){
                  if( filter != _currFilter ) {
                      $(".titan-framework-panel-wrap .options-container").removeClass("starsmenu-theme-panel-tab-" + filter);
                  }else{
                      $(".titan-framework-panel-wrap .options-container").addClass( "starsmenu-theme-panel-tab-" + filter );
                  }
              });

              /*if( _activeGEl.length == 0 ) {
                  $(_formTableSettings).prependTo($(".titan-framework-panel-wrap .stmenu-fields-wrapper-inner"));
              }*/

              if( !_.isEmpty( newActiveGroup ) ) {

                  _activeSettingsGroup( $(".stmenu-sub-sections").find('.stmenu-sub-section-tab[data-section-group="' + newActiveGroup + '"]') );

              }else if( _currFilter != 'designer'){

                  _activeSettingsGroup( _activeGEl );

              }

          });

          $(".titan-framework-panel-wrap .options-container").addClass( "starsmenu-theme-panel-tab-designer" );

      });

      var _themeItemBeforeSearchGroup ,
          _searchStart = false;

      var _searchSettingsReset = function( revert , clean ){

          revert = !_.isUndefined( revert ) ? revert : true;

          clean = !_.isUndefined( clean ) ? clean : true;

          var _input = $(".stmenu-search-settings-container .stmenu-search-settings");

          if( _input.length > 0 && _searchStart === true ){

              if( clean === true ) {
                  _input.val("");
              }

              _searchStart = false;

              $(".titan-framework-panel-wrap .options-container,.stars-menu-item-options-wrapper").removeClass("starsmenu-theme-panel-search-mode");

              if( revert === true ) {
                  _activeSettingsGroup($(".stmenu-sub-sections").find('.stmenu-sub-section-tab[data-section-group="' + _themeItemBeforeSearchGroup + '"]'));
              }
          }

      };

      //For Search In Menu Item Settings Panel And Menu Theme Settings Panel
      $(".stmenu-search-settings-container .stmenu-search-settings").livequery(function () {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          $(this).on('input', function(e) {

              if( _.isEmpty( $(this).val() ) ) {

                  _searchSettingsReset();

              }

          });

          $(this).on("keyup" , function(){

              var filter = $.trim( $(this).val() );

              if( !_.isEmpty( filter ) && filter.length > 2 ) {

                  if (_searchStart === false) {

                      _searchStart = true;

                      var _activeGEl = $(".stmenu-sub-sections .stmenu-sub-section-tab.stmenu-active");

                      _activeGEl.removeClass("stmenu-active");

                      _themeItemBeforeSearchGroup = ( _activeGEl.length == 0 ) ? "none" : _activeGEl.data("sectionGroup");

                      $(".titan-framework-panel-wrap .options-container,.stars-menu-item-options-wrapper").addClass("starsmenu-theme-panel-search-mode");

                  }

              }else{

                  var _clean =  filter.length == 0;

                  _searchSettingsReset( true , _clean );

                  return ;
              }

              // Loop through the Settings list
              $(".row-field-container").each(function(){

                  // If the list item does not contain the text phrase fade it out
                  var desc = $(this).find(".description").text(),
                      key = $(this).data("key") || "";

                  if ( key.search( new RegExp(filter, "i") ) < 0 && desc.search( new RegExp(filter, "i") ) < 0 ) {

                      $(this).fadeOut(100);

                  } else {

                      $(this).fadeIn(100);

                  }

              });

          });

      });

      
      $( '#menu-management' ).on( 'mouseenter touchEnd MSPointerUp pointerup' , '.menu-item:not(.stmenu-processed)' , function(e){ 
          $(this).addClass( 'stmenu-processed' );
          $(this).find( '.item-title' ).append( '<span class="stmenu-settings-toggle" data-stmenu-toggle="' + $(this).attr('id') + '"><i class="smd smd-setting"></i> Stars Menu </span>' );
          //console.log( $(this).find( '.item-title' ).text() );
      });


      //Don't allow clicks to propagate when clicking the toggle button, to avoid drag-starts of the menu item
      $( '#menu-management' ).on( 'mousedown' , '.stmenu-settings-toggle' , function( e ){
          e.preventDefault();
          e.stopPropagation();

          return false;
      });

      var optionsWrapper = $(".stars-menu-item-options-wrapper"),
          $body = $('body'),
          currentMenuItemId = null ,
          menuItemsPanelsContent = {} ,
          _AjaxProccesing = {};

      var _menuItemsPanelChangeState = function( isOpen ){

          if( isOpen ){
              _searchSettingsReset();
          }

          optionsWrapper.toggleClass('stars-menu-item-options-open' , !isOpen);

          $body.toggleClass("stars-menu-item-options-open-mode" , !isOpen);

      };

      $(document).on( 'keyup', function(e) {
          if(e.keyCode == 27) {
              if( !_.isNull( currentMenuItemId ) ){

                  _menuItemsPanelChangeState( optionsWrapper.hasClass("stars-menu-item-options-open") );

              }
          }
      });

      var _switchTmpl = function( menuItemId ){

          menuItemsPanelsContent[menuItemId] = optionsWrapper.find(".stars-menu-item-panel-content").children().hide().detach();

      };

      var _settingsLoading = function( show ){

          if( show && $(".stmenu-menu-item-settings-loading").hasClass("hide") ){

              $(".stmenu-menu-item-settings-loading").removeClass("hide");

          }else if( ! show && ! $(".stmenu-menu-item-settings-loading").hasClass("hide") ){

              $(".stmenu-menu-item-settings-loading").addClass("hide");

          }

      };

      $( '.stars-menu-item-options-wrapper .stmenu-fullscreen-settings' ).livequery(function(){

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          $(this).on( 'click' , function( e ){

              optionsWrapper.toggleClass("stars-menu-item-options-open-fullscreen");
              $(this).toggleClass("stmenu-active");

          });

      });

      $("#menu-settings-column .starsmenu-tooltip-wrap").tooltip({
          position: {
              my: "left+15 left",
              at: "right center",
              using: function( position, feedback ) {
                  $( this ).css( position );
                  $( "<div>" )
                      .addClass( "ui-tooltip-arrow ui-tooltip-left" )
                      .addClass( feedback.vertical )
                      .addClass( feedback.horizontal )
                      .appendTo( this );
              }
          }
      });

      var _isResetMenuItemSettings = false;

      $( '#menu-management' ).on( 'click' , '.stmenu-settings-toggle' , function( e ){

          var thisMenuItemId = $(this).attr( 'data-stmenu-toggle' ) ,
              isOpen = optionsWrapper.hasClass("stars-menu-item-options-open") ,
              needToLoad = false,
              currentMenuItem = $(this).parents( 'li.menu-item' );

          if( _.isNull( currentMenuItemId ) ){

              _menuItemsPanelChangeState( false );

              needToLoad = true;

          }else if( currentMenuItemId == thisMenuItemId ){

              _menuItemsPanelChangeState( isOpen && !_isResetMenuItemSettings );

              needToLoad = _isResetMenuItemSettings;

          }else if( currentMenuItemId != thisMenuItemId ){

                if( !isOpen ){

                    _menuItemsPanelChangeState( isOpen );

                }else{

                    _searchSettingsReset();

                }

                _switchTmpl( currentMenuItemId );

              needToLoad = true;

          }

          _settingsLoading( false );

          if( !_.isUndefined( _SaveAjaxProccesing[thisMenuItemId] ) ){

              _SaveItemSettingsLoading( optionsWrapper.find('.stmenu-menu-item-save-button') , "loading" );

          }else {

              _SaveItemSettingsLoading( optionsWrapper.find('.stmenu-menu-item-save-button') );
          }

          var item_type_label = currentMenuItem.find('.item-type:first').text(),
              item_type_class = item_type_label.replace( '[' , '' ).replace( ']' , '' ).replace( / /g , '_' ).toLowerCase(),
              item_type = item_type_class.replace( 'starsmenu_' , '' );

          if( needToLoad === true ) {

              if( !_.isUndefined( _AjaxProccesing[thisMenuItemId] ) ){

                  _settingsLoading( true );

              }
              
              if (_.isUndefined(menuItemsPanelsContent[thisMenuItemId]) || _isResetMenuItemSettings === true ) {

                  if( !_.isUndefined( _AjaxProccesing[thisMenuItemId] ) ){

                      return ;

                  }

                  _settingsLoading( true );

                  _AjaxProccesing[thisMenuItemId] = true;

                  wp.ajax.post('menu_item_settings', {
                      nonce     : $( '#stmenu-item-settings-loaded-nonce' ).val(),
                      item_id   : thisMenuItemId ,
                      item_type : item_type ,
                      reset     : _isResetMenuItemSettings ? "yes" : "no"
                  }).done(function (data) {

                      if( data.item_id == currentMenuItemId ){

                          if( _isResetMenuItemSettings ){
                              optionsWrapper.find(".stars-menu-item-panel-content").html('');
                          }

                          $(data.content).appendTo( optionsWrapper.find(".stars-menu-item-panel-content") ).fadeIn("slow");

                          _settingsLoading( false );

                      }else{

                          menuItemsPanelsContent[data.item_id] = data.content;

                      }

                      _isResetMenuItemSettings = false;

                      delete _AjaxProccesing[data.item_id];


                  }).fail(function (response) {

                      _settingsLoading( false );

                      optionsWrapper.find(".notice.notice-error .stmenu-status-message").text( response.message );

                      optionsWrapper.find(".stmenu-error-massage").slideDown( 900 ).delay(3000).slideUp(900);

                      _isResetMenuItemSettings = false;

                      //delete _AjaxProccesing[data.item_id];

                  });

              } else {

                  $( menuItemsPanelsContent[thisMenuItemId] ).appendTo( optionsWrapper.find(".stars-menu-item-panel-content") ).fadeIn("slow");

              }

          }

          currentMenuItemId = thisMenuItemId;

          var hash = '#' + currentMenuItemId;

          if( optionsWrapper.data( "itemType" ) ){

              optionsWrapper.removeClass( 'stmenu-menu-item-panel-type-' + optionsWrapper.data( "itemType" ) );

          }

          optionsWrapper.addClass( 'stmenu-menu-item-panel-type-' + item_type_class );

          optionsWrapper.data( "itemType" , item_type_class );

          //Get the Title from the Menu Item
          var _title = currentMenuItem.find('.menu-item-title').text();
          
          if( !_title ){
              _title = currentMenuItem.find('.item-title').text();
              _title = _title.substring( 0 , _title.indexOf( ' Stars' ) );
          }

          //Set Panel's Item Title, ID link, and Type
          optionsWrapper.find( '.stmenu-menu-item-title' ).html( '<a href="'+hash+'">'+_title+'</a>' );
          optionsWrapper.find( '.stmenu-menu-item-id' ).html( '<a href="'+hash+'">'+hash+'</a>' );
          optionsWrapper.find( '.stmenu-menu-item-type' ).text( item_type_label );

      });


      optionsWrapper.find(".stmenu-menu-item-settings-close").on( 'click' , function(e){
          e.preventDefault();
          e.stopPropagation();

          _menuItemsPanelChangeState( true );

      });

      $(".stars-menu-item-options-wrapper").mCustomScrollbar({
          //theme:"dark" ,
          autoHideScrollbar:true ,
          advanced:{
              updateOnBrowserResize:true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/
              updateOnContentResize:true
          },
          //scrollButtons:{
          //    enable:true
          //},
      });

      var _SaveItemSettingsLoading = function( $this , status ){

          $this.find( '.stmenu-save-status' ).addClass("hide");

          switch ( status ){

              case "loading" :

                  $this.find( '.stmenu-save-status.stmenu-save-loading' ).removeClass("hide");

                  break;

              case "success" :

                  $this.find( '.stmenu-save-status.stmenu-save-success' ).removeClass("hide");

                  var _showNormal = function(){

                      $this.find( '.stmenu-save-status.stmenu-save-success' ).addClass("hide");

                      $this.find( '.stmenu-save-status.stmenu-save' ).removeClass("hide");

                      window.clearTimeout(timeoutID);

                  };

                  var timeoutID = window.setTimeout( _showNormal , 3000);

                  break;

              default :

                  $this.find( '.stmenu-save-status.stmenu-save' ).removeClass("hide");

          }

      };

      var _SaveAjaxProccesing = {};

      optionsWrapper.on( 'click' , '.stmenu-menu-item-save-button' , function( e ){

          if( _.isNull( currentMenuItemId ) ){

              return ;

          }

          if( !_.isUndefined( _SaveAjaxProccesing[currentMenuItemId] ) ){

              _SaveItemSettingsLoading( $(this) , "loading" );

              return ;

          }

          var data = {
              //nonce     : $( '#titan-framework_theme-options_nonce' ).val(),
              item_id   : currentMenuItemId ,
              menu_id   : $("input#menu").val() ,
              form      : {}
          };

          var $this = $(this);

          _SaveAjaxProccesing[currentMenuItemId] = true;

          _SaveItemSettingsLoading( $(this) , "loading" );

          $.each( $(".stmenu-menu-item-settings-form").serializeArray() , function(i, field){

              data.form[field.name] = field.value;

          });

          !$('.stmenu-menu-item-settings-form .tf-checkbox,.stmenu-menu-item-settings-form .tf-enable').find('input[type="checkbox"]').not(":checked").each(function(){

              var fieldName = $(this).attr("name");

              if( _.isUndefined(data.form[fieldName]) ){
                  data.form[fieldName] = '0';
              }

          });

          wp.ajax.post( 'menu_item_settings_save' , data ).done(function (data) {

              if( data.item_id == currentMenuItemId ) {
                  _SaveItemSettingsLoading($this, "success");
              }

              delete _SaveAjaxProccesing[currentMenuItemId];

          }).fail(function (response) {

              _SaveItemSettingsLoading( $this );

              optionsWrapper.find(".notice.notice-error .stmenu-status-message").text( response.message );

              optionsWrapper.find(".stmenu-error-massage").slideDown( 900 ).delay(3000).slideUp(900);

              delete _SaveAjaxProccesing[currentMenuItemId];

          });


      });

      optionsWrapper.on( 'click' , '.stmenu-clear-settings' , function( e ){

          e.preventDefault();

          _isResetMenuItemSettings = true; 

          $( '#menu-management .stmenu-settings-toggle[data-stmenu-toggle="' + currentMenuItemId + '"]' ).trigger( 'click' );

          //$(".stmenu-menu-item-settings-form")[0].reset();

      });

      var _changeColorDebounce = null;

      $('.tf-gradient .stmenu-color').livequery(function () {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          $(this).wpColorPicker({
              change: function ( event, ui ) {

                  // update the preview, but throttle it to prevent fast loading
                  if ( _changeColorDebounce != null ) {
                      clearTimeout( _changeColorDebounce );
                      _changeColorDebounce = null;
                  }

                  var $this = $(this) ,
                      $container = $this.parents(".tf-gradient:first");

                  _changeColorDebounce = setTimeout( function() {

                      var params = {
                          'color'   : $container.find(".tf-back-start-color").val() ,
                          'end'     : $container.find(".tf-back-end-color").val()
                      };
                      // Update hidden save field
                      $container.find('.tf-for-saving').val(serialize(params));

                      $container.find('.tf-for-saving').trigger('change');


                  }, 300 );

              }
          });

      });

      if ( typeof $.fn.wpColorPicker !== 'undefined' ) {

          $('.tf-colorpicker').livequery(function () {

              if( ! $(this).data("starsOnceLoad") ){
                  $(this).data("starsOnceLoad" , true );
              }else{
                  return ;
              }

              $(this).wpColorPicker();
          });

      }

      var _loadIconManagerSets = function( ){

          window["stars_menu_la_icon_manager_library"] = new LAIconManager("library", "#stars_menu_la_icon_manager_library", window["la_icon_manager_collection"]);
          window["stars_menu_la_icon_manager_library"].showLibrary();

      };

      $('#stars_menu_la_icon_manager_library').livequery(function () {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          if( _.isUndefined( window["la_icon_manager_collection"] ) ) {

              $(document).on("iconManagerCollectionLoaded", function(){

                  _loadIconManagerSets( );

              });

          }else{

              _loadIconManagerSets( );

          }

      });

      var _loadIconManagerField = function( _fieldId , _selectId ){

          window["la_icon_manager_select_" + _selectId] = new LAIconManager(
              "0",
              "#" + _fieldId + "_icon_manager_library",
              window["la_icon_manager_collection"],
              "#" + _fieldId
          );
          window["la_icon_manager_select_" + _selectId].showIconSelect();

      };

      $('.tf-icon-library').livequery(function () {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          var _selectId = _.uniqueId( "stmenu_icon_field_" ),
              _fieldId = $(this).attr("id");

          if( _.isUndefined( window["la_icon_manager_collection"] ) ) {

              $(document).on("iconManagerCollectionLoaded", function(){

                  _loadIconManagerField( _fieldId , _selectId );

              });

          }else{

              _loadIconManagerField( _fieldId , _selectId );

          }

      });

      // AJAX Save Stars Nav Menu Meta Box Settings
      $(".stars-menu-save-settings-btn").on('click', function(e) {
          e.preventDefault();

          $(".stars_menu_meta_box .spinner").css('visibility', 'visible');

          var settings = JSON.stringify($( "[name^='stars_menu_meta']" ).serializeArray());

          wp.ajax.post('stars_menu_save_settings', {
              nonce             : $( '#menu-settings-column-nonce' ).val(),
              menu              : $('#menu').val(),
              stars_menu_meta   : settings
          }).done(function (data) {

              $(".stars_menu_meta_box .spinner").css('visibility', 'hidden');


          }).fail(function (response) {

              $(".stars_menu_meta_box .spinner").css('visibility', 'hidden');

              //_settingsLoading( false );

              //optionsWrapper.find(".notice.notice-error .stmenu-status-message").text( response.message );

              //optionsWrapper.find(".stmenu-error-massage").slideDown( 900 ).delay(3000).slideUp(900);

              //delete _AjaxProccesing[data.item_id];

          });
          
      });


      /**
       * Menu Designer
       */

      var _starsMenuDesigner = function(){

          var __menuLayoutModels = $.parseJSON( $(".starsmenu-design-drag-drop").val() ) || [],
              template = wp.template('menu-design-element-demo'),
              _changedAreas = [];

          //console.log( "_menuLayoutModels" , __menuLayoutModels );

          var __init = function() {

              __draggableInit();

              $(".stars-menu-elements-desktop input.stars-menu-element").livequery(function(){

                  if( ! $(this).data("starsOnceLoad") ){
                      $(this).data("starsOnceLoad" , true );
                  }else{
                      return ;
                  }

                  $(this).on("click", function () {//stars-menu-elements-sticky

                      var modelId = $(this).val();

                      if ($(this).prop("checked")) {

                          var __elementTpl = template({

                              elementId     : modelId,
                              elementTitle  : $(this).attr("title")

                          });

                          var elementDemo = $(__elementTpl).appendTo(".starsmenu-design-wrapper .starsmenu-sortable-right");

                          var model = {
                              id: modelId,
                              order: 0,
                              area: "right",
                              show_in_sticky: false
                          };

                          $(".stars-menu-elements-sticky input.stars-menu-element").filter(function(){
                              return $(this).val() == modelId;
                          }).prop("disabled" , false);

                          __addToModels(model);

                          __updateMobileElements( "add" , {
                              id     : modelId,
                              title  : $(this).attr("title")
                          } );

                      } else {

                          __removeFromModels(modelId);

                          __updateMobileElements( "remove" , modelId );

                          $(".starsmenu-design-wrapper").find( "[data-element='" + modelId + "']" ).remove();

                          $(".stars-menu-elements-sticky input.stars-menu-element").filter(function(){
                              return $(this).val() == modelId;
                          }).prop("checked" , false).prop("disabled" , true);

                      }

                      __updateOrders( $(".starsmenu-design-wrapper:not(.stars-menu-hamburger-design)").find( ".starsmenu-design-sortable" ) , $( ".stars-menu-hamburger-design" ) );

                      _changedAreas = [];

                  });

              });

              $(".stars-menu-elements-sticky input.stars-menu-element").livequery(function(){

                  if( ! $(this).data("starsOnceLoad") ){
                      $(this).data("starsOnceLoad" , true );
                  }else{
                      return ;
                  }

                  $(this).on("click", function () {

                      var modelId = $(this).val();

                      __updateAttr( modelId , 'show_in_sticky' , $(this).prop("checked") );

                  });

              });

          };

          var __draggableInit = function(){

              $(".starsmenu-design-wrapper:not(.stars-menu-hamburger-design)").find( ".starsmenu-design-sortable" ).sortable({
                  connectWith: ".connectedSortable,.connectedSortableNav" ,
                  helper: function(event , element ) {

                      var text = ( $(element ).find(".starsmenu-main-nav-title").length > 0  ) ? $(element ).find(".starsmenu-main-nav-title").text() : $(element ).text();

                      return $('<span class="starsmenu-drag-helper"/>').text( text );

                  },
                  //revert: true ,
                  //scrollSpeed: 40,
                  containment: $(".starsmenu-theme-panel-tab-designer") ,
                  cursorAt: { top: 25,left: 28 },
                  cursor: "move",
                  zIndex: 99999 ,
                  update : function( event, ui ){

                      __updateOrders( $(".starsmenu-design-wrapper:not(.stars-menu-hamburger-design)").find( ".starsmenu-design-sortable" ) , $( ".stars-menu-hamburger-design" ) );

                  }

              }).disableSelection();

              $( ".stars-menu-hamburger-design" ).find( ".starsmenu-design-sortable:not(.main-nav-drop-area)" ).sortable({
                  connectWith: ".connectedSortableHamburger" ,
                  cancel : ".starsmenu-elements" ,
                  containment: $(".starsmenu-theme-panel-tab-designer") ,
                  update : function( event, ui ){

                      __updateOrders( $( ".stars-menu-hamburger-design" ).find( ".starsmenu-design-sortable:not(.main-nav-drop-area)" ) , $(".starsmenu-design-wrapper:not(.stars-menu-hamburger-design)") );

                  }
              }).disableSelection();

          };

          var __updateAttr = function( modelId , attr , value ){

              __menuLayoutModels = _.map( __menuLayoutModels , function( model ){

                  if( modelId == model.id ){

                      model[attr] = value;

                  }

                  return model;
              });

              __updateModels( __menuLayoutModels );

          };

          var __getAttr = function( modelId , attr ){

              var model = _.findWhere( __menuLayoutModels , { id : modelId });

              if( !_.isUndefined( model ) ){

                  return model[attr];

              }else{

                  return null;

              }

          };

          var __updateOrders = function( $sortables , updateSortable ){

              $sortables.each(function(){

                  $(this).find(">li").each(function( indexEl , el ){

                      var currOrder = $(this).data("order"),
                          modelId = $(this).data("element") ,
                          currAreaName = __getAttr( modelId , "area" ),
                          newArea = $(this).parents('ul.starsmenu-design-sortable:first'),
                          newAreaName = newArea.data("name"),
                          equalElement = updateSortable.find("li[data-element='" + modelId + "']"),
                          newEqualElement;

                      if( currAreaName != newAreaName ){

                          var newAreaEqual = updateSortable.find("ul.starsmenu-design-sortable[data-name='" + newAreaName + "']");

                          if (indexEl == 0) {

                              newEqualElement = equalElement.prependTo( newAreaEqual );

                          } else {

                              newEqualElement = equalElement.insertAfter( newAreaEqual.find(">li").eq( (indexEl - 1) ) );

                          }

                          __updateAttr(modelId, 'area', newAreaName );

                          if (currOrder != indexEl) {

                              __updateAttr(modelId, 'order', indexEl);

                              $(this).data("order", indexEl);

                              newEqualElement.data("order", indexEl);

                          }

                      }else {

                          if (currOrder != indexEl) {

                              var currAreaEqual = updateSortable.find("ul.starsmenu-design-sortable[data-name='" + currAreaName + "']");

                              if (indexEl == 0) {

                                  newEqualElement = equalElement.prependTo( currAreaEqual );

                              } else {

                                  newEqualElement = equalElement.insertAfter( currAreaEqual.find(">li").eq( (indexEl - 1) ) );

                              }

                              $(this).data("order", indexEl);

                              __updateAttr(modelId, 'order', indexEl);

                              newEqualElement.data("order", indexEl);

                              /*if( $.inArray( area , _changedAreas ) == -1 ) {
                               _changedAreas.push( area );
                               }*/

                          }
                      }
                      
                  });

              });

          };


          var __updateModels = function(  ){

              $(".starsmenu-design-drag-drop").val( JSON.stringify( __menuLayoutModels ) );

              console.log( "_menuLayoutModels" , __menuLayoutModels );

          };


          var __addToModels = function( model ){

              __menuLayoutModels.push( model );

              __updateModels( __menuLayoutModels );

          };


          var __removeFromModels = function( id ){

              __menuLayoutModels = _.filter( __menuLayoutModels , function( model ){
                  return model.id != id;
              });

              __updateModels( __menuLayoutModels );

          };

          /**
           * Dynamic elements
           */

          var _maxKey = parseInt( $(".starsmenu-dynamic-elements-add .starsmenu-dynamic-element-max-key").val() );

          $(".starsmenu-dynamic-elements-add .button").on("click",function () {

              var $title = $(this).parent().find(".starsmenu-dynamic-element-title").val();

              var $menuId = $(this).parent().find(".starsmenu-dynamic-element-menu-ids").val();

              if( _.isEmpty( $menuId ) ){
                  return ;
              }

              var $phpClass = $(this).parent().find(".starsmenu-dynamic-element-class").val();

              var $baseId = $(this).parent().find(".starsmenu-dynamic-element-base-id").val();

              var $inputId = $(this).parent().find(".starsmenu-dynamic-element-input-id").val();

              var $themeId = $(this).parent().find(".starsmenu-theme-id").val();

              _maxKey += 1;

              var _id = $baseId + "-" + $themeId + "-" + _maxKey;

              var template = wp.template('menu-add-dynamic-element');

              var __elementTpl = template({
                  title         : $title ,
                  menuId        : $menuId ,
                  phpClass      : $phpClass ,
                  id            : _id ,
                  key           : _maxKey ,
                  inputId       : $inputId
              });

              $( __elementTpl ).appendTo( $(".starsmenu-dynamic-elements-list") );

              var inputTemplate = wp.template('menu-add-dynamic-element-to-designer');

              var __inputTplDesktop = inputTemplate({
                  title         : $title ,
                  id            : _id ,
                  type          : "desktop" ,
                  disabled      : ""
              });

              $( __inputTplDesktop ).appendTo( $(".stars-menu-elements-desktop .stars-menu-elements-checkboxes") );

              var __inputTplSticky = inputTemplate({
                  title         : $title ,
                  id            : _id ,
                  type          : "sticky" ,
                  disabled      : 'disabled="disabled"'
              });

              $( __inputTplSticky ).appendTo( $(".stars-menu-elements-sticky .stars-menu-elements-checkboxes") );

          });

          $(".starsmenu-dynamic-elements-list > .starsmenu-dynamic-element").livequery(function(){

              if( ! $(this).data("starsOnceLoad") ){
                  $(this).data("starsOnceLoad" , true );
              }else{
                  return ;
              }

              $(this).find(".remove-action").on("click" , function(){

                  var elementId = $(this).parent().find(".dynamic-element-id").val();

                  __removeFromModels(elementId);

                  __updateMobileElements( "remove" , elementId );

                  $(".starsmenu-design-wrapper").find( "[data-element='" + elementId + "']" ).remove();

                  $("." + elementId).each(function(){

                      $(this).parents("label:first").remove();

                  });

                  $(this).parent().remove();

              });

          });

          __init();

      };

      _starsMenuDesigner();


      /**
       * Mobile Designer
       */

      var __updateMobileModels = function(){

          var orders = [];

          $(".starsmenu-mobile-elements").find(">li").each(function(){
              orders.push( $(this).data("value") );
          });

          $(".starsmenu-mobile-design-drag-drop").val( orders.join(",") );

      };

      var __updateMobileElements = function( type , option ){

            if( type == "add" ){

                if( $.inArray( option.id , ['stars-logo' , 'stars-search'] ) > -1 ){
                    return ;
                }

                var li = '<li class="ui-sortable-handle" data-value="' + option.id +'"> <span>' + option.title +'</span><i class="smd smd-arrows"></i></li>';
                $( li ).appendTo( $(".starsmenu-mobile-elements") );

                //$(".starsmenu-mobile-design-drag-drop").sortable( "refresh" );
            }else{

                if( $.inArray( option , ['stars-logo' , 'stars-search'] ) > -1 ){
                    return ;
                }

                $(".starsmenu-mobile-elements").find( '[data-value="' + option + '"]' ).remove();

            }

            __updateMobileModels();

      };

      $(".starsmenu-mobile-elements").sortable({

          update : function( event, ui ){

              __updateMobileModels();

          }

      }).disableSelection();


      /**
       * Menu Integration Code
       */
      $("select#stars_menu_integrate_theme_location").on("change" , function(){

          var _location = $(this).val();

          $(".starsmenu-integration-code").hide();

          if( _location != "_default" ){
              $(".starsmenu-integration-code-" + _location).show();
          }

      });

      var _strasMenuSelectText = function( element ) {
          var doc = document
          //, text = element //doc.getElementById(element)
              , range, selection
              ;
          if (doc.body.createTextRange) { //ms
              range = doc.body.createTextRange();
              range.moveToElementText( element );
              range.select();
          } else if (window.getSelection) { //all others
              selection = window.getSelection();
              range = doc.createRange();
              range.selectNodeContents( element );
              selection.removeAllRanges();
              selection.addRange(range);
          }
      };

      //Highlight code
      $( '.starsmenu-highlight-code' ).on( 'click' , function(e){
          _strasMenuSelectText( $(this)[0] );
      });


      // validate inputs once the user moves to the next setting
      /*$( window ).scroll(function() {
          $('.theme_editor input:focus').blur();
      });

      $('.row-field-container[data-validation]').each(function() {
          var row = $(this);
          var validation = row.attr('data-validation');
          var error_message = label.siblings( '.mega-validation-message-' + label.attr('class') );
          var input = $('input', row);

          input.on('blur', function() {

              var value = $(this).val();

              if ( ( validation == 'int' && Math.floor(value) != value )
                  || ( validation == 'px' && ! ( value.substr(value.length - 2) == 'px' || value.substr(value.length - 2) == 'em' || value.substr(value.length - 2) == 'pt' || value.substr(value.length - 3) == 'rem' || value.substr(value.length - 1) == '%' ) && value != 0 )
                  || ( validation == 'float' && ! $.isNumeric(value) ) ) {
                  row.addClass('validation-error');

                  error_message.appendTo( row.find("td.second") );
                  error_message.show();

              } else {
                  row.removeClass('validation-error');
                  label.siblings( '.mega-validation-message-' + label.attr('class') ).hide();
              }

          });

      });*/


      /**
       * Modify Titan Framework Inline Js Via Livequery For Item panel settings
       */

      //enable Option
      $('.tf-enable .button-secondary').livequery(function(){

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          $(this).on("click" ,function() {

              $(this).parent().find('.button').toggleClass('button-primary button-secondary');

              var checkBox = $(this).parents('.tf-enable').find('input');

              if ( checkBox.is(':checked') ) {
                  checkBox.removeAttr('checked');
              } else {
                  checkBox.attr('checked', 'checked');
              }

              checkBox.trigger('change');

          });
      });

      //number option
      $('.tf-number input[type=number]').livequery(function(){

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          if ( ! $( this ).prev().is( '.number-slider' ) ) {
              return;
          }

          $( this ).prev().slider( {
              max: Number( $( this ).attr('max') ),
              min: Number( $( this ).attr('min') ),
              step: Number( $( this ).attr('step') ),
              value: Number( $( this ).val() ),
              animate: 'fast',
              change: function( event, ui ) {
                  var input = $( ui.handle ).parent().next();
                  if ( ui.value !== input.val() ) {
                      input.val( ui.value ).trigger( 'change' );
                  }
              },
              slide: function( event, ui ) {
                  var input = $( ui.handle ).parent().next();
                  if ( ui.value !== input.val() ) {
                      input.val( ui.value ).trigger( 'change' );
                  }
              }
          } ).disableSelection();


          $( this ).on( 'keyup', _.debounce( function() {
              if ( $( this ).prev().slider( 'value' ).toString() !== $( this ).val().toString() ) {
                  $( this ).prev().slider( 'value', $( this ).val() );
              }
          }, 500 ) );

      });

      //select Option
      if ( jQuery().select2 ) {

          $('select.tf-select, [class*="tf-select"] select').livequery(function() {

              if( ! $(this).data("starsOnceLoad") ){
                  $(this).data("starsOnceLoad" , true );
              }else{
                  return ;
              }
              /**
               * Select2
               * @see https://select2.github.io/
               */

              $(this).select2();

          });

      }

      //START =========== upload option

      $('.tf-upload .thumbnail').find('img').parent().addClass('has-value').find(':before').css({'opacity':'0'});

      var __tfUploadOptionCenterImage = function($this) {
          var _preview = $this.parents('.tf-upload').find('.thumbnail');
          $this.css({
              'marginTop': ( _preview.height() - $this.height() ) / 2,
              'marginLeft': ( _preview.width() - $this.width() ) / 2
          }).show();
      };


      // Remove the image when the remove link is clicked.
      $('.tf-upload i.remove').livequery(function() {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          $(this).on('click', function(event) {
              event.preventDefault();
              var _input = $(this).parents('.tf-upload').find('input');
              var _preview = $(this).parents('.tf-upload').find('div.thumbnail');

              _preview.removeClass('has-value').find('img').remove().end().find('i').remove();
              _input.val('').trigger('change');

              return false;
          });

      });


      // Open the upload media lightbox when the upload button is clicked.
      $('.tf-upload .thumbnail, .tf-upload img').livequery(function() {

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          if( $(this).prop("tagName").toLowerCase() == "img" ){

              // Calculate display offset of preview image on load.
              $(this).load(function() {
                  __tfUploadOptionCenterImage($(this));
              }).each(function(){
                  // Sometimes the load event might not trigger due to cache.
                  if(this.complete) {
                      $(this).trigger('load');
                  }
              });

          }

          $(this).on('click', function(event) {
              event.preventDefault();
              // If we have a smaller image, users can click on the thumbnail.
              if ( $(this).is('.thumbnail') ) {
                  if ( $(this).parents('.tf-upload').find('img').length != 0 ) {
                      $(this).parents('.tf-upload').find('img').trigger('click');
                      return true;
                  }
              }

              var _input = $(this).parents('.tf-upload').find('input');
              var _preview = $(this).parents('.tf-upload').find('div.thumbnail');
              var _remove = $(this).siblings('.tf-upload-image-remove');

              // Uploader frame properties.
              var frame = wp.media({
                  title: 'Select Image',
                  multiple: false,
                  library: { type: 'image' },
                  button : { text : 'Use image' }
              });

              // Get the url when done.
              frame.on('select', function() {
                  var selection = frame.state().get('selection');
                  selection.each(function(attachment) {

                      // if ( typeof attachment.attributes.sizes === 'undefined' ) {
                      // 	return;
                      // }

                      if ( _input.length > 0 ) {
                          _input.val(attachment.id);
                      }

                      if ( _preview.length > 0 ) {
                          // remove current preview
                          if ( _preview.find('img').length > 0 ) {
                              _preview.find('img').remove();
                          }
                          if ( _preview.find('i.remove').length > 0 ) {
                              _preview.find('i.remove').remove();
                          }

                          var url;

                          // Get the preview image.
                          if ( typeof attachment.attributes.sizes != 'undefined' ) {
                              var image = attachment.attributes.sizes.full;
                              if ( typeof attachment.attributes.sizes.thumbnail != 'undefined' ) {
                                  image = attachment.attributes.sizes.thumbnail;
                              }
                              url = image.url;
                              //var marginTop = ( _preview.height() - image.height ) / 2;
                              //var marginLeft = ( _preview.width() - image.width ) / 2;
                              //var filename = '';
                          } else {
                              url = attachment.attributes.url;
                              //var marginTop = ( _preview.height() - 64 ) / 2;
                              //var marginLeft = ( _preview.width() - 48 ) / 2;
                              //var filename = attachment.attributes.filename;
                          }

                          $("<img src='" + url + "'/>").appendTo(_preview);
                          $("<i class='dashicons dashicons-no-alt remove'></i>").prependTo(_preview);
                      }
                      // We need to trigger a change so that WP would detect that we changed the value.
                      // Or else the save button won't be enabled.
                      _input.trigger('change');

                      _remove.show();

                      $('.tf-upload .thumbnail').find('img').parent().addClass('has-value').find(':before').css({'opacity':'0'});
                  });
                  frame.off('select');
              });

              // Open the uploader.
              frame.open();

              return false;
          });

      });

      // code option
      $('.stars_ace_editor.ace_editor_wrapper').livequery(function(){

          if( ! $(this).data("starsOnceLoad") ){
              $(this).data("starsOnceLoad" , true );
          }else{
              return ;
          }

          var _editorId = $(this).data("editorId"),
              _height = $(this).data("height"),
              _theme = $(this).data("theme"),
              _lang = $(this).data("lang");

          var container = $('#' + _editorId);
          container.width( container.parent().width() ).height( _height );

          var editor = ace.edit( _editorId );
          container.css('width', 'auto');
          editor.setValue(container.siblings('textarea').val());
          editor.setTheme("ace/theme/" + _theme );
          editor.getSession().setMode('ace/mode/' + _lang );
          editor.setShowPrintMargin(false);
          editor.setHighlightActiveLine(false);
          editor.gotoLine(1);
          editor.session.setUseWorker(false);

          editor.getSession().on('change', function(e) {
              $(editor.container).siblings('textarea').val(editor.getValue());
          });

      });

      //END =========== upload option

      var __hideShowDepsTopLevelHover = function( $this ){

          var optionVal = $this.find('option:selected').val();

          if( optionVal.indexOf( 'starsmenuTopLevelHoverFill' ) === 0 ){

              $(".titan-framework-panel-wrap .options-container").addClass("starsmenu-top-level-hover-fill").removeClass("starsmenu-top-level-hover-border");

          }else if( optionVal.indexOf( 'starsmenuTopLevelHover' ) === 0 ){

              $(".titan-framework-panel-wrap .options-container").addClass("starsmenu-top-level-hover-border").removeClass("starsmenu-top-level-hover-fill");

          }

      };

      $("select[name='stars_menu_theme_top_level_hover'],select[name='stars_menu_theme_top_level_hover_default']").livequery(function(){

          $(this).on("change" , function(){

              __hideShowDepsTopLevelHover( $(this) );

          });

          __hideShowDepsTopLevelHover( $(this) );

      });


      /**
       * Custom Menu Location
       *
       * @param data
       * @private
       */

      window.__starsMenuAddCustomLocationSuccess = function( data ){

          $( data.content ).appendTo( $(".stars_menu_integration_code") );

          var nextId = parseInt( $("#stars_menu_next_menu_location_id").val() );

          $("#stars_menu_next_menu_location_id").val( nextId + 1 );

          $("select#stars_menu_integrate_theme_location").find("option").prop("selected" , false);

          $( data.option ).appendTo( $("select#stars_menu_integrate_theme_location") );

          $("select#stars_menu_integrate_theme_location").trigger( "change" );

      };

      window.__starsMenuAddCustomLocationData = function( data ){

          data.next_id = $("#stars_menu_next_menu_location_id").val();

          return data;

      };

      $(".stars_menu_remove_custom_location").livequery(function(){

          $(this).on("click" , function(){

              var locationId = $(this).data("location");

              $(this).parents(".starsmenu-integration-code:first").remove();

              //var currLoc = $("select#stars_menu_integrate_theme_location").val();

              //$("select#stars_menu_integrate_theme_location").find("option").prop("selected" , false);

              $("select#stars_menu_integrate_theme_location").find("option[value='" + locationId + "']").remove();

              $("select#stars_menu_integrate_theme_location").trigger( "change" );

          });

      });
      
      $(".stars_menu_title_custom_location").livequery(function(){

          $(this).on("keyup" , function(){

              var locationId = $(this).data("location");

              $("select#stars_menu_integrate_theme_location").find("option[value='" + locationId + "']").text( $(this).val() );

          });

      });

      /**
       * Custom Widget Area
       */
      $(".starsmenu-custom-widget-areas").find(".add-widget-area-btn").on("click" , function() {

          var template = wp.template('add-new-custom-widget-area');

          var __sidebarTpl = template({
              sidebar_id: _.uniqueId("stars_sidebar_id_")
          });

          $(__sidebarTpl).appendTo($(".starsmenu-custom-widget-areas > ul"));

      });

      $(".starsmenu-custom-widget-areas > ul > li .remove-action").livequery(function(){

          $(this).on("click",function(){

              $(this).parents("li:first").remove();

          });

      });

      /**
       * Activate && Deactivate License
       */
      $('.starsmenu-change-license-status').livequery(function(e){

          var $this = $(this);

          /*$(this).parents('form:first').submit(function(e) {

              //e.preventDefault();

              //alert( $this.data("actionType") );

              //$(this).find('[name="stars_menu_license_status"]').val( $this.data("actionType") );

              //$(this).submit();

          });*/

           $(this).on("click" , function(e) {

              //e.preventDefault();

              $(this).parents('form:first').find('[name="stars_menu_license_status"]').val( $(this).data("actionType") );

              //$(this).parents('form:first').submit();

          });

      });


      //_formTableSettings = $(".titan-framework-panel-wrap .form-table").detach();

  });

}( jQuery ));