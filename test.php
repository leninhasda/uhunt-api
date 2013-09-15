<?php  
include 'lib/class.uhunt.php';

$uid = getUserID('acoder');
$info = getUserSubmission($uid);

echo '<pre>';
print_r($info);
echo '</pre>';

foreach ($info->subs as $sub) {
	if( 90 == $sub[2] )
		echo $sub[1].': '.$sub[2].'<br>';
}
?>