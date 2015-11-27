22288882<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/uploadfilemulti.css" />
<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	if($("#leftImage1").val()!='')
	{		
		$("#showLeftImage1").html('<img src="<?php echo base_url().'uploads/advertise/'; ?>'+$("#leftImage1").val()+'" height="100" width="100" />');	
	}
		
	var settings = {
    url: "<?php echo base_url().$this->session->userdata('userType'); ?>/marketing/main_sliderupload",
    method: "POST",
    allowedTypes:"jpg,png,gif,jpeg",
    fileName: "myfile",
    multiple: false,
	dragDropStr:'',
	uploadButtonClass:'',
	showFileCounter:false,
	progressbar:false,
    onSuccess:function(files,data,xhr)
    {	
		$("#leftImage1").val(data);
    },
    afterUploadAll:function()
    {
    },
    onError: function(files,status,errMsg)
    {        
        $("#status").html("<font color='red'>Upload is Failed</font>");
    }
	}
	$("#leftUploadImage1").uploadFile(settings);
	
	if($("#leftImage2").val()!='')
	{	
		$("#showLeftImage2").html('<img src="<?php echo base_url().'uploads/advertise/'; ?>'+$("#leftImage2").val()+'" height="100" width="100" />');			
	}
});
</script>

<style>
.ajax-upload-dragdrop{border:none;
	border-radius:5px;
	text-align:left;
	padding:0;
	width:150px;
	border:0 !important;
	
}
.upload-statusbar{border:none;
	width:300px;
	margin:0;
	padding:5px 0;
}
.upload-progress{width:180px;
	margin: 0 10px 5px 0;
}
.upload-filename{margin:5px 0;
}

.fileupload-new-left img{max-width:100%;
	max-height:100%;
	width:100%;
}

</style>



<section id="main-content">
          <section class="wrapper">
              <!--contant start-->
              <div class="row">
			  	<?php $this->load->view('success_error_message'); ?>
			  	<div class="col-lg-12">
				<ul class="breadcrumbs-alt">
					
					<li>
						<a href="javascript:void(0);" class="current">Center Section</a>
					</li>
				</ul>
			</div>
                 <div class="col-lg-12">
                      <section class="panel">
					  	  <header class="panel-heading">
							  Center Section Image 							 
                          </header>
                          <div class="panel-body">
                <?php echo form_open();?>
                          	  <div class="form-group last">
								  <div class="col-md-12">
                                  	<div class="fileupload fileupload-new" data-provides="fileupload">
                                      <div class="col-sm-4 col-lg-3">
                                            
                                              <div class="fileupload-new fileupload-new-left thumbnail" style="width: 200px; height: 150px;" id="showLeftImage1">
                                             <img src="<?php echo base_url();?>img/no_image.jpg" alt="">
                                             
                                              </div>
                                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
											  <?php echo form_error('slider_image'); ?>
                                              <div>
                                           </div> 
                                       </div>
                                    
                                      <div class="col-sm-3" style="padding-top:50px;">
									  	<input type="hidden" name="slider_image" value="<?php echo $image_name; ?>" id="leftImage1" />
                                        <div id="leftUploadImage1">
                                            <span class="btn btn-danger btn-file">
                                                <span class="" id="imgname">
                                                    <i class="fa fa-paper-clip"></i> Browse image
                                                </span>
                                                 
                                            </span>											
                                        </div>
                                       
                                       </div>
                                        </div>
                                       <div class="col-sm-3" style="padding-top:50px;">
                                       		<input class="form-control" type="text" name="slider_link" placeholder="Image Link" value="<?php echo $slider_link; ?>" />
											<?php echo form_error('slider_link'); ?>
                                       </div>									  
								    </div>
                                    
                                    
                                  
								  <div class="col-sm-12 text-right">
								  	<button class="btn btn-primary" type="submit">Save</button>
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