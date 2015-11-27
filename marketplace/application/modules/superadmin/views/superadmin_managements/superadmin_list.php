<!-- Modal -->
<?php $this->load->view('superadmin_managements/addEditAdminForm');  ?>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url(); ?>superadmin/dashboard">Dashboard</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Superadmin Managment</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					$this->load->view('upload_image_in_js');
					?>  
                    <div class="panel-body">
                    	<section class="panel custom-panel">
							<div style="padding:0;" class="col-sm-12">
                            	<div class="col-sm-5 " style="padding: 5px;">
								 <div class="col-sm-2 col-sm-2" style="padding-left:0px;"><button class="btn btn-round btn-success" data-toggle="modal" data-target="#myModal" type="button">
										<i class="fa fa-plus"></i>&nbsp;Add
									</button></div>
									<div class="col-sm-4 col-lg-3">
										<div class="form-group">    
                                            <select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
										</div>
									</div>
									<div class="col-lg-5 col-sm-6"  style="padding:0px;">
										   <span class="records_per_page">Records Per Page</span>
									</div>
                                </div>
								<div class="col-sm-7 " style="padding: 5px;">
								<div class="input-group m-bot15 " >
                                              <div class="input-group-btn ">
											  <div style="">
											  <select class="selectpicker chosen-select form-control" data-style="btn-success" name="sorting"  id="sorting" onchange="ajax_search();">
                                            <option value="">All</option>
											<option value="name">Name</option>
                                        	<option value="email">Email</option>
										</select></div>                                                 
                                              </div>
                                              <input class="form-control" type="search" style="width:100%; border-radius: 0px  5px 5px 0px !important; " onkeyup="ajax_search();" name="search" placeholder="Search" id="search">
                                          </div>
								</div>	
							</div>
                        </section>
                        <section id="unseen">
                             <table class="table table-invoice table-custom">
								<thead>
									<tr>
										<th width="5%">S.no.</th>
										<th>Image</th>
										<th>Name</th>
										<th>Email</th>
										<th width="13%">Gender</th>
										<th>Details</th>									  
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
<!--main content end-->
<script language="javascript" type="application/javascript">
$('.selectpicker').selectpicker('show');
<?php
if((!empty($dataArr['show_modal']))&&($dataArr['show_modal']==1))
{
?>
	$( document ).ready( function() { 
    	$('#myModal').modal('show');
	});
<?php
}
?>
function ajax_search()
{
	postData = 'search='+$('#search').val()+'&sorting='+$('#sorting').val()+'&sel_no_entry='+$('#sel_no_entry').val();
	ajax_function('<?php echo base_url(); ?>superadmin/superadmin_management/ajaxFun/<?php echo $total; ?>/','#ajaxData',postData);
}

function ajaxPage(urlLink)
{
	postData = 'search='+$('#search').val()+'&sorting='+$('#sorting').val()+'&sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url(); ?>superadmin/superadmin_management/ajaxFun/<?php echo $total; ?>/');
</script>