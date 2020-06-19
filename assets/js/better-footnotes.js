(function ($) {
    "use strict";

    var betterFootnotes = {
        options: {
            scrollGap: 0,
            scrollSpeed: 0,
            groupFootnotes: 0
        },
        occurrenceLog: [],
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

            $('.bfn-footnoteHook', containerSelector).each(function() {
                var $footnoteHook  = $(this);
                var footnoteNum    = betterFootnotes.logOccurrence($footnoteHook.data('footnote-content'));
                var occurrenceCount = betterFootnotes.occurrenceLog[footnoteNum-1].count;
 
                betterFootnotes.populateFootnoteHook($footnoteHook, footnotePostId, footnoteNum, occurrenceCount);

            });

            this.generateFootnotesList(footnotePostId, $footenotes);

        },
        populateFootnoteHook: function($footnoteHook, footnotePostId, footnoteNum, occurrenceCount) {
            var footnoteId     = betterFootnotes.generateFootnoteId(footnotePostId, footnoteNum);
            var footnoteHookId = betterFootnotes.generateFootnoteHookId(footnotePostId, footnoteNum, occurrenceCount);
            $footnoteHook.attr("id", footnoteHookId);
            $footnoteHook.attr("href", "#" + footnoteId);
            $footnoteHook.attr("data-footnote-id", footnoteId);
            if ($footnoteHook.attr("data-footnote-type") === "numeric" || betterFootnotes.options.groupFootnotes == 1) {
                $footnoteHook.text(footnoteNum);
            }

            return $footnoteHook;
        },
        generateFootnoteHookId: function (postId, footnoteNum, occurrenceCount) {
            var id =  "article-footnote-hook-" + postId + "-" + footnoteNum;
            return (betterFootnotes.options.groupFootnotes == 1) ? id + "-" + occurrenceCount : id;
        },
        generateFootnoteId: function (postId, footnoteNum) {
            return "article-footnote-" + postId + "-" + footnoteNum;
        },
        generateFootnoteRef: function (footnoteHookId, footnoteId, footnoteNum, occurrenceCount, type) {
            var $footnoteRef = $("<a></a>");
            var text = ('numeric' === type) ? footnoteNum : String.fromCharCode(96 + occurrenceCount);
            $footnoteRef.text(text);
            $footnoteRef.addClass("bfn-footnoteRef");
            $footnoteRef.attr("href", "#" + footnoteHookId);
            if('numeric' === type) {
                $footnoteRef.attr("id", footnoteId);
            } else {
                $footnoteRef.addClass("bfn-footnoteRef-child");
            }
            return $footnoteRef;
        },
        generateFootnoteItem: function (logItem, postId, footnoteHookId, footnoteId, footnoteNum) {
            var $footnoteItem = $("<li></li>");
            $footnoteItem.addClass("bfn-footnoteItem");
            $footnoteItem.append(this.generateFootnoteRef(footnoteHookId, footnoteId, footnoteNum, 1, 'numeric'));
            $footnoteItem.append("&nbsp;");
            if(logItem.count > 1 ) {
                for(var x=1; x <= logItem.count; x++){
                    footnoteHookId = (x >1) ? this.generateFootnoteHookId(postId, footnoteNum, x) : footnoteHookId;
                    $footnoteItem.append(this.generateFootnoteRef(footnoteHookId, footnoteId, footnoteNum, x));
                    $footnoteItem.append("&nbsp;");
                }
            }
            $footnoteItem.append(logItem.contentRaw);
            return $footnoteItem;
        },
        generateFootnotesList: function(postId, $footenotes)
        {
            var $footenotesList = $(".bfn-footnotesList", $footenotes);

            for(var i=0; i< this.occurrenceLog.length; i++)
            {
                var logItem        = this.occurrenceLog[i];
                var footnoteNum    = i + 1;
                var footnoteHookId = this.generateFootnoteHookId(postId, footnoteNum, 1);
                var footnoteId     = this.generateFootnoteId(postId, footnoteNum);

                $footenotesList.append(this.generateFootnoteItem(logItem, postId, footnoteHookId, footnoteId, footnoteNum));
            }

            if (! $footenotesList.is(":empty")) {
                $footenotes.show();
            }        
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
        },
        getOccurrenceIndex: function(footnoteContent) {
            for(var i=0; i< this.occurrenceLog.length; i++) {
                if(this.occurrenceLog[i].content == footnoteContent) {
                    return i;
                }
            }
            return -1;
        },
        logOccurrence: function(footnoteContent) {

            var footnoteContentNorm = footnoteContent.toLowerCase();

            if(this.options.groupFootnotes == 1 ) {
                var occurrenceIndex = this.getOccurrenceIndex(footnoteContentNorm);
                if(occurrenceIndex >= 0) {
                    this.occurrenceLog[occurrenceIndex].count++;
                    return occurrenceIndex +1;
                }
            }

            return this.occurrenceLog.push({content: footnoteContentNorm, contentRaw: footnoteContent, count: 1});
        }
    };

    jQuery.extend(jQuery.easing, {
        easeOutCubic: function (x, t, b, c, d) {
            return c * ((t = t / d - 1) * t * t + 1) + b;
        }
    });

    $(document).ready(betterFootnotes.init);
})(jQuery);
