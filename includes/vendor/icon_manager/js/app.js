//parsaatef
String.prototype.replace_all = function(e, n) {
	return this.replace(new RegExp(e, "g"), n)
}, String.prototype.capitalize = function() {
	return this.charAt(0).toUpperCase() + this.slice(1)
}, String.prototype.endsWith = function(e) {
	return -1 !== this.indexOf(e, this.length - e.length)
}, Array.prototype.last || (Array.prototype.last = function() {
	return this[this.length - 1]
});

var AwesomeAjax = function(e) {
	"use strict";
	var a = jQuery,
		r = this,
		e = e + "_";
	r.result = {}, r.load_model = function(a, n, s, o) {
		return r.ajax({
			action: e + "get_" + a,
			data: {
				id: n
			},
			success_handler: s,
			error_handler: o
		})
	}, r.publish_model = function(a, n, s) {
		return r.ajax({
			action: e + "publish_model",
			data: {
				id: a
			},
			success_handler: n,
			error_handler: s
		})
	}, r.delete_model = function(a, n) {
		return r.ajax({
			action: e + "delete_model",
			data: {
				id: a,
				model_name: n
			},
			success_handler: function(e) {
				return e
			}
		})
	}, r.ajax = function(r) {
		return a.ajax({
			url: window[e + "localize"].ajaxurl,
			type: "post",
			data: {
				action: r.action,
				security: window[e + "localize"].ajax_nonce,
				data: r.data || {}
			},
			success: function(e) {
				var a = wpAjax.parseAjaxResponse(e);
				if (a.errors) {
					var n = a.responses[0].errors;
					r.success_error_handler(n)
				} else {
					var s = JSON.parse(a.responses[0].data);
					r.success_handler(s)
				}
			},
			error: function(e) {
				r.error_handler(e)
			}
		})
	}
};

function LAIconManager(id, el, collection, field) {
	this.ajax = new AwesomeAjax('laim');

	this.model = new Backbone.Model({
		id: id,
		el: el,
		field: field || '',
		custom_field: '',
		set: '',
		icon: '',
		collection: collection || {}
	});

	this.bindSearch();
	this.bindUpload();
	this.bindDelete();
}
(function ($) {
	LAIconManager.prototype.bindField = function () {
		var self = this;
		var dfd = $.Deferred();

		var handler = function () {
			if (self.model.get('field') === '') {
				var set = '';
				var icon = '';
			} else {
				var set = $(self.model.get('field')).val().split('_####_')[0];
				var icon = $(self.model.get('field')).val().split('_####_')[1];
			}

			self.model.set('set', self.sanitize(set));
			self.model.set('icon', icon);

			setTimeout(function () {
				$(self.model.get('el')).trigger('iconManagerIconChanged');
			}, 14);

			dfd.resolve();
		}

		handler();
		$(document).off('change', self.model.get('field'));
		$(document).on('change', self.model.get('field'), handler);

		return dfd.promise();
	}

	LAIconManager.prototype.bindCustomField = function () {
		var self = this;
		var button = '[data-action="accept-rating-custom-icon-' + this.model.get('id') + '"]';

		var handler = function (e) {
			e.preventDefault();

			var set = '####';
			var icon = $(self.model.get('custom_field')).val().trim();

			if (icon === '') {
				return;
			}

			self.model.set('set', self.sanitize(set));
			self.model.set('icon', icon);

			$(self.model.get('field')).val(set + '_####_' + icon).trigger('change');
			self.clearSelect();
		}

		$(document).off('click', button);
		$(document).on('click', button, handler);
	}

	LAIconManager.prototype.clearSelect = function () {
		var $manager = $(self.model.get('el'));
		$('li', $manager).attr('class', '');
	}

	LAIconManager.prototype.bindSelect = function () {
		var self = this;
		var dfd = $.Deferred();

		$(document).off('.la_icon_manager', self.model.get('el') + ' [data-action="change-icon"]');
		$(document).on('click.la_icon_manager', self.model.get('el') + ' [data-action="change-icon"]', function (e) {
			var $manager = $(self.model.get('el'));
			var set = $(this).parent('ul').data('set');
			var icon = $(this).data('icon');

			self.model.set('set', self.sanitize(set));
			self.model.set('icon', icon);

			$(self.model.get('field')).val(set + '_####_' + icon).trigger('change');
			$(self.model.get('custom_field')).val('');
			$('li', $manager).attr('class', '');
			$(this).addClass('active');
		});

		dfd.resolve();
		return dfd.promise();
	}

	LAIconManager.prototype.bindSearch = function () {
		$(document).off('.la_icon_manager', "[name='icon_manager_search']");
		$(document).on("input.la_icon_manager", "[name='icon_manager_search']", function (e) {
			var manager = $(this).parents(".la-icon-manager").get(0);
			var sets = $(".icon-set", manager);
			var query = $(this).val().trim();
			$.each(sets, function (index, item) {
				var icons = $("li", item);
				var count = 0;
				icons.hide();
				$.each(icons, function (index, item) {
					var aliases = $(item).data("tags") || "";
					if (aliases.indexOf(query) !== -1) {
						$(item).show();
						count++;
					}
				});
				if (count === 0) {
					$(item).hide();
				}
				if (query.length === 0) {
					$(item).show();
					icons.show();
				}
			});
		});
	}

	LAIconManager.prototype.bindUpload = function () {
		var self = this;

		$(document).off('.la_icon_manager', '[data-action="icon_manager_upload"]');
		$(document).on('click.la_icon_manager', '[data-action="icon_manager_upload"]', function (e) {
			e.preventDefault();
			var $notify = $('#la_icon_manager_notify'),
				$spinner = $('.upload_icons .spinner');

			if (typeof file_frame !== 'undefined') {
				file_frame.open();
				return;
			}

			file_frame = wp.media({
				frame: 'post',
				button: {
					text: "Load icons from Zip"
				},
				class: "media-frame",
				multiple: false,
				library: {
					type: 'application/octet-stream, application/zip'
				},
			});

			// handle image insert on media window submit
			file_frame.on('insert', function () {
				var json = file_frame.state().get('selection').first().toJSON();
				$spinner.css('visibility', 'visible');
				$notify.html('');

				if (0 > $.trim(json.url.length)) {
					return;
				}

				self.ajax.ajax({
					action: 'laim_upload_icons',
					data: {
						url: json.url
					},
					success_handler: function (data) {
						$spinner.css('visibility', 'hidden');
						$notify.html('Icons uploaded successfully! Reloading the page... ').show();
						setTimeout(function () {
							window.location.reload();
						}, 2000);
					},
					success_error_handler: function (errors) {
						var html = '';
						$.each(errors, function (index, value) {
							html += '<p>';
							html += value.message;
							html += '</p>';
						});
						$spinner.css('visibility', 'hidden');
						$notify.html(html).show();
					},
					error_handler: function (errors) {
						$spinner.css('visibility', 'hidden');
						$notify.html(errors).show();
					}
				});

				file_frame.close();
			});

			file_frame.open();
			return false;
		});
	}

	LAIconManager.prototype.bindDelete = function () {
		var self = this;

		$(document).off('.la_icon_manager', '[data-action="icon_manager_delete"]:not(.bound)');
		$(document).on('click.la_icon_manager', '[data-action="icon_manager_delete"]:not(.bound)', function (e) {
			e.preventDefault();

			var font = $(this).data('font'),
				$notify = $('#la_icon_manager_notify'),
				$spinner = $('.spinner', $(this).parent('h4'));

			$spinner.css('visibility', 'visible');
			$notify.html('');

			self.ajax.ajax({
				action: 'laim_delete_icons',
				data: {
					font: font
				},
				success_handler: function (data) {
					$spinner.css('visibility', 'hidden');
					$notify.html('Icon pack deleted!').show();
					$('.icon-set-' + font.toLowerCase().replace_all(' ', '_'), $(self.model.get('el'))).hide();
					if (window['la_icon_manager_collection'].contains(font)) {
						var model = window['la_icon_manager_collection'].findWhere({'name': font});
						window['la_icon_manager_collection'].remove(model);
					}

					setTimeout(function () {
						$notify.html('');
					}, 2000);
				},
				success_error_handler: function (errors) {
					var html = '';
					$.each(errors, function (index, value) {
						html += '<p>';
						html += value.message;
						html += '</p>';
					});
					$spinner.css('visibility', 'hidden');
					$notify.html(html).show();
				},
				error_handler: function (errors) {
					$spinner.css('visibility', 'hidden');
					$notify.html(errors).show();
				}
			});
		});
	}

	LAIconManager.prototype.bindPreview = function () {
		var self = this;

		$(document).off('.la_icon_manager', self.model.get('el'));
		$(document).on('iconManagerIconChanged.la_icon_manager', self.model.get('el'), function () {
			var $preview = $('.preview', $(self.model.get('el')));
			var icon;
			if (self.getSet() === '####') {
				icon = '<i class="custom" style="background-image:url(' + self.model.get('icon') + ')"></i>';
			} else {
				icon = '<i class="la' + md5(self.getSet()) + '-' + self.model.get('icon') + '"></i>';
			}
			$preview.html(icon)
		});
	}

	LAIconManager.prototype.getCollection = function (filter) {
		var self = this;
		var collection = self.model.get('collection') ? self.model.get('collection').clone() : [];

		if (filter instanceof Array && filter.length > 0) {
			collection.reset();
			filter.forEach(function (item) {
				var model = self.model.get('collection').findWhere({name: item});
				collection.add(model);
			});
		}

		return collection.toJSON();
	}

	LAIconManager.prototype.sanitize = function (val) {
		return val ? val.replace(/\+/gi, ' ').trim() : val;
	}

	LAIconManager.prototype.getSet = function () {
		return this.model.get('set') ? this.sanitize(this.model.get('set')) : '';
	}

	LAIconManager.prototype.getIcon = function () {
		return this.model.get('icon') ? this.model.get('icon') : '';
	}

	LAIconManager.prototype.showIconSelect = function (filter, docs_url) {
		docs_url = typeof filter !== 'undefined' ? docs_url : '';
		filter = typeof filter !== 'undefined' ? filter : [];

		var self = this;
		self.model.set('custom_field', '[name="la_icon_manager_' + this.model.get('id') + '_custom"]');
		var collection = this.getCollection(filter);

		self.bindField()
		self.bindCustomField()

		var view = new LAIconManagerView({
			template: la_icon_manager_templates['select'],
			el: this.model.get('el'),
			model: this.model,
			collection: collection,
			docs_url: docs_url,
			afterRender: function () {
				self.bindSelect().then(function () {
					self.bindPreview();
				});
			}
		});
		view.render();

		return this;
	}

	LAIconManager.prototype.showLibrary = function (filter) {
		filter = typeof filter !== 'undefined' ? filter : [];
		var collection = this.getCollection(filter);
		var view = new LAIconManagerView({
			template: la_icon_manager_templates['library'],
			el: this.model.get('el'),
			model: this.model,
			collection: collection,
		});
		view.render();

		return this;
	}
})(jQuery);