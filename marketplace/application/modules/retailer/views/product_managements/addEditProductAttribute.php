<style>
label{
	background-image:none;
}
.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}

.heading-attributs{padding: 5px 0px; font-size: 16px;
}
</style>
<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<?php $this->load->view('success_error_message'); ?>  
		<ul class="breadcrumb" style="font-size:18px; color:#F4873D; font-weight:600; background-color:#fff; border:0 !important;">
			<li>
				<?php
				if($result['product_id'])
				{
					echo 'Edit Product Attribute';
				}
				else
				{
					echo 'Add Product Attribute';
				} 
				?>
			</li>
		</ul>
		<div class="row panel" style="margin:5px 0 20px;">
		<div class="col-sm-12">
	    	<div class="progress progress-striped progress-sm" style="margin:5px 0; height:14px;">
	        	<div style = "width:63%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
	            	<span class="sr-only">40% Complete (success)</span>
	            </div>
			</div>
			
			<div class="col-sm-3 pd">Product Description</div>
	        <div class="col-sm-3 pd text-center">Images</div>
	        <div class="col-sm-3 pd text-center">Attributes</div>
	        <div class="col-sm-3 pd text-right">Review Product</div>
		</div>
	</div>
		<div class="alert alert-warning fade in">
                                  
                                  <strong>Note :</strong> Changes not saved until you click the save button
                              </div>
		
		
			<?php 
echo form_open();
?>                                                                                           
            <div class="panel col-sm-12 heading-attributs">
			<div class="col-lg-12">
            
        	
			
			<table id="attributeTbl" width="100%" class="table table-striped">
				<thead>
					<tr>
					<td colspan="3" style="padding-bottom:20px;width:100%;"><a onclick="addAttributeName();" class="btn btn-success btn-xs" style=" margin-top:6px;">
							<i class="fa fa-plus"></i>
						</a></td>
				</tr>
                <tr>
					<th   width="48%">Attribute Name</th>
					<th  width="48%">Attribute Value</th>
					<td width="5%">&nbsp;</td>
				</tr>
				</thead>
<tbody id="attrNameLst"  style="width:100%;">
	<tr>
		<td>
			<input type="text" class="form-control" name="attribute_name[0]" placeholder="Enter Attribute Name"/>
		</td>
		<td>
			<input type="text" class="form-control" name="attribute_value[0]" placeholder="Enter Attribute Value"/>
		</td>
	</tr>
</tbody>
	
</table>
						
			
            </div>
            </div>
            <div class="col-sm-12 btn-save" id="submitBtn" style="text-align:right; padding:0px;">
        		<button class="btn btn-success btn-save">Save & Continue</button>
        	</div>
		</form>
		
		
		<!--contant end-->
	</section>
</section>

<script type="text/javascript">
function removeAttributeName(nmID)
{
	$('#attrNmTr'+nmID).remove();
}

childCntr = 1;
function addAttributeName()
{	
	ttlbx = 0;
	flag = true;
	$('#attributeTbl').find('input[type="text"]').each(function(){
		if($(this).val()=='')
		{
			ttlbx++;
		}
	});
	
	if(ttlbx)
	{
		flag = false;
		swal("",'Please enter the blank text box value');
		return false;			
	}
	
	if(flag)
	{		
		html = '<tr id="attrNmTr'+childCntr+'"><td><input type="text" class="form-control" name="attribute_name['+childCntr+']" placeholder="Enter Attribute Name"/></td><td><input type="text" class="form-control" name="attribute_value['+childCntr+']" placeholder="Enter Attribute Value"/></td><td><a id="anchRmv'+childCntr+'"  href="javascript:void(0);" onclick="removeAttributeName('+childCntr+');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a></td></tr>';
		$('#attrNameLst').prepend(html);		
		childCntr++;		
	}
}

<?php
if(!empty($result['attribute_name']))
{
	foreach($result['attribute_name'] as $key=>$value)
	{
?>
	html = '<tr id="attrNmTr<?php echo $key; ?>"><td><input type="text" class="form-control" name="attribute_name[<?php echo $key; ?>]" value="<?php echo str_replace("'", "", $value); ?>" placeholder="Enter Attribute Name"/></td><td><input type="text" class="form-control" name="attribute_value[<?php echo $key; ?>]" placeholder="Enter Attribute Value"  value="<?php echo str_replace("'", "", $result['attribute_value'][$key]);  ?>"/></td><td><a id="anchRmv<?php echo $key; ?>"  href="javascript:void(0);" onclick="removeAttributeName(<?php echo $key; ?>);" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a></td></tr>';
		$('#attrNameLst').append(html);
<?php
	}
}
?>
</script>