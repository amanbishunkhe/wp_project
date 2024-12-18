(function ($) {
    var FAQs = {
        init: function () {
            this.cacheDOM();
            this.eventListener();
            this.checkScroll();
        },
        cacheDOM: function () {
            this.$cardHolders = $('.toggle-content-wrap');
            this.$faqTopics = $('.faq-topics-sidebar .faq-topic');
            this.$scrollSelector = $('.faq-do-scroll');
        },
        eventListener: function () {
            this.$faqTopics.on('click', this.filterTopicFAQs.bind(this));
        },
       
        filterTopicFAQs: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget),
                term_id = $this.attr('data-faq_topic'),
                $parent = $this.closest('.sibebar-toggle-wrapper'),
                $always = $this.parent().siblings().filter('.always'),
                $faqs = $parent.find('.faq-topic-' + term_id + '-contents');

            if ($this.hasClass('active')) {
                return;
            }
            
            $parent.find('.faq-topic.active').removeClass('active');
            $this.addClass('active');

            $faqs.addClass('active-content').siblings().removeClass('active-content');

            this.$cardHolders.find('.card button[data-toggle="collapse"]:not(.collapsed)').addClass('collapsed').attr('data-expanded', false);
            this.$cardHolders.find('.card .collapse.show').removeClass('show');

            $always.find('a').text($this.text());
            $always.siblings().show();
            $this.parent().hide();
        },
        // scroll to section if visited by topic
        checkScroll: function () {
            if (this.$scrollSelector.length) {
                var $faqWrapper = $('.faq-wrapper');
                if (!$faqWrapper.length) {
                    return;
                }

                $('html,body').animate({
                    scrollTop: $faqWrapper.offset().top - $('#masthead').outerHeight(true) - 10
                }, 1000 );
            }
        }
    };

    FAQs.init();
})(jQuery);