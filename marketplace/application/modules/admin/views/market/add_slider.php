<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/uploadfilemulti.css" />

<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	var settings = {
    url: "<?php echo base_url().$this->session->userdata('userType'); ?>/marketing/upload_image",
    method: "POST",
    allowedTypes:"jpg,png,gif,jpeg",
    fileName: "myfile",
    multiple: false,
	dragDropStr:'',
	uploadButtonClass:'',
	showFileCounter:true,
	progressbar:true,
	showDone:true,
    onSuccess:function(files,data,xhr)
    {
	$('#sliderimage').val(data);
	
	console.log(xhr);
	  $(".upload-statusbar").remove();  
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
</script>


 <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!--contant start-->
              <div class="row">
                 <div class="col-lg-12">
                      <section class="panel">
					  	  <header class="panel-heading">
							  Middle Section Image
							  <span class="tools pull-right">
								<a class="fa fa-chevron-down" href="javascript:;"></a>
								<a class="fa fa-times" href="javascript:;"></a>
							  </span>
                          </header>
                          <div class="panel-body">
                          	 <?php echo form_open();?>
							  <div class="form-group last">
							  
								  <div class="col-md-12">
								   <div class="col-sm-12" style="padding:0; margin-top:20px;">
										<div class="form-group">
											<label class="col-sm-2 image-label">Image Title</label>
											<div class="col-sm-6">
												<input class="form-control" name="image_title" placeholder="" value="<?php echo set_value('image_title');?>">
												<?php echo form_error('image_title');?>
											</div>
										</div>
									  </div>
								  <div class="col-sm-12" style="padding:0; margin-top:20px;">
										<div class="form-group">
											<label class="col-sm-2 image-label">Image link</label>
											<div class="col-sm-6">
												<input class="form-control" name="slider_link" placeholder="Image Link" value="<?php echo set_value('slider_link');?>">
												<?php echo form_error('slider_link');?>
											</div>
										</div>
									  </div>
								  </div>
								   <div class="col-sm-12" style="padding:0; margin-top:20px;">
										<div class="form-group">
											<label class="col-sm-2 image-label">Slider Text</label>
											<div class="col-sm-6">
												<input class="form-control" name="slider_text" placeholder="slider text" value="<?php echo set_value('slider_text');?>">
													<?php echo form_error('slider_text');?>
											</div>
										</div>
									  </div>
								 
								  
								  
								  <div class="clearfix">
								  </div>
									  <div class="fileupload fileupload-new" data-provides="fileupload">
										
										   <div id="uploadImage">
                            	<span class="btn btn-white btn-file">
		                        	<span class="fileupload-new" id="imgname">
										<i class="fa fa-paper-clip"></i> Select image
									</span>
		                        </span>
							</div>
							  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
											  <img src="<?php echo base_url();?>img/no_image.jpg" alt="" />
										  </div>
										  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
										  <div>
									<input type="hidden" name="slider_image" id="sliderimage" />
									<?php echo form_error('slider_image');?>
										  </div>
									  </div>
									 
								  <div class="col-sm-12 text-right">
								  	<button class="btn btn-primary" type="submit">Submit</button>
								  </div>
							  </div>                  
							  </form>           
                          </div>
                      </section>
                  </div>
              </div>
              <!--contant end-->
          </section>
      </section>
      <!--main content end-->