$(function () {
    
    var siteUrl = $("meta[name=site_url]").attr('content');
    $(".datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

    $("#btn-keyword-submit").click(function(){
        
        var data = $("#frm-tweep-statistic").serialize();
		var keyword = $("#input-keyword").val();
        var urlBar = siteUrl+'/mydashboard/sentiment_bar/'+keyword;

        
        $.when(
            $.post(urlBar,data)
            
            ).done(
            function(stats){
                $("#tweep-growth").html(stats);




                // Web stats
                $('table.stats').each(function() {
                    if($(this).attr('rel')) {
                        var statsType = $(this).attr('rel');
                    } else {
                        var statsType = 'area';
                    }
                    var chart_width = ($(this).parent('div').width()) - 60;
		
				
                    if(statsType == 'line' || statsType == 'pie') {		
                        $(this).hide().visualize({
                            type: statsType,	// 'bar', 'area', 'pie', 'line'
                            width: chart_width,
                            height: '240px',
                            colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c'],
				
                            lineDots: 'double',
                            interaction: true,
                            multiHover: 5,
                            tooltip: true,
                            tooltiphtml: function(data) {
                                var html ='';
                                for(var i=0; i<data.point.length; i++){
                                    html += '<p class="chart_tooltip"><strong>'+data.point[i].value+'</strong> '+data.point[i].yLabels[0]+'</p>';
                                }	
                                return html;
                            }
                        });
                    } else {
                        $(this).hide().visualize({
                            type: statsType,	// 'bar', 'area', 'pie', 'line'
                            width: chart_width,
                            height: '240px',
                            colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c']
                        });
                    }
                });
            
            });
        return false;
    });


});