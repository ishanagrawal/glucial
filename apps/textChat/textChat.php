<?php
class chat{
	var $host="localhost";
	var $user="root";
	var $db="glucial";
	var $pass="ishan1";
	
	function connect_easy($query)
		{
			$b = array();
			if(!$connect = mysql_connect($this->host,$this->user,$this->pass));
			if(!$dbr = mysql_select_db($this->db));
			if(!($result = mysql_query($query)));
			@$num = mysql_num_rows($result);
			@$num2 = mysql_num_fields($result);
			for($x=0;$x<$num;$x++)
			{
				$a = mysql_fetch_array($result);
					for($i=0;$i<$num2;$i++)
					{
						$b[$x][$i] = html_entity_decode($a[$i]);
					}
			}
			return $b;
		}
		
	function show($a){
		if(count($a)>0){
			$a=array_reverse($a);
			if(count($a)<9)
				$end=count($a);
			else
				$end=9;
			for($i=0;$i<$end;$i++){
				echo "<p><font size=2 color=red>".$a[$i][0]."</font>: ".$a[$i][1]."</p>";
			}
		}
	}
	function main(){
		session_start();
		echo '<html><head><script language="JavaScript">
				function createRequestObject(){
			var request_;
			var browser = navigator.appName;
			if(browser == "Microsoft Internet Explorer"){
			 request_ = new ActiveXObject("Microsoft.XMLHTTP");
			}else{
			 request_ = new XMLHttpRequest();
			}
			return request_;
			}
			
			var http = new Array();
			var http2 = new Array();
				
			
			function getInfo(){
			
			var curDateTime = new Date();
			http[curDateTime] = createRequestObject();
			
			http[curDateTime].open(\'get\', \'refresh.php\');
			
			http[curDateTime].onreadystatechange = function(){
				if (http[curDateTime].readyState == 4) 
		    	{
		        	if (http[curDateTime].status == 200 || http[curDateTime].status == 304) 
		        	{
		           	 	var response = http[curDateTime].responseText;
		 				document.getElementById(\'view_ajax\').innerHTML = response;
		        	}
		    	}
			}
			
			http[curDateTime].send(null);
			}
			
			
			function getInfo2(){
			var curDateTime = new Date();
			http2[curDateTime] = createRequestObject();
			http2[curDateTime].open(\'get\', \'submit.php?chat=\'+ document.ajax.chat.value);
			console.log("reaches here");
			http2[curDateTime].send(null);
			}
			
			function send(){
			getInfo2();
			document.ajax.chat.value=" ";
			}
			
			
			function go(){
			getInfo();
			window.setTimeout("go()", 2000);
			}
			
			</script>
			</head><body onLoad="go()"><center>
			<div id="view_ajax" style="overflow=auto; width: 500px; height: 300px; border: 1px;" align="left">
			</div><br><form action="JavaScript: send()" method="get" name="ajax">
			<input type="text" name="chat">&nbsp;<input type="button" value="OK" onClick="send()">
			</form></center>
			</body></html>';
		}
}