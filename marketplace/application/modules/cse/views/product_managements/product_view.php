<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<div class="col-md-12" style="padding-left:0px;">
			<ul class="breadcrumbs-alt animated fadeInLeft">
				<?php
				if($this->session->userdata('userType')=='admin')
				{
				?>
				<li>
					<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management'; ?>">Product Managment</a>
				</li>
				<?php
				}
				?>
				<li>
					<a href="<?php echo base_url().$this->session->userdata('userType').'/product_request_management'; ?>">Request Product Managment</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="current">Product View</a>
				</li>
			</ul>
		</div>
		
		<div class="clearfix"></div><?php $this->load->view('success_error_message'); ?> 
		<div class="col-lg-12 padding_left_zero padding_right_zero">
        <div class="panel">
        <header class="panel-heading head_text" style="padding-bottom: 18px;"> 
        <?php echo 'Request By '.$result['requestBy']; ?>
        <?php 
		if(($this->session->userdata('userType')=='admin')||((($this->session->userdata('userType')=='cse')||($this->session->userdata('userType')=='retailer'))&&(($result['verificationResultId'])&&($result['verificationResultId']==6))))
		{
		?>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/addEditProduct/'.id_encrypt($productId); ?>" class="btn btn-info pull-right" style="margin-left:10px;">
			<i class="fa fa-pencil"></i> &nbsp;Edit Details
		</a>
		<?php
		}
		if((($this->session->userdata('userType')=='cse')||($this->session->userdata('userType')=='retailer'))&&(($result['verificationResultId'])&&($result['verificationResultId']==6)))
		{
		?>
		<a href="javascript:void(0);" onclick="delete_product();" class="btn btn-danger pull-right" style="margin-left:10px;">
			Delete
		</a>
		<?php
		}
		if($this->session->userdata('userType')=='admin')
		{
		?>
		<a href="javascript:void(0);" onclick="hideShowBox();" class="btn btn-danger pull-right" style="margin-left:10px;">
			Decline
		</a>
		<a href="javascript:void(0);" onclick="accept_request();" class="btn btn-success pull-right">
				Accept
		</a>
            <br />	<br />
			<div id="declineReason" style="display:none;">
        	<?php echo form_open();?>
				
				<textarea name="decline" class="form-control" placeholder=" Please Enter Decline Reason"><?php echo set_value('decline'); ?></textarea>
				<span style="font-size:12px;"><?php echo form_error('decline'); ?></span>
				<input type="submit" name="submit" value="Submit" class="btn btn-warning" style="margin-top:5px;"/>
			</form>
		</div>
		<?php
		} //echo "<pre>"; print_r($result); exit;
		
		?>
        </header>
		
        </div>
        </div><div class="clearfix"></div>
        <?php
		if(($this->session->userdata('userType')=='cse')||($this->session->userdata('userType')=='retailer'))
		{
			if(($result['verificationResultId'])&&($result['verificationResultId']==6))
			{
		?>
		<div class="alert alert-info fade in">
			<strong>Decline Reason</strong> : <?php echo $result['requestReason']; ?>
		</div>
		<?php
			}
		}
		$this->load->view('retailer/product_managements/product_request_details_view'); 
		?>
	<!--contant end-->
	</section>
</section>


<style>
.product_view_heading{
	padding: 8px 15px;
	margin-bottom: 20px;
  	list-style: none;
  	background-color: #fff;
  	border-radius: 4px;
}
</style>
<script type="text/javascript">
<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">
<script type="text/javascript">
function accept_request()
{
	swal({   
	title: '',   
	text: 'Are you sure want to accept this product?',   
	//type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/product_request_management/accept_request/'.id_encrypt($productId); ?>';				
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function hideShowBox()
{
	$('div#declineReason').toggle();
}
<?php
if(!empty($_POST['submit']))
{
?>
hideShowBox();
<?php
}
?>
function decline_request()
{
	if(confirm('Are you sure want to decline this product?'))
	{
		return true;
	}
	return false;
/*
	swal({   
	title: '',   
	text: 'Are you sure want to decline this product?',   
	//type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			//window.location.href = '<?php //echo base_url().$this->session->userdata('userType').'/product_request_management/decline_request/'.id_encrypt($productId); ?>';
			return true;				
		} 
		else 
		{     
			swal("Cancelled","", "error");   
			return false;
		} 
	});
*/}

function delete_product()
{
	swal({   
	title: '',   
	text: 'Are you sure want to delete this request?',   
	//type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/product_request_management/delete_request/'.id_encrypt($productId); ?>';
			return true;				
		} 
		else 
		{     
			swal("Cancelled","", "error");   
			return false;
		} 
	});
}
</script>
