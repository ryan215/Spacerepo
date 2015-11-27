<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />
<style>
label{
	background-image:none;
}

.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}

.panel-heading .nav > li > a{
	font-size:15px;
	font-weight:600;
}

.nav-justified {background:#bcc1c5;
}

.table-invoice > thead > tr > th{color:#FFF;
}

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
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
				
					<li>
						<a href="javascript:void(0);" class="current">Semantics List</a>
					</li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
					
						<div class="panel-body">
							<section class="panel custom-panel" style="margin-bottom:0;">
									<div style="padding:0;" class="col-lg-12">
										<div class="col-sm-5 " style="padding: 0px;">									
											<div class="col-sm-3" style="padding-left:5px;">
											<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/addEditProduct'; ?>" class="btn btn-sm btn-shadow btn-success hvr-push" style="float:left;">
											<i class="fa fa-plus"></i> Add
										</a>
											</div>
																				
										</div>
										<div class="col-sm-7" style="padding-right:0px;">
											<div class="input-group m-bot15">
													<input type="text" placeholder="Enter Product Name" id="search" class="form-control">
													<span class="input-group-btn">
															<button class="btn btn-danger" type="button" onclick="ajaxPage();"><i class="fa fa-search"></i> Search</button>
														  </span>
											 </div>
										</div>
									</div>	
							</section>
							<section class="panel custom-panel" id="ajaxData">
							<div class="bs-example">
								<div class="panel-group" id="accordion">
							
								</div>
							</div>
								<!---->	
							</section>
							                         
						</div>
                </section>
            </div>
              </div>
              <!--contant end-->
          </section>
      </section>
	  
<script type="text/javascript">
$('.selectpicker').selectpicker('show');


function ajaxPage()
{ 
 postData = 'search='+$('#search').val();
 ajax_function('<?php echo base_url().$this->session->userdata('userType'); ?>/semantics/ajax_product_list','#accordion',postData); 
}


/* ensure any open panels are closed before showing selected */
$('#accordion').on('show.bs.collapse', function () {
    $('.collapse .in').collapse('hide');
});
document.getElementById("search").addEventListener("keydown", function(e) {
    if (!e) { var e = window.event; }
    // sometimes useful

    // Enter is pressed
    if (e.keyCode == 13) { ajaxPage(); }
}, false);
</script>
<style>
.padding_left_zero{
	padding-left:0px;
}
.padding_right_zero{
	padding-right:0px;
}
.semantics_box{

}
.one_box{ bottom: 0;
  box-shadow: 0 -1px 0 #e5e5e5,0 0 2px rgba(0,0,0,.12),0 2px 4px rgba(0,0,0,.24);
  padding:5px; cursor:pointer; margin-bottom:10px;
 }
.one_box tr td{ padding:5px; font-weight:bold; } 
dl{ margin:0px;}
dd { 
    display: inline-block;
    margin-left: 14px;
}
.panel-heading{ padding:0px;}
</style>