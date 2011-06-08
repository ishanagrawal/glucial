var request_interval;

var out_print_r = "";
function print_r(theObj)
{
  if(theObj.constructor == Array || theObj.constructor == Object)
  {
    out_print_r += "<ul>";
    for(var p in theObj)
    {
      if(theObj[p].constructor == Array || theObj[p].constructor == Object)
      {
        out_print_r += "<li>["+p+"] => "+typeof(theObj)+"</li>";
        out_print_r += "<ul>";
        print_r(theObj[p]);
        out_print_r += "</ul>";
      }
      else
      {
        out_print_r += "<li>["+p+"] => "+theObj[p]+"</li>";
      }
    }
    out_print_r += "</ul>";
  }
}
	function str_replace(str_find, str_replace, str_normal)
	{
	  var int_case_insensitive = true;
	  if (arguments.length<3 || str_find=="" || str_normal=="" || typeof("".split)!="function")
	    return(str_normal);
	
	  //no parm means default, "case SENSITIVE"...
	  if(!(int_case_insensitive))
	  return(str_normal.split(str_find)).join(str_replace);
	
	  str_find=str_find.toLowerCase();
	
	  var rv=""; 
	  var ix=str_normal.toLowerCase().indexOf(str_find);
	  while(ix>-1)
	  {
	    rv+=str_normal.substring(0,ix)+str_replace;
	    str_normal=str_normal.substring(ix+str_find.length);
	    ix=str_normal.toLowerCase().indexOf(str_find);
	  };
	  return(rv+str_normal);
	}

  function send_info(message, login)
  {
      http_request2 = false;
      if (window.XMLHttpRequest)
      {
         http_request2 = new XMLHttpRequest();
         if (http_request2.overrideMimeType)
         {
            http_request2.overrideMimeType('text/xml');
         }
      }
      else if (window.ActiveXObject)
      {
         try
         {
            http_request2 = new ActiveXObject("Msxml2.XMLHTTP");
         }
         catch (e)
         {
            try
            {
               http_request2 = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
         }
      }
      if (!http_request2)
      {
         alert('Cannot create XMLHTTP instance');
         return false;
      }

      http_request2.open('POST', 'senddata.php', true);
	  http_request2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	  if(login == undefined)  login = '';
	  message = str_replace("&","#and#",message);
	  login = str_replace("&","#and#",login);
	  http_request2.send('login='+login+'&datatype='+datatype+'&private_id='+private_id+'&room='+room+'&msg='+message);
  }

   var http_request = false;
   function makeRequest(url, parameters)
   {
      http_request = false;
      if (window.XMLHttpRequest)
      {
         http_request = new XMLHttpRequest();
         if (http_request.overrideMimeType)
         {
            http_request.overrideMimeType('text/xml');
         }
      }
      else if (window.ActiveXObject)
      {
         try
         {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
         }
         catch (e)
         {
            try
            {
               http_request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
         }
      }
      if (!http_request)
      {
         alert('Cannot create XMLHTTP instance');
         return false;
      }
      http_request.onreadystatechange = alertContents;
      http_request.open('GET', url + parameters, true);
      http_request.send(null);
   }

   function load_template(data)
   {   	
	  config_start('command_tpl.php?load_template='+data['load_template']+'&other_vars='+data['other_vars']);
   }

   var do_xml_reading = false;

   var last_id = 0;
   var msg_last_id = 0;
   var user_status_last_id = 0;
   var prv_msg_last_id = 0;

   function alertContents()
   {
       if (http_request.readyState == 4)
       {
         if (http_request.status == 200)
         {
            var xmldoc = http_request.responseXML;
            var root = xmldoc.getElementsByTagName('results').item(0);

            if(root != null)
	            for (var iNode = 0; iNode < root.childNodes.length; iNode++)
	            {
	               var node = root.childNodes.item(iNode);
	               for (i = 0; i < node.childNodes.length; i++)
	               {
	                  var sibl = node.childNodes.item(i);
	                  var len = parseInt(sibl.childNodes.length / 2);
			          var data = new Array();
			          var time = "";
	
	                  for (x = 0; x < sibl.childNodes.length; x++)
	                  {
	                     var sibl2 = sibl.childNodes.item(x);
	                     var sibl3;
	                     if (sibl2.childNodes.length > 0)
	                     {
	                        sibl3 = sibl2.childNodes.item(0);
	   						var node_name = sibl.childNodes.item(x).nodeName;
	
	   						if(node_name == 'time_stamp')		time = sibl3.data;
	                        if(node_name == 'id' && sibl3.data != "null")			last_id = sibl3.data;
	
	   						 var node_value = sibl3.data;
	   						 node_value = str_replace("#pale_close#", ">", node_value);
						     node_value = str_replace("#pale_open#", "<", node_value);
						     node_value = str_replace("#star#", "*", node_value);
						     node_value = str_replace("#and#", "&", node_value);
						     node_value = str_replace("#hash#", "#", node_value);
	
	   						data[node_name] = node_value;
	                     }
	                  }

					  if(data['datatype'] == "template" && data['load_template'] != '')
					  {
						load_template(data);
						if(private_id < 0)
	                      msg_last_id = data['id'];
	                    else
	                      prv_msg_last_id = data['id'];
					  }

	                  if(data['datatype'] == 'change_room')
	                  {
					     last_id = 0;
					     msg_last_id = 0;
					     user_status_last_id = 0;
					     room = data['new_room'];
						 change_room();
					     message_received(data);
	                  }
	                  else if(data['datatype'] == 'msg')
	                  {
	                    msg_last_id = data['id'];
						message_received(data);
	                  }
	                  else if(data['datatype'] == 'prv_msg_send')
	                  {
	                    msg_last_id = data['id'];
						private_message_received_info(data);
	                  }
	                  else if(data['datatype'] == 'shoutbox_msg')
	                  {
	                    msg_last_id = data['id'];
						shoutbox_message_received(data);
	                  }
	                  else if(data['datatype'] == 'private_msg')
	                  {
	                    prv_msg_last_id = data['id'];
						private_message_received(data);
	                  }
	                  else if(data['datatype'] == 'user_status')
	                  {
	                  	if(data['action'] == true)
	                      user_status_last_id = data['id'];
						user_status_received(data);
	                  }
	                  else if(data['datatype'] == 'functions' && data['function'] != '')
	                  {
	                  	if(data['function'] == 'clear')
	                  	  clear_msg();
	                  	else if(data['function'] == 'logout')
	                  	  logout();
	                  }
	               }
	            }
      		do_xml_reading = false;
         }
         else
         {
            alert('There was a problem with the request.');
         }
      }

   }

//-----------------------------------------------------------------------------

   var req_counter=0;
   function do_xml()
   {
   	  req_counter++;
   	  if(do_xml_reading == true) return;
   	  do_xml_reading = true;
   	  
   	  today = new Date();
   	  var stamp = today.getDay()+"+"+today.getHours()+"+"+today.getMinutes()+"+"+today.getSeconds()+"+"+today.getMilliseconds();  
   	  makeRequest('getdata.php', '?datatype='+datatype+'&prv_msg_last_id='+prv_msg_last_id+'&msg_last_id='+msg_last_id+'&user_status_last_id='+user_status_last_id+'&room='+room+'&today='+stamp+'&private_id='+private_id);
   }

   function LTStart()
   {
     request_interval = window.setInterval(do_xml,refresh_after);

     if(datatype == 'all_data')
       change_room();
   }
/*
   today = new Date();
   var stamp = today.getDay()+"+"+today.getHours()+"+"+today.getMinutes()+"+"+today.getSeconds()+"+"+today.getMilliseconds();  
   document.write('getdata.php?datatype='+datatype+'&msg_last_id='+msg_last_id+'&user_status_last_id='+user_status_last_id+'&room='+room+'&today='+stamp+'&private_id='+private_id+'<BR>');
*/
   window.onload=LTStart;
