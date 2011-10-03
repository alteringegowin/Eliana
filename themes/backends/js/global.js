$(document).ready(function(){
    $(".buttonUI").button();

    // CSS tweaks
    $('#header #nav li:last').addClass('nobg');
    $('.block_head ul').each(function() {
        $('li:first', this).addClass('nobg');
    });
    $('.block form input[type=file]').addClass('file');
    
    $(".buttonUI").click(function(){
        $(this).blur();
    });
    var base_url = $("meta[name=base_url]").attr('content');
    
    
    // Tabs
    $(".tab_content").hide();
    $("ul.tabs li:first-child").addClass("active").show();
    $(".block").find(".tab_content:first").show();

    $("ul.tabs li").click(function() {
        $(this).parent().find('li').removeClass("active");
        $(this).addClass("active");
        $(this).parents('.block').find(".tab_content").hide();
			
        var activeTab = $(this).find("a").attr("href");
        $(activeTab).show();
		
        // refresh visualize for IE
        $(activeTab).find('.visualize').trigger('visualizeRefresh');
		
        return false;
    });
    
    $(".sortable").tablesorter( {
        sortList: [[1,0]]
    }); 
    $('.check_all').click(function() {
        $(this).parents('form').find('input:checkbox').attr('checked', $(this).is(':checked'));   
    });

    $('.block .block_head form .text').bind('click', function() {
        $(this).attr('value', '');
    });
});
