<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/attribute_management'; ?>">
							Attribute List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
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
                            	<header class="panel-heading panel-heading1">
									<div class="row">
                                    
                                    	<div class="col-sm-5">
                                    	<span style="float:left; line-height:30px; margin-right:10px;"><strong>Product Type :</strong></span>
									<span style="line-height:30px;"><?php echo $result['productType']; ?></span>
                                    </div>
									
									<div>
										<div class="col-sm-7 text-right">
                                        	<span id="editBtn" onclick="show_box()" class="btn btn-danger btn-sm tooltips"><i class="fa fa-pencil"></i> </span>
										<span id="editBx" style="display:none; margin-top:5px;">
<?php 
echo form_open();
?>                                                                                           											<div class="col-sm-10 padding_right_zero"><input type="text" name="product_type" class="form-control" value="<?php echo $result['productType']; ?>" /></div>
											<div class="col-sm-2 pull-right padding_right_zero">											
											<input class="btn btn-success btn-sm tooltips" type="submit" name="submit" value="Save"  style="margin-top:0px; font-size:15px;"></div>
                                            <?php echo form_error('product_type'); ?>
											</form>
										</span>
                                        </div>
									
                                    </div>
							   </header>			                      
                        	</div>							
                        </section>
                    	
						<section id="unseen">
							<div class="col-sm-12 ">
                        		  <div class="form-group">
										<div class="col-sm-12 padding_left_zero padding_right_zero">
											<!--<a type="button" class="btn btn-round btn-success" style="padding: 6px 8px !important;" href="<?php echo base_url(); ?>superadmin/attribute_management/test2"><i class="fa fa-plus"></i>&nbsp;Add</a>&nbsp;&nbsp;-->
											<a type="button" class="btn btn-info" style="padding: 6px 8px !important;" href="<?php echo base_url().$this->session->userdata('userType').'/attribute_management/editAttributeList/'.id_encrypt($productTypeId); ?>">
												<i class="fa fa-pencil"></i>&nbsp;Edit
											</a>
										</div>										
                        		  </div><div class="clearfix"></div><br />
								  <div class="col-sm-12 padding_left_zero">
										<table class="table table-invoice table-custom atribt-table">
										<?php
										//echo "<pre>"; print_r($attrList); exit;
										if(!empty($result['attrList']))
										{
											foreach($result['attrList'] as $value)
											{
										?>
										<thead>
                                            <tr>
                                                <th colspan="4"><?php echo $value['attribute_type']; ?></th>
                                            </tr>
                                        </thead>
										<tbody>
                                            <tr>
                                                <td>Attribute Name</td>
                                                <td>Mandatory</td>
                                                <td>Display On Frontend</td>
												<td>Key Features</td>
                                            </tr>
											<?php
											if(!empty($value['attribute_name']))
											{
												foreach($value['attribute_name'] as $nameVal)
												{
											?>
											<input type="hidden" name="attr_name[]" value="<?php echo $nameVal['productTaxonomyId'];?>" />
											<tr>
                                                <td><?php echo $nameVal['attribute_name']; ?></td>
                                                <td>
                                                	<div class="checkbox c-checkbox">
                                                        <label>
														  <input type="checkbox" name="is_required[<?php echo $nameVal['productTaxonomyId'];?>]" <?php if($nameVal['isRequired']){ ?> checked="checked" <?php } ?> disabled="disabled" />
                                                          <span class="fa fa-check"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                	<div class="checkbox c-checkbox">
                                                        <label>
														  <input type="checkbox" name="is_display[<?php echo $nameVal['productTaxonomyId'];?>]" <?php if($nameVal['isDisplayed']){ ?> checked="checked" <?php } ?> disabled="disabled" />
                                                          <span class="fa fa-check"></span>
                                                        </label>
                                                    </div>
                                                </td>
												<td>
                                                	<div class="checkbox c-checkbox">
                                                        <label>
														  <input type="checkbox" name="keyFeatures[<?php echo $nameVal['productTaxonomyId'];?>]" <?php if($nameVal['keyFeatures']){ ?> checked="checked" <?php } ?> disabled="disabled" />
                                                          <span class="fa fa-check"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
											<?php	
												}
											}
											?>
                                        </tbody>
										<?php
											}
										}
										?>
                                    </table>								
								  </div>
								  		
							</div>
                        </section>
						
                    </div>
					
                </section>
            </div>
        </div>
        <!--contant end-->
	</section>
</section>
<script type="text/javascript">
$('.selectpicker').selectpicker('show');

function show_box()
{
	$("#editBx").css('display','block');
}

<?php
if(isset($_POST['product_type']))
{
?>
show_box();
<?php
}
?>
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

.error{font-size:15px;}

.atribt-table tbody tr:first-child td {
  font-weight:600;
  font-size:15px;
  background:#E5E8EC;
  color:#838383;
}

</style>