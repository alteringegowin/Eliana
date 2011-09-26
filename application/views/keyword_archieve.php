<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords</h2>
    </div>
    <div class="block_content">
        <form id="frm-keyword-submit" action="<?php echo site_url('keyword/filter_keyword') ?>" method="post">
            <p>
                <label>From:</label>
                <input type="text" class="tiny datepicker" name="start" value="">
                <label>Until:</label>
                <input type="text" class="tiny datepicker" name="end" value="">
            </p>  

            <p>
                <?php echo form_hidden('keyword', $keyword) ?>
                <input type="submit" class="submit mid" id="btn-keyword-submit" value="Show">
            </p>
        </form>

        <hr/>
        <div id="loading">loading...</div>
        <div id="statistic" class="ui-widget">
            
            <div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
                <div>Download File CSV</div>
                <a id="downloadbutton" href="#">Download</a>
            </div>
            <div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
                <div>Total Tweet Found</div>
                <div class="number" id="number-tweet-found"></div>
            </div>
            <div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
                <div>Total User Participate</div>
                <div class="number" id="number-user-participate"></div>
            </div>
            <div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
                <div>Total Impression</div>
                <div class="number" id="number-tweet-impression"></div>
            </div>
            <div class="clear"></div>


        </div>

        <div id="tweet-stat-user" class="tweet-reg"></div>
        <div id="tweet-cloud" class="tweet-reg"></div>
        <div id="tweet-freq" class="tweet-reg">
            <table class="stats" rel="line" cellpadding="0" cellspacing="0" width="100%"> 
                <thead> 
                    <tr> 
                        <td>&nbsp;</td> 
                    </tr> 
                </thead> 

                <tbody> 
                    <tr> 
                        <th>Page views</th> 
                    </tr> 

                    <tr> 
                        <th>Unique visitors</th>								
                    </tr> 
                </tbody> 
            </table> 

        </div>

    </div>		
    <!-- .block_content ends --> 

    <div class="bendl"></div> 
    <div class="bendr"></div> 

</div>
