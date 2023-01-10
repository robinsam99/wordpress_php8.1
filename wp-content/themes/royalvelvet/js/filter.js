jQuery(document).ready(function($){

    //Global variables
    var selectedCategory;

    /*********************
    * Homepage Filtering *
    **********************/
    var selectedLayout = 'grid',
        grid = $('#grid'),
        list = $('<div id="list"></div>');

    $(window).load(function() {
        var category = getUrlParameter('filter');
        if(category) {
            var dropdown_category = $('.top_level_filters li.'+category+' a').data('filter');

            $('.top_level_filters li a').removeClass('selected');
            $('.top_level_filters li.'+category+' a').addClass('selected');
            $('.filter_hidden ul li.'+category).trigger('click');

            filter_dropdown(dropdown_category, 2);
        }

        setTimeout(function() {
            if(selectedLayout === 'grid') {
                grid.isotopeMB('layout');
            } else {
                list.isotopeMB('layout');
            }
        }, 1000);
    });

    grid.mediaBoxes({
        boxesToLoadStart: 999,
        waitForAllThumbsNoMatterWhat: true,
        verticalSpaceBetweenBoxes: 20,
        horizontalSpaceBetweenBoxes: 20,
        LoadingWord: '<div class="spinner"><div class="cube1"></div><div class="cube2"></div></div>',
        resolutions: [
            {
                maxWidth: 768,
                columns: 3,
                columnWidth: 'auto'
            },
            {
                maxWidth: 640,
                columns: 2,
                columnWidth: 'auto'
            }
        ]
    });

    grid.isotopeMB({
        itemSelector: '.media-box',
        getSortData: {
            selectedCategory: function(itemElem) {
              return $(itemElem).hasClass(selectedCategory) ? 0 : 1;
            }
        }
    });

    if($('#list').length) {
        list.mediaBoxes({
            boxesToLoadStart: 999,
            columns: 1,
            verticalSpaceBetweenBoxes: 20,
            horizontalSpaceBetweenBoxes: 0,
            LoadingWord: '<div class="spinner"><div class="cube1"></div><div class="cube2"></div></div>',
            resolutions: [
                {
                    maxWidth: 768,
                    columns: 1,
                    columnWidth: 'auto'
                }
            ]
        });

        list.isotopeMB({
            itemSelector: '.media-box',
            getSortData: {
                selectedCategory: function(itemElem) {
                  return $(itemElem).hasClass(selectedCategory) ? 0 : 1;
                }
            }
        });
    }


    $('.filter_hidden ul li').click(function() {
        selectedCategory = $(this).data('category');

        $('.filter_hidden ul li').find('img').removeClass('selected');
        $(this).find('img').addClass('selected');

        $('.media-box-content .tags ul li').removeClass('selected');
        $('.'+selectedCategory).addClass('selected');

        if(selectedLayout === 'grid') {
            grid.isotopeMB('updateSortData');
            grid.isotopeMB({sortBy: 'selectedCategory'});
        } else {
            list.isotopeMB('updateSortData');
            list.isotopeMB({sortBy: 'selectedCategory'});
        }
    });

    if(getUrlParameter('filter')) {
        var count = 1;
    } else {
        var count = 0;
    }

    $('.top_level_filters li a').click(function(e) {
        e.preventDefault();
        count++;
        var clicked_filter = $(this).data('filter');

        $('.top_level_filters li a').removeClass('selected');
        $(this).addClass('selected');

        if(clicked_filter != '*') {
            filter_dropdown(clicked_filter, count);
        } else {
            //Reset filtering to default view
            count = 0;
            if(selectedLayout === 'grid') {
                grid.isotopeMB('updateSortData');
                grid.isotopeMB({sortBy: 'original-order'});
            } else {
                list.isotopeMB('updateSortData');
                list.isotopeMB({sortBy: 'original-order'});
            }

            $('.filter_hidden ul li').find('img').removeClass('selected');
            $('.media-box-content .tags ul li').removeClass('selected');
            filter_dropdown(null, count);
        }
    });

    //Tags Filtering
    $('.media-box-content .tags ul li').live('click', function(e) {
        selectedCategory = $(this).data('filter');
        var className = $(this).attr('class');

        if(!$(this).hasClass('selected')) {
            $('.media-box .tags li').removeClass('selected');
            $('.'+className).addClass('selected');
            $('.top_level_filters li a').removeClass('selected');
            $('.top_level_filters li.'+className+' a').addClass('selected');
            $('.filter_hidden li img').removeClass('selected');
            $('.filter_hidden li.'+className+' img').addClass('selected');

            if(selectedLayout === 'grid') {
                grid.isotopeMB('updateSortData');
                grid.isotopeMB({sortBy: 'selectedCategory'});
            } else {
                list.isotopeMB('updateSortData');
                list.isotopeMB({sortBy: 'selectedCategory'});
            }
        }

    });

    //Mediaboxes layout switch
    $('.layout_switch ul .grid').click(function() {
        if(!$(this).hasClass('active')) {
            $('.top_level_filters li a').removeClass('selected');
            $('.top_level_filters li:first-child a').addClass('selected');
            $('.filter_hidden li img').removeClass('selected');
            $('.layout_switch ul li').removeClass('active');

            $('.filter_hidden').slideUp('500');

            $(this).addClass('active');

            switch_mediabox_layout('grid');
        }
    });

    $('.layout_switch ul .list').click(function() {
        if(!$(this).hasClass('active')) {
            $('.top_level_filters li a').removeClass('selected');
            $('.top_level_filters li:first-child a').addClass('selected');
            $('.filter_hidden li img').removeClass('selected');
            $('.layout_switch ul li').removeClass('active');

            $('.filter_hidden').slideUp('500');

            $(this).addClass('active');

            switch_mediabox_layout('list');
        }
    });

    //Function to control which filter options are shown
    function filter_dropdown(filterType, count) {

        var active_filter = $('.'+filterType);

        if(count === 0) {
            //If "All" is clicked
            $('.filter_hidden').slideUp(500);
        } else if(count > 1) {
            //If one of the other filters are open
            $('.filter_hidden').css('display', 'none');
            $(active_filter).css('display', 'block');
        } else if(count === 1) {
            //Open selected filter
            $(active_filter).slideDown(500);
        }

    }

    function switch_mediabox_layout(layout) {
        var grid = $('#grid'),
            list = $('#list');

        if(layout === 'grid') {
            selectedLayout = layout;
            //Ajax call
            switch_layout(selectedLayout);

            //Remove both container elements
            grid.remove();
            list.remove();
            $('.media-boxes-load-more-button').remove();
        } else {
            selectedLayout = layout;
            //Ajax call
            switch_layout(selectedLayout);

            //Remove both container elements
            list.remove();
            grid.remove();
            $('.media-boxes-load-more-button').remove();
        }
    }


    var switch_layout = function(layout) {
        $.ajax({
            type		: "GET",
            data		: {action: "media_box_switch_layout", layout: layout},
            dataType	: "html",
            url			: ajaxObject.ajaxurl,
            beforeSend	: function() {
                var container = $('.media_boxes_container');
                grid.empty();
                list.empty();
                if(layout === 'grid') {
                    container.append(grid);
                } else {
                    container.append(list);
                }
            },
            success		: function(data) {
                $data = $(data);

                if($data.length){
                    if(layout === 'grid') {

                        grid.append($data);

                        grid.mediaBoxes({
                            boxesToLoadStart: 999,
                            columns: 4,
                            verticalSpaceBetweenBoxes: 20,
                            horizontalSpaceBetweenBoxes: 20,
                            LoadingWord: '<div class="spinner"><div class="cube1"></div><div class="cube2"></div></div>',
                            resolutions: [
                                {
                                    maxWidth: 640,
                                    columns: 2,
                                    columnWidth: 'auto'
                                }
                            ]
                        });

                        grid.isotopeMB({
                            itemSelector: '.media-box',
                            getSortData: {
                                selectedCategory: function(itemElem) {
                                  return $(itemElem).hasClass(selectedCategory) ? 0 : 1;
                                }
                            }
                        });

                        grid.on( 'arrangeComplete', function( event, laidOutItems ) {
                            grid.isotopeMB('layout');
                        });

                    } else {

                        list.append($data);

                        list.mediaBoxes({
                            boxesToLoadStart: 999,
                            columns: 1,
                            verticalSpaceBetweenBoxes: 20,
                            waitForAllThumbsNoMatterWhat: true,
                            horizontalSpaceBetweenBoxes: 0,
                            LoadingWord: '<div class="spinner"><div class="cube1"></div><div class="cube2"></div></div>',
                            resolutions: [
                                {
                                    maxWidth: 768,
                                    columns: 1,
                                    columnWidth: 'auto'
                                }
                            ]
                        });

                        list.isotopeMB({
                            itemSelector: '.media-box',
                            getSortData: {
                                selectedCategory: function(itemElem) {
                                  return $(itemElem).hasClass(selectedCategory) ? 0 : 1;
                                }
                            }
                        });

                        list.on( 'arrangeComplete', function( event, laidOutItems ) {
                            list.isotopeMB('layout');
                        });

                    }
                }
            },
            error		: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    };

    function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    }

});
