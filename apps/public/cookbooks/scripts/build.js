//steal/js cookbooks/scripts/compress.js

load("steal/rhino/steal.js");
steal.plugins('steal/build','steal/build/scripts','steal/build/styles',function(){
	steal.build('cookbooks/scripts/build.html',{to: 'cookbooks'});
});
