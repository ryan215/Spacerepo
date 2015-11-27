<div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
</div>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Category List</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
                	<?php 
					$this->load->view('success_error_message'); 
					//$this->load->view('last_update_view');
					?>     
                    <div class="panel-body">
                    	<section class="panel custom-panel">
                        	<div style="padding:0;" class="col-lg-12">
								<div class="col-sm-5 " style="padding: 5px;">
								 <div class="col-sm-2 " style="padding-left:0px;"><button type="button" onclick="category_form(0);" class="btn btn-round btn-success"><i class="fa fa-plus"></i>&nbsp;Add</button></div>
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
								<div class="input-group m-bot15 " >
                                              <div class="input-group-btn ">
											  <div style="">
											  <select class="selectpicker chosen-select form-control" data-style="btn-success" name="sorting"  id="sorting" onchange="ajax_search();">
												<option value="">All</option>
                                                <option value="category_name">Category Name</option>
										</select></div>                                                 
                                              </div>
                                              <input class="form-control" type="search" style="width:100%; border-radius: 0px  5px 5px 0px !important; " onKeyUp="ajax_search();" name="search" id="search" placeholder="Search">
                                          </div>
								</div>								
                            </div>
                        </section>
                        <section id="unseen">
                              <table class="table table-invoice table-customm">
	<thead>
    	<tr style="color:#fff;">
        	<th width="5%">S.no.</th>
            <th>Category Name</th>
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
$('.selectpicker').selectpicker('show');
function category_form(catID)
{	
	postData = '<?php echo $sendData; ?>';
	ajax_function("<?php echo base_url(); ?>admin/category/category_form/"+catID,'#addEditModal',postData);
	$('#addEditModal').modal('show');
}

function ajax_search()
{
	postData = 'search='+$('#search').val()+'&sel_no_entry='+$('#sel_no_entry').val()+'&sorting='+$('#sorting').val();
	ajax_function('<?php echo base_url(); ?>admin/category/ajaxFun/<?php echo $total; ?>/','#ajaxData',postData);
}

function ajaxPage(urlLink)
{	
	postData = '<?php echo $sendData; ?>';
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url(); ?>admin/category/ajaxFun/<?php echo $total; ?>/');

<?php 
if((!empty($show_modal))&&($show_modal))
{
?>
	category_form(0);
<?php
}
?>

function delete_category(categoryID)
{
	confirm_box('<?php echo base_url().'admin/category/delete_category/'; ?>'+categoryID,'Are you sure want to delete this category ?');
}
</script>