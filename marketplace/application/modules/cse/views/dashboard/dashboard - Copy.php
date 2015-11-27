<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
        	<div class="col-lg-12">
            	
                	<?php
					$this->load->view('success_error_message'); 
					?>            
					
                   
					<div class="row state-overview">
						<div class="col-lg-3 col-sm-6">
						  <section class="panel">
								  <div class="symbol terques">
									  <i class="fa fa-user"></i>
								  </div>
								  <div class="value">
									  <h1 class="countmy"><?php echo $total_cse_product; ?></h1>
									  <p>Total Number of Products Awaiting Review</p>
								  </div>
						  </section>
					  </div>
					  	<div class="col-lg-3 col-sm-6">
						  <section class="panel">
								  <div class="symbol red">
									  <i class="fa fa-user"></i>
								  </div>
								  <div class="value">
									  <h1 class="countmy"><?php echo $total_my_product; ?></h1>
									  <p>Total Number of Products Awaiting My Review</p>
								  </div>
						  </section>
					  </div>
					  	<div class="col-lg-3 col-sm-6">
						  <section class="panel">
								  <div class="symbol yellow">
									  <i class="fa fa-user"></i>
								  </div>
								  <div class="value">
									  <h1 class="countmy"><?php echo $total_send_more_my_product; ?></h1>
									  <p>Total Number of Products sent back for more info</p>
								  </div>
						  </section>
					  </div>
					  	<div class="col-lg-3 col-sm-6">
						  <section class="panel">
								  <div class="symbol blue">
									  <i class="fa fa-user"></i>
								  </div>
								  <div class="value">
									  <h1 class="countmy"><?php echo $retailer_count; ?></h1>
									  <p>Total Number of Retailers Assigned to Me</p>
								  </div>
						  </section>
					  </div>
                    </div>
					<section id="unseen">
							
                    </section>
                	</div>
            	
        	</div>
		<!--Chart-->
		<div class="row">
        	<div class="col-lg-12">
			<section class="panel">
				 <div id="chartdiv" style="width: 100%; height: 600px;"></div>
						
			</section>
			</div>
		</div>	
		<!--Chart-->
		
		<!--Pie Chart-->
		<div class="row">
        	<div class="col-lg-6">
			<section class="panel">
				 <div id="chartdiv1" style="height: 450px;"></div>
				<center><h5 style="position: relative;top: -55px; font-weight:bold; color:#000;">Top Selling<br> Retailer based on Categories</h5></center>
			</section>
			</div>
			<div class="col-lg-6">
			<section class="panel">
				 
				 <div id="chartdiv2" style="height: 450px;"></div>
				<center><h5 style="position: relative;top: -55px; font-weight:bold; color:#000;">Top Trending<br /> Products/Categories</h5></center>		
			</section>
			</div>
		</div>	
		<!--Pie Chart-->	
		
		<div class="row state-overview">
						<div class="col-lg-2 col-sm-2">
						  <section class="panel">
								 
								  <div class="value" style="background-color:#fff; width:100%;">
								   <div class="symbol terques">
									  <i class="fa fa-tags"></i>
								  </div>
									  <h1 class="countmy">
										&#x20A6;<?php echo number_format($total_sale_amount_product,2); ?>
									  </h1>
									  <p style="padding-bottom: 27px;">Total Sales</p>
								  </div>
						  </section>
					  </div>
					  	<div class="col-lg-2 col-sm-2">
						  <section class="panel">
								 
								  <div class="value" style="background-color:#fff; width:100%;">
								   <div class="symbol red">
									  <i class="fa fa-user"></i>
								  </div>
									  <h1 class="countmy">
									  	<?php echo $total_retailer_unblock_users; ?>
									  </h1>
									  <p style="padding-bottom: 27px;">Total Retailers</p>
								  </div>
						  </section>
					  </div>
					  	<div class="col-lg-2 col-sm-2">
						  <section class="panel">
								  
								  <div class="value" style="background-color:#fff; width:100%;">
								  <div class="symbol yellow">
									  <i class="fa fa-tags"></i>
								  </div>
									  <h1 class="countmy">
									  	&#x20A6;<?php echo number_format($total_sale_amount_product/$total_retailer_unblock_users,2); ?>
									  </h1>
									  <p style="padding-bottom: 27px;">Average Total Sales by Retailer</p>
								  </div>
						  </section>
					  </div>  	
                   
						<div class="col-lg-2 col-sm-2">
						  <section class="panel">
								  
								  <div class="value" style="background-color:#fff; width:100%;">
								  	  <div class="symbol blue">
									  <i class="fa fa-tags"></i>
								  </div>	
									  <h1 class="countmy">
									  	&#x20A6;<?php echo number_format($total_sale_amount_retailer_cse,2); ?>
									  </h1>
									  <p style="padding-bottom: 5px;">Total Sales For Retailers assigned to me</p>
								  </div>
						  </section>
					  </div>
					  	<div class="col-lg-2 col-sm-2">
						  <section class="panel">
								  
								  <div class="value" style="background-color:#fff; width:100%;">
								  <div class="symbol red">
									  <i class="fa fa-user"></i>
								  </div>
									  <h1 class="countmy">
									  	&#x20A6;<?php echo number_format($total_sale_amount_retailer_cse/$retailer_count,2); ?>
									  </h1>
									  <p style="padding-bottom: 5px;">Average Total Sales for Retailers assigned to me</p>
								  </div>
						  </section>
					  </div>
					  	
					  	
                    </div>
        </div>
    	<!--contant end-->
		
		
	</section>

<!--main content end-->

<style>
	.state-overview .symbol {
		padding: 32px 15px !important;
	}
	.state-overview .value p{
		font-size: 14px;
	}
	.amcharts-chart-div  svg > a{
		display:none;
	}	
	.state-overview .value h1{
		font-size:18px;
	}	
</style>
<script type="text/javascript">
            var chart;

            var chartData = [
			<?php
			if(!empty($segment_retailer))
			{
				foreach($segment_retailer as $row)
				{
			?>
				{
                    "year": '<?php echo $row['segment_name']; ?>',
                    "income": '<?php echo $row['total_retailer']; ?>'
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
                // this single line makes the chart a bar chart,
                // try to set it to false - your bars will turn to columns
                chart.rotate = true;
                // the following two lines makes chart 3D
                chart.depth3D = 20;
                chart.angle = 30;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.axisColor = "#57c8f2";
                categoryAxis.fillAlpha = 1;
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillColor = "#FAFAFA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisColor = "#57c8f2";
                valueAxis.title = "Retailer Distribution based on Products / Category";
                valueAxis.gridAlpha = 0.1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "Income";
                graph.valueField = "income";
                graph.type = "column";
                graph.balloonText = "Retailer Count For [[category]]:[[value]]";
                graph.lineAlpha = 0;
                graph.fillColors = "#57c8f2";
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("chartdiv");
            });
        </script>
		<script type="text/javascript">
            var chart;
            var legend;

            var chartData1 = [
				<?php
				if(!empty($segment_retailer))
				{
					foreach($segment_retailer as $row)
					{
				?>
					{
						"country": '<?php echo $row['segment_name']; ?>',
						"value": '<?php echo $row['total_retailer_product_sale']; ?>'
					},
				<?php	
					}
				}
				?>
                ];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData1;
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
                chart.write("chartdiv1");
            });
        </script>
		<script type="text/javascript">
            var chart;
            var legend;

            var chartData2 = [
				<?php
				if(!empty($segment_retailer))
				{
					foreach($segment_retailer as $row)
					{
				?>
					{
						"country": '<?php echo $row['segment_name']; ?>',
						"value": '<?php echo $row['product_sale']; ?>'
					},
				<?php	
					}
				}
				?>
            ];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData2;
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
                chart.write("chartdiv2");
            });
        </script>
		
		