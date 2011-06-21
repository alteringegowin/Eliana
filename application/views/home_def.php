<script>
    $(document).ready(function(){
        $("#sort-col2").tablesorter( {
            sortList: [[3,1]]
        }); 
        
        $.featureList($("#tabs li a"),$("#output li"), {start_item	:	1});
 
        
    });
</script>

<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Dashboard</h2>
    </div>
    <div class="block_content">
        <h3>Welcome to elliana</h3>
        <p>&nbsp;</p>
        <hr /> 
        <div id="feature_list"> 
            <ul id="tabs"> 
                <li> 
                    <a href="javascript:;"> 
                        <img src="images/services.png" /> 
                        <h3>Services</h3> 
                        <span>Lorem ipsum dolor sit amet consect</span> 
                    </a> 
                </li> 
                <li> 
                    <a href="javascript:;"> 
                        <img src="images/programming.png" /> 
                        <h3>Programming</h3> 
                        <span>Lorem ipsum dolor sit amet consect</span> 
                    </a> 
                </li> 
                <li> 
                    <a href="javascript:;"> 
                        <img src="images/applications.png" /> 
                        <h3>Applications</h3> 
                        <span>Lorem ipsum dolor sit amet consect</span> 
                    </a> 
                </li> 
                <li> 
                    <a href="javascript:;"> 
                        <img src="images/programming.png" /> 
                        <h3>Programminxg</h3> 
                        <span>Lorem ipsum dolor sit amet consect</span> 
                    </a> 
                </li> 
            </ul> 
            <ul id="output"> 
                <li> 
                    <img src="images/sample1.jpg" /> 
                    <a href="#">See project details</a> 
                </li> 
                <li> 
                    <img src="images/sample2.jpg" /> 
                    <a href="#">See project details</a> 
                </li> 
                <li> 
                    <img src="images/sample3.jpg" /> 
                    <a href="#">See project details</a> 
                </li> 
                <li> 
                    <img src="images/samplex1.jpg" /> 
                    <a href="#">See project details</a> 
                </li> 
            </ul> 

        </div> 
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
<!-- .login ends -->
