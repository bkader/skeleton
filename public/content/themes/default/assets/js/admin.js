! function(t) {
    return "function" == typeof define && define.amd ? define(["jquery"], function(e) {
        return t(e, window, document)
    }) : t(jQuery, window, document)
}(function(t, e, i) {
    "use strict";
    var s, o, n, r, a, l, h, c, p, d, u, f, g, v, y, m, b, w, $, T, S, C, x, E, k, D, O, A, I, N, R;
    x = {
        paneClass: "nano-pane",
        sliderClass: "nano-slider",
        contentClass: "nano-content",
        iOSNativeScrolling: !1,
        preventPageScrolling: !1,
        disableResize: !1,
        alwaysVisible: !1,
        flashDelay: 1500,
        sliderMinHeight: 20,
        sliderMaxHeight: null,
        documentContext: null,
        windowContext: null
    }, w = "scrollbar", b = "scroll", p = "mousedown", d = "mouseenter", u = "mousemove", g = "mousewheel", f = "mouseup", m = "resize", a = "drag", l = "enter", T = "up", y = "panedown", n = "DOMMouseScroll", r = "down", S = "wheel", h = "keydown", c = "keyup", $ = "touchmove", s = "Microsoft Internet Explorer" === e.navigator.appName && /msie 7./i.test(e.navigator.appVersion) && e.ActiveXObject, o = null, O = e.requestAnimationFrame, C = e.cancelAnimationFrame, I = i.createElement("div").style, R = function() {
        var t, e, i, s, o, n;
        for (s = ["t", "webkitT", "MozT", "msT", "OT"], t = o = 0, n = s.length; n > o; t = ++o)
            if (i = s[t], e = s[t] + "ransform", e in I) return s[t].substr(0, s[t].length - 1);
        return !1
    }(), N = function(t) {
        return R === !1 ? !1 : "" === R ? t : R + t.charAt(0).toUpperCase() + t.substr(1)
    }, A = N("transform"), k = A !== !1, E = function() {
        var t, e, s;
        return t = i.createElement("div"), e = t.style, e.position = "absolute", e.width = "100px", e.height = "100px", e.overflow = b, e.top = "-9999px", i.body.appendChild(t), s = t.offsetWidth - t.clientWidth, i.body.removeChild(t), s
    }, D = function() {
        var t, i, s;
        return i = e.navigator.userAgent, (t = /(?=.+Mac OS X)(?=.+Firefox)/.test(i)) ? (s = /Firefox\/\d{2}\./.exec(i), s && (s = s[0].replace(/\D+/g, "")), t && +s > 23) : !1
    }, v = function() {
        function h(s, n) {
            this.el = s, this.options = n, o || (o = E()), this.$el = t(this.el), this.doc = t(this.options.documentContext || i), this.win = t(this.options.windowContext || e), this.body = this.doc.find("body"), this.$content = this.$el.children("." + n.contentClass), this.$content.attr("tabindex", this.options.tabIndex || 0), this.content = this.$content[0], this.previousPosition = 0, this.options.iOSNativeScrolling && null != this.el.style.WebkitOverflowScrolling ? this.nativeScrolling() : this.generate(), this.createEvents(), this.addEvents(), this.reset()
        }
        return h.prototype.preventScrolling = function(t, e) {
            if (this.isActive)
                if (t.type === n)(e === r && t.originalEvent.detail > 0 || e === T && t.originalEvent.detail < 0) && t.preventDefault();
                else if (t.type === g) {
                if (!t.originalEvent || !t.originalEvent.wheelDelta) return;
                (e === r && t.originalEvent.wheelDelta < 0 || e === T && t.originalEvent.wheelDelta > 0) && t.preventDefault()
            }
        }, h.prototype.nativeScrolling = function() {
            this.$content.css({
                WebkitOverflowScrolling: "touch"
            }), this.iOSNativeScrolling = !0, this.isActive = !0
        }, h.prototype.updateScrollValues = function() {
            var t, e;
            t = this.content, this.maxScrollTop = t.scrollHeight - t.clientHeight, this.prevScrollTop = this.contentScrollTop || 0, this.contentScrollTop = t.scrollTop, e = this.contentScrollTop > this.previousPosition ? "down" : this.contentScrollTop < this.previousPosition ? "up" : "same", this.previousPosition = this.contentScrollTop, "same" !== e && this.$el.trigger("update", {
                position: this.contentScrollTop,
                maximum: this.maxScrollTop,
                direction: e
            }), this.iOSNativeScrolling || (this.maxSliderTop = this.paneHeight - this.sliderHeight, this.sliderTop = 0 === this.maxScrollTop ? 0 : this.contentScrollTop * this.maxSliderTop / this.maxScrollTop)
        }, h.prototype.setOnScrollStyles = function() {
            var t;
            k ? (t = {}, t[A] = "translate(0, " + this.sliderTop + "px)") : t = {
                top: this.sliderTop
            }, O ? (C && this.scrollRAF && C(this.scrollRAF), this.scrollRAF = O(function(e) {
                return function() {
                    return e.scrollRAF = null, e.slider.css(t)
                }
            }(this))) : this.slider.css(t)
        }, h.prototype.createEvents = function() {
            this.events = {
                down: function(t) {
                    return function(e) {
                        return t.isBeingDragged = !0, t.offsetY = e.pageY - t.slider.offset().top, t.slider.is(e.target) || (t.offsetY = 0), t.pane.addClass("active"), t.doc.bind(u, t.events[a]).bind(f, t.events[T]), t.body.bind(d, t.events[l]), !1
                    }
                }(this),
                drag: function(t) {
                    return function(e) {
                        return t.sliderY = e.pageY - t.$el.offset().top - t.paneTop - (t.offsetY || .5 * t.sliderHeight), t.scroll(), t.contentScrollTop >= t.maxScrollTop && t.prevScrollTop !== t.maxScrollTop ? t.$el.trigger("scrollend") : 0 === t.contentScrollTop && 0 !== t.prevScrollTop && t.$el.trigger("scrolltop"), !1
                    }
                }(this),
                up: function(t) {
                    return function() {
                        return t.isBeingDragged = !1, t.pane.removeClass("active"), t.doc.unbind(u, t.events[a]).unbind(f, t.events[T]), t.body.unbind(d, t.events[l]), !1
                    }
                }(this),
                resize: function(t) {
                    return function() {
                        t.reset()
                    }
                }(this),
                panedown: function(t) {
                    return function(e) {
                        return t.sliderY = (e.offsetY || e.originalEvent.layerY) - .5 * t.sliderHeight, t.scroll(), t.events.down(e), !1
                    }
                }(this),
                scroll: function(t) {
                    return function(e) {
                        t.updateScrollValues(), t.isBeingDragged || (t.iOSNativeScrolling || (t.sliderY = t.sliderTop, t.setOnScrollStyles()), null != e && (t.contentScrollTop >= t.maxScrollTop ? (t.options.preventPageScrolling && t.preventScrolling(e, r), t.prevScrollTop !== t.maxScrollTop && t.$el.trigger("scrollend")) : 0 === t.contentScrollTop && (t.options.preventPageScrolling && t.preventScrolling(e, T), 0 !== t.prevScrollTop && t.$el.trigger("scrolltop"))))
                    }
                }(this),
                wheel: function(t) {
                    return function(e) {
                        var i;
                        return null != e ? (i = e.delta || e.wheelDelta || e.originalEvent && e.originalEvent.wheelDelta || -e.detail || e.originalEvent && -e.originalEvent.detail, i && (t.sliderY += -i / 3), t.scroll(), !1) : void 0
                    }
                }(this),
                enter: function(t) {
                    return function(e) {
                        var i;
                        return t.isBeingDragged && 1 !== (e.buttons || e.which) ? (i = t.events)[T].apply(i, arguments) : void 0
                    }
                }(this)
            }
        }, h.prototype.addEvents = function() {
            var t;
            this.removeEvents(), t = this.events, this.options.disableResize || this.win.bind(m, t[m]), this.iOSNativeScrolling || (this.slider.bind(p, t[r]), this.pane.bind(p, t[y]).bind("" + g + " " + n, t[S])), this.$content.bind("" + b + " " + g + " " + n + " " + $, t[b])
        }, h.prototype.removeEvents = function() {
            var t;
            t = this.events, this.win.unbind(m, t[m]), this.iOSNativeScrolling || (this.slider.unbind(), this.pane.unbind()), this.$content.unbind("" + b + " " + g + " " + n + " " + $, t[b])
        }, h.prototype.generate = function() {
            var i, s, n, r, a, l, h, c = t("html").hasClass("rtl");
            return r = this.options, l = r.paneClass, h = r.sliderClass, i = r.contentClass, (a = this.$el.children("." + l)).length || a.children("." + h).length || this.$el.append('<div class="' + l + '"><div class="' + h + '" /></div>'), this.pane = this.$el.children("." + l), this.slider = this.pane.find("." + h), 0 === o && D() ? (n = e.getComputedStyle(this.content, null).getPropertyValue("padding-right").replace(/[^0-9.]+/g, ""), s = c ? {
                left: -14,
                paddingLeft: +n + 14
            } : {
                right: -14,
                paddingRight: +n + 14
            }) : o && (s = c ? {
                left: -o
            } : {
                right: -o
            }, this.$el.addClass("has-scrollbar")), null != s && this.$content.css(s), this
        }, h.prototype.restore = function() {
            this.stopped = !1, this.iOSNativeScrolling || this.pane.show(), this.addEvents()
        }, h.prototype.reset = function() {
            var t, e, i, n, r, a, l, h, c, p, d, u;
            return this.iOSNativeScrolling ? void(this.contentHeight = this.content.scrollHeight) : (this.$el.find("." + this.options.paneClass).length || this.generate().stop(), this.stopped && this.restore(), t = this.content, n = t.style, r = n.overflowY, s && this.$content.css({
                height: this.$content.height()
            }), e = t.scrollHeight + o, p = parseInt(this.$el.css("max-height"), 10), p > 0 && (this.$el.height(""), this.$el.height(t.scrollHeight > p ? p : t.scrollHeight)), l = this.pane.outerHeight(!1), c = parseInt(this.pane.css("top"), 10), a = parseInt(this.pane.css("bottom"), 10), h = l + c + a, u = Math.round(h / e * h), u < this.options.sliderMinHeight ? u = this.options.sliderMinHeight : null != this.options.sliderMaxHeight && u > this.options.sliderMaxHeight && (u = this.options.sliderMaxHeight), r === b && n.overflowX !== b && (u += o), this.maxSliderTop = h - u, this.contentHeight = e, this.paneHeight = l, this.paneOuterHeight = h, this.sliderHeight = u, this.paneTop = c, this.slider.height(u), this.events.scroll(), this.pane.show(), this.isActive = !0, t.scrollHeight === t.clientHeight || this.pane.outerHeight(!0) >= t.scrollHeight && r !== b ? (this.pane.hide(), this.isActive = !1) : this.el.clientHeight === t.scrollHeight && r === b ? this.slider.hide() : this.slider.show(), this.pane.css({
                opacity: this.options.alwaysVisible ? 1 : "",
                visibility: this.options.alwaysVisible ? "visible" : ""
            }), i = this.$content.css("position"), ("static" === i || "relative" === i) && (d = parseInt(this.$content.css("right"), 10), d && this.$content.css({
                right: "",
                marginRight: d
            })), this)
        }, h.prototype.scroll = function() {
            return this.isActive ? (this.sliderY = Math.max(0, this.sliderY), this.sliderY = Math.min(this.maxSliderTop, this.sliderY), this.$content.scrollTop(this.maxScrollTop * this.sliderY / this.maxSliderTop), this.iOSNativeScrolling || (this.updateScrollValues(), this.setOnScrollStyles()), this) : void 0
        }, h.prototype.scrollBottom = function(t) {
            return this.isActive ? (this.$content.scrollTop(this.contentHeight - this.$content.height() - t).trigger(g), this.stop().restore(), this) : void 0
        }, h.prototype.scrollTop = function(t) {
            return this.isActive ? (this.$content.scrollTop(+t).trigger(g), this.stop().restore(), this) : void 0
        }, h.prototype.scrollTo = function(t) {
            return this.isActive ? (this.scrollTop(this.$el.find(t).get(0).offsetTop), this) : void 0
        }, h.prototype.stop = function() {
            return C && this.scrollRAF && (C(this.scrollRAF), this.scrollRAF = null), this.stopped = !0, this.removeEvents(), this.iOSNativeScrolling || this.pane.hide(), this
        }, h.prototype.destroy = function() {
            return this.stopped || this.stop(), !this.iOSNativeScrolling && this.pane.length && this.pane.remove(), s && this.$content.height(""), this.$content.removeAttr("tabindex"), this.$el.hasClass("has-scrollbar") && (this.$el.removeClass("has-scrollbar"), this.$content.css({
                right: ""
            })), this
        }, h.prototype.flash = function() {
            return !this.iOSNativeScrolling && this.isActive ? (this.reset(), this.pane.addClass("flashed"), setTimeout(function(t) {
                return function() {
                    t.pane.removeClass("flashed")
                }
            }(this), this.options.flashDelay), this) : void 0
        }, h
    }(), t.fn.nanoScroller = function(e) {
        return this.each(function() {
            var i, s;
            if ((s = this.nanoscroller) || (i = t.extend({}, x, e), this.nanoscroller = s = new v(this, i)), e && "object" == typeof e) {
                if (t.extend(s.options, e), null != e.scrollBottom) return s.scrollBottom(e.scrollBottom);
                if (null != e.scrollTop) return s.scrollTop(e.scrollTop);
                if (e.scrollTo) return s.scrollTo(e.scrollTo);
                if ("bottom" === e.scroll) return s.scrollBottom(0);
                if ("top" === e.scroll) return s.scrollTop(0);
                if (e.scroll && e.scroll instanceof t) return s.scrollTo(e.scroll);
                if (e.stop) return s.stop();
                if (e.destroy) return s.destroy();
                if (e.flash) return s.flash()
            }
            return s.reset()
        })
    }, t.fn.nanoScroller.Constructor = v
}), ! function(t, e) {
    e["true"] = t, ! function(t) {
        "use strict";
        var e = function(e, i) {
            this.options = i, this.$acp = t(e), this.$content = this.$acp.find("~ .content-wrap"), this.$nano = this.$acp.find(".nano"), this.$html = t("html"), this.$body = t("body"), this.$window = t(window), this.changed = !1, this.init()
        };
        e.DEFAULTS = {
            duration: 300,
            resizeWnd: 1e3
        }, e.prototype.init = function() {
            var e = this;
            e.$body.addClass("acp-notransition"), e.$nano.nanoScroller({
                preventPageScrolling: !0
            }), t(".acp-toggle").on("click", function(t) {
                t.preventDefault(), e.toggleYay()
            }), e.$content.on("click", function() {
                e.isHideOnContentClick() && e.hideYay()
            }), e.$acp.on("click", "li a.acp-sub-toggle", function(i) {
                i.preventDefault(), e.toggleSub(t(this))
            }), "push" == e.showType() && e.isShow() && e.$body.css("overflow", "hidden"), e.$acp.hasClass("acp-gestures") && e.useGestures(), e.$window.on("resize", function() {
                e.windowResize()
            }), e.windowResize(), setTimeout(function() {
                e.$body.removeClass("acp-notransition")
            }, 1)
        }, e.prototype.isShow = function() {
            return !this.$body.hasClass("acp-hide")
        }, e.prototype.showType = function() {
            return this.$acp.hasClass("acp-overlay") ? "overlay" : this.$acp.hasClass("acp-push") ? "push" : this.$acp.hasClass("acp-shrink") ? "shrink" : void 0
        }, e.prototype.isHideOnContentClick = function() {
            return this.$acp.hasClass("acp-overlap-content")
        }, e.prototype.isStatic = function() {
            return this.$acp.hasClass("acp-static")
        }, e.prototype.toggleYay = function(t) {
            var e = this,
                i = !e.isShow();
            t && ("show" == t && !i || "hide" == t && i) || (e.options.changed = !0, i ? e.showYay() : e.hideYay())
        }, e.prototype.showYay = function() {
            var t = this;
            t.$body.removeClass("acp-hide"), "push" == t.showType() && t.$body.css("overflow", "hidden"), setTimeout(function() {
                t.$nano.nanoScroller(), t.$window.resize()
            }, t.options.duration)
        }, e.prototype.hideYay = function() {
            var t = this;
            t.$body.addClass("acp-hide"), t.$nano.nanoScroller({
                destroy: !0
            }), setTimeout(function() {
                "push" == t.showType() && t.$body.css("overflow", "visible"), t.$window.resize()
            }, t.options.duration)
        }, e.prototype.toggleSub = function(t) {
            var e = this,
                i = t.parent(),
                s = i.find("> ul"),
                o = i.hasClass("open");
            s.length && (o ? e.closeSub(s) : e.openSub(s, i))
        }, e.prototype.closeSub = function(e) {
            var i = this;
            e.css("display", "block").stop().slideUp(i.options.duration, "swing", function() {
                t(this).find("li a.acp-sub-toggle").next().attr("style", ""), i.$nano.nanoScroller()
            }), e.parent().removeClass("open"), e.find("li a.acp-sub-toggle").parent().removeClass("open")
        }, e.prototype.openSub = function(t, e) {
            var i = this;
            t.css("display", "none").stop().slideDown(i.options.duration, "swing", function() {
                i.$nano.nanoScroller()
            }), e.addClass("open"), i.closeSub(e.siblings(".open").find("> ul"))
        }, e.prototype.useGestures = function() {
            var t = this,
                e = 0,
                i = 0,
                s = 0;
            t.$window.on("touchstart", function(t) {
                i = (t.originalEvent.touches ? t.originalEvent.touches[0] : t).pageX, s = (t.originalEvent.touches ? t.originalEvent.touches[0] : t).pageX, e = 1
            }), t.$window.on("touchmove", function(t) {
                e && (s = (t.originalEvent.touches ? t.originalEvent.touches[0] : t).pageX)
            }), t.$window.on("touchend", function() {
                if (e) {
                    var o = i - s,
                        n = t.$html.hasClass("rtl");
                    if (e = 0, Math.abs(o) < 100) return;
                    n && (o *= -1, i = t.$window.width() - i), 0 > o ? 40 > i && t.showYay() : t.hideYay()
                }
            })
        };
        var i;
        e.prototype.windowResize = function() {
            var t = this;
            t.options.changed || (clearTimeout(i), i = setTimeout(function() {
                t.$window.width() < t.options.resizeWnd && t.toggleYay("hide")
            }, 50))
        }, t(".acpbar").each(function() {
            var i = t.extend({}, e.DEFAULTS, t(this).data(), "object" == typeof option && option);
            new e(this, i)
        })
    }(jQuery)
}({}, function() {
    return this
}()),
function() {
    function t() {
        var t = "",
            e = "";
        n.find("input").each(function() {
            "acpHide" == this.name ? e = this.checked ? ' class="' + this.value + '"' : "" : this.checked && (t += " " + this.value)
        }), o.val(r.replace(/\{\{acpOptions\}\}/g, t).replace(/\{\{acpShow\}\}/g, e))
    }
    var e = $(".acpbar"),
        i = $("html"),
        s = $("body"),
        o = ($(".chooseYayOpts"), $("#resultHTML")),
        n = $(".chooseYayOpts"),
        r = ["<!doctype html>", "<html>", "<head>", '  <meta charset="utf-8">', '  <meta http-equiv="X-UA-Compatible" content="IE=edge">', '  <meta name="viewport" content="width=device-width, initial-scale=1">\n', "  <title>Yay</title>\n", "  <!-- Styles -->", '  <link href="assets/css/bootstrap.min.css" rel="stylesheet">', '  <link href="assets/css/font-awesome.min.css" rel="stylesheet">', '  <link href="assets/css/acp.min.css" rel="stylesheet">', "  <!-- HTML5 shim IE8 support for HTML5 elements -->", "  <!--[if lt IE 9]>", '    <script src="js/html5shiv.min.js"></script>', "  <![endif]-->", "</head>\n", "<body{{acpShow}}>\n", "  <!-- Bootstrap top navbar -->", '  <nav class="navbar navbar-default navbar-fixed-top">', '    <div class="container-fluid">\n', "      <!-- Yay toggle button -->", '      <button class="btn btn-default navbar-btn acp-toggle" type="button"><i class="fa fa-bars"></i></button>\n', '      <a class="navbar-brand" href="#">Yay</a>\n', "    </div><!-- /.container-fluid -->", "  </nav>", "  <!-- /Bootstrap top navbar -->\n\n", "  <!--", "    Yay Sidebar", "    Options [you can use all of theme classnames]:", "      .acp-hide-to-small         - no hide menu, just set it small with big icons", "      .acp-static                - stop using fixed sidebar (will scroll with content)", "      .acp-gestures              - to show and hide menu using gesture swipes", "      .acp-light                 - light color scheme", "      .acp-hide-on-content-click - hide menu on content click\n", "    Effects [you can use one of these classnames]:", "      .acp-overlay  - overlay content", "      .acp-push     - push content to right", "      .acp-shrink   - shrink content width", "  -->", '  <div class="acpbar{{acpOptions}}">', '    <div class="nano">', '      <div class="nano-content">\n', "        <ul>", '          <li class="label">Menu</li>', '          <li class="active">', '            <a href="#"><i class="fa fa-dashboard"></i> Dashboard <span class="badge">7</span></a>', "          </li>\n", "          <li>", '            <a class="acp-sub-toggle"><i class="fa fa-indent"></i> Menu Levels<span class="acp-collapse-icon fa fa-angle-down"></span></a>', "            <ul>", "              <li>", '                <a class="acp-sub-toggle" href="#">Second Level<span class="acp-collapse-icon fa fa-angle-down"></span></a>', "                <ul>", '                  <li><a href="#">Third Level</a></li>', "                </ul>", "              </li>", "            </ul>", "          </li>\n", '          <li class="label">Stats</li>', '          <li class="content">', '            <span><i class="fa fa-spinner"></i> Server Load</span>', '            <div class="progress">', '              <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">', '                <span class="sr-only">60%</span>', "              </div>", "            </div>", "          </li>", "        </ul>\n", "      </div>", "    </div>", "  </div>", "  <!-- /Yay Sidebar -->\n", "  <!-- Place your content here", "       NOTE: Must be after Yaybar:", '         <div class="acpbar">...</div>', '         <div class="content-wrap">...</div>', "  -->", '  <div class="content-wrap">', "    Your Content HERE!", "  </div>\n", "  <!-- Scripts -->", '  <script src="assets/js/jquery.min.js"></script>', '  <script src="assets/js/bootstrap.min.js"></script>', '  <script src="assets/js/jquery.nanoscroller.min.js"></script>', '  <script src="assets/js/acp.min.js"></script>\n', "</body>", "</html>"].join("\n");
    t(), o.on("click", function() {
        $(this).select()
    }), n.on("change", "input", function() {
        var o = this.name,
            n = this.value,
            r = this.checked;
        "acpEffect" == o ? e.removeClass("acp-overlay acp-push acp-shrink").addClass(n) : "acpRTL" == o ? r ? i.addClass(n) : i.removeClass(n) : "acpHide" == o ? r ? s.addClass("acp-hide") : s.removeClass("acp-hide") : r ? e.addClass(n) : e.removeClass(n), t()
    })
}();
