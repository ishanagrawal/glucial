<html>
<head>
    <title>Gigya Example</title>

    <!-- Step 1 - Including the socialize.js script: -->
    <script type="text/javascript" src="http://cdn.gigya.com/JS/socialize.js?apikey=2_Wj_OfPXRfKyWZM7quHHtfN8bTjZgGvrxIh6cRrnnwK9WLa_j27FeSm1Yl-DkQiXF" ></script>

    <script type="text/javascript" >
   
    // Step 2 - Define a configuration object. Insert your Gigya APIKey below:
    //var conf = { 
    //    APIKey: "2_Wj_OfPXRfKyWZM7quHHtfN8bTjZgGvrxIh6cRrnnwK9WLa_j27FeSm1Yl-DkQiXF",
    //    enabledProviders: "facebook,twitter"
    //};
	var conf = { APIKey: '2_Wj_OfPXRfKyWZM7quHHtfN8bTjZgGvrxIh6cRrnnwK9WLa_j27FeSm1Yl-DkQiXF'};
   
    function Connect()
    {
        // Step 3 - Define parameters object:
        var params = {
           callback: onConnectionAdded,
           provider: "facebook"

        };   
   
        // Step 4 - Calling the Gigya API method - addConnection:
        gigya.services.socialize.addConnection(conf, params);
    }
   
    // Step 5 - Define callback function:
    function onConnectionAdded(response)
    {
        if (response.errorCode == 0)
        {
            // Update the page with the data received in the response:

            // inject the user's nickname to the "divUserName" div 
            document.getElementById('divUserName').innerHTML = response.user.nickname;
            // inject the user's photo to the image "src" attribute.
            document.getElementById('imgUserPhoto').src=response.user.photoURL;
        }
        else
        {
            //handle errors
            alert("An error has occurred!" + '\n' + 
                "Error details: " + response.errorMessage + '\n' +
                "In method: " + response.operation);
        }
    }   
   function storeUser(response)
   {
   
   }
   
   gigya.services.socialize.addConnection(conf,{callback:printResponse, provider:'facebook'}); 
  </script>
 
</head>
<body >
<?php
echo "Welcome ".$_GET['fname']."! This is going to be your profile page";
?>
    <center>
    <input type="button" onclick="Connect()" value="Connect to Facebook"   />
    <div id="UserInfo">
        <div id="divUserName"></div>
        <div id="divUserPhoto"><img id="imgUserPhoto" src="http://www.gigya.com/wildfire/i/transparent.GIF" 
                           onerror="this.src='http://www.gigya.com/wildfire/i/transparent.GIF'" /></div>
    </div>
    </center>
	
</body>
</html>