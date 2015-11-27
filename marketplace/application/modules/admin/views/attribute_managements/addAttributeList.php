<style>
body {
    padding: 20px;
}
input {
    display: block;
}
label {
    margin-top: 5px;
    display: block;
}

input.parsley-error {
    border: 1px solid red;
}

.parsley-error-list {
    color: red;
}

button {
    display: block;
    margin-top: 20px;
}

.confirm{margin:10% auto 5% !important;
}

.plus-delete-cion{padding-top:6px;
}

</style>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/attribute_management'; ?>">
							Attribute Management
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Add</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					?> 
                	<div class="panel-body" style="padding:0px;">
						<section class="panel custom-panel">
                        	<div class="col-lg-12" style="padding:0;">
                            	<header class="panel-heading panel-heading1">Add Product Type </header>						                      
                        	</div>
                        </section>
						<?php 
						$attributes = array('id' => 'attrForm');
						echo form_open('',$attributes);
						?>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="col-sm-12 save-div" style="padding-top:20px;">
									<a href="<?php echo base_url().$this->session->userdata('userType').'/attribute_management'; ?>" class="btn btn-danger btn-save">
										Cancel
									</a>&nbsp;&nbsp;
									<button class="btn btn-success btn-save" onclick="return savefun();" style="margin-top:0;">Save</button>
					</div>
						<section id="unseen">
							<div class="col-sm-12 ">
                        		  <div class="form-group">
										<div class="col-sm-2 padding_left_zero">
											<label for="product_type" style="float:left; line-height:33px; margin-right:10px;">
												Product Type
											</label>
										</div>	
										<div class="col-sm-4 padding_left_zero">
											<input type="text" name="product_type" id="product_type" class="form-control" value="<?php echo $result['product_type']; ?>">
											<?php echo form_error('product_type'); ?>
										</div>
										
                        		  </div>
								  <div class="clearfix"></div><br />
								  
								  <div class="col-sm-12 padding_left_zero">
								  <div id="attributeList">	
																		 										 
								  </div>	 
										
								  </div>								  		
							</div>
                        </section>
						
                    </div>
					
                </section>
				</form>
            </div>
        </div>
        <!--contant end-->
	</section>
</section>
<script type="text/javascript">
$('.selectpicker').selectpicker('show');

</script>
<style>
.modal-header{
	border-radius:0px !important;
}
label{ background-image:none;}
.modal-header .close{
  width: 33px;
  position: relative;
  top: -26px;
  right: -21px;
  float: right;
}
.modal-header h4.modal-title{ font-weight:600;}
.padding_left_zero{ padding-left:0px;}
.padding_right_zero{ padding-right:0px;}
.c-checkbox span {
  position: relative;
  display: inline-block;
  vertical-align: top;
  margin-left: -20px;
  width: 20px;
  height: 20px;
  border-radius: 2px;
  border: 2px solid #ccc;
  text-align: center;
}

.c-checkbox {margin-top:0;
	margin-bottom:0;
}

.c-checkbox span:before{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  opacity: 0.2;
  text-align: center !important;
  font-size: 12px;
  line-height: 18px;
  vertical-align: middle;
}

.c-checkbox input[type=checkbox]{
  position:absolute;
  margin: 4px 0 0;
  opacity:0;
}

.c-checkbox input[type=checkbox]:checked {
color: #fff;
transition: color 0.3s ease-out;
}

.c-checkbox input[type=checkbox]:checked + span{
border-color:#94C359;
background-color:#94C359;
}

.c-checkbox input[type=checkbox]:checked + span:before{
  color: #fff;
opacity: 1;
transition: color 0.3s ease-out;
}


.atribt-table tbody tr:first-child td{
	background-color:#FDE3E1;
}

</style>

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">

<script type="text/javascript">
function removeAttributeTp(boxID)
{
	$('#attrNmTable'+boxID).remove();
	$('#attrTp'+boxID).remove();
}

function removeAttributeName(nmID)
{
	$('#attrNmTr'+nmID).remove();
}
childCntr  = 0;
parentCntr = 0;

function addAttributeName(ID,attrTyID)
{	
	ttlbx = 0;
	flag = true;
	$('#attrNmTable'+attrTyID).find('input[type="text"]').each(function(){
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
		$('#anchRmv'+ID).css('display','inline-block');
		$('#anchAdd'+ID).css('display','none');
		html = '<tr id="attrNmTr'+childCntr+'"><td><input type="text" class="form-control" name="attribute_name['+attrTyID+']['+childCntr+']" placeholder="Enter Attribute Name"/></td><td><div class="checkbox c-checkbox"><label><input type="checkbox" class="is_required" name="is_required['+attrTyID+']['+childCntr+']" id="isReq'+attrTyID+'_'+childCntr+'"><span class="fa fa-check"></span></label></div></td><td><div class="checkbox c-checkbox"><label><input type="checkbox" checked="checked" class="is_display" name="is_display['+attrTyID+']['+childCntr+']" id="isDespl'+attrTyID+'_'+childCntr+'"><span class="fa fa-check"></span></label></div></td><td><div class="checkbox c-checkbox"><label><input type="checkbox" class="key_features"  name="key_features['+attrTyID+']['+childCntr+']" id="keyFtrs'+attrTyID+'_'+childCntr+'" onclick="key_check('+childCntr+','+attrTyID+');"><span class="fa fa-check"></span></label></div></td><td><a id="anchAdd'+childCntr+'" onclick="addAttributeName('+childCntr+','+attrTyID+');" class="btn btn-success btn-xs" style=" margin-top:6px;"><i class="fa fa-plus"></i></a><a  style="display:none" id="anchRmv'+childCntr+'"  href="javascript:void(0);" onclick="removeAttributeName('+childCntr+');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a></td></tr>';
		$('#attrNameLst'+attrTyID).prepend(html);
		childCntr++;		
	}
}

function addAttribute()
{	
	ttlbx = 0;
	flag = true;
	$('#attributeList').find('input[type="text"]:first').each(function(){
		if($(this).val()=='')
		{
			ttlbx++;
		}
	});
	
	if(ttlbx)
	{
		flag = false;
		swal("",'Please enter the blank text box value for attribute type');
		return false;			
	}
	if(flag)
	{
		rmvBtn = '';
		if(childCntr)
		{
			rmvBtn = '<a href="javascript:void(0);" onclick="removeAttributeTp('+childCntr+');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>';
		}
		
		html = '<div class="form-group" id="attrTp'+childCntr+'"><div class="col-sm-2 padding_left_zero"><label for="attribute_type" style="float:left; line-height:33px; margin-right:10px;">Attribute Type</label></div><div class="col-sm-4 padding_left_zero" class="attrTp"><input type="text" name="attribute_type['+parentCntr+']" class="form-control" onkeyup="hideShow(this.value,'+childCntr+')"></div><div class="col-sm-1 padding_left_zero plus-delete-cion"><a onclick="addAttribute();" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;'+rmvBtn+'</div></div><div class="clearfix"></div><br /><table class="table table-invoice table-custom atribt-table" style="display:none;" id="attrNmTable'+childCntr+'"><thead><tr><th>Attribute Name</th><th>Mandatory</th><th>Display On Frontend</th><th>Key Features</th><th width="8%"></th></tr></thead><tbody id="attrNameLst'+parentCntr+'"><tr id="attrNmTr'+childCntr+'"><td><input type="text" class="form-control" name="attribute_name['+parentCntr+']['+childCntr+']" placeholder="Enter Attribute Name" /></td><td><div class="checkbox c-checkbox"><label><input id="isReq'+parentCntr+'_'+childCntr+'" type="checkbox" class="is_required" name="is_required['+parentCntr+']['+childCntr+']"><span class="fa fa-check"></span></label></div></td><td><div class="checkbox c-checkbox"><label><input type="checkbox" checked="checked" class="is_display" name="is_display['+parentCntr+']['+childCntr+']" id="isDespl'+parentCntr+'_'+childCntr+'"><span class="fa fa-check"></span></label></div></td><td><div class="checkbox c-checkbox"><label><input id="keyFtrs'+parentCntr+'_'+childCntr+'" onclick="key_check('+childCntr+','+parentCntr+');" type="checkbox" class="key_features" name="key_features['+parentCntr+']['+childCntr+']"><span class="fa fa-check"></span></label></div></td><td><a id="anchAdd'+childCntr+'" onclick="addAttributeName('+childCntr+','+parentCntr+');" class="btn btn-success btn-xs" style="margin-top:6px;"><i class="fa fa-plus"></i></a><a   style="display:none" id="anchRmv'+childCntr+'" href="javascript:void(0);" onclick="removeAttributeName('+childCntr+');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a></td></tr></tbody></table>';
		$('#attributeList').prepend(html);
		//$('#txtbx'+counter).focus();
		childCntr++;	
		parentCntr++;
	}
}

addAttribute();


function savefun()
{
	ttlbx = 0;
	flag = true;
	
	if($('#product_type').val()=='')
	{
		swal("",'Please enter the product type');
		return false;
		flag = false;
	}	
	
	if(flag)
	{
		return true;
	}
	return false;
}

function key_check(childID,prntID)
{
	if($('#keyFtrs'+prntID+'_'+childID).prop("checked"))
	{
		$('#isReq'+prntID+'_'+childID).prop( "checked",true);
		$('#isDespl'+prntID+'_'+childID).prop( "checked",true);
		
		$('#isReq'+prntID+'_'+childID).attr("disabled", true);
		$('#isDespl'+prntID+'_'+childID).attr("disabled", true);		
	}
	else
	{
		$('#isReq'+prntID+'_'+childID).prop( "checked",false);
		//$('#isDespl'+prntID+'_'+childID).prop( "checked",false);
		
		$('#isReq'+prntID+'_'+childID).attr("disabled", false);
		$('#isDespl'+prntID+'_'+childID).attr("disabled",false);
	}	
}

function hideShow(txtVal,prdID)
{
	if(txtVal!='')
	{
		$('#attrNmTable'+prdID).css('display','inline-table');
	}
	else
	{
		$('#attrNmTable'+prdID).css('display','none');
	}
}
</script>