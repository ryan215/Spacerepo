<style>
.btn-reqt{border:1px solid #ccc;
}

.notifi{position:absolute !important;
	top:-8px !important;
}

#header_notification_bar {
list-style-type: none !important;
float: left;
padding-left: 20px;
}
</style>


<!-- Modal -->

<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url(); ?>admin/shipping_matrix/index1" class="">Shipping Matrix</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Add</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
                	      
                    <div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0px;">
                        	<div class="col-lg-12" style="padding:0;">
                            	<div class="alert alert-warning fade in">                                  
                                  <strong>Note :</strong> Kindly make sure that you are only selecting multiple cities & states for delivery only if you deliver on all of them at the same price.
                              </div>                               						                      
                        	</div>
                        </section>
						<section class="panel custom-panel">
                        	<div class="col-lg-12" style="padding:0;">
                            	<div class="col-sm-3 " style="padding: 5px;">
								<div class="input-group-btn">	
								<label style="background-image:none;">From (Select Warehouse)	</label>										
											<div style="">
											  <select class="selectpicker chosen-select" data-live-search="true" multiple data-style="btn-defalut" name="sorting"  id="sorting" onchange="ajax_search();">
													<option value="">Select Warehouse</option>
												  	<option value="">Demo</option>
												  	<option value="">Demo1</option>
													<option value="">Demo2</option>
													<option value="">Demo3</option>													
													<option value="">Demo4</option>
												</select>
											</div>                                                 
                                        </div>		                      
                        	</div>
								<div class="col-sm-3 " style="padding: 5px;">
								<div class="input-group-btn">
								<label style="background-image:none;">To (Select State)	</label>											
											<div style="">
											  <select class="selectpicker chosen-select" data-live-search="true" multiple show-menu-arrow data-style="btn-defalut" name="sorting"  id="sorting" onchange="ajax_search();">
													<option value="">Select State</option>
												  	<option value="">Demo</option>
												  	<option value="">Demo1</option>
													<option value="">Demo2</option>
													<option value="">Demo3</option>													
													<option value="">Demo4</option>
												</select>
											</div>                                                 
                                        </div>		                      
                        	</div>
								<div class="col-sm-3 " style="padding: 5px;">
								<div class="input-group-btn">	
								<label style="background-image:none;">Select City	</label>										
											<div style="">
											  <select class="selectpicker chosen-select" data-live-search="true" multiple data-style="btn-defalut" name="sorting"  id="sorting" onchange="ajax_search();">
													<option value="">Select City</option>
												  	<option value="">Demo</option>
												  	<option value="">Demo1</option>
													<option value="">Demo2</option>
													<option value="">Demo3</option>													
													<option value="">Demo4</option>
												</select>
											</div>                                                 
                                        </div>		                      
                        	</div>						
							</div>
                        </section>
						<section class="table-responsive" id="unseen">
							<table id="options-table" class="table table-invoice table-custom " style="100%">
								<thead>
									<tr>
										<th width="8%">S.no.</th>
										<th>From (Weight in KG)</th>
										<th>To (Weight in KG)</th>
										<th>Charge (&#x20A6;)</th>
										<th>ETA</th>																				
										<th width="10%">Action</th>										 
									</tr>
								</thead>
								<tbody>
									<tr>										
										<td>1</td>
										<td><div class="right-inner-addon "><span>KG</span>
										<input type="text" name="val[]"  class="form-control"/></div></td>
										<td><div class="right-inner-addon "><span>KG</span>
										<input type="text" class="form-control" name="val1[]"/></div></td>
										<td><div class="left-inner-addon "><span>&#x20A6;</span>
										<input type="text" class="form-control" name="val2[]"/></div></td>
										<td><input type="text" class="form-control" name="val3[]" /></td>
										<td class="add"><a class="btn btn-round btn-success">Add</a></td>											
									</tr>									
								</tbody>								
							</table>
							<script type="text/javascript">
			$(document).ready(function(){		
				$('.del').click('click',function(){
					$(this).parent().parent().remove();
				});
				
				$('.add').click('click',function(){
					$(this).val('Delete');
					$(this).attr('class','del');
					var appendTxt = "<tr><td>1</td><td><div class='right-inner-addon'><span>KG</span><input type='text' name='val[]'  class='form-control'/></div></td><td><div class='right-inner-addon'><span>KG</span><input type='text' class='form-control' name='val1[]'/></div></td><td><div class='left-inner-addon'><span>&#x20A6;</span><input type='text' class='form-control' name='val2[]'/></div></td><td><input type='text' class='form-control' name='val3[]' /></td><td class='del'><a class='btn btn-round btn-danger'><i class='fa fa-trash'></i> Delete</a></td></tr>";
					$('tr:last').after(appendTxt);			
				});        
			});
		</script>
  </section>
						<button type="button" class="btn btn-defalut pull-right" style="margin-left:10px;">Cancel</button>
						<button type="button" class="btn btn-success pull-right">Save</button>
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

</script>
<style>
.table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    overflow-x: scroll;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #DDD;
    -webkit-overflow-scrolling: touch;
}
.right-inner-addon {
    position: relative;
}
.right-inner-addon input {
    padding-right: 30px;    
}
.right-inner-addon span {
    position: absolute;
    right: 0px;
    padding: 10px 12px;
    pointer-events: none;
	top:-3px; font-weight:bold;
}
.left-inner-addon {
    position: relative;
}
.left-inner-addon input {
    padding-left: 30px;    
}
.left-inner-addon span {
    position: absolute;
    padding: 10px 12px;
    pointer-events: none;
	top:-3px; font-weight:bold;
}

</style>