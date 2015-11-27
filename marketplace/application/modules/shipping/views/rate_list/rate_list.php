<style>
/*view user detail*/
.page-header{font-size: 20px;
    margin-top: 15px;
 }
 
.bio-graph-info{font-size:15px;
}

.bio-row{width:80%;
 padding:0;
}


</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Rate List</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	
					<div class="row">							
                            <aside class="profile-info col-lg-12"><br />
								
							
<table class="table table-invoice table-customm" style="margin-top:5px;">
	<thead>
		<tr>
			<th width="1%">S. No</th>
			<th width="3%">Dropship Center</th>
			<th width="5%">State Covered</th>
			<th width="5%">Areas Covered</th>
			<th width="5%">Cities Covered</th>
			<th width="5%">Weight From (in KG)</th>
			<th width="5%">Weight To (in KG)</th>
			<th width="4%">Price</th>
			<th width="5%">ETA (in Days)</th>
			
		</tr>
	</thead>
	<tbody id="ajaxData">
	</tbody>
</table>
									
                        </aside>
                	</div>
            	</section>
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>
<script type="text/javascript">
function ajaxPage(urlLink)
{	
	ajax_function(urlLink,'#ajaxData'); 
}
ajaxPage('<?php echo base_url().'shipping/rate_list/shippingRatesAjaxFun'; ?>');
</script>