<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management'; ?>">
							Shipping Vendor List
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($shippingOrgId); ?>">
							View
						</a>
					</li>
                    <li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId); ?>">
							Shipping Rates List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Add Rate List
						</a>
					</li>
				</ul>
			</div>
			
			<div class="col-lg-12">
				<section class="panel">
					<!----------------->
					


<!--start main contant-->
<div class="container" style="display:inline-bock; width:100%;">		
	<div class="col-sm-12">
    	<div class="col-sm-12">
        	<div class="col-sm-12 log-in-box  main-shi-div" style="padding-top:20px;">
				<?php 
$attributes = array('class' => 'form-horizontal shipping-form','method' => 'post');
echo form_open('',$attributes);
?>

                    	<div class="col-sm-8 padding-bottom">                        
                        	<div class="icon-addon"> 
								<input type="hidden" name="image_name" id="hideImage" value="<?php echo set_value('image_name'); ?>" />
								<div id="uploadImage">
									<span id="imgname">
										<img class="img-circle" src="<?php echo base_url().'images/239389-upload_arrow_up-128.png'; ?>" height="100" width="100" style=" width: 9%;  height: 40px;">
										&nbsp;&nbsp;
										<button type="button" data-loading-text="Loading..." class="btn btn-primary">Upload Your Rate List</button> <a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/file_download'; ?>" style="color: #7bc570; text-decoration:none; top:0px; padding-left:20px; position:relative;">
								(<i class="fa fa-arrow-circle-down"></i> Download Sample Document  Format)
							</a>
									</span>
								</div>								
                            </div>
							<div id="imgErr" class="error"></div>
							<div id="phpErrMsg"><?php echo form_error('image_name'); ?></div>
							
 						</div>
						<div class="clearfix"></div><br><br>
						<div style="">
                        <div style="padding-bottom:20px; margin-left:20px !important; ">
                            <button type="submit" class="btn btn-success  ship-sign-btn">Save</button>
                        </div>
						</div>
                    </form>  
                </div>
            </div>
           
        </div>
	</div> 
					<!---------------->							
				</section>
			</div>
		</div>		
	</section>
</section>		
<!--main content end-->

<script src="<?php echo base_url(); ?>js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
base_url = '<?php echo base_url(); ?>';
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/upsloadfilemulti.css" />
<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#imgErr").html('');	
	var settings = {
    url: "<?php echo base_url().$this->session->userdata('userType').'/vendor_management/upload_document_excel'; ?>",
    method: "POST",
    allowedTypes:"xlsx",
    fileName: "myfile",
    multiple: false,
	dragDropStr:'',
	uploadButtonClass:'',
	showFileCounter:false,
	progressbar:true,
	formData:{
  		'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
	},
    onSuccess:function(files,data,xhr)
    {	
		$("#imgErr").html('');
		$("#phpErrMsg").html('');
		
		dats = $.parseJSON(data); 
		console.log(dats);
		if(dats.error=='')
		{
			$("#hideImage").val(dats.newImageName);		
			$("span#imgname").html($("div.upload-statusbar:first > div.upload-filename").html());
			$("div.upload-statusbar").hide();
        	$("#status").html("<font color='green'>Upload is success</font>");
	        $("#imgname").html('<img class="img-circle" src="<?php echo base_url().'images/239389-upload_arrow_up-128.png'; ?>" height="100" width="100" style=" width: 9%;  height: 40px;"><span>'+dats.newImageName+'</span>');
		}
		else
		{
			$("#imgErr").html(dats.error);
		}
    },
    afterUploadAll:function()
    {
        //alert("all images uploaded!!");
    },
    onError: function(files,status,errMsg)
    {        
        $("#status").html("<font color='red'>Upload is Failed</font>");
    }
	}
	$("#uploadImage").uploadFile(settings);
});
$(function() { 
    $(".btn").click(function(){
        $(this).button('loading').delay(1000).queue(function() {
            $(this).button('reset');
            $(this).dequeue();
        });        
    });
});
</script>
<style>
body{ overflow-x:hidden !important; } 
.uImg {
   height: 40px !important;
  width: 225px !important;
}
</style>