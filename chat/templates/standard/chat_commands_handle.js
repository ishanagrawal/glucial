    var users_images = new Array();
	/**
    Usowa div a z prywatna wiadomoscia po nacisnieciu "zamknij"

    @param element(text) id elementu do usuniecia
    @see private_message_received()
   */
   function remove_msg(element)
   {
	 var el = document.getElementById(element);
	 el.parentNode.removeChild(el);
   }
   //-----------------------------------------------------------------------------------

   /**
    Wpisanie nowej wiadomosci do iframe z tekstem

    @param data(array) Informacje potrzebne do wyswietlenia wiadomosci
/*
      <datatype>msg</datatype>
      <user_name>test</user_name>
      <user_id></user_id>
  	  <time_stamp>2006-February-27 14:02:47</time_stamp>
      <hour>14</hour>
      <minute>02</minute>
      <second>47</second>
      <text>test</text>
      <id>5636</id>
      <is_command>false</is_command>
  	  <LTChatTemplatePath>./templates/standard/</LTChatTemplatePath>
*/

   function message_received(data)
   {
     var out = "";
   	 var img = users_images[data['user_name']];
/*			  if(!isset($out['other_options']['type_handle']))
			  	$out['other_options']['type_handle'] = 'info';*/

	 if(img == undefined)
	    img = "./img/avatars/noavatar.gif";
     if(data['is_command'] == "true")
     {
     	if(data['type_handle'] == 'error')
     	  out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td><span style='color:red;'><b>"+data['text']+"</b></span></td></tr></TABLE>";
     	else
     	  out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td><b>"+data['text']+"</b></td></tr></TABLE>";
     }
     else									out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td><img  src='"+img+"'></td><td width=100%><b>"+data['user_name']+"</b> (<span style='color:#aaaaaa;'>"+data['hour']+ ":"+data['minute']+ ":"+data['second']+"</span>)<br>"+data['text']+"</td></tr></TABLE>";

     document.getElementById("IFRAME_TEXT").contentWindow.document.getElementById("data").innerHTML += out;
     IFRAME_TEXT.scrollTo(0,document.getElementById("IFRAME_TEXT").contentWindow.document.body.scrollHeight);
   }
   //-----------------------------------------------------------------------------------
   
   function logout()
   {
     window.location.href = "logout.php?back="+escape(location.href);
   }
   
   /**
	  wyczyszczenie wszystkich wiadomosci w chacie
   */
   function clear_msg()
   {
     document.getElementById("IFRAME_TEXT").contentWindow.document.getElementById("data").innerHTML = '';
   }
   
   /**
    @param url(string) adres gdzie jest config do strony
   */
   function config_start(url)
   {
     window.open(url,"","width=530,height=440,scrollbars=1,resizable=1");
   }
   //-----------------------------------------------------------------------------------

   /**
     Kiedy uzytkownik uzywa komendy /prv to jest zwrot jaki dostanie !!!
   */
   function private_message_received_info(data)
   {
   	 if(data['text'] == "undefined")  data['text'] = " ";

     var out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\" ><tr><td><b>"+data['user_name']+"</b>: <span style='color:#AAAAAA'> ("+data['nick']+")</b> <a href='#' onclick='parent.config_start(\"" + data['link'] + "\")'><img  border='0' valign=middle src=\""+ChatTemplatePath+"img/prv_msg.bmp\"></a>	"+data['text']+"</span></td></tr></TABLE>";

     document.getElementById("IFRAME_TEXT").contentWindow.document.getElementById("data").innerHTML += out;
     IFRAME_TEXT.scrollTo(0,document.getElementById("IFRAME_TEXT").contentWindow.document.body.scrollHeight);
   }

   /**
    Wpisanie prywatnej wiadomosci do diva

    @param data(array) Informacje potrzebne do wyswietlenia wiadomosci
   */
   function private_message_received(data)
   {
     var out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\" ><tr><td><b>"+data['user_name']+"</b>: <a href='#' onclick='parent.config_start(\"./private.php?private_id="+data['user_id']+"\")'><img valign=middle src=\""+ChatTemplatePath+"img/prv_msg.bmp\" border=0></a> <span style='color:#AAAAAA'> "+data['text']+"</span></td></tr></TABLE>";

     document.getElementById("IFRAME_TEXT").contentWindow.document.getElementById("data").innerHTML += out;
     IFRAME_TEXT.scrollTo(0,document.getElementById("IFRAME_TEXT").contentWindow.document.body.scrollHeight);

   }
   //-----------------------------------------------------------------------------------

   /**
    Wpisanie Informacji o pokoju do pola w iframe
   */
   function change_room()
   {
   	 document.getElementById("LTuser_status").contentWindow.document.getElementById("data").innerHTML = "";
   	 var msg = str_replace("#room_name#",room,change_room_msg)
     document.getElementById("room").innerHTML = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td>"+msg+"</td></tr></TABLE>";
   }
   //-----------------------------------------------------------------------------------

   /**
    Funkcja ustawiajaca zmiany statusow w informacje

    @param data(array) Informacje o uzytkowniku
   */
   function user_status_received(data)
   {
	 var id_user = "uinfo"+data['users_id'];
     var out = "";

     if(data['online'] == 1)
       out = "<a href='javascript:parent.config_start(\"./private.php?private_id="+data['users_id']+"\")'><img src='"+ChatTemplatePath+"/img/online.gif' border=0>"+ data['nick']+"</a><BR>";
     else
       out = "<img src='"+ChatTemplatePath+"/img/offline.gif'> "+ data['nick']+"<BR>";

       
     users_images[data['nick']] = data['picture_url'];

     if(private_id >=0)
       return;

     if(data['online'] == 1 || data['friend'] == true)
     {
     	if(document.getElementById("LTuser_status").contentWindow.document.getElementById(id_user) == null)
     	  document.getElementById("LTuser_status").contentWindow.document.getElementById("data").innerHTML += "<div id='"+id_user+"'></div>";

     	document.getElementById("LTuser_status").contentWindow.document.getElementById(id_user).innerHTML = out;
     	document.getElementById("LTuser_status").contentWindow.document.getElementById(id_user).style.display = 'block';
     	
     }
     else
     {  
     	if(document.getElementById("LTuser_status").contentWindow.document.getElementById(id_user) != null)
     	  document.getElementById("LTuser_status").contentWindow.document.getElementById(id_user).style.display = 'none';
     }
   }
   //-----------------------------------------------------------------------------------

   var isNS4 = (navigator.appName=="Netscape")?1:0;
   function key_u(code)
   {
     if(code == 13)
     {
       send_info(document.getElementById('message').value);
       document.getElementById('message').value = '';
     }
   }
