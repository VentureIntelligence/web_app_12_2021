/*
Mioo LePopup v1.36
2011 Â© scripts.mioo.sk
*/
;(function ($) {
	"use strict";	// Strict mode

	var pluginName = 'LePopup',
	defaults = {
		modal	: true,

		autoShowDelay  	: false,
		autoCloseDelay 	: false,
		sessionInterval	: 0,	// If autoShowDelay is set, this will show popup according to interval in Hours (1 will show popup automatically every hour to each user) / Note: setting this to -1 is one time session (show only once to user)

		closeOnButton  	: true,
		closeOnEsc     	: true,
		closeOnClick : true,
		closeOnContentClick : false,

		animSpeed	: 300,
		skin     	: "default"
	},
	globals = {
		lePopup : {
			overlay : "<div id='lepopup-overlay' />",
			wrap : "<div id='lepopup-wrap' />",
			outer : "<div id='lepopup-outer' />",
			inner : "<div id='lepopup-inner' />",
			close : "<div id='lepopup-footer'><div id='lepopup-close' title='Close Popup'></div></div>"
		},
		loading : "loading",
		visible : "visible",
		cookieName : "lepopup_interval"
	};

	// The actual plugin constructor
	function LeMiooPlugin(element, options) {
		this.element = element;
		this.$element = $(this.element);
		this.options = $.extend({}, defaults, options);
		this._defaults = defaults;
		this._name = pluginName;

		this.$popup = null;
		this.$overlay = null;
		this.$outer = null;
		this.$close = null;
		this.$content = null;
		this.timeout = null;
		this.dynamic = null;
		this.ajax = null;
		this.prevSkin = this.options.skin;
		this.cookieName = globals.cookieName + "_" + this.$element.LeCompatibleAttr("id");
		this.storageSupport = false;

		this.init();
	}

	// Plugin private methods
	LeMiooPlugin.prototype = {

		// Plugin initialization
		init : function () {

			try { if(localStorage)this.storageSupport = true;}catch(er){console.log(er);}
			this.setPopup();
			this.setAutoShow();

			if (!this.$element.is("a[href*='.php']")) {
				this.dynamic = false;
				this.$element.css('display','none');

			}else{
				this.dynamic = true;

			}
			this.bindLinks();
		},

		setPopup : function () {
			this.$popup = $("#" + $(globals.lePopup.wrap).LeCompatibleAttr("id"));
			if (!this.$popup.length) {
				var popup = $(globals.lePopup.wrap);
				popup.append($($(globals.lePopup.outer).addClass(this.options.skin).append(globals.lePopup.inner + globals.lePopup.close)));
				this.$popup = $(popup);
				//this.$close = (typeof this.options.closeOnButton === "boolean") ? this.$popup.find("#lepopup-close") : this.$content.find(this.options.closeOnButton);
				var self = this;
				/*this.$close.bind("click", function(e){
					self.toggle(false);
					e.preventDefault();
					return false;
				});
				this.$popup.bind("close", function(){

				});*/

				$("body").append(this.$popup).append(globals.lePopup.overlay);
				if ( $.browser.msie  && $.browser.version <= 7) {
					this.$popup.find("#lepopup-outer").css({'max-width': '900px'});
				}
			} else {
				//this.$close = this.$popup.find("#lepopup-close");
			}
			this.$close = (typeof this.options.closeOnButton === "boolean") ? this.$popup.find("#lepopup-close") : (this.options.closeOnButton);
			this.$content = this.$popup.find("#lepopup-inner");
			this.$outer = this.$popup.find("#lepopup-outer");

			this.$overlay = $("#" + $(globals.lePopup.overlay).LeCompatibleAttr("id"));
			//this.bindClosures();
			this.setCloseButton();
			//console.log(this.getCloseButton());
		},

		getCloseButton : function () {
			if (typeof this.options.closeOnButton == "boolean" || this.options.closeOnButton == 1)
				return this.$popup.find("#lepopup-close");

			if (typeof this.options.closeOnButton === "string")
				return this.$content.find(this.options.closeOnButton);

			return false;
		},

		setCloseButton : function () {
			if (typeof this.options.closeOnButton === "string") {
				this.$popup.find("#lepopup-footer").hide();
			}
		},

		bindClosures : function () {
			var self = this,closebut;

			if (this.options.closeOnEsc) {
				$(document).bind("keyup",function(e){
					if (e.which === 27) {
						self.toggle(false);
					}
				});
			}

			if (this.options.closeOnClick) {
				this.$overlay.bind("click", function (e) {
					self.toggle(false);
				});
			}

			if (this.options.closeOnContentClick) {
				this.$outer.bind("click", function (e) {
					self.toggle(false);
				});
			}

			if (this.options.closeOnButton) {
				closebut = this.getCloseButton();
				closebut.bind("click", function (e) {
					self.toggle(false);
					e.preventDefault();
				});
			}


		},

		unbindClosures : function () {
			if (this.options.closeOnEsc) {
				$(document).unbind("keyup");
			}

			if (this.options.closeOnClick) {
				this.$overlay.unbind("click");
			}

			if (this.options.closeOnContentClick) {
				this.$outer.unbind("click");
			}

			if (this.options.closeOnButton) {
				var closebut = this.getCloseButton();
				closebut.unbind("click");
			}

			/*var elem = $(document).add(this.$overlay).add(this.$close);
			elem.unbind("click keyup");*/
			/*$(document).unbind("keyup");
			this.$overlay.add(this.$close).unbind("click");*/
		},

		bindLinks : function () {
			var self = this;
			this.$links = $("a[href=#" + this.$element.LeCompatibleAttr("id") + "]");
			if (this.dynamic){$.extend(this.$links, this.$element);}
			this.$links.bind("click", function (e) {
				self.toggle(true);
				e.preventDefault();
				return false;
			});
		},

		bindResize : function () {
			var self = this;

			$(window).bind("resize scroll", function () {
				self.setPosition();

				/*$(this).unbind('resize');
				setTimeout(function () {self.bindResize();$(window).trigger("resize");},400);*/
			});
			/*this.$popup.bind("resize", function(){
				$(window).trigger("resize");
			});*/
		},

		unbindResize : function () {
			$(window).unbind("resize");
		},

		setAutoShow : function () {
			if (this.options.autoShowDelay !== false) {

				var cookieValue = parseFloat(this.getCookie(this.cookieName), 10) || null,
					hourInt = parseFloat(this.options.sessionInterval, 10),
					self = this;
				//if (hourInt == -1) return false;
				if (cookieValue !== null && (hourInt === 0 || cookieValue !== hourInt)) {
					this.deleteCookie(this.cookieName);
					cookieValue = parseFloat(this.getCookie(this.cookieName), 10) || null;
				}

				if (cookieValue === null || hourInt == 0) {
					$(document).bind("ready", function () {
						if (self.options.autoShowDelay > 0) {
							self.timeout = setTimeout(function () {
								self.toggle(true);
								self.setAutoClose();

								if (hourInt)
									self.setCookie(self.cookieName, hourInt, hourInt);

							}, self.options.autoShowDelay);
						}else{
							self.toggle(true);
							self.setAutoClose();
						}

					});
				}
			}
		},

		setAutoClose : function () {
			var self = this;
			if (this.options.autoCloseDelay > 0) {
				/*if (this.options.allowCloseOnAutoShow == false){
					this.unbindClosures();
				}*/
				this.timeout = setTimeout(function() {
					self.toggle(false);
					/*if (self.options.allowCloseOnAutoShow == false){
						self.bindClosures();
					}*/
				}, (this.options.autoCloseDelay  + this.options.animSpeed));
			}
		},

		setCloseAllow : function () {
			var a = this.options.allowCloseOnAutoShow;
			if (a !== false) {
				this.unbindClosures();
				if (a === true) {
					setTimeout(function() {
						self.bindClosures();
					}, this.options.closeDelay);

				}else if (typeof a == "number"){
					setTimeout(function() {
						self.bindClosures();
					}, a);
				}

			}
		},

		toggle : function (show, el) {
			var self = this,
			url;
			/*
			if(!this.$popup.is(":visible"))
				this.unbindResize();
			*/
			clearTimeout(this.timeout);

			if (this.dynamic && typeof el === "undefined" && show) {
				url = this.$element.attr("href");
				this.$outer.addClass(globals.loading);
				this.ajax =
					$.get(url)
						.done( function(data) {
							self.toggle(true, $(data));
							self.ajax = null;
						}).always( function() {
							self.$outer.removeClass(globals.loading);
							return;
						});
				this.doToggle(show);

			}else{
				if(typeof el === "undefined") el = this.$element.clone().css('display','block');

				if (show /*&& (this.$content.children().get(0) !== el.get(0))*/ ) {
					this.$content.empty().append(el);
				}
				this.doToggle(show);
			}

		},

		doToggle : function (show) {
			this.toggleOverlay(show);

			if (show) {
				this.bindClosures();
			}else{
				this.unbindClosures();
			}

			this.setToggle(this.$popup, show);

			this.$popup.css(this.getPosition());
		},

		toggleOverlay : function (show) {
			if (this.options.modal) {
				this.setToggle(this.$overlay, show);
			}
		},

		setPosition : function () {//console.log($(window).scrollTop()-this.$popup.offset().top < 0);
			if (this.$popup.is(":visible") && (/* this.$popup.outerHeight() < $(window).height() ||*/ ( $(window).scrollTop()-this.$popup.offset().top < 0 ) || ($(window).scrollTop()+$(window).height())-(this.$popup.outerHeight()+this.$popup.offset().top) > 0 ) ) {
				this.$popup.stop(true,false).animate(this.getPosition(), this.options.animSpeed);
			}
		},

		getPosition : function () {
			var pos = {
				left : ($(window).width()/2) - (this.$popup.outerWidth()/2) + $(document).scrollLeft(),
				top : ($(window).height()/2) - (this.$popup.outerHeight()/2) + $(document).scrollTop()
			};
			return pos;
		},

		setToggle : function (ele, show) {
			if(typeof ele === "undefined" || ele.length === 0) return false;
			var self = this;
			ele.clearQueue();
			if (show) {
				if (!ele.is(":visible")) {
					//if (ele.is(this.$popup)) {
						this.setSkin();
						this.setCloseBut();
					//}
					ele.stop().fadeIn(this.options.animSpeed, function(){
						//if (ele.is(this.$popup)) {
							self.bindResize();
						//}
					});
				}
			} else {
				if (ele.is(":visible"))
					//if (ele.is(this.$popup)) {
						this.unbindResize();
					//}
					ele.stop().fadeOut(this.options.animSpeed, function(){
						//if (ele.is(this.$popup)) {
							self.emptyContent();
							self.setCloseBut();
						//}

					});
			}
		},

		emptyContent : function () {
			if(this.ajax) {
				this.ajax.abort();
				return false;
			}

			this.$content.empty();
		},

		setSkin : function () {
			this.$outer.removeClass(this.prevSkin).addClass(this.options.skin);
			this.prevSkin = this.options.skin;
		},

		setCloseBut : function () {
			var c = this.getCloseButton();
			if(typeof this.options.closeOnButton === "boolean"){
				this.$popup.find("#lepopup-footer").toggle(this.options.closeOnButton);
			}else if(typeof this.options.closeOnButton === "string"){
				this.$popup.find("#lepopup-footer").toggle(false);
				c.show();
			}
		},

		getCookie : function (check_name) {
			var a_all_cookies = document.cookie.split( ';' );
			var a_temp_cookie = '';
			var cookie_name = '';
			var cookie_value = '';
			var b_cookie_found = false;
			var i = '';
			/*
			if (this.options.hourInterval == -1)
				return -1;*/

			if (this.storageSupport) {
				var storage = new Date(localStorage.getItem(check_name));
				if (storage < new Date()) {
					//this.deleteCookie(check_name);
					return null;
				}else{
					return localStorage.getItem(check_name + '_interval');
				}
			}

			for ( i = 0; i < a_all_cookies.length; i++ )
			{
				a_temp_cookie = a_all_cookies[i].split( '=' );

				cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');
				if ( cookie_name == check_name )
				{
					b_cookie_found = true;
					if ( a_temp_cookie.length > 1 )
					{
						cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
					}
					return cookie_value;
					break;
				}
				a_temp_cookie = null;
				cookie_name = '';
			}
			if ( !b_cookie_found )
			{
				return null;
			}
		},

		setCookie : function (name, value, expires, path, domain, secure) {


			// set time, it's in milliseconds
			var today = new Date();
			today.setTime( today.getTime() );
			if ( expires )
			{
				expires = expires * 1000 * 60 * 60;
			}

			var expires_date = new Date( today.getTime() + (expires) );
			if (this.options.sessionInterval == -1) {
				expires_date = new Date( today.getTime() + (-value * 99999999990) );
			}

			if (this.storageSupport) {

				localStorage.setItem(name, expires_date.toGMTString() );
				localStorage.setItem(name + '_interval', value );
				return true;
			}

			document.cookie = name + "=" +escape( value ) +
				( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + //expires.toGMTString()
				( ( path ) ? ";path=" + path : "" ) +
				( ( domain ) ? ";domain=" + domain : "" ) +
				( ( secure ) ? ";secure" : "" );
		},

		// this deletes the cookie when called
		deleteCookie : function (name, path, domain) {
			if (this.storageSupport) {
				localStorage.removeItem(name);
				localStorage.removeItem(name + '_interval');
				return true;
			}

			if ( this.getCookie( name ) ) document.cookie = name + "=" +
					( ( path ) ? ";path=" + path : "") +
					( ( domain ) ? ";domain=" + domain : "" ) +
					";expires=Thu, 01-Jan-1970 00:00:01 GMT";
		},

		method : function () {}

	};

	// jQuery external plugin definition
	$.fn[pluginName] = function (options) {
		return this.each(function () {
			if (!$.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new LeMiooPlugin(this, options));
			}
		});
	};

	$.fn.LeCompatibleAttr = function () {
		try {
			return this.prop("id");
		} catch (err) {
			return this.attr("id");
		}
	};

})(jQuery);
