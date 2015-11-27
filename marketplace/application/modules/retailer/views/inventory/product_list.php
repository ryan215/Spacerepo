<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="col-md-12" style="padding-left:0px;">
			<ul class="breadcrumbs-alt">
				<li>
					<a href="javascript:void(0);" class="current">Manage Inventory</a>
				</li>
			</ul>
		</div>
		<!--contant start-->
        <div class="row">
			<div class="col-lg-12">
				<?php $this->load->view('success_error_message'); ?>			
            	<section class="panel">
                	<div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0;">
                        	<?php 
							$attributes = array('id' => 'srchFrm');
							echo form_open('',$attributes);
							?>
							<div style="padding:0;" class="col-lg-12">
                            	
                                <div class="col-sm-6 text-left">
                                	<a style="padding:8px 12px;" class="btn btn-success" href="<?php echo base_url().'retailer/product_management/addEditProduct'; ?>">
										Suggest A Product
									</a>
                                </div>
								<div style="padding:0;" class="col-sm-6">
                                	<input type="search" style="width:100%;" onKeyUp="ajax_search(this.value);" name="search" placeholder="Search"> 
                                </div>                    
							</div>
                            							
                            <div class="col-sm-12" style="padding:0; margin-top:25px;">
                            	<div class="col-sm-2" style="padding-left:0;">
                                	<div class="form-group" id="segAjaxId">    
                                    
									</div>
                                </div>
                                <div class="col-sm-2" style="padding:0;">
                                	<div class="form-group" id="catAjaxId">    
                                    	
                                	</div>
                                </div>
                                    <div class="col-sm-2" style="padding-right:0;">
                                        <div class="form-group" id="subCatAjaxId">    
                                            
                                      </div>
                                    </div>
                                    <div class="col-sm-2" style="padding-right:0;">
                                        <div class="form-group" id="subCat2AjaxId">    
                                            
                                      </div>
                                    </div>
                                    <div class="col-sm-2" style="padding-right:0;">
                                        <div class="form-group" id="subCat3AjaxId">    
                                            
                                		</div>
                            		</div>
									
									<div class="col-sm-2" style="padding-right:0;">
                                        <div class="form-group" id="subCat4AjaxId">    
                                            
                                		</div>
                            		</div>
									
									<div class="col-sm-2" style="padding-right:0;">
                                        <div class="form-group" id="subCat5AjaxId">    
                                            
                                		</div>
                            		</div>
									
									<div class="col-sm-2" style="padding-right:0;">
                                        <div class="form-group" id="subCat6AjaxId">    
                                            
                                		</div>
                            		</div>
                        	</div>                     
							</form>           
                        </section>
                        <section id="unseen">
                        	<table class="table table-invoice table-customm">
									<thead>
								   		<tr>
								        	<th width="5%">S.no.</th>
								            <th width="20%">Product Image</th>
											<th width="30%">Product Name</th>
											<th width="30%">Modified By</th>
								            <th width="10%">Details</th>
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
function seg_list()
{
	ajax_function('<?php echo base_url(); ?>retailer/inventory/segment_list','#segAjaxId');
	cat_list($("#segment_id").val());	
}

function cat_list(segmntID)
{	
	$('#catAjaxId').html('');
	if((segmntID!='')&&(segmntID!==undefined))
	{
		ajax_function('<?php echo base_url(); ?>retailer/inventory/category_list/'+segmntID,'#catAjaxId');
	}
	subcat1_list($("#category_id").val());	
}

function subcat1_list(catId)
{	
	$('#subCatAjaxId').html('');
	if((catId!='')&&(catId!==undefined))
	{	
		ajax_function('<?php echo base_url(); ?>retailer/inventory/sub_category1_list/'+catId,'#subCatAjaxId');
	}
	subcat2_list($("#sub_category1_id").val());	
}

function subcat2_list(subCat1Id)
{
	$('#subCat2AjaxId').html('');
	if((subCat1Id!='')&&(subCat1Id!==undefined))
	{
		ajax_function('<?php echo base_url(); ?>retailer/inventory/sub_category2_list/'+subCat1Id,'#subCat2AjaxId'); 
	}
	subcat3_list($("#sub_category2_id").val());
}

function subcat3_list(subCat2Id)
{
	$('#subCat3AjaxId').html('');
	if((subCat2Id!='')&&(subCat2Id!==undefined))
	{
		ajax_function('<?php echo base_url(); ?>retailer/inventory/sub_category3_list/'+subCat2Id,'#subCat3AjaxId'); 
	}
	subcat4_list($("#sub_category3_id").val());
}


function subcat4_list(subCat3Id)
{
	$('#subCat4AjaxId').html('');
	if((subCat3Id!='')&&(subCat3Id!==undefined))
	{
		ajax_function('<?php echo base_url(); ?>retailer/inventory/sub_category4_list/'+subCat3Id,'#subCat4AjaxId'); 
	}
	subcat5_list($("#sub_category4_id").val());
}

function subcat5_list(subCat4Id)
{
	$('#subCat5AjaxId').html('');
	if((subCat4Id!='')&&(subCat4Id!==undefined))
	{
		ajax_function('<?php echo base_url(); ?>retailer/inventory/sub_category5_list/'+subCat4Id,'#subCat5AjaxId'); 
	}
	subcat6_list($("#sub_category5_id").val());
}

function subcat6_list(subCat5Id)
{
	$('#subCat6AjaxId').html('');
	if((subCat5Id!='')&&(subCat5Id!==undefined))
	{
		ajax_function('<?php echo base_url(); ?>retailer/inventory/sub_category6_list/'+subCat5Id,'#subCat6AjaxId'); 
	}	
	
	postData = $("form#srchFrm").serialize(); 
	ajax_function('<?php echo base_url(); ?>retailer/inventory/ajaxFun/<?php echo $total; ?>','#ajaxData',postData);
}
seg_list();

function ajax_search(srchval)
{
	postData = $("form#srchFrm").serialize();
	ajax_function('<?php echo base_url(); ?>retailer/inventory/ajaxFun/<?php echo $total; ?>','#ajaxData','search='+srchval);
}

function ajaxPage(urlLink)
{	
	postData = $("form#srchFrm").serialize(); 
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url(); ?>retailer/inventory/ajaxFun/<?php echo $total; ?>');
</script>

      