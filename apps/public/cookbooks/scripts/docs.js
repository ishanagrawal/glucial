//js cookbooks/scripts/doc.js

load('steal/rhino/steal.js');
steal.plugins("documentjs").then(function(){
	DocumentJS('cookbooks/cookbooks.html');
});