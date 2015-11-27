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
    	<div class="col-lg-12 pd">
        	<ul class="breadcrumbs-alt">
          		<li> <a href="<?php echo base_url().$this->session->userdata('userType').'/dashboard'; ?>">Dashboard</a> </li>
                <li> <a href="javascript:void(0);" class="current"><?php echo $cseName; ?></a> </li>
        	</ul>
	    </div>
		<div class="row">
        	<div class="col-lg-12">
				<section class="panel">
					 <h4 class="text-center" style="margin-top:25px; padding-top:25px; padding-bottom:10px; font-weight:bold;">
							Report For Product With Category
					 </h4>
                     <div class="col-sm-2 pull-right">      
				 	 <select class="form-control selectpicker" onchange="product_with_category(this.value);" id="actDay">
                    		<option value="0">Today</option>
	                    	<option value="1" <?php if($byDay==1){ ?> selected="selected" <?php } ?>>Yesterday</option>
	 	                   	<option value="2" <?php if($byDay==2){ ?> selected="selected" <?php } ?>>This Week</option>
                    	</select>
				 	</div>
                     <div class="col-sm-2 pull-right">
                            <strong>
                                <span style="line-height:30px;">
                                    Total Products 
                                </span>
                             </strong> - <span id="totalId"><?php echo $total; ?></span>
                        </div>	                 
                     <div id="prdWithCat" style="width: 100%; padding-bottom:0px; height:480px; padding-top:20px;"></div>	 					
				</section>
                    			
			</div>
            
            <div class="col-lg-6">
				<section class="panel">
					<h4 class="text-center" style="margin-top:0px; padding-top:20px; padding-bottom:20px; font-weight:bold;">
                    Product Request - <?php echo $totalReqRS; ?>
                    </h4>
					<div class="panel-body">
						<div id="chartdiv" style="width: 100%; height: 400px;"></div>
					</div>
				</section>
			</div>
            
            <div class="col-lg-6">
				<section class="panel">
					<h4 class="text-center" style="margin-top:0px; padding-top:20px; padding-bottom:20px; font-weight:bold;">
                    Inventory - <?php echo $totalNewInvtry+$totalUpdtInvtry; ?>
                    </h4>
					<div class="panel-body">
						<div id="newUpIntry" style="width: 100%; height: 400px;"></div>
					</div>
				</section>
			</div>
		</div>	
	</section>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>js/amcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/serial.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/pie.js"></script>

<!--script for this page-->
<script src="<?php echo base_url(); ?>js/count.js"></script>

<!-- script for this page only-->
<script src="<?php echo base_url();?>js/Chart.js"></script>
<script type="text/javascript">
var chart;
var legend;
var chartData = [
				<?php
				if(!empty($reqRes))
				{
					foreach($reqRes as $row)
					{
						$act = 'Pending';
						if($row->verificationResultId==5)
						{
							$act = 'Accepted';
						}
						elseif($row->verificationResultId==6)
						{
							$act = 'Declined';
						}
				?>
					{
                		country: "<?php echo $act; ?>",
                		litres: '<?php echo $row->total; ?>'
            		},
			<?php
				}
			}
			?>
			];
			AmCharts.ready(function () {
            	// PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "litres";
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.8;
                chart.outlineThickness = 2;

                // WRITE
                chart.write("chartdiv");
           });
		   
		   
		   
var chart2;	
var chartData2 = [
				<?php
				if(!empty($prdWithCat))
				{
					foreach($prdWithCat as $row)
					{
				?>
					{
                		year: "<?php echo $row->categoryCode; ?>",
                		income: '<?php echo $row->total; ?>'
            		},
			<?php
				}
			}
			?>
			];

            // SERIAL CHART
			chart2 = new AmCharts.AmSerialChart();
			chart2.dataProvider = chartData2;
			chart2.categoryField = "year";
			chart2.startDuration = 1;
            chart2.plotAreaBorderColor = "#DADADA";
            chart2.plotAreaBorderAlpha = 1;
            // this single line makes the chart a bar chart
            chart2.rotate = true;

            // Category
            var categoryAxis2 = chart2.categoryAxis;
            categoryAxis2.gridPosition = "start";
            categoryAxis2.gridAlpha = 0.1;
            categoryAxis2.axisAlpha = 0;

            // Value
            var valueAxis2 = new AmCharts.ValueAxis();
            valueAxis2.axisAlpha = 0;
            valueAxis2.gridAlpha = 0.1;
            valueAxis2.position = "top";
            chart2.addValueAxis(valueAxis2);

            // first graph
            var graph1 = new AmCharts.AmGraph();
            graph1.type = "column";
            graph1.title = "Product";
            graph1.valueField = "income";
            graph1.balloonText = "Product count :[[value]]";
            graph1.lineAlpha = 0;
            graph1.fillColors = "#57c8f2";
            graph1.fillAlphas = 1;
            chart2.addGraph(graph1);               

            // LEGEND
            var legend = new AmCharts.AmLegend();
            chart2.addLegend(legend);
			chart2.creditsPosition = "top-right";
			
			// WRITE
            chart2.write("prdWithCat");
			
var chart3;
var legend;
var chartData3 = [{country: "New Inventory",litres: '<?php echo $totalNewInvtry; ?>'},{country: "Update Inventory",litres: '<?php echo $totalUpdtInvtry; ?>'}];
AmCharts.ready(function () {
	// PIE CHART
    chart3 = new AmCharts.AmPieChart();
    chart3.dataProvider = chartData3;
    chart3.titleField = "country";
    chart3.valueField = "litres";
    chart3.outlineColor = "#FFFFFF";
    chart3.outlineAlpha = 0.8;
    chart3.outlineThickness = 2;
	// WRITE
    chart3.write("newUpIntry");
});

function product_with_category(byDay)
{
	window.location.href = "<?php echo base_url().$this->session->userdata('userType'); ?>/dashboard/cse_graph/<?php echo id_encrypt($employeeId); ?>/"+byDay;
}

</script>

<style>
body{
		overflow-x: hidden;
	}
.amcharts-legend-div { display:none;}	
</style>

