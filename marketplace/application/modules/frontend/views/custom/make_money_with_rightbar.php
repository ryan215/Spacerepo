<?php
$uriSeg4 = $this->uri->segment(1);
?>
<aside class="col-right col-main sidebar col-sm-3">
	<div class="block block-company">
    	<div class="block-title" style="padding:10px;">MAKE MONEY WITH US </div>
        <div class="block-content">
        	<ol id="recently-viewed-items">
            	<li class="item even">					
			  		<a href="<?php echo base_url(); ?>sell-on-pointemart">
						<?php
						if($uriSeg4=='sell-on-pointemart')
						{
							echo '<strong>Sell on Pointemart</strong>'; 
						}
						else
						{
							echo 'Sell on Pointemart';
						}
						?>
					</a>
				</li>			  	
			  	<li class="item odd">
					<a href="<?php echo base_url(); ?>advertise-your-products">
						<?php
						if($uriSeg4=='advertise-your-products')
						{
							echo '<strong>Advertise Your Products</strong>'; 
						}
						else
						{
							echo 'Advertise Your Products';
						}
						?>						
					</a>
				</li>
                
                <li class="item even">					
			  		<a href="<?php echo base_url(); ?>terms-of-use">
						<?php
						if($uriSeg4=='terms-of-use')
						{
							echo '<strong>Terms of Use</strong>'; 
						}
						else
						{
							echo 'Terms of Use';
						}
						?>
					</a>
				</li>			  	
			  	<li class="item odd">
					<a href="<?php echo base_url(); ?>privacy-policy">
						<?php
						if($uriSeg4=='privacy-policy')
						{
							echo '<strong>Privacy Policy</strong>'; 
						}
						else
						{
							echo 'Privacy Policy';
						}
						?>						
					</a>
				</li>
            </ol>
		</div>
	</div>
</aside>