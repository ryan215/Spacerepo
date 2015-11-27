<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
 
 var settings = {
    url: "<?php echo base_url().$this->session->userdata('userType'); ?>/marketing/main_sliderupload",
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
  // $(".upload-statusbar").remove();  
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
<div class="modal-dialog segment-model">
	<div class="modal-content">
    	<div class="modal-header modal-header1 segment-header">
        	<button type="button" class="close close-btn" data-dismiss="modal"><span aria-hidden="true"><img src="<?php echo base_url();?>img/close.png"></span><span class="sr-only">Close</span></button>
        </div>
        
		<div class="modal-body modal-body-custom">
        	<section class="panel">
            	<header class="panel-heading rform-header">
                	<?php
					if($sliderID)
					{
						echo 'Edit';
					}
					else
					{
						echo 'Add';
					}
					?>
					Slider Image
                  </header>
                      <div class="panel-body">
                    
                          <div class="tab-content">
                              <div class="tab-pane active" id="home">
                                  <div class="row">
                                      <div class="col-sm-12  form-div">
                                      <p>Please Use the 1000*460 image size to upload.</p>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                             	<div class="col-sm-12">
                                                	 <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                          <img src="<?php echo base_url();?>img/no_image.jpg" alt="" />
                                                      </div>
                                                     <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                <div>	
                                              </div>
                                              
                                          </div>
                                          <?php echo form_open();?>
                                            <input type="text" name="slider_image" id="sliderimage" value="<?php echo $slider_image; ?>" />
											<input type="text" name="slider_id" value="<?php echo $sliderID; ?>" />
                                          <div class="col-sm-5 text-left" style="padding-top:10px;">
                                               <div id="uploadImage">
                                                    <span class="btn btn-danger btn-file">
                                                        <span class="" id="imgname">
                                                            <i class="fa fa-paper-clip"></i> Browse image
                                                        </span>
                                                         
                                                    </span>
                                                </div>
                                           </div>
                                      </div>
                                      <div class="col-sm-12" style="padding:10px 0;">
                                            <div class="col-sm-12" style="">
                                                <input type="text" name="slider_link" class="form-control model-input" placeholder="Image link" value="<?php echo $slider_link; ?>">
                                            </div>
                                      </div>
                                      <div class="col-sm-12" style="padding:10px 0 0;">
                                          <div class="col-sm-12 text-right">
                                            <input  type="submit" class="btn btn-success" value="Save" >
                                          </div>
                                      </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                 
             </section>
      </div>
    </div>
  </div>
</div>