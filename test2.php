<?php  
include 'lib/class.uhunt.php';

$user = new uHunt( 'acoder' );

if( '' != $user->getError() && !$user->getError()) {
	echo $user->getError();
	die();
} else {
?>
<table border="1">
<tr>
	<td>Name</td>
	<td><?php echo $user->getFullname(); ?></td>
</tr>
<tr>
	<td>Username</td>
	<td><?php echo $user->getUsername(); ?></td>
</tr>
<tr>
	<td>UserID</td>
	<td><?php echo $user->getUserID(); ?></td>
</tr>
<tr>
	<td>Problem solved</td>
	<td><?php echo $user->getProblemSolved(); ?></td>
</tr>
<tr>
	<td>Rank</td>
	<td><?php echo $user->getCurrentRank(); ?></td>
</tr>
</table>
<?php } ?>