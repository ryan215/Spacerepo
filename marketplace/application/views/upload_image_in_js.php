<style>
.ajax-upload-dragdrop
{
	padding:10px 13px 0px 26px !important; 
	border:none !important; 
}

.fileupload-exists
{
	padding:10px 13px 0px 26px !important;
}
</style>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/uploadfilemulti.css" />
<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	if($("#hideImage").val()!='')
	{
		<?php
		//if((!empty($image_name))&&(file_exists('uploads/'.$this->session->userdata('userType').'/'.$image_name)))											
		{
		?>
		$("#imgname").html('<img class="img-circle" src="<?php echo $imagePath; ?>'+$("#hideImage").val()+'" height="100" width="100" />');
		<?php
		}
		?>
	}
		
	var settings = {
    url: "<?php echo $imageUploadPath; ?>",
    method: "POST",
    allowedTypes:"jpg,png,gif,jpeg",
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
		$("#hideImage").val(data);		
		$("span#imgname").html($("div.upload-statusbar:first > div.upload-filename").html());
		$("div.upload-statusbar").hide();
        $("#status").html("<font color='green'>Upload is success</font>");
        $("#imgname").html('<img class="img-circle" src="<?php echo $imagePath; ?>'+data+'" height="100" width="100" />');
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