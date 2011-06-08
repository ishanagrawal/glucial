<?php 
/**
*
* This class is used for finding the right match for users.
*
*/
  
class matching
{
	private $user_id;
    function __construct($id) {
		$user_id = $id;
	} 
	
	function getMatchingUsers() {
	$q="SELECT interests from user where id =".$user_id;
	$result = mysql_query($q);
if (!$result) {
    die('Could not query:' . mysql_error());
}	
$interest=mysql_fetch_array($result)['interests'];
$interests = split(',', $interest);
$matchCount[]=array();
foreach($interest as $value)
{
	//make a database call on each value
	$query=mysql_query("SELECT id from user where interests LIKE '%".$value."%'");
	while($list = mysql_fetch_array($query))
	{
	//id here acts as a key
	//more matches to a already existing id increses the count
		if($matchCount[$list['id']])
			$matchCount[$list['id']]++;
		else	
			$matchCount[$list['id']] = 1;
	}
}
asort($matchCount);
//returns the list of sorted users based on the matching score
return $matchCount;
}
}  
  
?>
