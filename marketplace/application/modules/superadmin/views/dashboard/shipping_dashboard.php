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
<script type="text/javascript" src="<?php echo base_url(); ?>js/amcharts.js"></script>
<script src="<?php echo base_url(); ?>js/pie.js" type="text/javascript"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

      <!--main content start-->
<section id="main-content">
	<section class="wrapper" >
		<?php $this->load->view('success_error_message');  ?>
    	<!--state overview start-->
        <div class="row state-overview">
        		  <div class="col-lg-3 col-sm-6">
            	<section class="panel">
                	<div class="symbol terques">
                    	<i class="fa fa-tags"></i>
                    </div>
                    <div class="value">
                    	<h2><?php echo $total_new_orders; ?></h2>
                        <p>New Orders</p>
                    </div>
				</section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="fa fa-tags"></i>
                          </div>
                          <div class="value">
                              <h2 class=""><?php echo $total_ready_orders; ?></h2>
                              <p>Ready To Be Shipped</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="fa fa-tags"></i>
                          </div>
                          <div class="value">
                              <h2 class=""><?php echo $total_transit_orders; ?></h2>
                              <p>Shipped In Transit</p>
                          </div>
                      </section>
                  </div>
				  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="fa fa-tags"></i>
                          </div>
                          <div class="value">
                              <h2 class=""><?php echo $total_deliverd_orders; ?></h2>
                              <p>Products Delivered</p>
                          </div>
                      </section>
                  </div>
		</div>
		<!--Chart-->
		
		<div class="row">
			<div class="col-lg-12">
				<section class="panel" style="padding: 25px;">
                	<!--custom chart start-->
                    <div class="border-head">
                    	<h3>New Order</h3>
                    </div>
					<div id="chartdivMonth" style="width: 100%; height: 355px;"></div>
                    
                    <!--custom chart end-->
				</section>
			</div>
		</div>
		<!--Chart-->
		
		<!--Pie Chart-->
		<div class="row">
        	<div class="col-lg-12">
				<section class="panel">
					<div class="col-sm-2 pull-right" style="margin-top:20px;">
				 		<select class="form-control" onchange="change_graph(this.value);">
							<?php
							foreach($month_list as $key=>$value)
							{
							?>
							<option value="<?php echo $key; ?>" <?php if($key==date('M')){ ?> selected="selected" <?php } ?>><?php echo $key; ?></option>
							<?php
							}
							?>
						</select>
					</div>
					<div id="chartdiv" style="height: 450px;"></div>
				</section>
			</div>
		</div>	
	</section>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>js/amcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/serial.js"></script>

<script type="text/javascript">
var chart;
var chartData = [
	<?php
	foreach($month_list as $key=>$value)
	{
	?>
	{
   		country: "<?php echo $key; ?>",
    	visits: '<?php echo $value['total']; ?>'
	},
	<?php
	}
	?>
	];

AmCharts.ready(function() {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "country";
    chart.startDuration = 1;

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.labelRotation = 90;
    categoryAxis.gridPosition = "start";

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.
    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "visits";
    graph.balloonText = "[[category]]: [[value]]";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 0.8;
    chart.addGraph(graph);
    
    chart.addListener("clickGraphItem", function (event) {
        // let's look if the clicked graph item had any subdata to drill-down into
        if (event.item.dataContext.subdata != undefined) {
            // wow it has!
            // let's set that as chart's dataProvider
            event.chart.dataProvider = event.item.dataContext.subdata;
            event.chart.validateData();
        }
    });

    chart.write("chartdivMonth");
});

function change_graph(monthNM)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'admin/dashboard/vendor_month/'; ?>',
		data:'month_name='+monthNM+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#chartdiv').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			var chartData = jQuery.parseJSON(result);
			// PIE CHART
			chart = new AmCharts.AmPieChart();
			chart.dataProvider = chartData;
			chart.titleField = "country";
			chart.valueField = "value";
			chart.outlineColor = "#FFFFFF";
			chart.outlineAlpha = 0.8;
			chart.outlineThickness = 2;
			chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
			// this makes the chart 3D
			chart.depth3D = 15;
			chart.angle = 30;
			// WRITE
			chart.write("chartdiv");
		}
	});
}

change_graph('<?php echo date('M'); ?>');
</script>