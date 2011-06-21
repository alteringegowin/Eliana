$(function () {
    
    var siteUrl = $("meta[name=site_url]").attr('content');
    $(".datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

    $("#btn-keyword-submit").click(function(){
        
        var data = $("#frm-tweep-statistic").serialize();
        var user_id = $("#input-user-id").val();
        var urlGrowth = siteUrl+'/tweep/get_growth/'+user_id;
        var urlStat = siteUrl+'/tweep/get_rt/'+user_id;
        var urlCloud = siteUrl+'/tweep/get_cloud/'+user_id;
        var urlRT = siteUrl+'/tweep/get_stat_rt/'+user_id;
        var urlMention = siteUrl+'/tweep/get_mention/'+user_id;
        
        $.when(
            $.post(urlGrowth,data),
            $.post(urlStat,data),
            $.post(urlCloud,data),
            $.post(urlRT,data),
            $.post(urlMention,data)
            
            ).done(
            function(growth,stat,cloud,rt,mention){
                $("#tweep-num").html(rt[0]);
                $("#tweep-growth").html(growth[0]);
                $("#tweep-stat").html(stat[0]);
                $("#tweep-cloud").html(cloud[0]);
                $("#tweep-mention").html(mention[0]);




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
