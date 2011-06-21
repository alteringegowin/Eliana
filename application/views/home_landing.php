<script language="javascript"> 
    $(document).ready(function() {
 
        $.featureList(
        $("#tabs li a"),
        $("#output li"), {
            start_item	:	1
        }
    );
    });
</script> 
<div id="content"> 
    <h1>Feature List</h1> 

    <p>This is a demo page. You can view the supporting article <a href="http://jqueryglobe.com/article/feature-list">here</a></p> 

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
        </ul> 

    </div> 
</div> 
<div class="clear"></div>