(function($) {
	"use strict";

       var Shortcodes = vc.shortcodes;
        window.VcRowView = vc.shortcode_view.extend({
            change_columns_layout: !1,
            events: {
                'click > .vc_controls [data-vc-control="delete"]': "deleteShortcode",
                "click > .vc_controls .set_columns": "setColumns",
                'click > .vc_controls [data-vc-control="add"]': "addElement",
                'click > .vc_controls [data-vc-control="edit"]': "editElement",
                'click > .vc_controls [data-vc-control="clone"]': "clone",
                'click > .vc_controls [data-vc-control="move"]': "moveElement",
                'click > .vc_controls [data-vc-control="toggle"]': "toggleElement",
                "click > .wpb_element_wrapper .vc_controls": "openClosedRow"
            },
            convertRowColumns: function(layout) {
                var layout_split = layout.toString().split(/_/),
                    columns = Shortcodes.where({
                        parent_id: this.model.id
                    }),
                    new_columns = [],
                    new_layout = [],
                    new_width = "";
                return _.each(layout_split, function(value, i) {
                    var new_column_params, new_column, column_data = _.map(value.toString().split(""), function(v, i) {
                        return parseInt(v, 10)
                    });
                    new_width = 3 < column_data.length ? column_data[0] + "" + column_data[1] + "/" + column_data[2] + column_data[3] : 2 < column_data.length ? column_data[0] + "/" + column_data[1] + column_data[2] : column_data[0] + "/" + column_data[1], new_layout.push(new_width), new_column_params = _.extend(_.isUndefined(columns[i]) ? {} : columns[i].get("params"), {
                        width: new_width
                    }), "undefined" != typeof window.vc_settings_presets[this.getChildTag()] && (new_column_params = _.extend(new_column_params, window.vc_settings_presets[this.getChildTag()])), vc.storage.lock(), new_column = Shortcodes.create({
                        shortcode: this.getChildTag(),
                        params: new_column_params,
                        parent_id: this.model.id
                    }), _.isObject(columns[i]) && _.each(Shortcodes.where({
                        parent_id: columns[i].id
                    }), function(shortcode) {
                        vc.storage.lock(), shortcode.save({
                            parent_id: new_column.id
                        }), vc.storage.lock(), shortcode.trigger("change_parent_id")
                    }), new_columns.push(new_column)
                }, this), layout_split.length < columns.length && _.each(columns.slice(layout_split.length), function(column) {
                    _.each(Shortcodes.where({
                        parent_id: column.id
                    }), function(shortcode) {
                        vc.storage.lock(), shortcode.save({
                            parent_id: _.last(new_columns).id
                        }), vc.storage.lock(), shortcode.trigger("change_parent_id")
                    })
                }), _.each(columns, function(shortcode) {
                    vc.storage.lock(), shortcode.destroy()
                }, this), this.model.save(), this.setActiveLayoutButton("" + layout), new_layout
            },
            changeShortcodeParams: function(model) {
                window.VcRowView.__super__.changeShortcodeParams.call(this, model), this.buildDesignHelpers()
            },
            designHelpersSelector: "> .vc_controls .column_toggle",
            buildDesignHelpers: function() {
                var css, $elementToPrepend, image, color, rowId, matches, row_show_on, color;
                css = this.model.getParam("css"), $elementToPrepend = this.$el.find(this.designHelpersSelector), this.$el.find("> .vc_controls .vc_row_color").remove(), this.$el.find("> .vc_controls .vc_row_image").remove(), matches = css.match(/background\-image:\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (image = matches[1]), matches = css.match(/background\-color:\s*([^\s\;]+)\b/), matches && !_.isUndefined(matches[1]) && (color = matches[1]), matches = css.match(/background:\s*([^\s]+)\b\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (color = matches[1], image = matches[2]), rowId = this.model.getParam("el_id"), this.$el.find("> .vc_controls .vc_row-hash-id").remove(), _.isEmpty(rowId) || $('<span class="vc_row-hash-id"></span>').text("#" + rowId).insertAfter($elementToPrepend), image && $('<span class="vc_row_image" style="background-image: url(' + image + ');" title="' + window.i18nLocale.row_background_image + '"></span>').insertAfter($elementToPrepend), color && $('<span class="vc_row_color" style="background-color: ' + color + '" title="' + window.i18nLocale.row_background_color + '"></span>').insertAfter($elementToPrepend),this.$el.find('> .vc_controls .vc_row_screens').remove(); 
				row_show_on = this.model.getParam('row_show_on');
				  if(row_show_on) {		  
					var hide_on_screen = ' '+ row_show_on.replace(/,/gi, ' ');
				  } else {
					var hide_on_screen = '';
				  }
				  $('<span class="vc_row_screens'+ hide_on_screen +'"><i class="device-icon device-screen"></i><i class="device-icon device-tablet2"></i><i class="device-icon device-tablet"></i><i class="device-icon device-mobile2"></i><i class="device-icon device-mobile"></i></span>').insertAfter($elementToPrepend);
				  // End preview
				  this.$el.find('> .vc_controls .vc_row_color').remove();
				  color = this.model.getParam('bg_color');
				  if(color) {
					$('<span class="vc_row_color" style="background-color: ' + color + '" title="' + i18nLocale.row_background_color + '"></span>')
					  .insertAfter($elementToPrepend);
				  }
            },
            addElement: function(e) {
                e && e.preventDefault(), Shortcodes.create({
                    shortcode: this.getChildTag(),
                    params: {},
                    parent_id: this.model.id
                }), this.setActiveLayoutButton(), this.$el.removeClass("vc_collapsed-row")
            },
            getChildTag: function() {
                return "vc_row_inner" === this.model.get("shortcode") ? "vc_column_inner" : "vc_column"
            },
            sortingSelector: "> [data-element_type=vc_column], > [data-element_type=vc_column_inner]",
            sortingSelectorCancel: ".vc-non-draggable-column",
            setSorting: function() {
                var that = this;
                1 < this.$content.find(this.sortingSelector).length ? this.$content.removeClass("wpb-not-sortable").sortable({
                    forcePlaceholderSize: !0,
                    placeholder: "widgets-placeholder-column",
                    tolerance: "pointer",
                    cursor: "move",
                    items: this.sortingSelector,
                    cancel: this.sortingSelectorCancel,
                    distance: .5,
                    start: function(event, ui) {
                        $("#visual_composer_content").addClass("vc_sorting-started"), ui.placeholder.width(ui.item.width())
                    },
                    stop: function(event, ui) {
                        $("#visual_composer_content").removeClass("vc_sorting-started")
                    },
                    update: function() {
                        var $columns = $(that.sortingSelector, that.$content);
                        $columns.each(function() {
                            var model = $(this).data("model"),
                                index = $(this).index();
                            model.set("order", index), $columns.length - 1 > index && vc.storage.lock(), model.save()
                        })
                    },
                    over: function(event, ui) {
                        ui.placeholder.css({
                            maxWidth: ui.placeholder.parent().width()
                        }), ui.placeholder.removeClass("vc_hidden-placeholder")
                    },
                    beforeStop: function(event, ui) {}
                }) : (this.$content.hasClass("ui-sortable") && this.$content.sortable("destroy"), this.$content.addClass("wpb-not-sortable"))
            },
            validateCellsList: function(cells) {
                var b, return_cells = [],
                    split = cells.replace(/\s/g, "").split("+"),
                    sum = _.reduce(_.map(split, function(c) {
                        if (c.match(/^(vc_)?span\d?$/)) {
                            var converted_c = vc_convert_column_span_size(c);
                            return !1 === converted_c ? 1e3 : (b = converted_c.split(/\//), return_cells.push(b[0] + "" + b[1]), 12 * parseInt(b[0], 10) / parseInt(b[1], 10))
                        }
                        return c.match(/^[1-9]|1[0-2]\/[1-9]|1[0-2]$/) ? (b = c.split(/\//), return_cells.push(b[0] + "" + b[1]), 12 * parseInt(b[0], 10) / parseInt(b[1], 10)) : 1e4
                    }), function(num, memo) {
                        return memo += num
                    }, 0);
                return 12 !== sum ? !1 : return_cells.join("_")
            },
            setActiveLayoutButton: function(column_layout) {
                column_layout || (column_layout = _.map(vc.shortcodes.where({
                    parent_id: this.model.get("id")
                }), function(model) {
                    var width = model.getParam("width");
                    return width ? width.replace(/\//, "") : "11"
                }).join("_")), this.$el.find("> .vc_controls .vc_active").removeClass("vc_active");
                var $button = this.$el.find('> .vc_ [data-cells-mask="' + vc_get_column_mask(column_layout) + '"] [data-cells="' + column_layout + '"], > .vc_controls [data-cells-mask="' + vc_get_column_mask(column_layout) + '"][data-cells="' + column_layout + '"]');
                $button.length ? $button.addClass("vc_active") : this.$el.find("> .vc_controls [data-cells-mask=custom]").addClass("vc_active")
            },
            layoutEditor: function() {
                return _.isUndefined(vc.row_layout_editor) && (vc.row_layout_editor = new vc.RowLayoutUIPanelBackendEditor({
                    el: $("#vc_ui-panel-row-layout")
                })), vc.row_layout_editor
            },
            setColumns: function(e) {
                _.isObject(e) && e.preventDefault();
                var $button = $(e.currentTarget);
                if ("custom" === $button.data("cells")) this.layoutEditor().render(this.model).show();
                else {
                    if (vc.is_mobile) {
                        var $parent = $button.parent();
                        $parent.hasClass("vc_visible") || ($parent.addClass("vc_visible"), $(document).off("click.vcRowColumnsControl").on("click.vcRowColumnsControl", function(e) {
                            $parent.removeClass("vc_visible")
                        }))
                    }
                    $button.is(".vc_active") || (this.change_columns_layout = !0, _.defer(function(view, cells) {
                        view.convertRowColumns(cells)
                    }, this, $button.data("cells")))
                }
                this.$el.removeClass("vc_collapsed-row")
            },
            sizeRows: function() {
                var max_height = 45;
                $("> .wpb_vc_column, > .wpb_vc_column_inner", this.$content).each(function() {
                    var content_height = $(this).find("> .wpb_element_wrapper > .wpb_column_container").css({
                        minHeight: 0
                    }).height();
                    content_height > max_height && (max_height = content_height)
                }).each(function() {
                    $(this).find("> .wpb_element_wrapper > .wpb_column_container").css({
                        minHeight: max_height
                    })
                })
            },
            ready: function(e) {
                return window.VcRowView.__super__.ready.call(this, e), this
            },
            checkIsEmpty: function() {
                window.VcRowView.__super__.checkIsEmpty.call(this), this.setSorting()
            },
            changedContent: function(view) {
                return this.change_columns_layout ? this : void this.setActiveLayoutButton()
            },
            moveElement: function(e) {
                e.preventDefault()
            },
            toggleElement: function(e) {
                e && e.preventDefault(), this.$el.toggleClass("vc_collapsed-row")
            },
            openClosedRow: function(e) {
                this.$el.removeClass("vc_collapsed-row")
            },
            remove: function() {
                this.$content && this.$content.data("uiSortable") && this.$content.sortable("destroy"), this.$content && this.$content.data("uiDroppable") && this.$content.droppable("destroy"), delete vc.app.views[this.model.id], window.VcRowView.__super__.remove.call(this)
            }
        });	

	
	window.VcIconView = vc.shortcode_view.extend({
	   changeShortcodeParams:function (model) {
		 var params = model.get('params');
		 window.VcIconView.__super__.changeShortcodeParams.call(this, model);
		 if (_.isObject(params) && _.isString(params.name)) {
			if(_.isString(params.icon_color)){
					var icon_style = ' color:'+ params.icon_color;
			} else {
					var icon_style = '';
			}
			
			this.$el.find('.wpb_element_wrapper').html('<h4 class="wpb_element_title"><span class="vc_element-icon icon-wpb-vc_icons"></span></h4><i style="font-size:32px;'+ icon_style +'" class="fa ' + params.name + '"></i>');
		 }
	   }
	});	
	
	window.VcServiceView = vc.shortcode_view.extend({
	   changeShortcodeParams:function (model) {
		 var params = model.get('params');
		 window.VcServiceView.__super__.changeShortcodeParams.call(this, model);
		 if (_.isObject(params) && _.isString(params.icon_name)) {
			if(_.isString(params.icon_color)){
					var icon_style = ' style="color:'+ params.icon_color + ';"';
			} else {
					var icon_style = '';
			}
			
			this.$el.find('.wpb_element_wrapper .icon_name').html('<i'+ icon_style +' class="service-icon fa ' + params.icon_name + '"></i>');
		 }
	   }
	});	

    window.VcButtonView = vc.shortcode_view.extend({events:function () {
        return _.extend({'click button':'buttonClick'
        }, window.VcToggleView.__super__.events);
    },
        buttonClick:function (e) {
            e.preventDefault();
        },
        changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcButtonView.__super__.changeShortcodeParams.call(this, model);
            if (_.isObject(params)) {
                var el_class = params.color + ' ' + params.size + ' ' + params.button_style;
                this.$el.find('.wpb_element_wrapper').removeClass(el_class);
                this.$el.find('button.title').attr({ "class":"title textfield wpb_button " + el_class });
				
				if (params.icon_name) {
                    this.$el.find('button.title').append('<i class="fa '+params.icon_name+'"></i>');
                } else {
                    this.$el.find('button.title i.fa').remove();
                }

            }
        }
    });
	
	window.VcTeamView = vc.shortcode_view.extend({
        changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcTeamView.__super__.changeShortcodeParams.call(this, model);
			if (params.img_url) {
				this.$el.find('.wpb_element_wrapper .img_url').show();
			 } else {
				this.$el.find('.wpb_element_wrapper .img_url').hide();
			 }
        }
    });
	
	window.VcListItemView = vc.shortcode_view.extend({
	   changeShortcodeParams:function (model) {
			var params = model.get('params');
			window.VcListItemView.__super__.changeShortcodeParams.call(this, model);
			if (_.isObject(params) && _.isString(params.icon_name)) {
				if(_.isString(params.icon_color)){
					var icon_style = ' style="color:'+ params.icon_color +'"';
				} else {
					var icon_style = '';
				}
				
				this.$el.find('.icon_name').html('<i class="fa ' + params.icon_name + '"'+ icon_style +'></i>');
			} else {
				this.$el.find('.icon_name').html('<i class="fa fa-check"></i>');
			}
		}
	});	
	
	window.VcTestimonialView = vc.shortcode_view.extend({
        changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcTestimonialView.__super__.changeShortcodeParams.call(this, model);
            if (!_.isString(params.name)) {
                this.$el.find('h3.name').text('Testimonial');
            }			
        }
    });
	
	window.VcTestimonialSliderView = vc.shortcode_view.extend({
        adding_new_tab:false,
        events:{
            'click .add_tab':'addTab',
            'click > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete':'deleteShortcode',
            'click > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit':'editElement',
            'click > .vc_controls .column_clone,> .vc_controls .vc_control-btn-clone':'clone'
        },
        render:function () {
            window.VcTestimonialSliderView.__super__.render.call(this);
            this.$content.sortable({
                axis:"y",
                handle:".wpb_element_wrapper,.vc_element-move",
                stop:function (event, ui) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.prev().triggerHandler("focusout");
                    $(this).find('> .wpb_sortable').each(function () {
                        var shortcode = $(this).data('model');
                        shortcode.save({'order':$(this).index()}); // Optimize
                    });
                }
            });
            return this;
        },
        changeShortcodeParams:function (model) {
            window.VcTestimonialSliderView.__super__.changeShortcodeParams.call(this, model);
            var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
            if (this.$content.hasClass('ui-accordion')) {
                this.$content.accordion("option", "collapsible", collapsible);
            }
        },
        changedContent:function (view) {
            if (this.$content.hasClass('ui-accordion')) this.$content.accordion('destroy');
            var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
            this.$content.accordion({
                header:"h3",
                navigation:false,
                autoHeight:true,
                heightStyle: "content",
                collapsible:collapsible,
                active:this.adding_new_tab === false && view.model.get('cloned') !== true ? 0 : view.$el.index()
            });
            this.adding_new_tab = false;
        },
        addTab:function (e) {
            this.adding_new_tab = true;
            e.preventDefault();
            vc.shortcodes.create({shortcode:'vc_testimonial', params:{title:window.i18nLocale.section}, parent_id:this.model.id});
        },
        _loadDefaults:function () {
            window.VcTestimonialSliderView.__super__._loadDefaults.call(this);
        }
    });
	
	
	window.VcPricingView = window.VcColumnView.extend({
        events:{
          'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
          'click > .vc_controls .vc_control-btn-prepend':'addElement',
          'click > .vc_controls .vc_control-btn-edit':'editElement',
          'click > .vc_controls .vc_control-btn-clone':'clone',
          'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
        },
		changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcPricingView.__super__.changeShortcodeParams.call(this, model);
            if (_.isObject(params)) {
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'h4.title' ) );
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'span.wpb_vc_param_value' ) );
            }			
        }
    });
	
	window.VcTooltipView = window.VcColumnView.extend({
        events:{
          'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
          'click > .vc_controls .vc_control-btn-prepend':'addElement',
          'click > .vc_controls .vc_control-btn-edit':'editElement',
          'click > .vc_controls .vc_control-btn-clone':'clone',
          'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
        }
    });
	

})(window.jQuery);