<!--Implement the request to chat using AJAX -> Will revert back to this user the link to chat with other people

Implement the -->
{include file="templates/header.tpl"}

{literal}
<script type='text/javascript'>

$('div#addInterestButton').live('click', function(){
		//alert(getElementById('interestInput').value);
		if(document.getElementById('interestInput').value== ""){
			return;
		}else{
		$('ul#userInterestList').append("<li id='interest'><a class='smallbutton' href='#' id='select-interest'><p>" + document.getElementById('interestInput').value + "</p></a></li>");
    	document.getElementById('interestInput').value= "";
		}
		
});
$('a#select-interest').live('click', function(){
            $(this).closest('li').remove();
});


$('div#searchButton').live('click', function(){
	
		// If search bar was blank, then ignore
		if(document.getElementById('searchBarInput').value== ""){
			return;
		}//else populate the list of matched users
		else{
			//clear previous list of matched users
			document.getElementById('matchedUserList').innerHTML="";
			
			//get list of users based on matched interest
			
			//add them to the list in UI one by one
			$('ul#matchedUserList').append("<li id='matchedUserWrapper'><p>test</p></li>");
			
			
			//clear input field
			document.getElementById('searchBarInput').value= "";
		}
		
});



</script>
{/literal}
        <div class="menu"><a href="#" class="xtrsmallbutton"><p>Logout</p></a><a href="#" class="xtrsmallbutton"><p>Account</p></a></div>
</div> <!--- This div ends the header, do not remove. It is here to add menu buttons in the header -->
<div class="profileBodyWrapper">
	<div class="userBar">
    	<div class="userPersonalization">
        	<img id="userAvatar" width="90px" height="60px" src="/ritesh/apps/images/avatar.jpg" />
            <h1 id="userName">{$fname} {$lname} </h1>
        </div>
        <div id="interestManagerWrapper">
        	<div id="interestInputWrapper">
                <p align="center">Manage your interests</p>
                <div style="padding-left:5px;"><input type="text" id="interestInput"/></div>
                <div class="xtrSmallButton" id="addInterestButton"><p>Add</p></div><br />
            </div>
            <div id="userInterestListWrapper">
            	<ul id="userInterestList" >
                	<li id='interest'></li>
                </ul>
            </div>
        </div>
	</div><!-- end userBar -->
	<div class="searchWrapper">
        <p align="center">What do you feel like talking about?</p>
    	<div id="searchBarInputWrapper"><input type="text" id="searchBarInput" /></div>
        <div id="searchButton" class="xtrsmallbutton"><h1>Search</h1></div>
        <div class="matchedUsersListWrapper">
        	<ul id="matchedUserList">
            	<li id="matchedUserWrapper"></li>
            </ul>
        </div>
	</div><!-- end searchWrapper -->
	<div class="otherUserWrapper">
	</div><!-- end otherUserWrapper -->
</div>


<div id='match_list' style='display:none'>
    {$uid}
</div>

</div>
    <ul id='user-list' style="display:none">
        {foreach from=$aUser key=k item=user}
            <li id='{$k}'>{$user.username} <div id='status_{$k}'>{$user.status}</div><button id='chat' name='{$k}'>Chat/Send Offline Message</button></li>
        {/foreach}
    </ul>
<div id='test'></div>

<script type='text/javascript'>
	{literal}
	
		$(document).ready(function(){
			
			//send notification
			$('button#chat').live('click', function(){
				$.post("views/ajax/conversation.php",
					   {uid: $(this).name(), msg: 'send_notification'},
					   function(data) {
						   
					   });
			})
			
					//setInterval(check_notification($(this).val()), 120000);
		});
{/literal}
</script>
{include file="templates/footer.tpl"}