<section id="main-content">
          <section class="wrapper">
		  		<?php $this->load->view('success_error_message'); ?> 
              <!--contant start-->
              <div class="row">
			  	  <div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a class="current" href="javascript:void(0);">
							Dashboard
						</a>
					</li>
				</ul>
			</div>
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading panel-heading1">
                              Dashboard							  
                          </header>
                          <div class="panel-body">
                              
						  <div class="col-lg-12 pd">
                                  <section class="panel">
                                      <span class="ac_head">
                                         Account Status -
                                     </span>
                                   <label class="status_label">Unverified</label>                                   
                                   <div class="log-in-box  main-shi-div  verify-maindiv" style="max-width:500px; margin:0 auto; display:table;">
                                   <?php 
echo form_open();
?>
                                   <div class="form-group">
                                   <div class="col-sm-12" style="padding-bottom:20px;">
                            		<label for="">Email</label>
                                	<input type="text" placeholder="Email" name="" class="form-control " value="" id="">
                                   </div>
								   </div>
                                   <div class="form-group">
                                   <div class="col-sm-12" style="padding-bottom:20px;">
                            		
                                    <label for="">Phone No.</label><span class="error">*</span>
                                	<div class="input-group">
                                     <span class="input-group-addon" style="background-color: #eee !important; font-size:14px;">+234</span>
                                     <input type="text" name="businessPhone" class="form-control" placeholder="Phone No." value="">
									 <input type="hidden" name="countryCode" value="+234" >
								
                                  </div>
								  	 <?php echo form_error('businessPhone');?>
                                   </div>
								   </div>
                                   <div class="form-group">
                                   <div class="col-sm-12" style="padding-bottom:20px;">
                                   <button class="btn btn-success col-sm-12" type="submit" >Submit</button>
                                   </div>
                                   </div>
                                   </form>
                                   </div> <br />
                                   <div class="clearfix"></div> 
                                                                   
                                  </section>
						  </div>
                         </div>
                      </section>
                  </div>
              </div>
              <!--contant end-->
          </section>
      </section>
      <!--main content end-->
<style>
.ac_head{  color: #1FB5AD;  font-weight: 700;  font-size: 22px; }
.status_label { text-transform:capitalize;top: -1px;position: relative;}
.verify-input{width:45px;
			height:55px;
			float:left;
			margin-right:6px;
			box-shadow:0px 0px 2px rgba(0,0,0,0.2);
			font-size:17px;
		
		}
		.veify-p{text-align:center;
		}
		.verify-maindiv{width:420px;
			margin:0 auto;
			background-color:#fff;
		}
		.fivedigit-inputs{padding-left:53px;
		}
		.verify-text{font-size:15px;
			text-align:left;
		}
		
		.main-verfy-div{padding-bottom:90px;
		}
		.main-shi-div{box-shadow: 0 0 7px #ccc;
    padding: 12px 35px 6px;
	background-color:#fff;
}
.shipping-form h2{color:#444444;
	text-align:center;
	margin-bottom:29px;
	font-size:19px;
}

.ship-input{height:45px;
	box-shadow:none;
	border-radius:1px !important;
}
.switch {
    position: relative;
    height: 26px;
    width: 120px;
    margin: 10px 0 0;
    background: #F1F2F7;
    border-radius: 3px;
    text-align:center;
  
  }
  
  .switch-label {
    position: relative;
    z-index: 2;
    float: left;
    width: 58px;
    line-height: 26px;
    font-size: 11px;
    color: #666;
    text-align: center;
    font-size:25px;
    cursor: pointer;
    padding-left:0 !important;
  }
  .switch-label:active {
    font-weight: bold;
  }
  
  .switch-label-off {
    padding-left: 2px;
  }
  
  .switch-label-on {
    padding-right: 2px;
  }
   small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 100%;
}

  
  .switch-input {
    display: none;
  }
  .switch-input:checked + .switch-label {
    font-weight: bold;
    color: #fff;
    text-shadow: 0 1px rgba(255, 255, 255, 0.25);
    -webkit-transition: 0.15s ease-out;
    -moz-transition: 0.15s ease-out;
    -ms-transition: 0.15s ease-out;
    -o-transition: 0.15s ease-out;
    transition: 0.15s ease-out;
    -webkit-transition-property: color, text-shadow;
    -moz-transition-property: color, text-shadow;
    -ms-transition-property: color, text-shadow;
    -o-transition-property: color, text-shadow;
    transition-property: color, text-shadow;
  }
  .switch-input:checked + .switch-label-on ~ .switch-selection {
    left: 60px;
    / Note: left: 50%; doesn't transition in WebKit /
  }
  
  .switch-selection {
    position: absolute;
    z-index: 1;
    height: 100%;
    left: 2px;
    display: block;
    width: 60px;
    border-radius: 3px;
    background-color: #8CB94D;
    -webkit-transition: left 0.15s ease-out;
    -moz-transition: left 0.15s ease-out;
    -ms-transition: left 0.15s ease-out;
    -o-transition: left 0.15s ease-out;
    transition: left 0.15s ease-out;
  }
		label{background-image:none;
		}
		.chosen-container-single .chosen-single{background:none !important;
			border:1px solid #CCC !important;
			border-radius:4px !important; 
		}
		.panel-heading .nav > li > a{font-size:15px;
			font-weight:600;
		}
		
		 .table-invoice tr th{color:#FFF;
		}
		.summary-list li{height:45px;
		}
		
		.summary-list li:first-child{width:15%;
		}
		.summary-list li:nth-child(2){width:20%;
			padding: 5px 9px 5px 5px;
			vertical-align:top;
		}
		.summary-list li:last-child{width:10%;
			text-align:center;
			padding:5px 15px;
		}
		.summary-list .r-activity{margin:0;
		}
		.btn-space{padding:5px 20px;
		}
		.symbol1{font-size: 21px;
			color:#fff;
		}
		.detail-plus{font-size:21px;
		}
		.detail-plus i{font-size:34px;
			padding-left:10px;
		}
		.stock-div{border-bottom:1px solid #ccc;
			margin-bottom:15px;
		}
		
		.stock-left-numbers{padding: 0px 21px ! important; text-align: center;
		}
		
		.stock-red-div{float:left;
			background-color:#fff !important;
			color:#1FB5AD;
			width:160px !important;
			font-weight:700;
			font-size:22px;
			text-align:left !important;
		}
		.stock_table tr td{ padding:5px !Important;}
		.sizes_label{
		top: -2px;
  		position: relative}
		input[type=checkbox] {
			  margin: 4px 8px 0px !important;
			  line-height: normal;
			}
			.color-filter small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 14px;
}
.block-element label {
  float: left;
  margin-right: 18px;
}
.color-filter .block-element {float:left;
}
</style>
	  