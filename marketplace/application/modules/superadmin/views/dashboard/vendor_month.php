<div id="chartdiv" style="height: 450px;"></div>
<script type="text/javascript">
	var chart;
    var legend;
	var chartData = [
				<?php
				if(!empty($order_in_month_vendor))
				{
					foreach($order_in_month_vendor as $row)
					{
				?>
				{
                    "country": "<?php echo $row->shipping_vendor_name; ?>",
                    "value": '',
                },
				<?php	
					}
				}
				?>
                
                {
                    "country": "Ireland",
                    "value": 201
                },
                {
                    "country": "Germany",
                    "value": 65
                },
                {
                    "country": "Australia",
                    "value": 39
                },
                {
                    "country": "UK",
                    "value": 19
                },
                {
                    "country": "Latvia",
                    "value": 10
                }
            ];

            AmCharts.ready(function () {
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
            });
        </script>

