<%= copyright_block("#{namespace} Unit Test") %>
/*globals <%= namespace %> module test ok equals same stop start */

module("<%= namespace %>");

// TODO: Replace with real unit test
test("test description", function() {
  var expected = "test";
  var result   = "test";
  equals(result, expected, "test should equal test");
});

