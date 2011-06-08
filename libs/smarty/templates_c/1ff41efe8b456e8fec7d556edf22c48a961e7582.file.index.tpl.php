<?php /* Smarty version Smarty-3.0.7, created on 2011-06-03 23:00:58
         compiled from "/var/chroot/home/content/85/7868385/html/binhngoc/apps/views/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2149076794de9ca1a6d66d5-84033907%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ff41efe8b456e8fec7d556edf22c48a961e7582' => 
    array (
      0 => '/var/chroot/home/content/85/7868385/html/binhngoc/apps/views/index.tpl',
      1 => 1307167232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2149076794de9ca1a6d66d5-84033907',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Home</title>
		<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	</head>
	<body>
		<script type='text/javascript'>
			var apiKey = <?php echo 907052;?>
; // OpenTok sample API key. Replace with your own API key.
			var sessionId = <?php echo $_smarty_tpl->getVariable('opentok_sessionid')->value;?>
; // Replace with your session ID.
			var token = <?php echo $_smarty_tpl->getVariable('opentok_token')->value;?>
; // Should not be hard-coded.
		</script>
		<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" ></script>
		<script src="views/js/opentok.js" ></script>
		<p>Hello, World!</p>
                <strong> <?php echo $_smarty_tpl->getVariable('name')->value;?>
</strong>
		<div id="opentok_console"></div>
		<div id="links">
			<input type="button" value="Connect" id ="connectLink" onClick="javascript:connect()" />
			<input type="button" value="Leave" id ="disconnectLink" onClick="javascript:disconnect()" />
			<input type="button" value="Start Publishing" id ="publishLink" onClick="javascript:startPublishing()" />
			<input type="button" value="Stop Publishing" id ="unpublishLink" onClick="javascript:stopPublishing()" />
		</div>
		<div id="myCamera" class="publisherContainer"></div>
		<div id="subscribers"></div>
		
	</body>
</html>
