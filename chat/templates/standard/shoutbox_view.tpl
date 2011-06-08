<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<style>
* {font-family : Verdana, Arial, Helvetica, sans-serif; font-size : 11px; }
</style>
<SCRIPT>
   /**
    Wpisanie nowej wiadomosci do iframe z tekstem

    @param data(array) Informacje potrzebne do wyswietlenia wiadomosci
   */
   var msg_my_counter = 0
   function shoutbox_message_received(data)
   {
   	 msg_my_counter++;

   	 if(data['user_name'] == undefined)  data['user_name'] = " ";

     var out = "";
     if(msg_my_counter % 2)
       out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\" class=\"shbox_msg1\"><tr><td style='font-family : Verdana, Arial, Helvetica, sans-serif;font-size:12px;'><b>"+data['user_name']+"</b>: "+data['text']+"</td></tr></TABLE>";
     else
       out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\" class=\"shbox_msg2\"><tr><td style='font-family : Verdana, Arial, Helvetica, sans-serif;font-size:12px;'><b>"+data['user_name']+"</b>: "+data['text']+"</td></tr></TABLE>";

     document.getElementById("IFRAME_TEXT").contentWindow.document.getElementById("data").innerHTML += out;
     IFRAME_TEXT.scrollTo(0,document.getElementById("IFRAME_TEXT").contentWindow.document.body.scrollHeight);
   }
   //-----------------------------------------------------------------------------------
   
   /**
    Zmienna na podstawie ktorej tworzone sa nowe id do div-ow
   */
   var msg_counter=0;

   var isNS4 = (navigator.appName=="Netscape")?1:0;
   function key_u(code)
   {
     if(code == 13)
     {
       send_info(document.getElementById('message').value, document.getElementById('login').value);
       document.getElementById('message').value = '';
     }
   }
   
   /**
    Zmienne potrzebne do poprawnego wyswietlenia chata nie zmieniaj ich chyba ze wiesz co robisz
   */
   var room = '';
   var datatype = 'shoutbox';
   var private_id = "#sbox_id#";
   var refresh_after = '#refresh_after#';

</SCRIPT>
<LINK REL="STYLESHEET" HREF="#css_link#" TYPE="text/css">
<script language="JavaScript" type="text/javascript" src="#LTChatTemplatePath#chat_functions.js"></script>
</head>
<body leftmargin=0 topmargin=0>
<table class="shboxmaintab" cellspacing="1" cellpadding="1" border="0" width="100%" height="100%">
  <tr>
    <td><IFRAME width="100%" height="100%" frameborder="0" scrolling="auto" name="IFRAME_TEXT" id="IFRAME_TEXT" src='iframe.php?type=shoutbox_frame'></IFRAME></td>
  </tr>
  <tr>
    <td style="height:10px;"><b>#login#:</b> <input type="text" id="login" class="chboxinput"></td>
  </tr>
  <tr>
    <td style="height:10px;"><b>#message#:</b><br><TEXTAREA name='message' rows="3" id='message' class="chboxinput" onkeypress="if(this.value.length > 255) this.value = this.value.substring(0, 255);" onKeyup="if(!isNS4){  key_u(event.keyCode);  } else { key_u(event.which);}" style="width:100%;"></TEXTAREA></td>
  </tr>
  <tr>
    <td style="height:10px;"><input type="button" class="chboxbutton" value="#send#" onclick="key_u(13);"> </td>
  </tr>
</table>
</body>
</HTML>
