<colgroup>
	<col>
    <col>
    <col>
    <col width="1">
    <col width="1">
    <col width="1">
</colgroup>
<thead>
	<tr class="first last sold_buy" style="background:#F2F2F2 !important;">
    	<th width="20%">Sellers</th>
        <th width="20%">Price</th>
		<th width="20%">ETA</th>
        <th width="20%">Shipping Fee</th>
        <th width="">&nbsp;</th>
	</tr>
</thead>
<tbody>
	<?php
	if(!empty($sellerList))
	{
		foreach($sellerList as $row)
		{
?>
	<tr>
		<td><?php echo $row['businessName']; ?></td>
		<td>
		<?php
		if(!empty($row['marketingPrice']))
		{
		?>
        <p class="actual-price">
        	<?php /*?><strike>&#x20A6;<?php echo number_format($row['currentPrice'],2); ?></strike><?php */?>
            <strike>&#x20A6;<?php echo number_format($row['displayPrice'],2); ?></strike>
        </p>
        <?php
		}
		?>
        <p class="special-price">
        	<span class="price"><?php if(!empty($row['marketingPrice'])){ echo '&#x20A6;'.number_format($row['marketingPrice'],2); }else{ echo '&#x20A6;'.number_format($row['currentPrice'],2); } ?></span>
        </p>  
		</td>
		<td><?php echo $row['eta']; ?></td>

        <td>
        <?php
		if($row['shippFee']=='NA')
		{
			echo 'NA';
		}
		else
		{
			if(is_numeric($row['shippFee']))
			{
				echo '&#x20A6;'.number_format($row['shippFee'],2);
			}
			else
			{
				echo $row['shippFee'];
			}
		}
		?>
        </td>
       <?php
		if($row['shippFee']!='NA')
		{
		?>
		<td>
			<button class="button btn-cart btn_adc" title="Add to Cart" type="button" onclick="add_to_cart('<?php echo id_encrypt($row['organizationProductId']); ?>',0,'<?php echo id_encrypt($row['marketingProductId']); ?>');">
				<span><i class="icon-basket"></i> Add to Cart</span>
			</button>
		</td>
		<?php
		}
		?>
	</tr>
<?php
		}
	}
?>						
</tbody>