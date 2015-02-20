<?php
include "connect.php";

function enterRecord($startpage, $endpage, $steps)
{

	$numLinks 				= $steps;
	$raw					= array(" ","%28","%29");
	$fixed					= array("_","(",")");

	$startPage = str_replace($fixed, $raw, $startpage);
	$startPage = ucfirst($startPage); 
	$endName = str_replace($fixed, $raw, $endpage);
	$endName = ucfirst($endName);

$result = mysql_query("INSERT INTO `records`(`startpage`, `endpage`, `steps`) VALUES ('$startPage','$endName','$numLinks')") or die(mysql_error());

}

function getRecords()
{



$result = mysql_query("SELECT startpage, endpage, username, steps FROM records ORDER BY steps DESC") or die(mysql_error());

if(mysql_num_rows($result) > 0){ ?>
<center>Records</center>
<center><div id="records">
<table id="recordstable">
    <tr>
        <th>Start Page</th>
        <th>End Page</th>
        <th>Steps</th>
        <th>User</th>
    <tr>
    <?php while($row = mysql_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['startpage']; ?></td>
        <td><?php echo $row['endpage']; ?></td>
        <td><?php echo $row['steps']; ?></td>
        <td><?php echo $row['username']; ?></td>
    </tr>
    <?php endwhile; ?>
</table></div>
<?php 
}

else
{ ?>

<center>
<font color="red">No Records Yet!<br></font>
<font size="4px">Do some searches to see how hard you can beat the system!</font>

</center>


<?php
}



}
