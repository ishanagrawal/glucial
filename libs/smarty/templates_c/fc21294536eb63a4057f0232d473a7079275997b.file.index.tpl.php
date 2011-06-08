<?php /* Smarty version Smarty-3.0.7, created on 2011-06-04 01:20:56
         compiled from "D:/Conveee/xampp2/htdocs/conveee/apps/views/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:240044de96c58d317d8-56703485%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc21294536eb63a4057f0232d473a7079275997b' => 
    array (
      0 => 'D:/Conveee/xampp2/htdocs/conveee/apps/views/index.tpl',
      1 => 1307143253,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '240044de96c58d317d8-56703485',
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
		<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" ></script>
		<script src="views/js/opentok.js" ></script>
		<p>Hello, World!</p>
                <strong> <?php echo $_smarty_tpl->getVariable('name')->value;?>
</strong>
		<!--<iframe id="basicEmbed" src="https://api.opentok.com/hl/embed/1embb3190d3153cae4aabe1e26fd19f0aa00360d" width="500" height="340" style="border:none"></iframe>-->
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
