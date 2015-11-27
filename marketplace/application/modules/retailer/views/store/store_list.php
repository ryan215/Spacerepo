<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
   	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/logo.png">
	<title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>css/retailer/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/shipping/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/retailer/hover-min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/retailer/shipping_pp_pm_login.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		body{background-color:#ffffff;
		}
		.header-store{background-color:#92C759;
			 padding:5px;
			 text-align:center;
			 font-size:16px;
			 color:#fff;
		}
		.store-modal{padding-top:0;
			 padding-bottom:0;
			
		}
		.store-model-main{max-width:380px;
		}
		.store-input{border-radius:30px !important;
			width:90%;
			margin:0 auto !important;
			height:38px;
		}
		.btn-adstore{border-radius:30px !important;
			background-color:#7DBE4D;
			border-color:#7DBE4D;
		}
		.btn-adstore:hover{background-color:#79ba49;
			border-color:#79ba49;
		}
		.close-store{opacity:1;
			position: absolute;
			right: -12px;
			top: -12px;
		}
		.close-store img{width:35px;
		}
		
		.labels-radio{margin-right:5px;
			font-weight:normal;
		}
		
		input[type=radio] {
	    display:none;
		}
		input[type=radio] + label:before {
			content: "";  
			display: inline-block;  
			width: 15px;  
			height: 15px;  
			vertical-align:middle;
			margin-right: 8px;  
			border:1px solid #666;
			border-radius: 8px;  
		}
	
		input[type=radio]:checked + label:before {
			content: "\2022";
			color:#99CB5D;
			font-size:2em;
			text-align:center;
			line-height:10.7px;
			text-shadow:0px 0px 3px #eee;
		}
		
		.store-div-box{border:1px solid #ccc;
			padding:20px 20px 10px 20px;
			vertical-align:middle;
			transition:all ease-out 0.2s;
			height:262px;
			overflow:hidden;
			text-align:center;
		}
		
		.store-div-box img{max-width:100%;
			max-height:194px;
		}
		
		.store-div-box-main a{text-decoration:none;
		}
		
		.store-div-box-main{max-height:262px;
			margin-bottom:18px;
		}
		
		.store-div-box:hover{box-shadow:1px 2px 2px rgba(0,0,0,0.2);
		}
		
		.store-div-box p{color:#333;
			font-size:17px;
			margin:10px 0 0 0;
			text-align:center;
			text-decoration:none;
		}

	
	</style>
	<script src="<?php echo base_url(); ?>js/retailer/jquery-1.11.1.js"></script>
	<script src="<?php echo base_url(); ?>js/retailer/bootstrap.min.js"></script>
	<script type="text/javascript">
		base_url = '<?php echo base_url(); ?>';
	</script>

  </head>
<body style="">

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog store-model-main">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close close-store" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php echo base_url();?>images/close.png"></span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Add Store</h4>
      </div>
      <div class="modal-body store-modal">
        <div class="row">
        	<div class="col-sm-12 text-center" style="padding:10px 0;">
            	<img src="<?php echo base_url();?>img/on-img.png">
                <p>Upload Store Image</p>
            </div>
            <div class="col-sm-12 form-group" style="">
                <input class="form-control store-input" placeholder="Store Id">
            </div>
            <div class="col-sm-12 text-center" style="padding-bottom:10px;">
            	<label class="signup-labels" style="margin-bottom:5px;">Signing In For</label><br />
								
                <input type="radio" name="associationType" value="1" id="associationType1" />
                <label for="associationType1" class="labels-radio">Pointe Mart</label>
                <input type="radio" name="associationType" value="2" id="associationType2"/>
                <label for="associationType2" class="labels-radio">Pointe Pay</label>
                <input type="radio" name="associationType" value="3" id="associationType3"/>
                <label for="associationType3" class="labels-radio">Both</label>
            </div>
        	<div class="col-sm-12 header-store">
            	Store Manager Details
            </div>
        	<div class="col-sm-12">
            	<div class="form-group" style="margin-top:15px;">
                	<input class="form-control store-input" placeholder="First Name">
                </div>
                <div class="form-group">
                	<input class="form-control store-input" placeholder="Last Name">
                </div>
                <div class="form-group">
                	<input class="form-control store-input" placeholder="Phone Number">
                </div>
                <div class="form-group">
                	<input class="form-control store-input" placeholder="Email Address">
                </div>
            </div>
            <div class="col-sm-12 header-store">
            	Address
            </div>
            <div class="col-sm-12">
            	<div class="form-group" style="margin-top:15px;">
                	<select class="form-control store-input">
                    	<option>Select State</option>
                        <option>MP</option>
                        <option>UP</option>
                    </select>
                </div>
                <div class="form-group">
                	<select class="form-control store-input">
                    	<option>Select Area</option>
                        <option>Indore</option>
                        <option>Dewas</option>
                    </select>
                </div>
                <div class="form-group">
                	<input class="form-control store-input" placeholder="Street">
                </div>
                
            </div>
        </div>
      </div>
      <div class="modal-footer" style="text-align:center;">
        <button type="button" class="btn btn-success btn-adstore">Add Store</button>
      </div>
    </div>
  </div>
</div>

<!--main-container open-->
<div class="main-container">

    <!--Header Open-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="padding:20px 0 0 0;">
                <div class="col-sm-6  col-lg-5 col-md-5  col-xs-12 logo">
                    <a href="javascript:void(0);" title="Logo">
                        <img class="pm-logo" src="<?php echo base_url(); ?>images/pointemart_logo_pm_pp.png" alt="Logo" />
                    </a>
                    <span class="logo-divider"><img src="<?php echo base_url(); ?>images/logo-divider.png"/></span>
                    <a href="javascript:void(0);" title="Logo">
                        <img class="pp-logo" src="<?php echo base_url(); ?>images/pointpay_logo_pm_pp.png" alt="Logo"/>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-7 col-xs-12 top-btn-div">
                
                    <a class="btn btn-shiping-sign" data-toggle="modal" data-target="#myModal">
                        Add
                    </a>

                </div>
            </div>
        </div>
    </div>	
    <!--Header CLose-->
    
    <!--start main contant-->
    <div class="container">	
    	<div class="col-sm-12 pd" style="padding:50px 0 30px 0;">
        	<div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/ad-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/ad-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/ad-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
            <div class="col-sm-3 store-div-box-main">
            	<a href="#">
                <div class="store-div-box">
                	<img src="<?php echo base_url();?>images/store-img.png">
                    <p>Store Name</p>
                </div>
                </a>
            </div>
        </div>
    </div>
        
</div>


</body>
</html>