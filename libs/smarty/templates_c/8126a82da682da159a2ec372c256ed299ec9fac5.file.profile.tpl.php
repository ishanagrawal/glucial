<?php /* Smarty version Smarty-3.0.7, created on 2011-06-06 05:15:35
         compiled from "C:\wamp\www\glucial\apps\views\profile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:253314dec62778d81c8-94482663%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8126a82da682da159a2ec372c256ed299ec9fac5' => 
    array (
      0 => 'C:\\wamp\\www\\glucial\\apps\\views\\profile.tpl',
      1 => 1307327074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '253314dec62778d81c8-94482663',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!--Implement the request to chat using AJAX -> Will revert back to this user the link to chat with other people

Implement the -->
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

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


<center>
<!--<input type="button" onclick="Connect()" value="Connect to Facebook"   />
<div id="UserInfo">
    <div id="divUserName"></div>
    <div id="divUserPhoto"><img id="imgUserPhoto" src="http://www.gigya.com/wildfire/i/transparent.GIF" 
                       onerror="this.src='http://www.gigya.com/wildfire/i/transparent.GIF'" /></div>
</div>-->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

Thank <b><?php echo $_smarty_tpl->getVariable('fname')->value;?>
, <?php echo $_smarty_tpl->getVariable('lname')->value;?>
</b> for helping Glucial!
</center>
<br>

        <ul>
            <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('aUser')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
?>
                <li><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value['status'];?>

            <?php }} ?>
        </ul>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
    
<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>