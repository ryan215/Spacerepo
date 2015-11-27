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
	</style>
    
<section id="main-content">
	<section class="wrapper">
			<div class="col-md-12" style="padding-left:0px;">
						<ul class="breadcrumbs-alt">
								<li>
									<a href="<?php echo base_url().'retailer/myinventory'; ?>">My Inventroy</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="current">Edit Inventory</a>
								</li>
						</ul>
					</div>
              <!--contant start-->
              <div class="row">			  		 					
                  <div class="col-lg-12">
				  		<?php $this->load->view('success_error_message'); ?>
                      <section class="panel">
                          <header class="panel-heading">
                              Edit Inventory
							  
                          </header>
                          <div class="panel-body">
                              <div class="col-lg-12" style="padding:0;">
                              <section class="panel">
                                  <div class="panel-body" style="padding:0;">
								 <?php 
echo form_open();
?>                                                                                           
								 <ul class="summary-list">
                                          <li>
                                         <div class="switch">
              <input type="radio" class="switch-input" name="editinventory" value="add" id="add" checked>
              <label for="add" class="switch-label switch-label-off">+</label>
              <input type="radio" class="switch-input" name="editinventory" value="sub" id="sub">
              <label for="sub" class="switch-label switch-label-on">-</label>
              <span class="switch-selection"></span>
              </div>
                                          </li>
                                          
                                          <li>
                                             <input class="form-control" type="text"  name="inventory" placeholder="">
                                          </li>
                                          <li>
                                              <button type="submit" class="btn btn-space btn-info pull-right">
												  GO
											  </button>
                                          </li>
                                      </ul>
									  </form>
                                  </div>
                              </section> 
                          </div>
						  <div class="col-lg-12 stock-div">
						  	<div class="col-sm-4 state-overview">
                                  <section class="panel">
                                      <div class="symbol symbol1 red">
                                          Stock Left
                                      </div>
                                      <div class="value">
										  <h1>
											<?php echo  $inventory_detail->inventory; ?>
										  </h1>
										  <p>Left</p>
									  </div>
                                  </section>
                              </div>
						  </div>
						  
						  <!--start product detail page-->
						  <div class="col-sm-12">
						  	<div class="col-sm-12 detail-plus">
								Product Detail <a id="hide_show" href="#"><i class="fa fa-plus-circle"></i></a>
								
							</div>
							<div class=" dtl-div" style="display:none;">
								<p>
								<?php
								if(!empty($inventory_detail))
								{
									if($inventory_detail->used)
									{
										echo 'Used Product';
									}
									else
									{
										echo 'Unused Product';
									}
								}
								?></p>
								<?php $this->load->view('retailer/product_managements/product_details_view'); ?>
							</div>
						  </div>
						  <!--enf of product detail page-->
						  
                         </div>
                      </section>

                  </div>
              </div>
              <!--contant end-->
          </section>
      </section>
      <!--main content end-->
	  
  <script>
	$(document).ready(function(){

	  $("#hide_show").click(function(){
		$(".dtl-div").toggle(1000);
	  });
	});
</script>