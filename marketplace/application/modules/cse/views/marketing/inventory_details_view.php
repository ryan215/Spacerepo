 <style>
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
		 small {
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

<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?> 
        <!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().'cse/product_management'; ?>">
							Product Management
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'cse/product_marketing_management'; ?>">
							Campaign Management Products
						</a>
					</li>									
					<li>
						<a class="current" href="javascript:void(0);">
							Inventory Details
						</a>
					</li>
				</ul>
			</div>
			<?php $this->load->view('admin/marketing/inventory_details'); ?> 
		</div>
		<!--contant end-->
	</section>
</section>
<!--main content end-->