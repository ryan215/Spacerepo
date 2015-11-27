<style>
label
{
	background-image:none;
}
.chosen-container-single .chosen-single
{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}

.ajax-upload-dragdrop{border:none !important;
}

.btn-white {
    border: 1px solid #666;
    color: #666;
}

.upload-img-div{padding:0 5px;
	margin-bottom:10px;
}

.upload-statusbar{border:none 	!important;
}

.img-opacity{
	opacity:1;
}

.view{margin:0 !important;
}

.main-image-div{
	  background-color: #78CD51;
	  color: #fff;
	  width: 100%;
	  padding: 2px 5px;
	  bottom: 0px;
	  text-align: center;
	  position: absolute;
	  z-index: 100;
	  left:0;
}
</style>

<script>
base_url = '<?php echo base_url(); ?>';
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/uploadfilemulti.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/image_hover.css" />

<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
	var settings = {
    url: "<?php echo base_url().$this->session->userdata('userType').'/product_management/uploadProductImage/'.id_encrypt($product_id); ?>",
    method: "POST",
    allowedTypes:"jpg,png,gif,jpeg",
    fileName: "myfile",
    multiple: true,
	dragDropStr:'',
	uploadButtonClass:'',
	showFileCounter:true,
	progressbar:true,
	showDone:true,
	formData:{
		'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
	},
	onSuccess:function(files,data,xhr)
    {/*		
		res = $.parseJSON(data);
		if(res.success==1)
		{
			$("#errorMsg").html('');
			$("#errorMsg").css('display','none');			
		}
		else
		{
			$("#errorMsg").css('display','block');
			$("#errorMsg").html(res.message);
			return false;			
		}
    */},
    afterUploadAll:function(response)
    {
		//res = $.parseJSON(response.responses);
		//if(res.success==1)
		//{
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/product_management/addEditProductImage/'.id_encrypt($product_id); ?>";
		/*}
		else
		{
			$("#errorMsg").css('display','block');
			$("#errorMsg").html(res.message);
			return false;			
		}*/
    },
    onError: function(files,status,errMsg)
    {  
		$("#errorMsg").css('display','block');      
		$("#errorMsg").html('Upload is Failed');
        $("#status").html("<font color='red'>Upload is Failed</font>");
    }
	}
	$("#uploadImage").uploadFile(settings);
});
</script>
<?php $uri_segment2=$this->uri->segment(2);?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div style="padding-left:0px;">
			<ul class="breadcrumbs-alt animated fadeInLeft">
				<li>
					<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management'; ?>">
						Product Managment
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="current">
						Add|Edit Product Image
					</a>
				</li>
			</ul>
		</div>
    	<?php $this->load->view('success_error_message'); ?>  
		<div class="row panel" style="margin:5px 0 20px;">
		<div class="col-sm-12">
	    	<div class="progress progress-striped progress-sm" style="margin:5px 0; height:14px;">
	        	<div style = "width:38%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
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
		<div class="row">
        	<div class="col-lg-12">
            	<section class="panel">
                	<header class="panel-heading panel-heading1">
                    	Product Images
                    </header>
					<div class="panel-body">
						<div class="col-sm-12 upload-img-div">
                        	<div id="uploadImage">
                            	<span class="btn btn-white btn-file">
		                        	<span class="fileupload-new" id="imgname">
										<i class="fa fa-paper-clip"></i> Upload image
									</span>
		                        </span>
							</div>
						</div>
                    <?php
					$mainImage = 0;
					if(!empty($productList))
					{						
						foreach($productList as $row)
						{
							$product_image_name = $row->imageName;
							$class = 'img-opacity';
							if($row->displayOrder)
							{
								$class = '';
								$mainImage = $row->displayOrder;	
							}
					?>
					<div class="col-sm-3">
						<div class="media-gal">
							<div class="images item view view-first" id="<?php echo $row->productImageId; ?>">
                            	<?php
								if((!empty($product_image_name))&&(file_exists('uploads/product/'.$product_image_name)))
								{
								?>
								<img src="<?php echo base_url(); ?>uploads/product/<?php echo $product_image_name; ?>" class="img-responsive <?php echo $class; ?>" />
								<?php
								}
								else
								{
								?>
								<img src="<?php echo base_url(); ?>img/no_image.jpg"/>
								<?php
								}									
								?> 
                                <div class="mask">
                                    <h2 style="margin-bottom:50px" id="rmvSpn<?php echo $row->productImageId; ?>">
										<a href="javascript:void(0);" onclick= "return remove_image('<?php echo id_encrypt($row->productImageId); ?>');" title="Delete">
											<i class="fa fa-times"></i>
										</a>
										<?php
										if(!$row->displayOrder)
										{
										?>
										<a href="javascript:void(0);" onclick= "return make_main_image('<?php echo id_encrypt($row->productImageId); ?>');" title="Make Main Image">
											<i class="fa fa-thumbs-up"></i> Main Image
										</a>
										<?php
										}
										?>
									</h2>
									<?php
									if($row->displayOrder==1)
									{
									?>
										<a href="javascript:void(0);" class="info">Main Image</a>
									<?php
									}
									?>
                                </div>	
                                <?php
							if($row->displayOrder==1)
							{
							?>
							<div class="main-image-div">Main Image</div>
							<?php	
							}
							?> 														
                            </div>
							
						</div>
					</div>
					<?php
						}
					}
					?>
					</div>
				</section>
			</div>  
		</div>
        <?php
		if($mainImage)
		{
			if($uri_segment2=='semantics')
			{
					
		?>     
        <div class="col-sm-12 save-div">
			<a href="<?php echo base_url().$this->session->userdata('userType').'/semantics/product_review/'.id_encrypt($product_id);?>">
	        	<button class="btn btn-success btn-save">Save & Continue</button>
			</a>
        </div>
		<?php
				
			}else{
					
		?>     
        <div class="col-sm-12 save-div">
			<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/addEditProductAttribute/'.id_encrypt($product_id); ?>">
	        	<button class="btn btn-success btn-save">Save & Continue</button>
			</a>
        </div>
		<?php
			}
		
		}
		else
		{
		?>     
        <div class="col-sm-12 save-div">
			<a href="javascript:void(0);" onclick="msg();">
	        	<button class="btn btn-success btn-save">Save & Continue</button>
			</a>
        </div>
		<?php	
		}
		?>	
        <!--contant end-->
	</section>
</section>
<!--main content end-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">

<script type="text/javascript">
function msg()
{
	swal("","Please Select Main Image then you go next");
}

function remove_image(prdImgID)
{	
	if(confirm('Are you sure want to remove this ?'))
	{
		window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/'. $uri_segment2.'/deleteImage/'; ?>'+prdImgID+'/<?php echo id_encrypt($product_id); ?>';
	}
	return false;		
}

function make_main_image(prdImgID)
{
	swal({   
	title: '',   
	text: 'Are you sure want to make this as "MAIN IMAGE"?',   
	type: "warning",   
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType'); ?>/<?php echo  $uri_segment2;?>/makeMainImage/'+prdImgID+'/<?php echo id_encrypt($product_id); ?>';   
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

$(document).ready(function(){
	
	$('.fileupload-new .img-opacity').css('opacity', 0.4);  
	$('.fileupload-new').mouseover(function(){  
		ID = $(this).attr('id'); 
		if(parseInt(ID))
		{
			$('#rmvSpn'+ID).show();
			$('#'+ID).find('.img-opacity').stop().fadeTo('slow',1);			
		}
	});
	$('.fileupload-new').mouseout(function(){  
		ID = $(this).attr('id');
		if(parseInt(ID))
		{
			$('#rmvSpn'+ID).hide();
			$('#'+ID).find('.img-opacity').stop().fadeTo('slow', 0.4); 			
		}
	});
});
</script>