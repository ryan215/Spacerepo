<?php
if(!empty($rating_review))
{
	foreach($rating_review as $row)
	{
?>
<div class="col-sm-12 review-div">
	<div class="col-sm-2 writer-div">
		<a href="<?php echo base_url().'frontend/seller/seller_detail/'.id_encrypt($row->rating_given_by); ?>">
			<?php echo $row->rating_given_by_name; ?>
		</a>
		<div>
			<?php
			$rating_point = $row->rating_point;
			for($i=1;$i<=5;$i++)
			{
				if($i<=$rating_point)
				{
					echo '<span class="fa-star fa"></span>';
				}
				else
				{
					echo '<span class="fa-star fa" style="color:#666656 !important;"></span>';
				}
			}
			?>
		</div>
		<p><?php echo date('d F, Y',$row->last_modified_time); ?></p>
	</div>
	<div class="col-sm-8 review-text">
		<?php echo $row->rating_review; ?>
	</div>
</div>	
<?php
	}
}
?>
<?php
if(!empty($links))
{
?>
	<!--start div of pagination-->
	<div class="col-sm-12 pagination-div">
		<div class="pagination">
			<ul>
				<?php echo $links; ?>
			</ul>
		</div>
	</div>
	<!--end div of pagination-->
<?php
}
?>	