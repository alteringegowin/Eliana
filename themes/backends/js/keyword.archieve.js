$(function () {
    hideLoading();
    $("#statistic").hide();
    $(".stats").hide();
    var siteUrl = $("meta[name=site_url]").attr('content');
    $(".datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

    $("#btn-keyword-submit").click(function(){
        showLoading();
        $("#statistic").hide();

        var data = $("#frm-keyword-submit").serialize();
        var urlTotalTweets = siteUrl+'/keyword/count_tweet/';
        var urlTotalUsers = siteUrl+'/keyword/count_user/';
        var urlCloud = siteUrl+'/keyword/get_cloud/';
        var urlFreq = siteUrl+'/keyword/get_freq/';
        
        $.when(
            $.post(urlTotalTweets,data,function(){},'json'),
            $.post(urlTotalUsers,data),
            $.post(urlFreq,data),
            $.post(urlCloud,data)).
        done(function(tweet,user,freq,cloud){
            $("#number-tweet-found").html(addCommas(tweet[0].tweets));
            $("#number-user-participate").html(addCommas(tweet[0].users));
            $("#number-tweet-impression").html(addCommas(tweet[0].followers));
            $("#tweet-stat-user").html(user[0]);
            $("#tweet-cloud").html(cloud[0]);
            $("#tweet-freq").html(freq[0]);
            $("#downloadbutton").attr('href',siteUrl+'/keyword/download/'+tweet[0].dstart+'/'+tweet[0].dend);
            
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
            
            
            $("#statistic").show();
            
            
            
            hideLoading();
            

        });
        
        return false;
        
    });
   
    function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    function showLoading() {
        $("#loading").show();
    }

    function hideLoading() {
        $("#loading").hide();
    }
    
    
});
