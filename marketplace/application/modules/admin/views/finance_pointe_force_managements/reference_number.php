<style>
/*view user detail*/
.page-header{font-size: 20px;
    margin-top: 15px;
 }
 
.bio-graph-info{font-size:15px;
}

.bio-row{width:80%;
 padding:0;
}
 small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 100%;
}

</style>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_pointe_force_management/processing_balance'; ?>">
							Pointe Force
						</a> 
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Reference Number
						</a>
					</li>
				</ul>
			</div>
			
			<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 page-header  panel-heading1" style="margin-bottom:5px;">
						Add Details
					</div>
					<?php echo form_open(); ?>
					<div class="panel-body">
						<div style="width:50%; margin:0 auto;text-align: center;">
							<img src="<?php echo base_url(); ?>images/new_images/s2.png" />
						</div>

						<div class="details_main" style="">
							<div class="form-group">
								<label for="ref_no" class="signup-labels">
									transaction reference number
								</label>
								<span class="error">*</span>
								<div class="iconic-input right">
									<input type="text" placeholder="Reference Number" id="ref_no" class="form-control ship-input ship-input2" value="<?php echo set_value('referenceNumber'); ?>" name="referenceNumber">
									<?php echo form_error('referenceNumber'); ?>
								</div>
							</div>
						</div><br />
						
						<center>
							<input type="submit" class="btn btn-success btn-save" name="submit" value="Save">&nbsp;&nbsp;
						</center>
					</div>			  	
					</form>
				</section>
			</div>
		</div>
    	<!--contant end-->
	</section>
</section>
<!--main content end-->
<style>
.wallet_tab li{ list-style-type:none; float:left; margin-right:30px;}
.wallet_tab li a { color:#999; padding-bottom: 3px;    font-size: 1.3em;}
.activetab { color:#000 !important; border-bottom:5px solid #78CD51;}
.wallet_tab li a:hover{ color:#666;}
.data-table {
    width: 100%;
    margin-bottom: 20px;
}

.data-table {
    border: 1px solid #E5E5E5;
    border-spacing: 0;
    text-align: left;
    font-size: 13px;
}
.data-table thead tr {
    background-color: #f7f7f7!important;
}
.btn-orderid {
    background: #78CD51;
    color: #fff;    margin: 10px;
    border: 1px solid #78CD51; 
}
.btn-orderid:hover{ color:#fff;}
.data-table tfoot {
    border-top: 1px solid #e9e9e9;
}
.data-table tfoot tr, .order-listmaindiv .data-table thead tr {
    background-color: #f9f9f9!important;
}
td{     padding: 15px;}
.color_static {
    padding: 8px;
    margin-left: 5px;
}
.btn-track {
    border: 1px solid #78CD51 ; color:#000;
}
.btn-track i {
    color: #78CD51;
}
.btn{ margin:10px;}
label{ background-image:none;}
.details_main {
    border: 1px solid #eaeaea;
    box-shadow: 1px 1px 13px -1px rgba(221, 221, 221, 1);margin:auto;width:50%; background:#fff;
	padding:20px; margin-top:30px;
}
</style>