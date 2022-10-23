"use strict";
!function (p, u) {
    p.Package.name = "DashLite",
        p.Package.version = "2.3";
    var c = u(window)
        , a = u("body")
        , l = u(document)
        , t = "nk-menu"
        , s = "nk-header-menu"
        , r = "nk-sidebar"
        , d = p.Break;
    function f(e, n)
    {
        return Object.keys(n).forEach(function (t) {
            e[t] = n[t]
        }),
            e
    }
    p.ClassBody = function () {
        p.AddInBody(r)
    }
        ,
        p.ClassNavMenu = function () {
            p.BreakClass("." + s, d.lg, {
                timeOut: 0
            }),
                c.on("resize", function () {
                    p.BreakClass("." + s, d.lg)
                })
        }
        ,
        p.Prettify = function () {
            window.prettyPrint && prettyPrint()
        }
        ,
        p.Copied = function () {
            var t = ".clipboard-init"
                , i = ".clipboard-text"
                , o = "clipboard-success"
                , s = "clipboard-error";
            function e(t, e)
            {
                var t = u(t)
                    , n = t.parent()
                    , a = {
                        text: "Copy",
                        done: "Copied",
                        fail: "Failed"
                }
                    , t = {
                        text: t.data("clip-text"),
                        done: t.data("clip-success"),
                        fail: t.data("clip-error")
                }
                    , t = (a.text = t.text || a.text,
                    a.done = t.done || a.done,
                    a.fail = t.fail || a.fail,
                    "success" === e ? a.done : a.fail);
                n.addClass("success" === e ? o : s).find(i).html(t),
                    setTimeout(function () {
                        n.removeClass(o + " " + s).find(i).html(a.text).blur(),
                            n.find("input").blur()
                    }, 2e3)
            }
            ClipboardJS.isSupported() ? new ClipboardJS(t).on("success", function (t) {
                e(t.trigger, "success"),
                    t.clearSelection()
            }).on("error", function (t) {
                e(t.trigger, "error")
            }) : u(t).css("display", "none")
        }
        ,
        p.CurrentLink = function () {
            var t = window.location.href
                , n = (n = t.substring(0, -1 == t.indexOf("#") ? t.length : t.indexOf("#"))).substring(0, -1 == n.indexOf("?") ? n.length : n.indexOf("?"));
            u(".nk-menu-link, .menu-link, .nav-link").each(function () {
                var t = u(this)
                    , e = t.attr("href");
                n.match(e) ? (t.closest("li").addClass("active current-page").parents().closest("li").addClass("active current-page"),
                    t.closest("li").children(".nk-menu-sub").css("display", "block"),
                    t.parents().closest("li").children(".nk-menu-sub").css("display", "block"),
                    this.scrollIntoView({
                        block: "start"
                    })) : t.closest("li").removeClass("active current-page").parents().closest("li:not(.current-page)").removeClass("active")
            })
        }
        ,
        p.PassSwitch = function () {
            p.Passcode(".passcode-switch")
        }
        ,
        p.Toast = function (t, e, n) {
            var a = "info" === (e = e || "info") ? "ni ni-info-fill" : "success" === e ? "ni ni-check-circle-fill" : "error" === e ? "ni ni-cross-circle-fill" : "warning" === e ? "ni ni-alert-fill" : ""
                , i = {
                    position: "bottom-right",
                    ui: "",
                    icon: "auto",
                    clear: !1
            }
                , n = n ? f(i, n) : i;
            n.position = n.position ? "toast-" + n.position : "toast-bottom-right",
                n.icon = "auto" === n.icon ? a : n.icon || "",
                n.ui = n.ui ? " " + n.ui : "",
                i = "" !== n.icon ? '<span class="toastr-icon"><em class="icon ' + n.icon + '"></em></span>' : "",
            "" !== (t = "" !== t ? i + '<div class="toastr-text">' + t + "</div>" : "") && (!0 === n.clear && toastr.clear(),
                a = {
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !1,
                    progressBar: !1,
                    positionClass: n.position + n.ui,
                    closeHtml: '<span class="btn-trigger">Close</span>',
                    preventDuplicates: !0,
                    showDuration: "1500",
                    hideDuration: "1500",
                    timeOut: "2000",
                    toastClass: "toastr",
                    extendedTimeOut: "3000"
                },
                toastr.options = f(a, n),
                toastr[e](t))
        }
        ,
        p.TGL.screen = function (t) {
            u(t).exists() && u(t).each(function () {
                var t = u(this).data("toggle-screen");
                t && u(this).addClass("toggle-screen-" + t)
            })
        }
        ,
        p.TGL.content = function (t, e) {
            var t = u(t || ".toggle")
                , n = u("[data-content]")
                , s = !1
                , a = {
                    active: "active",
                    content: "content-active",
                    break: !0
            }
                , r = e ? f(a, e) : a;
            p.TGL.screen(n),
                t.on("click", function (t) {
                    s = this,
                        p.Toggle.trigger(u(this).data("target"), r),
                        t.preventDefault()
                }),
                l.on("mouseup", function (t) {
                    var e, n, a, i, o;
                    s && (e = u(s),
                        n = u(s).data("target"),
                        n = u('[data-content="'.concat(n, '"]')),
                        a = u(".select2-container"),
                        i = u(".datepicker-dropdown"),
                        o = u(".ui-timepicker-container"),
                    e.is(t.target) || 0 !== e.has(t.target).length || n.is(t.target) || 0 !== n.has(t.target).length || a.is(t.target) || 0 !== a.has(t.target).length || i.is(t.target) || 0 !== i.has(t.target).length || o.is(t.target) || 0 !== o.has(t.target).length || (p.Toggle.removed(e.data("target"), r),
                        s = !1))
                }),
                c.on("resize", function () {
                    n.each(function () {
                        var t = u(this).data("content")
                            , e = u(this).data("toggle-screen")
                            , e = d[e];
                        p.Win.width > e && p.Toggle.removed(t, r)
                    })
                })
        }
        ,
        p.TGL.expand = function (t, e) {
            var t = t || ".expand"
                , n = {
                    toggle: !0
            }
                , a = e ? f(n, e) : n;
            u(t).on("click", function (t) {
                p.Toggle.trigger(u(this).data("target"), a),
                    t.preventDefault()
            })
        }
        ,
        p.TGL.ddmenu = function (t, e) {
            var t = t || ".nk-menu-toggle"
                , n = {
                    active: "active",
                    self: "nk-menu-toggle",
                    child: "nk-menu-sub"
            }
                , a = e ? f(n, e) : n;
            u(t).on("click", function (t) {
                (p.Win.width < d.lg || u(this).parents().hasClass(r)) && p.Toggle.dropMenu(u(this), a),
                    t.preventDefault()
            })
        }
        ,
        p.TGL.showmenu = function (t, e) {
            var n = u(t || ".nk-nav-toggle")
                , a = u("[data-content]")
                , i = a.hasClass(s) ? d.lg : d.xl
                , t = {
                    active: "toggle-active",
                    content: r + "-active",
                    body: "nav-shown",
                    overlay: "nk-sidebar-overlay",
                    break: i,
                    close: {
                        profile: !0,
                        menu: !1
                    }
            }
                , o = e ? f(t, e) : t;
            n.on("click", function (t) {
                p.Toggle.trigger(u(this).data("target"), o),
                    t.preventDefault()
            }),
                l.on("mouseup", function (t) {
                    !n.is(t.target) && 0 === n.has(t.target).length && !a.is(t.target) && 0 === a.has(t.target).length && p.Win.width < i && p.Toggle.removed(n.data("target"), o)
                }),
                c.on("resize", function () {
                    (p.Win.width < d.xl || p.Win.width < i) && p.Toggle.removed(n.data("target"), o)
                })
        }
        ,
        p.sbCompact = function () {
            var t = u(".nk-nav-compact");
            u("[data-content]");
            t.on("click", function (t) {
                t.preventDefault();
                var t = u(this)
                    , e = t.data("target")
                    , e = u("[data-content=" + e + "]");
                t.toggleClass("compact-active"),
                    e.toggleClass("is-compact")
            })
        }
        ,
        p.Ani.formSearch = function (t, e) {
            var n = {
                active: "active",
                timeout: 400,
                target: "[data-search]"
            }
                , a = e ? f(n, e) : n
                , i = u(t)
                , o = u(a.target);
            i.exists() && (i.on("click", function (t) {
                t.preventDefault();
                var t = u(this).data("target")
                    , e = u("[data-search=" + t + "]")
                    , t = u("[data-target=" + t + "]");
                e.hasClass(a.active) ? (t.add(e).removeClass(a.active),
                    setTimeout(function () {
                        e.find("input").val("")
                    }, a.timeout)) : (t.add(e).addClass(a.active),
                    e.find("input").focus())
            }),
                l.on({
                    keyup: function (t) {
                        "Escape" === t.key && i.add(o).removeClass(a.active)
                    },
                    mouseup: function (t) {
                        o.find("input").val() || o.is(t.target) || 0 !== o.has(t.target).length || i.is(t.target) || 0 !== i.has(t.target).length || i.add(o).removeClass(a.active)
                    }
                }))
        }
        ,
        p.Ani.formElm = function (t, e) {
            var n = {
                focus: "focused"
            }
                , a = e ? f(n, e) : n;
            u(t).exists() && u(t).each(function () {
                var t = u(this);
                t.val() && t.parent().addClass(a.focus),
                    t.on({
                        focus: function () {
                            t.parent().addClass(a.focus)
                        },
                        blur: function () {
                            t.val() || t.parent().removeClass(a.focus)
                        }
                    })
            })
        }
        ,
        p.Validate = function (t, e) {
            u(t).exists() && (u(t).each(function () {
                var t = {
                    errorElement: "span"
                }
                    , t = e ? f(t, e) : t;
                u(this).validate(t)
            }),
                p.Validate.OnChange(".js-select2"),
                p.Validate.OnChange(".date-picker"),
                p.Validate.OnChange(".js-tagify"))
        }
        ,
        p.Validate.OnChange = function (t) {
            u(t).on("change", function () {
                u(this).valid()
            })
        }
        ,
        p.Validate.init = function () {
            p.Validate(".form-validate", {
                errorElement: "span",
                errorClass: "invalid",
                errorPlacement: function (t, e) {
                    e.parents().hasClass("input-group") ? t.appendTo(e.parent().parent()) : t.appendTo(e.parent())
                }
            })
        }
        ,
        p.Dropzone = function (a, i) {
            u(a).exists() && u(a).each(function () {
                var t = u(a).data("max-files") || null
                    , e = u(a).data("max-file-size") || 256
                    , n = u(a).data("accepted-files")
                    , t = {
                        autoDiscover: !1,
                        maxFiles: t,
                        maxFilesize: e,
                        acceptedFiles: n || null
                }
                    , e = i ? f(t, i) : t;
                u(this).addClass("dropzone").dropzone(e)
            })
        }
        ,
        p.Dropzone.init = function () {
            p.Dropzone(".upload-zone", {
                url: "/images"
            })
        }
        ,
        p.Wizard = function () {
            var t = u(".nk-wizard");
            t.exists() && t.each(function () {
                var t = u(this).attr("id")
                    , a = u("#" + t).show();
                a.steps({
                    headerTag: ".nk-wizard-head",
                    bodyTag: ".nk-wizard-content",
                    labels: {
                        finish: "Submit",
                        next: "Next",
                        previous: "Prev",
                        loading: "Loading ..."
                    },
                    titleTemplate: '<span class="number">0#index#</span> #title#',
                    onStepChanging: function (t, e, n) {
                        return n < e || (e < n && (a.find(".body:eq(" + n + ") label.error").remove(),
                            a.find(".body:eq(" + n + ") .error").removeClass("error")),
                            a.validate().settings.ignore = ":disabled,:hidden",
                            a.valid())
                    },
                    onFinishing: function (t, e) {
                        return a.validate().settings.ignore = ":disabled",
                            a.valid()
                    },
                    onFinished: function (t, e) {
                        window.location.href = "#"
                    }
                }).validate({
                    errorElement: "span",
                    errorClass: "invalid",
                    errorPlacement: function (t, e) {
                        t.appendTo(e.parent())
                    }
                })
            })
        }
        ,
        p.DataTable = function (t, o) {
            u(t).exists() && u(t).each(function () {
                var t = u(this).data("auto-responsive")
                    , e = !(void 0 === o.buttons || !o.buttons)
                    , n = u(this).data("export-title") ? u(this).data("export-title") : "Export"
                    , a = e ? '<"dt-export-buttons d-flex align-center"<"dt-export-title d-none d-md-inline-block">B>' : ""
                    , e = e ? " with-export" : ""
                    , i = '<"row justify-between g-2' + e + '"<"col-7 col-sm-4 text-start"f><"col-5 col-sm-8 text-end"<"datatable-filter"<"d-flex justify-content-end g-2"' + a + 'l>>>><"datatable-wrap my-3"t><"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-start text-md-end"i>>'
                    , e = '<"row justify-between g-2' + e + '"<"col-7 col-sm-4 text-start"f><"col-5 col-sm-8 text-end"<"datatable-filter"<"d-flex justify-content-end g-2"' + a + 'l>>>><"my-3"t><"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-start text-md-end"i>>'
                    , a = {
                        responsive: !0,
                        autoWidth: !1,
                        dom: u(this).hasClass("is-separate") ? e : i,
                        language: {
                            search: "",
                            searchPlaceholder: "Type in to Search",
                            lengthMenu: "<span class='d-none d-sm-inline-block'>Show</span><div class='form-control-select'> _MENU_ </div>",
                            info: "_START_ -_END_ of _TOTAL_",
                            infoEmpty: "0",
                            infoFiltered: "( Total _MAX_  )",
                            paginate: {
                                first: "First",
                                last: "Last",
                                next: "Next",
                                previous: "Prev"
                            }
                        }
                }
                    , e = o ? f(a, o) : a
                    , e = !1 === t ? f(e, {
                        responsive: !1
                    }) : e;
                u(this).DataTable(e),
                    u(".dt-export-title").text(n)
            })
        }
        ,
        p.DataTable.init = function () {
            p.DataTable(".datatable-init", {
                responsive: {
                    details: !0
                }
            }),
                p.DataTable(".datatable-init-export", {
                    responsive: {
                        details: !0
                    },
                    buttons: ["copy", "excel", "csv", "pdf"]
                }),
                u.fn.DataTable.ext.pager.numbers_length = 7
        }
        ,
        p.BS.ddfix = function (t, e) {
            var n = e || "a:not(.clickable), button:not(.clickable), a:not(.clickable) *, button:not(.clickable) *";
            u(t || ".dropdown-menu").on("click", function (t) {
                u(t.target).is(n) || t.stopPropagation()
            }),
            p.State.isRTL && u(".dropdown-menu").each(function () {
                var t = u(this);
                t.hasClass("dropdown-menu-end") && !t.hasClass("dropdown-menu-center") ? t.prev('[data-bs-toggle="dropdown"]').dropdown({
                    popperConfig: {
                        placement: "bottom-start"
                    }
                }) : t.hasClass("dropdown-menu-end") || t.hasClass("dropdown-menu-center") || t.prev('[data-bs-toggle="dropdown"]').dropdown({
                    popperConfig: {
                        placement: "bottom-end"
                    }
                })
            })
        }
        ,
        p.BS.tabfix = function (t) {
            u(t || '[data-toggle="modal"]').on("click", function () {
                var t = u(this)
                    , e = t.data("target")
                    , n = t.attr("href")
                    , t = t.data("tab-target")
                    , e = e ? a.find(e) : a.find(n);
                t && "#" !== t && e ? e.find('[href="' + t + '"]').tab("show") : e && (n = e.find(".nk-nav.nav-tabs"),
                    t = u(n[0]).find('[data-bs-toggle="tab"]'),
                    u(t[0]).tab("show"))
            })
        }
        ,
        p.ModeSwitch = function () {
            var t = u(".dark-switch");
            a.hasClass("dark-mode") ? t.addClass("active") : t.removeClass("active"),
                t.on("click", function (t) {
                    t.preventDefault(),
                        u(this).toggleClass("active"),
                        a.toggleClass("dark-mode")
                })
        }
        ,
        p.Knob = function (t, e) {
            var n, a;
            u(t).exists() && "function" == typeof u.fn.knob && (n = {
                min: 0
            },
                a = e ? f(n, e) : n,
                u(t).each(function () {
                    u(this).knob(a)
                }))
        }
        ,
        p.Knob.init = function () {
            var t = {
                readOnly: !0,
                lineCap: "round"
            }
                , e = {
                    angleOffset: -90,
                    angleArc: 180,
                    readOnly: !0,
                    lineCap: "round"
            };
            p.Knob(".knob", t),
                p.Knob(".knob-half", e)
        }
        ,
        p.Range = function (t, d) {
            u(t).exists() && "undefined" != typeof noUiSlider && u(t).each(function () {
                var t = u(this)
                    , e = t.attr("id")
                    , n = t.data("start")
                    , n = (n = /\s/g.test(n) ? n.split(" ") : n) || 0
                    , a = t.data("connect")
                    , a = void 0 === (a = /\s/g.test(a) ? a.split(" ") : a) ? "lower" : a
                    , i = t.data("min") || 0
                    , o = t.data("max") || 100
                    , s = t.data("min-distance") || null
                    , r = t.data("max-distance") || null
                    , c = t.data("step") || 1
                    , l = t.data("orientation") || "horizontal"
                    , t = t.data("tooltip") || !1
                    , e = (console.log(t),
                    document.getElementById(e))
                    , n = {
                        start: n,
                        connect: a,
                        direction: p.State.isRTL ? "rtl" : "ltr",
                        range: {
                            min: i,
                            max: o
                        },
                        margin: s,
                        limit: r,
                        step: c,
                        orientation: l,
                        tooltips: t
                }
                    , a = d ? f(n, d) : n;
                noUiSlider.create(e, a)
            })
        }
        ,
        p.Range.init = function () {
            p.Range(".form-control-slider"),
                p.Range(".form-range-slider")
        }
        ,
        p.Select2.init = function () {
            p.Select2(".js-select2")
        }
        ,
        p.Slick = function (t, e) {
            u(t).exists() && "function" == typeof u.fn.slick && u(t).each(function () {
                var t = {
                    prevArrow: '<div class="slick-arrow-prev"><a href="javascript:void(0);" class="slick-prev"><em class="icon ni ni-chevron-left"></em></a></div>',
                    nextArrow: '<div class="slick-arrow-next"><a href="javascript:void(0);" class="slick-next"><em class="icon ni ni-chevron-right"></em></a></div>',
                    rtl: p.State.isRTL
                }
                    , t = e ? f(t, e) : t;
                u(this).slick(t)
            })
        }
        ,
        p.Slider.init = function () {
            p.Slick(".slider-init")
        }
        ,
        p.Lightbox = function (t, e, n) {
            u(t).exists() && u(t).each(function () {
                var t = {}
                    , t = "video" == e || "iframe" == e ? {
                        type: "iframe",
                        removalDelay: 160,
                        preloader: !0,
                        fixedContentPos: !1,
                        callbacks: {
                            beforeOpen: function () {
                                this.st.image.markup = this.st.image.markup.replace("mfp-figure", "mfp-figure mfp-with-anim"),
                                this.st.mainClass = this.st.el.attr("data-effect")
                            }
                        }
                } : "content" == e ? {
                    type: "inline",
                    preloader: !0,
                    removalDelay: 400,
                    mainClass: "mfp-fade content-popup"
                } : {
                    type: "image",
                    mainClass: "mfp-fade image-popup"
                }
                    , t = n ? f(t, n) : t;
                u(this).magnificPopup(t)
            })
        }
        ,
        p.Control = function (t) {
            document.querySelectorAll(t).forEach(function (t, e, n) {
                t.checked && t.parentNode.classList.add("checked"),
                    t.addEventListener("change", function () {
                        "checkbox" == t.type && (t.checked ? t.parentNode.classList.add("checked") : t.parentNode.classList.remove("checked")),
                        "radio" == t.type && (document.querySelectorAll('input[name="' + t.name + '"]').forEach(function (t, e, n) {
                            t.parentNode.classList.remove("checked")
                        }),
                        t.checked && t.parentNode.classList.add("checked"))
                    })
            })
        }
        ,
        p.NumberSpinner = function (t, e) {
            var a = document.querySelectorAll("[data-number='plus']")
                , i = document.querySelectorAll("[data-number='minus']");
            a.forEach(function (t, e, n) {
                a[e].parentNode;
                a[e].addEventListener("click", function () {
                    var s = a[e].parentNode.children;
                    s.forEach(function (t, e, n) {
                        var a, i, o;
                        s[e].classList.contains("number-spinner") && (a = "" == !s[e].value ? parseInt(s[e].value) : 0,
                            i = "" == !s[e].step ? parseInt(s[e].step) : 1,
                            o = "" == !s[e].max ? parseInt(s[e].max) : 1 / 0,
                            s[e].value = a + i < o + 1 ? a + i : a)
                    })
                })
            }),
                i.forEach(function (t, e, n) {
                    i[e].parentNode;
                    i[e].addEventListener("click", function () {
                        var s = i[e].parentNode.children;
                        s.forEach(function (t, e, n) {
                            var a, i, o;
                            s[e].classList.contains("number-spinner") && (a = "" == !s[e].value ? parseInt(s[e].value) : 0,
                                i = "" == !s[e].step ? parseInt(s[e].step) : 1,
                                o = "" == !s[e].min ? parseInt(s[e].min) : 0,
                                s[e].value = o - 1 < a - i ? a - i : a)
                        })
                    })
                })
        }
        ,
        p.Stepper = function (t, a) {
            t = document.querySelectorAll(t);
            0 < t.length && t.forEach(function (t, e) {
                var n = {
                    selectors: {
                        nav: "stepper-nav",
                        progress: "stepper-progress",
                        content: "stepper-steps",
                        prev: "step-prev",
                        next: "step-next",
                        submit: "step-submit"
                    },
                    classes: {
                        nav_current: "current",
                        nav_done: "done",
                        step_active: "active",
                        step_done: "done",
                        active_step: "active"
                    },
                    current_step: 1
                }
                    , n = a ? f(n, a) : n;
                p.Custom.Stepper(t, n),
                    p.Validate.OnChange(".js-select2"),
                    p.Validate.OnChange(".date-picker"),
                    p.Validate.OnChange(".js-tagify")
            })
        }
        ,
        p.Stepper.init = function () {
            p.Stepper(".stepper-init")
        }
        ,
        p.Tagify = function (t, e) {
            u(t).exists() && "function" == typeof u.fn.tagify && (e = e ? f(void 0, e) : void 0,
                u(t).tagify(e))
        }
        ,
        p.Tagify.init = function () {
            p.Tagify(".js-tagify")
        }
        ,
        p.OtherInit = function () {
            p.ClassBody(),
                p.PassSwitch(),
                p.CurrentLink(),
                p.LinkOff(".is-disable"),
                p.ClassNavMenu(),
                p.SetHW("[data-height]", "height"),
                p.SetHW("[data-width]", "width"),
                p.NumberSpinner(),
                p.Lightbox(".popup-video", "video"),
                p.Lightbox(".popup-iframe", "iframe"),
                p.Lightbox(".popup-image", "image"),
                p.Lightbox(".popup-content", "content"),
                p.Control(".custom-control-input")
        }
        ,
        p.Ani.init = function () {
            p.Ani.formElm(".form-control-outlined"),
                p.Ani.formSearch(".toggle-search")
        }
        ,
        p.BS.init = function () {
            p.BS.menutip("a.nk-menu-link"),
                p.BS.tooltip(".nk-tooltip"),
                p.BS.tooltip(".btn-tooltip", {
                    placement: "top"
                }),
                p.BS.tooltip('[data-toggle="tooltip"]'),
                p.BS.tooltip('[data-bs-toggle="tooltip"]'),
                p.BS.tooltip(".tipinfo,.nk-menu-tooltip", {
                    placement: "right"
                }),
                p.BS.popover('[data-toggle="popover"]'),
                p.BS.popover('[data-bs-toggle="popover"]'),
                p.BS.progress("[data-progress]"),
                p.BS.fileinput(".form-file-input"),
                p.BS.modalfix(),
                p.BS.ddfix(),
                p.BS.tabfix()
        }
        ,
        p.Picker.init = function () {
            p.Picker.date(".date-picker"),
                p.Picker.dob(".date-picker-alt"),
                p.Picker.time(".time-picker"),
                p.Picker.date(".date-picker-range", {
                    todayHighlight: !1,
                    autoclose: !1
                })
        }
        ,
        p.Addons.Init = function () {
            p.Knob.init(),
            p.Range.init(),
            p.Select2.init(),
            p.Dropzone.init(),
            p.Slider.init(),
            p.DataTable.init(),
            p.Tagify.init()
        }
        ,
        p.TGL.init = function () {
            p.TGL.content(".toggle"),
                p.TGL.expand(".toggle-expand"),
                p.TGL.expand(".toggle-opt", {
                    toggle: !1
                }),
                p.TGL.showmenu(".nk-nav-toggle"),
                p.TGL.ddmenu("." + t + "-toggle", {
                    self: t + "-toggle",
                    child: t + "-sub"
                })
        }
        ,
        p.BS.modalOnInit = function () {},
        p.init = function () {
            p.coms.docReady.push(p.OtherInit),
            p.coms.docReady.push(p.Prettify),
            p.coms.docReady.push(p.ColorBG),
            p.coms.docReady.push(p.ColorTXT),
            p.coms.docReady.push(p.Copied),
            p.coms.docReady.push(p.Ani.init),
            p.coms.docReady.push(p.TGL.init),
            p.coms.docReady.push(p.BS.init),
            p.coms.docReady.push(p.Validate.init),
            p.coms.docReady.push(p.Picker.init),
            p.coms.docReady.push(p.Addons.Init),
            p.coms.docReady.push(p.Wizard),
            p.coms.docReady.push(p.sbCompact),
            p.coms.docReady.push(p.Stepper.init),
            p.coms.winLoad.push(p.ModeSwitch)
        },
        p.init(),
        document.addEventListener('turbo:load', () =>  p.init())
}(NioApp, jQuery);
