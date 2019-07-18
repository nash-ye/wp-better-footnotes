(function ($) {
    "use strict";

    var betterFootnotes = {
        options: {
            scrollGap: 0,
            scrollSpeed: 0
        },
        init: function () {
            if (typeof betterFootnotesOptions !== 'undefined') {
                betterFootnotes.options = Object.assign(betterFootnotes.options, betterFootnotesOptions);
            }

            $(document).on('click', '.bfn-footnoteRef, .bfn-footnoteHook', function (e) {
                e.preventDefault();
                var target = $($(this).attr('href') + ":first");
                if (target.length) {
                    betterFootnotes.scrollTo(target, betterFootnotes.options.scrollSpeed);
                }
            });
        },
        scrollTo: function (target, time) {
            if (!betterFootnotes.isDefined(time) || time === false) {
                time = 800;
            }

            var targetY = target.offset().top - betterFootnotes.options.scrollGap;

            if (time !== false || time !== 0) {
                $("html, body").animate(
                    { scrollTop: targetY },
                    time,
                    'easeOutCubic'
                ).promise().done(function () {
                });
            } else {
                $("html, body").scrollTop(targetY);
            }
        },
        isDefined: function (object) {
            if (typeof object !== typeof undefined && object !== false) {
                return true;
            } else {
                return false;
            }
        }
    };

    jQuery.extend(jQuery.easing, {
        easeOutCubic: function (x, t, b, c, d) {
            return c * ((t = t / d - 1) * t * t + 1) + b;
        }
    });

    $(document).ready(betterFootnotes.init);
})(jQuery);
