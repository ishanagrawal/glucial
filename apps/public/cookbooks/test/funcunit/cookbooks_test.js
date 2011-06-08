module("cookbooks test", { 
	setup: function(){
		S.open("//cookbooks/cookbooks.html");
	}
});

test("Copy Test", function(){
	equals(S("h1").text(), "Welcome to JavaScriptMVC 3.0!","welcome text");
});