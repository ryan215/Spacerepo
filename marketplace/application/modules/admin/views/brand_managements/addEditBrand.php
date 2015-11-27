<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />
<section id="main-content">
  <section class="wrapper">
  <div class="row">
    <div class="col-md-12">
      <ul class="breadcrumbs-alt animated fadeInLeft">
        <li> <a href="<?php echo base_url().'admin/brand_management'; ?>"> Brand List </a> </li>
        <li> <a href="javascript:void(0);" class="current">
          <?php
					if($brandId)
					{
						echo 'Edit ';
					}
					else
					{
						echo 'Add ';
					}
					?>
          Brand</a> </li>
      </ul>
    </div>
  </div>
  <?php echo form_open();?>
    <div class="row">
      <div class="col-md-12" style="padding:0;">
        <div class="col-lg-12">
          <?php $this->load->view('upload_image_in_js'); ?>
          <section class="panel" style="">
          <header class="panel-heading panel-heading1">
            <?php
					if($brandId)
					{
						echo 'Edit ';
					}
					else
					{
						echo 'Add ';
					}
					?>
            Brand</header>
          <div class="panel-body" style="line-height:21px;">
            <div style="max-width:50%; margin:0 auto; padding-top:30px;">
            
            <div class="form-group col-sm-12" style="margin-top:10px;">
                <div class="col-sm-4"> <label for="countryName" style="float:left; line-height:33px;"> Image</label>&nbsp;<span class="error">*</span> </div>
                <div class="col-sm-8 pd">
                  <input type="hidden" name="image_name" id="hideImage" value="<?php echo $result['brand_image']; ?>" />
                  <div id="uploadImage"> <span id="imgname">
                    <?php
												$image = '<img class="img-circle" src="'.base_url().'images/default_user_image.jpg" height="100" width="100">';		
												if((!empty($result['brand_image']))&&(file_exists('uploads/brand/'.$result['brand_image'])))											
												{
													$image = '<img height="100" width="100" class="img-circle" src="'.base_url().'uploads/brand/thumb50/'.$result['brand_image'].'" alt="" />';													
												}
												echo $image;
												?>
                    &nbsp;&nbsp;&nbsp;&nbsp; 
                    Upload your display image <i class="fa fa-paper-clip"></i>  </span> </div>
                  <?php echo form_error('image_name'); ?> </div>
              </div>
            
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label for="countryName" style="float:left; line-height:33px;"> Brand </label>
                  &nbsp;<span class="error">*</span></div>
                <div class="col-sm-8 padding_left_zero">
                  <input type="hidden" name="brand_id" value="<?php echo $brandId; ?>" />
                  <input type="text" class="form-control" placeholder="Brand Name" name="brand_name" value="<?php echo $result['brand_name']; ?>">
                  <?php echo form_error('brand_name'); ?> </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label for="countryName" style="float:left; line-height:33px;"> Description </label>
                  </div>
                <div class="col-sm-8 padding_left_zero">
                  <textarea name="brandDescription" class="form-control" style="width:100%;"><?php echo $result['brandDescription']; ?></textarea>
                  <?php echo form_error('brandDescription'); ?> </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 form-div padding_right_zero">
            <div class="col-sm-12 text-right padding_right_zero"> <a class="btn btn-danger btn-save" href="<?php echo base_url(); ?>admin/brand_management">Cancel</a>
              <button class="btn btn-success btn-save">Save</button>
            </div>
          </div>
        </div>
        </section>
      </div>
    </div>
    </div>
  </form>
</section>
</section>
<style>
label{
	background-image:none;
}

.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}
.r-activity{margin-top:0;
	font-size:10px;
}

.r-activity1{
	display:inline-block;
	height: 32px;
	font-size: 14px;
	padding: 5px;
	margin-top:1px;
	float:right;
}

.ftrBoxID{
	margin: 12px 0 0 0px;
	display:flex;
}

.ftrBoxID input{width:100%;
}

.ftrAjaxID
{
	text-align:right !important;
	
}
.edit-btns{float:right;
	  float: right;
	  height: 32px;
	  padding: 5px;
	  font-size: 14px;
	  margin: 1px 2px;
}

.block-element label{float:left;
	margin-right:18px;
}

.ajax-upload-dragdrop{
	width:325px !important;
	padding: 0 !important;
	margin:0 !important;
}

.ajax-upload-dragdrop input{height:104px !important;
}

#imgname{color:#8b8b8b !important;}

#imgname img{box-shadow:0 0 1px rgba(0,0,0,0.2);
	border:1px solid #E1E1E1;
}
</style>
