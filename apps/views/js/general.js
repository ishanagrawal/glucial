function ping_server(uid){

    $.post("views/ajax/ping_server.php",
            {uid: uid, msg: 'ping_host'},
            function(data) {
                
                alert(data)
                //if (data == 'success') {
                //} else {
                //    window.document.location.href = 'http://glucial.com/binhngoc/apps/home.html';
                //} 
                
            });
    
        setTimeout(ping_server(uid), 30000);
                
}

//function search_friends(topic) {
//    
//}