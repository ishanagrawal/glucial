<STYLE>
		* { text-decoration: none;font-family: Verdana, Helvetica;  color:black; font-size:11px }
    a { color:#21536A;text-decoration: underline; font-size:11px; font-family:Verdana;  }
	    a:hover {color: black; text-decoration: none; font-size:11px;   }
	like_hov {font-family:Verdana; text-decoration: none; color:#21536A; color:#21536A;}

	H2 {
		FONT-SIZE: 16px; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #666666; FONT-FAMILY: Arial, Verdana, Helvetica, sans-serif; TEXT-DECORATION: none
		}
	.stars
	{
	  cursor:pointer;
	  cursor:hand;
	}
</STYLE>
<head>
<title>#title#</title>
</head>
<body>
<body bgcolor="#71828A">
<table width="100%" height="100%">
<tr>
  <td align="center" valign="middle">
	<TABLE  cellspacing="0" cellpadding="0">
	<tr>
	<td>
	  <table width="100%" border="0" style='height:6px;' cellspacing="0"> 
	  <tr>
	    <td background="#LTChatTemplatePath#img/chat_box/lt.bmp" style='width:4px;'></td>
	    <td bgcolor="White" style=""></td>
	    <td background="#LTChatTemplatePath#img/chat_box/rt.bmp" style='width:5px;'></td>
	  </tr>
	  </table>
	</td>
	</tr>
	<tr>
	  <td bgcolor="White" style="padding-left:5px;padding-right:5px;border-right:1px #7A7B7B solid;">
	  	 	<h2 align="center">#title#</h2>
			<form action="http://www.ajaxchat.org/bug.php" method="POST">
			<table cellspacing="2" cellpadding="2" width="100%"  width="100%" border="0">
			<tr>
			  <td style="width:100px;">Your Name:</td>
			  <td><input style="width:100%" maxlength="60" name="name" /></td>
			</tr>
			<tr>
			  <td>Your Email:</td>
			  <td><input style="width:100%" maxlength="60" name="user_email" /></td>
			</tr>
			<tr>
			  <td>Category:</td>
			  <td>
				<select style="width:100%" name="category_id">
				<option value="none" selected="selected">None</option>
				<option value="">Chat Interface</option> 
				<option value="310836">Admin</option>
				<option value="310837">Installation</option>
				<option value="310838">Coding Error</option>
				</select>
			  </td>
			</tr>
			<tr>
			</tr>
			<tr>
			  <td>Summary:</td>
			  <td><input style="width:100%" maxlength="60" name="summary" /></td></tr>
			<tr>
			  <td valign="top">Detail:</td>
			  <td><textarea name="details" rows="9" style="width:100%;"></textarea><br>
			  (please be as specific as possible)</td></tr>
			<tr>
			  <td valign="top"></td>
			  <td><input type="hidden" name="ver" value="#ver#"><input class="submit" type="submit" value="#submit#" name="submit" /></td>
			</tr>
			</table>
			</form>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table width="100%" border="0" style='height:7px;' cellspacing="0"> 
	    <tr>
	      <td background="#LTChatTemplatePath#img/chat_box/lb.bmp"	style='width:5px;'></td>
	      <td bgcolor="White" style=""></td>
	      <td background="#LTChatTemplatePath#img/chat_box/rb.bmp" style='width:5px;'></td>
	    </tr>
	    </table>
	  </td>
	</tr>
	</TABLE>
</body>