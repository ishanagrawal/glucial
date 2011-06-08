<?php /* Smarty version Smarty-3.0.7, created on 2011-06-06 05:14:07
         compiled from "C:\wamp\www\glucial\apps\views\templates/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:166004dec621fac4860-54942867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfcd4a98b731daff494eec4727a5216d0c1afcee' => 
    array (
      0 => 'C:\\wamp\\www\\glucial\\apps\\views\\templates/footer.tpl',
      1 => 1307330547,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '166004dec621fac4860-54942867',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
    <div class="footer">&copy; Glucial Inc. All rights reserved.</div>
</body>
<?php if ($_smarty_tpl->getVariable('is_login')->value=='y'){?>
    <script type='text/javascript'>
        setInterval(ping_server(<?php echo $_smarty_tpl->getVariable('uid')->value;?>
), 30000);
    </script>
<?php }?>
</html>
