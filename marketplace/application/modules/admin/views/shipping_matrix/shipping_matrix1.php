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
						<a href="javascript:void(0);" class="current">Rate List</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
                	      
                    <div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0px;">
                        	<div class="col-lg-12" style="padding:0;">
                            	<div class="col-sm-5" style="padding: 5px;">
									
										
										<div class="col-sm-2 " style="padding-left:0px;">
										<a style="float:left;" class="btn btn-round btn-success" href="<?php echo base_url(); ?>admin/shipping_matrix/index2">
											<i class="fa fa-pencil-square-o"></i> Edit
										</a>
										</div>
										<div class="col-sm-2 " style="padding-left:10px;">
										<button style="float:left;" class="btn btn-round btn-danger" data-toggle="modal" data-target="#largeModal" type="button">
											Block
										</button>
										</div>
										
									<div class="col-sm-10" style="padding-left:0px;">
									<div class="col-sm-3">
										<div class="form-group">                                               
											 
                                      </div>
									  </div>
									  
									  </div>									
                                </div>                                							                      
                        	</div>
                        </section>
						<section class="panel custom-panel">
                        	<div class="col-lg-12" style="padding:0;">
                            	<div class="col-sm-12" style="padding: 5px;">								
									<label style="background-image:none;">From :</label><span> Demo</span>&nbsp;&nbsp;&nbsp;&nbsp;									                        		
									<label style="background-image:none;">To :</label><span> Demo1</span>
                        		</div>
							</div>
                        </section>
						<section class="table-responsive" id="unseen">
							<table class="table table-invoice table-custom " style="100%">
								<thead>
									<tr>
										<th width="8%">S.no.</th>
										<th>Weight</th>
										<th>Price</th>
										<th>ETA</th>																				
																				 
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>0-1</td>
										<td> &#x20A6; 12</td>
										<td>5 Days</td>										
									</tr>
									<tr>
										<td>2</td>
										<td>1-2</td>
										<td> &#x20A6; 24</td>
										<td>2 Days</td>										
									</tr>
									<tr>
										<td>3</td>
										<td>2-3</td>
										<td> &#x20A6; 18</td>
										<td>4 Days</td>										
									</tr>
																
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
 <div id="largeModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-radius:0px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Reason</h4>
                </div>
                <div class="modal-body">
                   <input type="text" name="" class="form-control" placeholder="Please Enter Reason" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
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

</style>