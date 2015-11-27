<?php
$uriSeg4 = $this->uri->segment(1);
?>
<aside class="col-main col-right sidebar col-sm-3">
	<div class="block block-company">
    	<div class="block-title" style="padding:10px;">LET US HELP YOU</div>
        <div class="block-content">
        	<ol id="recently-viewed-items">
            	<li class="item odd">
					<?php
					if($this->session->userdata('userId'))
					{
					?>
					<a href="<?php echo base_url().'frontend/dashboard';?>" title="Your Account">
						Your Account
					</a>
					<?php
					}
					else
					{
					?>
					<a href="<?php echo base_url().'frontend/home/sign_in'; ?>" title="Your Account">
						Your Account
					</a>
					<?php
					}
					?>
				</li>
			  	<li class="item even">
			  		<a href="<?php echo base_url(); ?>shipping-rates-and-policies">
						<?php
						if($uriSeg4=='shipping-rates-and-policies')
						{
							echo '<strong>Shipping Rates & Policies</strong>'; 
						}
						else
						{
							echo 'Shipping Rates & Policies';
						}
						?>
					</a>			  	
			  	</li>
			  	<li class="item even">
					<a href="<?php echo base_url(); ?>return-and-replacements">
						<?php
						if($uriSeg4=='return-and-replacements')
						{
							echo '<strong>Return & Replacements</strong>'; 
						}
						else
						{
							echo 'Return & Replacements';
						}
						?>					
					</a>
				</li>
			  	<li class="item even">
					<a href="<?php echo base_url(); ?>contact-us">
						<?php
						if($uriSeg4=='contact-us')
						{
							echo '<strong>Contact Us</strong>'; 
						}
						else
						{
							echo 'Contact Us';
						}
						?>							
					</a>
				</li>
			</ol>
		</div>
	</div>
</aside>

