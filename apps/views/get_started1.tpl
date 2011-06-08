{include file="templates/header.tpl"}
{literal}
<script type='text/javascript'>
    $(document).ready(function(){
        
        //$('div#getStartedWrapper').html($('div#interest-selection').html());
        $('div#getStartedWrapper').html($('div#social-plugin').html());
        
        $('a#back').live('click', function(){
            $('div#getStartedWrapper').html($('div#interest-selection').html());    
        })
        
        $('a#NextButton').live('click', function(){
            $('div#getStartedWrapper').html($('div#social-plugin').html());
	//    $('ul#interest-selected li').each(function(){
	//	$('div#redirect-link').append($(this).value)
	//    })
        })
        
        //$('#interest-table td.mediumbutton').each(function(){
        //    
        //    $(this).click(function(){
        //        alert("Hi");
        //    })
        //})
        $('a#interest').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Cars</p></a></li>");
        })
        $('a#select-interest').live('click', function(){
            $(this).closest('li').remove();
        })
    })
</script>

<script type="text/javascript" lang="javascript" 
	   src="http://cdn.gigya.com/JS/socialize.js?apikey=2_Wj_OfPXRfKyWZM7quHHtfN8bTjZgGvrxIh6cRrnnwK9WLa_j27FeSm1Yl-DkQiXF">
	</script>
	<script type="text/javascript">
	   var conf = { APIKey: '2_Wj_OfPXRfKyWZM7quHHtfN8bTjZgGvrxIh6cRrnnwK9WLa_j27FeSm1Yl-DkQiXF'};
        // Changing the default look and behavior of the Plugin using the 'params' object:
        var params =
        {
            showTermsLink:false, // 'terms' link is hidden
            headerText:"Please Login using one of the following providers:", // adding header text
            height:60, // changing default Plugin size
            width:220,  // changing default Plugin size
            cid:'',       
            
            containerID:"loginDiv", // The Plugin will embed itself inside the "loginDiv" DIV (will not be a popup) 
            
            // Changes to the default design of the Plugin's design
            //     Background color is changed to purple, text color to gray and button size is set to 40 pixels:    
            UIConfig:'<config><body><texts color="#DFDFDF"></texts><controls><snbuttons buttonsize="40"></snbuttons></controls><background background-color="#51286D"></background></body></config>',
        
            // Change the buttons design style to the 'fullLogo' style:
            buttonsStyle:'fullLogo',
            
            // After successful login - the user will be redirected to "www.MySite.com/welcome.html" :   
            redirectURL: "http://localhost/login.php"
          
}

        </script>
{/literal}
    <div class="insideBody">
    	<div id="getStartedWrapper">
        </div>
        
    </div>
<!--    <div class="feedbar">            
        <ul id="interest-selected">
                
        </ul>
        <a href='#' class="smallbutton" id="NextButton"><h1>Next</h1></a>    
    </div>-->
    
    
    
<div id='interest-selection' style='display:none'>
        <h2 align="center">What do you love talking about?</h2>
        <div class='getStarted' id='interest-table'>
            <ul>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Animals</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
            </ul>
            <ul>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
            </ul>
            <ul>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
            </ul>
            <ul>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
                <li><a href='#' class="mediumbutton" id='interest'><h1>Cars</h1></a></li>
            </ul>
        </div>
        <!--<table class="getStarted" id='interest-table'>
        	 <tr>
            	<td class="mediumbutton"><a href='#' id='interest'><h1>Cars</h1></a></td>
            	<td class="mediumbutton"><h1>Animals</h1></td>
            	<td class="mediumbutton"><h1>Environment</h1></td>
            	<td class="mediumbutton"><h1>Sports</h1></td>
            </tr>
            <tr>
            	<td class="mediumbutton"><h1>Politics</h1></td>
            	<td class="mediumbutton"><h1>Technology</h1></td>
            	<td class="mediumbutton"><h1>Food</h1></td>
            	<td class="mediumbutton"><h1>Religion</h1></td>
            </tr>
            <tr>
            	<td class="mediumbutton"><h1>Travel</h1></td>
            	<td class="mediumbutton"><h1>Photography</h1></td>
            	<td class="mediumbutton"><h1>Health</h1></td>
            	<td class="mediumbutton"><h1>Entrepreneurship</h1></td>
            </tr>
            <tr>
            	<td class="mediumbutton"><h1>Science</h1></td>
            	<td class="mediumbutton"><h1>History</h1></td>
            	<td class="mediumbutton"><h1>Love &amp; Relationships</h1></td>
            	<td class="mediumbutton"><h1>Reading</h1></td>
            </tr>
        </table>-->
</div>
<div id='redirect-link' style='display:none'>
    login.php
</div>
<div id='social-plugin' style='display:none'>
    <p>Please sign in using one of the following providers:</p>
    {literal}
    
        <div id="loginDiv"></div>
        <script type="text/javascript">
                gigya.services.socialize.showLoginUI(conf, {containerID: "loginDiv", cid:'', width:220, height:60,
                                redirectURL: "login.php",
                                showTermsLink:false, hideGigyaLink:true // remove 'Terms' and 'Gigya' links
                                });
                //gigya.services.socialize.addConnection(conf,{callback:printResponse, provider:'facebook'}); 		
        </script>
        
    {/literal}
</div>

{include file="templates/footer.tpl"}
