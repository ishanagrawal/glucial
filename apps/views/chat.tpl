<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Home</title>
		<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	</head>
	<body>
		<script type='text/javascript'>
			var apiKey = 907052; // OpenTok sample API key. Replace with your own API key.
			var sessionId = '{$opentok_sessionid}'; // Replace with your session ID.
			var token = '{$opentok_token}'; // Should not be hard-coded.
		</script>
		<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" ></script>
		<script src="views/js/opentok.js" ></script>
		<p>Hello, World!</p>
                <strong> {$name}</strong>
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
