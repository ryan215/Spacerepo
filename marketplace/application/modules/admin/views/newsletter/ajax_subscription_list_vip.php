<?php
/**
 * Created by PhpStorm.
 * User: VIJJU
 * Date: 8/4/2015
 * Time: 11:59 AM
 */
//echo "<pre>"; print_r($subscriptionList); exit;
if(!empty($subscriptionList))
{	
    $i = $page+1;
    foreach($subscriptionList as $row)
    {
       // print_r($row);
	?>
<tr>
	<td><?php echo $i; ?></td>
    <td><?php echo $row->subscription_email; ?></td>
	 <td><?php if($row->gender==1){echo 'Male';}elseif($row->gender==2){ echo 'Female';}; ?></td>
	<td><?php echo $row->createDt; ?></td>
</tr>
	<?php
    	$i++;
    }
    if(!empty($links))
    {
        ?>
        <tr>
            <td colspan="10" align="right">
                <div class="pagination">
                    <?php echo $links; ?>
                </div>
            </td>
        </tr>
    <?php
    }
}
else
{
    ?>
    <tr>
        <td colspan="2" align="center">No Data Found</td>
    </tr>
<?php
}
?>
