<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      
</div>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().'admin/dashboard'; ?>">Dashboard</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Segment List</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
                	<?php 
					$this->load->view('success_error_message'); 
					?> 
					<div class="panel-body">
                    	<section class="panel custom-panel">
                        	<div style="padding:0;" class="col-lg-12">
							<div class="col-sm-5 " style="padding: 5px;">
								 <div class="col-sm-2 " style="padding-left:0px;"><button type="button" onclick="segment_form(0);" class="btn btn-round btn-success"><i class="fa fa-plus"></i>&nbsp;Add</button></div>
									<div class="col-sm-3">
										<div class="form-group">    
                                            <select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
										</div>
									</div>
									<div class="col-sm-5"  style="padding:0px;">
										   <span class="records_per_page">Records Per Page</span>
									</div>
									 
                                </div>
							<div class="col-sm-7 " style="padding: 5px;">
								<div class="" >
                                             
                                              <input class="form-control" type="search" style="width:100%; border-radius: 5px !important; " onKeyUp="ajax_search();" name="search" id="search" placeholder="Search">
                                          </div>
								</div>	
								
							
							
								
							</div>
                              </section>
                              <section id="unseen">
                                <table class="table table-invoice table-custom">
									<thead>
										<tr>
											<th width="5%">S.no.</th>
											<th>Segment Name</th>
											<th>Action</th>
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

<script type="text/javascript">
function segment_form(segmntID)
{	
	postData = '<?php echo $sendData; ?>';
	ajax_function("<?php echo base_url(); ?>admin/segment/segment_show/"+segmntID,'#myModal',postData);
	$('#myModal').modal('show');
}

function ajax_search()
{
	ajaxPage('<?php echo base_url(); ?>admin/segment/ajaxFun/<?php echo $total; ?>/');
}

function ajaxPage(urlLink)
{	
	postData = 'search='+$('#search').val()+'&sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData);
}

ajaxPage('<?php echo base_url(); ?>admin/segment/ajaxFun/<?php echo $total; ?>/');
<?php 
if((!empty($show_modal))&&($show_modal))
{
?>
	segment_form(0);
<?php
}
?>
function delete_segment(segmentID)
{
	confirm_box('<?php echo base_url().'admin/segment/delete_segment/'; ?>'+segmentID,'Are you sure want to delete this segment ?');
}
</script>