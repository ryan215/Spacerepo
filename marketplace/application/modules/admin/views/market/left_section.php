<!--main content start-->
<section id="main-content">
	<section class="wrapper">
	 
		
    	<!--contant start-->
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Left Slider List</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<?php 
		$this->load->view('success_error_message'); 
		?>
            	<section class="panel">
                	<header class="panel-heading">
                        <a class="btn btn-primary" href="<?php echo base_url().$this->session->userdata('userType').'/marketing/addLeftSlider'; ?>">
							Edit
						</a>
                      </header>
                	<div class="panel-body">
                    	
                        <section id="unseen" class="table-responsive">
                        	<table class="table table-invoice table-customm">
									<thead>
								   		<tr>
								        	<th width="5%">S.no.</th>
								            <th width="">Slider Image</th>
											<th width="">Slider Link</th>
								           <?php /*?> <th width="10%">Action</th><?php */?>
										</tr>
								    </thead>
								    <tbody id="ajaxData"> 
									
									</tbody>
								</table>      
                    	</section>
                	</div>
            	</section>
        	</div>
    	</div>
    <!--contant end-->
	</section>
</section>

<script language="javascript" type="application/javascript">
function delete_slider()
{
	if(confirm('Are you sure want to delete this?'))
	{
		return true;
	}
	return false;
}

function ajaxPage(urlLink)
{
	ajax_function(urlLink,'#ajaxData');
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/marketing/leftAjaxFun/'.$total; ?>');
</script>

<style>
.isa_success{margin-bottom:0;
}
</style>