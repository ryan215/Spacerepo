<?php
$uriSeg4 = $this->uri->segment(1);
?>
<aside class="col-right col-main sidebar col-sm-3">
	<div class="block block-company">
    	<div class="block-title" style="padding:10px;">GET TO KNOW US </div>
        <div class="block-content">
            <ol id="recently-viewed-items">
				<li class="item even">
			  		<a href="<?php echo base_url(); ?>about">
						<?php
						if($uriSeg4=='about')
						{
							echo 'About Pointemart'; 
						}
						else
						{
							echo 'About Pointemart';
						}
						?>
					</a>			  	
			  	</li>
				
				<li class="item odd">
					<a href="<?php echo base_url(); ?>press-release">
						<?php
						if($uriSeg4=='press-release')
						{
							echo 'Press Release'; 
						}
						else
						{
							echo 'Press Release';
						}
						?>						
					</a>
				</li>
				<li class="item even">
					<a href="<?php echo base_url(); ?>careers">
						<?php
						if($uriSeg4=='carrer')
						{
							echo 'Carrers'; 
						}
						else
						{
							echo 'Carrers';
						}
						?>						
					</a>
				</li>
        	</ol>
		</div>
	</div>
</aside>