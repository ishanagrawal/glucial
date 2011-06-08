<?php /* Smarty version Smarty-3.0.7, created on 2011-06-04 01:44:40
         compiled from "/var/chroot/home/content/85/7868385/html/binhngoc/apps/views/chat.tpl" */ ?>
<?php /*%%SmartyHeaderCode:872080984de9f0789d6868-82011574%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67e7e15f488d4eae1b919251f68e378dd7fe5038' => 
    array (
      0 => '/var/chroot/home/content/85/7868385/html/binhngoc/apps/views/chat.tpl',
      1 => 1307170349,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '872080984de9f0789d6868-82011574',
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
			var apiKey = 907052; // OpenTok sample API key. Replace with your own API key.
			var sessionId = '<?php echo $_smarty_tpl->getVariable('opentok_sessionid')->value;?>
'; // Replace with your session ID.
			var token = '<?php echo $_smarty_tpl->getVariable('opentok_token')->value;?>
'; // Should not be hard-coded.
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
