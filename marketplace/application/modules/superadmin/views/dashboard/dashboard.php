<style>
  ul.doughnut-legend li span {
   float: left;
   height: 10px;
   margin-right: 10px;
   margin-top: 5px;
   padding: 5px;
   width: 10px;
  }
  ul.doughnut-legend li {
   clear: both;
   float: left;
  }
  ul li {
   list-style: outside none none;
  }
  ul.doughnut-legend {
   float: right;
   position: absolute;
   right: 40px;
   top: 60px;
  }
 </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

 
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message');  ?>
    	<!--state overview start-->
             <?php /*?><div class="row state-overview">
        	<div class="col-lg-3 col-sm-6">
            	<section class="panel">
                	<div class="symbol terques">
                    	<i class="fa fa-tags"></i>
                    </div>
                    <div class="value">
                    	<h2><?php echo $totalCategory; ?></h2>
                        <p>Total Category</p>
                    </div>
				</section>
			</div>
		
			<div class="col-lg-3 col-sm-6">
            	<section class="panel">
                	<div class="symbol terques">
                    	<i class="fa fa-laptop"></i>
                    </div>
                    <div class="value">
                    	<h2><?php echo $totalProduct; ?></h2>
                        <p>Total Product</p>
                    </div>
				</section>
			</div>  
		
			 	  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="fa fa-ticket"></i>
                          </div>
                          <div class="value">
                              <h2><?php echo $totalBrands; ?></h2>
                              <p>Total Brands</p>
                          </div>
                      </section>
                  </div>
			
				 <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="fa fa-bars"></i>
                          </div>
                          <div class="value">
                              <h2><?php echo $totalProductType; ?></h2>
                              <p>Total Product Type</p>
                          </div>
                      </section>
                  </div>
				  
				  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="fa fa-map-marker"></i>
                          </div>
                          <div class="value">
                              <h2><?php echo $totalCountry; ?></h2>
                              <p>Total Country</p>
                          </div>
                      </section>
                  </div>
				  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="fa fa-map-marker"></i>
                          </div>
                          <div class="value">
                              <h2><?php echo $totalStates; ?></h2>
                              <p>Total State</p>
                          </div>
                      </section>
                  </div>
				  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="fa fa-map-marker"></i>
                          </div>
                          <div class="value">
                              <h2><?php echo $totalCity; ?></h2>
                              <p>Total City</p>
                          </div>
                      </section>
                  </div>	  	  	  
		</div><?php */?>
		<!--Chart-->
		     <!--main content start-->
	  <div class="col-lg-12 pd">
        <ul class="breadcrumbs-alt">
          <li> <a href="javascript:void(0);" class="current">Dashboard</a> </li>
        </ul>
      </div>
		<div class="row">
        	<div class="col-lg-12">
			<section class="panel">
				 <h4 class="text-center" style="margin-top:0px; padding-top:20px; padding-bottom:20px; font-weight:bold;">Product Upload Report (By CSE)</h4>	
				 <div class="col-sm-2 pull-right">
				 	<select class="form-control selectpicker" onchange="change_map(this.value);">
                    	<option value="1">
                        	Today
                        </option>
	                    <option value="2" <?php if($accVal==2){ ?> selected="selected" <?php } ?>>
                        	Yesterday
                        </option>
 	                   	<option value="3" <?php if($accVal==3){ ?> selected="selected" <?php } ?>>
                        	Week
                        </option>
                    </select>
				 </div>
				 <div id="chartdiv" style="width: 100%; height: 480px;"></div>				 					
			</section>			
			</div>
		</div>	
		<!--Chart-->
        </section>
<?php /*?>
          <section class="wrapper" style="display:none;">
              <!-- page start-->
              <div class="tab-pane" id="chartjs">
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Doughnut
                              </header>
                              <div class="panel-body text-center">
                                  <canvas id="doughnut" height="300" width="400"></canvas>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Line
                              </header>
                              <div class="panel-body text-center">
                                  <canvas id="line" height="300" width="450"></canvas>
                              </div>
                          </section>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Radar
                              </header>
                              <div class="panel-body text-center">
                                  <canvas id="radar" height="300" width="400"></canvas>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Polar Area
                              </header>
                              <div class="panel-body text-center">
                                  <canvas id="polarArea" height="300" width="400"></canvas>
                              </div>
                          </section>
                      </div>
                  </div>
                  
              </div>
              <!-- page end-->
          </section><?php */?>
      </section>
      <!--main content end-->
      <!-- Right Slidebar start -->
   <?php /*?>   <div class="sb-slidebar sb-right sb-style-overlay">
          <h5 class="side-title">Online Customers</h5>
          <ul class="quick-chat-list">
              <li class="online">
                  <div class="media">
                      <a href="#" class="pull-left media-thumb">
                          <img alt="" src="img/chat-avatar2.jpg" class="media-object">
                      </a>
                      <div class="media-body">
                          <strong>John Doe</strong>
                          <small>Dream Land, AU</small>
                      </div>
                  </div><!-- media -->
              </li>
              <li class="online">
                  <div class="media">
                      <a href="#" class="pull-left media-thumb">
                          <img alt="" src="img/chat-avatar.jpg" class="media-object">
                      </a>
                      <div class="media-body">
                          <div class="media-status">
                              <span class=" badge bg-important">3</span>
                          </div>
                          <strong>Jonathan Smith</strong>
                          <small>United States</small>
                      </div>
                  </div><!-- media -->
              </li>

              <li class="online">
                  <div class="media">
                      <a href="#" class="pull-left media-thumb">
                          <img alt="" src="img/pro-ac-1.png" class="media-object">
                      </a>
                      <div class="media-body">
                          <div class="media-status">
                              <span class=" badge bg-success">5</span>
                          </div>
                          <strong>Jane Doe</strong>
                          <small>ABC, USA</small>
                      </div>
                  </div><!-- media -->
              </li>
              <li class="online">
                  <div class="media">
                      <a href="#" class="pull-left media-thumb">
                          <img alt="" src="img/avatar1.jpg" class="media-object">
                      </a>
                      <div class="media-body">
                          <strong>Anjelina Joli</strong>
                          <small>Fockland, UK</small>
                      </div>
                  </div><!-- media -->
              </li>
              <li class="online">
                  <div class="media">
                      <a href="#" class="pull-left media-thumb">
                          <img alt="" src="img/mail-avatar.jpg" class="media-object">
                      </a>
                      <div class="media-body">
                          <div class="media-status">
                              <span class=" badge bg-warning">7</span>
                          </div>
                          <strong>Mr Tasi</strong>
                          <small>Dream Land, USA</small>
                      </div>
                  </div><!-- media -->
              </li>
          </ul>
          <h5 class="side-title"> pending Task</h5>
          <ul class="p-task tasks-bar">
              <li>
                  <a href="#">
                      <div class="task-info">
                          <div class="desc">Dashboard v1.3</div>
                          <div class="percent">40%</div>
                      </div>
                      <div class="progress progress-striped">
                          <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
                              <span class="sr-only">40% Complete (success)</span>
                          </div>
                      </div>
                  </a>
              </li>
              <li>
                  <a href="#">
                      <div class="task-info">
                          <div class="desc">Database Update</div>
                          <div class="percent">60%</div>
                      </div>
                      <div class="progress progress-striped">
                          <div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-warning">
                              <span class="sr-only">60% Complete (warning)</span>
                          </div>
                      </div>
                  </a>
              </li>
              <li>
                  <a href="#">
                      <div class="task-info">
                          <div class="desc">Iphone Development</div>
                          <div class="percent">87%</div>
                      </div>
                      <div class="progress progress-striped">
                          <div style="width: 87%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                              <span class="sr-only">87% Complete</span>
                          </div>
                      </div>
                  </a>
              </li>
              <li>
                  <a href="#">
                      <div class="task-info">
                          <div class="desc">Mobile App</div>
                          <div class="percent">33%</div>
                      </div>
                      <div class="progress progress-striped">
                          <div style="width: 33%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar progress-bar-danger">
                              <span class="sr-only">33% Complete (danger)</span>
                          </div>
                      </div>
                  </a>
              </li>
              <li>
                  <a href="#">
                      <div class="task-info">
                          <div class="desc">Dashboard v1.3</div>
                          <div class="percent">45%</div>
                      </div>
                      <div class="progress progress-striped active">
                          <div style="width: 45%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar">
                              <span class="sr-only">45% Complete</span>
                          </div>
                      </div>

                  </a>
              </li>
              <li class="external">
                  <a href="#">See All Tasks</a>
              </li>
          </ul>
      </div><?php */?>
      <!-- Right Slidebar end -->
<script type="text/javascript">
	$('.selectpicker').selectpicker('show');
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/amcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/serial.js"></script>
<script src="<?php echo base_url(); ?>js/pie.js" type="text/javascript"></script>


<!--common script for all pages-->
<script src="<?php echo base_url(); ?>js/common-scripts.js"></script>


<!--script for this page-->

<script src="<?php echo base_url(); ?>js/count.js"></script>
   
    <!-- script for this page only-->
	<script src="<?php echo base_url();?>js/Chart.js"></script>
	<script>
	
	 var chart;	
	 var chartData = [
	 			<?php
				if(!empty($cseReqTotalProdList))
				{
					foreach($cseReqTotalProdList as $row)
					{
				?>
				{
                    "year": '<?php echo $row->firstName.' '.$row->middle.' '.$row->lastName; ?>',
                    "income": '<?php echo $row->total; ?>'
                },
				<?php
					}
				}
				?>
	 		];

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "year";
                chart.startDuration = 1;
                chart.plotAreaBorderColor = "#DADADA";
                chart.plotAreaBorderAlpha = 1;
                // this single line makes the chart a bar chart
                chart.rotate = true;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.gridAlpha = 0.1;
                valueAxis.position = "top";
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph
                var graph1 = new AmCharts.AmGraph();
                graph1.type = "column";
                graph1.title = "Product";
                graph1.valueField = "income";
                graph1.balloonText = "Product count :[[value]]";
                graph1.lineAlpha = 0;
                graph1.fillColors = "#57c8f2";
                graph1.fillAlphas = 1;
                chart.addGraph(graph1);               

                // LEGEND
                var legend = new AmCharts.AmLegend();
                chart.addLegend(legend);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("chartdiv");
            });
			
function change_map(accVal)			
{
	window.location.href = '<?php echo base_url().'superadmin/dashboard/index/'; ?>'+accVal;
}
			
		
</script>

<style>
body{
		overflow-x: hidden;
	}
</style>

