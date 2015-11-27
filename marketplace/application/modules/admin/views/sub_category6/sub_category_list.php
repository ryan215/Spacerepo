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
						<a href="<?php echo base_url().'admin/dashboard'; ?>">Dashboard</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Sub Category6 List</a>
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
								<div style="padding:0;" class="col-lg-12">
                            	<div style="padding:0;" class="col-sm-6">
									<button type="button" onclick="sub_category_form(0);" class="btn btn-round btn-success"><i class="fa fa-plus"></i>&nbsp;Add</button>
                                </div>
								<div style="padding:0;" class="col-sm-6">
                                	<input type="search" style="width:100%;" onKeyUp="ajax_search();" name="search" id="search" placeholder="Search"> 
                                </div>                   
                            </div>
							
                            	                   
                            </div>
                        </section>
                        <section id="unseen">
                              <table class="table table-invoice table-custom">
								<thead>
									<tr>
										<th width="5%">S.no.</th>
										<th>SubCategory4 Name</th>
										<th>SubCategory5 Name</th>
										<th>SubCategory6 Name</th>
										<th width="5%">Edit</th>
										<th width="5%">Delete</th>
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
function sub_category_form(subCat6ID)
{	
	postData = '<?php echo $sendData; ?>';
	ajax_function("<?php echo base_url(); ?>admin/sub_category6/sub_category_form/"+subCat6ID,'#addEditModal',postData);
	$('#addEditModal').modal('show');
}

function ajax_search()
{
	postData = 'search='+$("#search").val();
	ajax_function('<?php echo base_url(); ?>admin/sub_category6/ajaxFun/<?php echo $total; ?>/','#ajaxData',postData);
}

function ajaxPage(urlLink)
{	
	ajax_function(urlLink,'#ajaxData');
}
ajaxPage('<?php echo base_url(); ?>admin/sub_category6/ajaxFun/<?php echo $total; ?>/');

<?php 
if((!empty($show_modal))&&($show_modal))
{
?>
	sub_category_form(0);
<?php
}
?>

function delete_sub_category6(subcatID)
{
	confirm_box('<?php echo base_url().'admin/sub_category6/delete_sub_category6/'; ?>'+subcatID,'Are you sure want to delete this sub category6 ?');
}
</script>