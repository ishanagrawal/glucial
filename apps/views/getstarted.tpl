{include file="templates/header.tpl"}

		<!-- No Menu buttons on get started page 
        <div class="menu"><a href="#">register</a><a href="#">login</a></div> -->
</div> <!--- This div ends the header, do not remove. It is here to add menu buttons in the header -->

{literal}
<script type='text/javascript'>
    $(document).ready(function(){
        
        $('div#insideBodyID').html($('div#getStartedWrapper').html());
        //$('div#getStartedWrapper').html($('div#social-plugin').html());
        
        $('a#BackButton').live('click', function(){
            $('div#insideBodyID').html($('div#getStartedWrapper').html());    
        })
        
        $('a#NextButton').live('click', function(){
            $('div#insideBodyID').html($('div#socialLoginWrapper').html());
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
		//Ngocs interest selected code
		/*
        $('a#interest').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Cars</p></a></li>");
        })*/
		
		//Ritesh hard coded for now
		$('a#Cars').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Cars</p></a></li>");
			$('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Cars</p></a></li>");
        })
		$('a#Animals').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Animals</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Animals</p></a></li>");

        })
		$('a#Environment').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Environment</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Environment</p></a></li>");
			
        })
		$('a#Technology').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Technology</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Technology</p></a></li>");

        })
		$('a#Education').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Education</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Education</p></a></li>");

        })
		$('a#Politics').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Politics</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Politics</p></a></li>");

        })
		$('a#Religion').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Religion</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Religion</p></a></li>");

        })
		$('a#Food').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Food</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Food</p></a></li>");

       })
		$('a#Arts').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Arts</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Arts</p></a></li>");

        })
		$('a#Movies').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Movies</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Movies</p></a></li>");
        })
		$('a#Music').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Music</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Music</p></a></li>");
        })
		$('a#Sports').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Sports</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Sports</p></a></li>");
        })
		$('a#History').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>History</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>History</p></a></li>");
        })
		$('a#Science').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Science</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Science</p></a></li>");
        })
		$('a#Fitness').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Fitness</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Fitness</p></a></li>");
        })
		$('a#Travel').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Travel</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Travel</p></a></li>");
        })
		$('a#News').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>News</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>News</p></a></li>");
        })
		$('a#Philosophy').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Philosophy</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Philosophy</p></a></li>");

        })
		$('a#Entrepreneurship').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Entrepreneurship</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Entrepreneurship</p></a></li>");

        })
		$('a#Relationships').live('click', function(){
            //alert("Hi");
            $('ul#interest-selected').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Relationships</p></a></li>");
            $('ul#interest-selected2').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>Relationships</p></a></li>");
        })
		
        $('a#select-interest').live('click', function(){
            $(this).closest('li').remove();
        })
		
    })
	
</script>	

{/literal}
<div class="insideBody" id="insideBodyID"></div> <!-- End insideBody -->

<div id="getStartedWrapper" style="display:none">
            <div class='getStarted' id='interest-table'>
            		<h2 align="center">What do you love talking about?</h2>
                    <ul>
                        <li><a class="mediumbutton" id='Cars'><img /><h1>Cars</h1></a></li>
                        <li><a class="mediumbutton" id='Animals'><img /><h1>Animals</h1></a></li>
                        <li><a class="mediumbutton" id='Environment'><img /><h1>Environment</h1></a></li>
                        <li><a class="mediumbutton" id='Technology'><img /><h1>Technology</h1></a></li>
                        <li><a class="mediumbutton" id='Education'><img /><h1>Education</h1></a></li>
                    </ul>
                    <ul>
                        <li><a class="mediumbutton" id='Politics'><img /><h1>Politics</h1></a></li>
                        <li><a class="mediumbutton" id='Religion'><img /><h1>Religion</h1></a></li>
                        <li><a class="mediumbutton" id='Food'><img /><h1>Food</h1></a></li>
                        <li><a class="mediumbutton" id='Arts'><img /><h1>Arts</h1></a></li>
                        <li><a class="mediumbutton" id='Movies'><img /><h1>Movies</h1></a></li>
                    </ul>
                    <ul>
                        <li><a class="mediumbutton" id='Music'><img /><h1>Music</h1></a></li>
                        <li><a class="mediumbutton" id='Sports'><img /><h1>Sports</h1></a></li>
                        <li><a class="mediumbutton" id='History'><img /><h1>History</h1></a></li>
                        <li><a class="mediumbutton" id='Science'><img /><h1>Science</h1></a></li>
                        <li><a class="mediumbutton" id='Fitness'><img /><h1>Fitness</h1></a></li>
                    </ul>
                    <ul>
                        <li><a class="mediumbutton" id='Travel'><img /><h1>Travel</h1></a></li>
                        <li><a class="mediumbutton" id='News'><img /><h1>News</h1></a></li>
                        <li><a class="mediumbutton" id='Philosophy'><img /><h1>Philosophy</h1></a></li>
                        <li><a class="mediumbutton" id='Entrepreneurship'><img /><h1>Entrepreneurship</h1></a></li>
                        <li><a class="mediumbutton" id='Relationships'><img /><h1>Relationships</h1></a></li>
                    </ul>
	        </div> <!-- End getStarted -->
       <div class="feedbar">
			<p style="padding-left:45px">Your selected interests: </p>            
       		<ul id="interest-selected"></ul>
            <div id="NextButtonWrapper"><a href='#' class="smallbutton" id="NextButton"><h1>Next</h1></a></div>    
    </div> <!-- End feedbar -->
</div> <!-- End getStartedWrapper -->

<div id='redirect-link' style='display:none'>
    login.php
</div>


<div id='socialLoginWrapper' style='display:none'>
	<div class="interestsGathered">
    	<p style="padding-left:40px;">So we know you have these interests....</p>
    	<ul id="interest-selected2"></ul>
    </div>
	<div class="socialLogin">
    	<p>...but you can also add your existing interests on any of these social networks <br />(hint: its easy &amp; we work better this way)</p>
        {literal}
            <div id="loginDiv"></div>
            <script type="text/javascript">
                    gigya.services.socialize.showLoginUI(conf, {containerID: "loginDiv", cid:'', width:330, height:180,
                                    redirectURL: "login.php"
                                    ,showTermsLink:false
									,hideGigyaLink:true // remove 'Terms' and 'Gigya' links
									,buttonsStyle:'fullLogo'
									,extraFields: 'interests,activities'
									,lastLoginIndication: 'none'
									,pendingRegistration: 'true'
									,UIConfig: '<config><body><controls><snbuttons buttonsize="50"></snbuttons></controls></body></config>' 
                                    });
                    //gigya.services.socialize.addConnection(conf,{callback:printResponse, provider:'facebook'}); 		
            </script>
            
        {/literal}
		<div class="BackNextButtonWrapper">
        	<div id="BackButtonWrapper"><a href='#' class="smallbutton" id="BackButton"><h1>Back</h1></a></div>    
			<div id="NextButton2Wrapper"><a href='#' class="smallbutton" id="NextButton2"><h1>Next</h1></a></div>    
		</div>
    </div>
    
    
</div>

{include file="templates/footer.tpl"}