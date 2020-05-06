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

            betterFootnotes.populateFootnotesLists();

            $(document).on('click', '.bfn-footnoteRef, .bfn-footnoteHook', function (e) {
                e.preventDefault();
                var target = $($(this).attr('href') + ":first");
                if (target.length) {
                    betterFootnotes.scrollTo(target, betterFootnotes.options.scrollSpeed);
                }
            });
        },
        populateFootnotesLists: function(context) {
            $('.bfn-footnotes', context).each(function() {
                betterFootnotes.populateFootnotesList(this);
            });
        },
        populateFootnotesList: function($footenotes) {
            var $footenotes = $($footenotes);
            var isPopulated = $footenotes.data("is-populated");

            if (isPopulated) {
                return;
            }

            var footnotePostId = $footenotes.attr("data-post-id");
            var containerSelector = $footenotes.attr("data-container");
            if (! containerSelector) {
                containerSelector = "#post-" + footnotePostId;
            }

            var $footenotesList = $(".bfn-footnotesList", $footenotes);
            $('.bfn-footnoteHook', containerSelector).each(function(index) {
                var footnoteNum = index + 1;

                var $footnoteHook = $(this);
                betterFootnotes.populateFootnoteHook($footnoteHook, footnotePostId, footnoteNum);

                var $footnoteItem = betterFootnotes.generateFootnoteItem($footnoteHook);
                $footenotesList.append($footnoteItem);
            });

            if ($footenotesList.is(":empty")) {
                $footenotes.hide();
            }
        },
        populateFootnoteHook: function($footnoteHook, footnotePostId, footnoteNum) {
            var footnoteId = betterFootnotes.generateFootnoteId(footnotePostId, footnoteNum);
            var footnoteHookId = betterFootnotes.generateFootnoteHookId(footnotePostId, footnoteNum);

            $footnoteHook.attr("id", footnoteHookId);
            $footnoteHook.attr("href", "#" + footnoteId);
            $footnoteHook.attr("data-footnote-id", footnoteId);
            if ($footnoteHook.attr("data-footnote-type") === "numeric") {
                $footnoteHook.text(footnoteNum);
            }

            return $footnoteHook;
        },
        generateFootnoteHookId: function (postId, footnoteNum) {
            return "article-footnote-hook-" + postId + "-" + footnoteNum;
        },
        generateFootnoteId: function (postId, footnoteNum) {
            return "article-footnote-" + postId + "-" + footnoteNum;;
        },
        generateFootnoteRef: function ($footnoteHook) {
            var $footnoteRef = $("<a></a>");

            $footnoteRef.text($footnoteHook.text());
            $footnoteRef.addClass("bfn-footnoteRef");
            $footnoteRef.attr("href", "#" + $footnoteHook.attr("id"));
            $footnoteRef.attr("id", $footnoteHook.attr("data-footnote-id"));

            return $footnoteRef;
        },
        generateFootnoteItem: function ($footnoteHook) {
            var $footnoteItem = $("<li></li>");
            $footnoteItem.addClass("bfn-footnoteItem");

            $footnoteItem.append(betterFootnotes.generateFootnoteRef($footnoteHook));
            $footnoteItem.append($footnoteHook.attr("data-footnote-content"));

            return $footnoteItem;
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
