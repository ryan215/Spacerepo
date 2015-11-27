<?php
$uriSeg4 = $this->uri->segment(1);
?>
<aside class="col-right col-main sidebar col-sm-3">
	<div class="block block-company">
    	<div class="block-title" style="padding:10px;">Policies</div>
        <div class="block-content">
        	<ol id="recently-viewed-items">
				<?php /*?><li class="item even">					
			  		<a href="<?php echo base_url(); ?>site-map">
						<?php
						if($uriSeg4=='site-map')
						{
							echo '<strong>Site Map</strong>'; 
						}
						else
						{
							echo 'Site Map';
						}
						?>
					</a>
				</li><?php */?>
			  	<li class="item even">
					<a href="<?php echo base_url(); ?>privacy-and-security">
						<?php
						if($uriSeg4=='privacy-and-security')
						{
							echo '<strong>Privacy & Security</strong>'; 
						}
						else
						{
							echo 'Privacy & Security';
						}
						?>						
					</a>
				</li>
			  	<li class="item even" style="border-bottom:0;">
					<a href="<?php echo base_url(); ?>conditions-of-use">
						<?php
						if($uriSeg4=='conditions-of-use')
						{
							echo '<strong>Conditions of Use</strong>'; 
						}
						else
						{
							echo 'Conditions of Use';
						}
						?>							
					</a>
				</li>
			</ol>
		</div>
	</div>
</aside>