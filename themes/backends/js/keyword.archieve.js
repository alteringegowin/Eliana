$(function () {
    $(".sentiment-positif" ).button({
        icons: {
            primary: "ui-icon-plus"
        },
        text: false
    });
    $(".sentiment-negatif" ).button({
        icons: {
            primary: "ui-icon-minus"
        },
        text: false
    });
    $(".sentiment-ask" ).button({
        icons: {
            primary: "ui-icon-help"
        },
        text: false
    });
    $(".sentiment-netral" ).button({
        icons: {
            primary: "ui-icon-cancel"
        },
        text: false
    });
    
    $(".sentiment").click(function(){
        var url = $(this).attr("href");
        $.get(url,function(){
            location.reload(true);
        });
        return false;
    });
	
});
