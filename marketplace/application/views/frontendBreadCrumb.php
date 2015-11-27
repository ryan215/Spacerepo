<?php
$uriSeg2 = $this->uri->segment(2);
$uriSeg3 = $this->uri->segment(3);
?>

	<div class="breadcrumbDiv col-lg-12" style="padding-top:40px;">
    	<ul class="breadcrumb">
        	<li>
				<a href="<?php echo base_url(); ?>">
					Home
				</a> 
			</li>
			<li class="active">
				<?php
				if(($uriSeg2=='myaccount')&&(($uriSeg3=='')||($uriSeg3=='index')))
				{
					echo 'Personal Information';
				}
				elseif($uriSeg3=='change_password')
				{
					echo 'Change Password';
				}
				elseif($uriSeg3=='billing_info')
				{
					echo 'Billing Information';
				}
				elseif(($uriSeg2=='product')&&($uriSeg3=='rating_review_details'))
				{
					echo 'Product Rating & Reviews';
				}
				?>				
			</li>
		</ul>
	</div>
