<link href="<?php echo base_url(); ?>css/frontend/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/frontend/owl.theme.css" rel="stylesheet">
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
          		<li> <a href="javascript:void(0);" class="current">Dashboard</a> </li>
        	</ul>
	    </div>
        <div class="col-lg-12 pd">
            	
		<section class="panel">
        <div class="col-md-12">
            	<h4 class="text-center" style="margin-top:0px; padding-top:20px; padding-bottom:20px; font-weight:bold;">
                    	Top Trending Products
                </h4>
        </div>
		<div class="clearfix"></div>
		<div style="padding-bottom: 0;  margin-bottom: 10px;  box-shadow: 0 0 2px rgba(0,0,0,.3);  background-color: #fff;" class="wonens-slider">	
        	
        <div id="owl-demo" class="owl-carousel">          
        	<?php
			if(!empty($trendingPrdList))
			{
				$i = 1;
				foreach($trendingPrdList as $rowVal)
				{
			?>
            <div class="item">
				<div class="col-sm-2 pd" style="position:absolute;">
                	<img class="lazyOwl" src="<?php echo base_url(); ?>images/tag_img.png" style="display: inline; width:48px !important;">
                    <span style=" position: relative;  left: -5px;  top: -47px; "><?php echo $i; ?></span>	
                </div>
				<div class="pro-imgdiv">
					<?php
					$imageUrl = base_url().'img/no_image.jpg';
					if((!empty($rowVal->imageName))&&(file_exists('uploads/product/'.$rowVal->imageName)))
					{
						$imageUrl = base_url().'uploads/product/'.$rowVal->imageName;
					}
					?>
					<img src="<?php echo $imageUrl ;?>" class="lazyOwl" style="display: inline;"> 
				</div>
				<p class="product_names" title="<?php echo $rowVal->code; ?>">
                	<?php
					if(strlen($rowVal->code)>10)
					{
						$productName = substr($rowVal->code,0,10).'...'; 
					}
					else
					{
						$productName = $rowVal->code;
					}
					echo $productName;
					?>
                </p>
				<p style="color:#333;">
				No. of hits = <?php echo $rowVal->totalViewCount;?>
				<p>
				<div class="sale-prcdiv">&#x20A6;<?php echo number_format($rowVal->currentPrice,2); ?></div>
			</div>
			<?php		
				$i++;
				}
			}
			?>
    	</div>
		<div class="customNavigation">
			<a class="btn5 prev5 pull-left"><i class='fa fa-angle-left'></i></a>
			<a class="btn5 next5 pull-right"><i class='fa fa-angle-right'></i></a>
		</div>
       	
        </section>
        </div>
		<div class="row">
        	
        	<div class="col-lg-12">
            	
				<section class="panel">
					<h4 class="text-center" style="margin-top:0px; padding-top:20px; padding-bottom:20px; font-weight:bold;">
                    	Product Upload Report (By CSE)
                    </h4>
					<div class="col-sm-2 pull-left" ><a href="<?php echo base_url().$this->session->userdata('userType').'/shipping_bounce'; ?>" class="btn btn-danger">
                	Shipping Bounce
                	</a></div>	
                    <div class="col-sm-2 pull-right">
                    	<select class="form-control selectpicker" onchange="cse_graph(this.value);">
                        	<option value="">CSE List</option>
                        	<?php
							if(!empty($statesList))
							{
								foreach($statesList as $row)
								{
							?>
                            <option value="<?php echo id_encrypt($row->employeeId); ?>">
                            	<?php echo $row->firstName.' '.$row->middle.' '.$row->lastName; ?>
                            </option>
                            <?php		
								}
							}
							?>                    		
                         </select>
                    </div>					
				 	<div class="col-sm-2 pull-right">
                    	<select class="form-control selectpicker" id="stateId" onchange="product_add_by_cse();">
                        	<option value="0">All</option>
                        	<?php
							if(!empty($statesArr))
							{
								foreach($statesArr as $key=>$value)
								{
							?>
                            <option value="<?php echo $key; ?>">
                            	<?php echo $value; ?>
                            </option>
                            <?php		
								}
							}
							?>                    		
                         </select>
                    </div>
                    <div class="col-sm-2 pull-right">      
				 		<select class="form-control selectpicker" onchange="product_add_by_cse();" id="cseReqDay">
                    		<option value="0">Today</option>
	                    	<option value="1">Yesterday</option>
	 	                   	<option value="2">This Week</option>
                    	</select>
				 </div>
              		<div class="col-sm-3 pull-right"><strong><span style="line-height:30px;">Total Products Uploaded</span></strong> - <span id="cseReq"><?php echo $totalReq; ?></span></div>
				    <div id="cseProduct"  style="width: 100%;height: 480px;padding-bottom:20px; padding-top:20px;"></div>
                </section>
                
				<section class="panel">
					 <h4 class="text-center" style="margin-top:25px; padding-top:25px; padding-bottom:10px; font-weight:bold;">
							Report For Product Action By Admin
					 </h4>
                     <div class="col-sm-2 pull-right">      
				 	 <select class="form-control selectpicker" onchange="product_action_by_admin();" id="adminActDay">
                    		<option value="0">Today</option>
	                    	<option value="1">Yesterday</option>
	 	                   	<option value="2">This Week</option>
                    	</select>
				 	</div>
                     <div class="col-sm-2 pull-right">
                            <strong>
                                <span style="line-height:30px;">
                                    Total Products 
                                </span>
                             </strong> - <span id="adminAct"><?php echo $totalActAdmin; ?></span>
                        </div>	                 
                     <div id="adminProduct" style="width: 100%; padding-bottom:0px; height: 480px; padding-top:20px;"></div>	 					
				</section>
                    		
				<section class="panel">
					 <h4 class="text-center" style="margin-top:25px; padding-top:25px; padding-bottom:10px; font-weight:bold;">
							Demo report
					 </h4>
                    
                     	                 
                     <div id="demochart" style="width: 100%; padding-bottom:0px; height: 480px; padding-top:20px;"></div>	 					
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
function product_add_by_cse()
{
	stateId   = $('#stateId').val();
	cseReqDay = $('#cseReqDay').val();
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/dashboard/product_add_by_cse'; ?>',
		data:'stateId='+stateId+'&cseReqDay='+cseReqDay,
		beforeSend: function() {
			$("#cseProduct").html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			console.log(result);
			res = jQuery.parseJSON(result);
			$('#cseReq').html(res.total);
			var chart;	
	 		var chartData = res.result;

            // SERIAL CHART
			chart = new AmCharts.AmSerialChart();
			chart.dataProvider = chartData;
			chart.categoryField = "year";			
			chart.startDuration = 1;
            chart.plotAreaBorderColor = "#DADADA";
            chart.plotAreaBorderAlpha = 1;
			
        /*chart.categoryAxis= {
            "labelColorField": "year", // specifies which field in data holds color for label
            "gridPosition": "start",
            "gridAlpha": 0,
            "tickPosition": "start",
            "tickLength": 20,
            "labelFunction": function(valueText, serialDataItem, categoryAxis) {
                
                console.log(serialDataItem.dataContext.href);
				create
				valueText='<a href>'+valueText+'</a>';
               
                return valueText;
            }
        }*/
            // this single line makes the chart a bar chart
            chart.rotate = true;

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
            chart.write("cseProduct");
        }
	});
}
product_add_by_cse();

function product_action_by_admin()
{
	adminActDay = $('#adminActDay').val();
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/dashboard/product_action_by_admin'; ?>',
		data:'adminActDay='+adminActDay,
		beforeSend: function() {
			$("#adminProduct").html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			//console.log(result);
			res = jQuery.parseJSON(result);
			$('#adminAct').html(res.total);
			var chart;	
	 		var chartData = res.result;

            // SERIAL CHART
			chart = new AmCharts.AmSerialChart();
			chart.dataProvider = chartData;
			chart.categoryField = "year";
			chart.startDuration = 1;
            chart.plotAreaBorderColor = "#DADADA";
            chart.plotAreaBorderAlpha = 1;
            // this single line makes the chart a bar chart
            chart.rotate = true;

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
            chart.write("adminProduct");
        }
	});
}
product_action_by_admin();

function cse_graph(employeeId)
{
	window.location.href = '<?php echo base_url().$this->session->userdata('userType'); ?>/dashboard/cse_graph/'+employeeId;
}
</script>
        <script>
            var chart;

            var chartData = [
                {
                    "year": "rohit ambeldkar",
                    "expenses": 1				
                },
                 {
                    "year": "rohit ambeldkar sdfsdfsdfs ",
                    "expenses": 2
                },
				 {
                    "year": "rohit ambeldkar",
                    "expenses": 3
                },
				 {
                    "year": "rohit ambeldkar",
                    "expenses": 4
                },
				 {
                    "year": "rohit ambeldkar",
                    "expenses": 5
                }, {
                    "year":"rohit ambeldkar",
                    "expenses": 6
                }, {
                    "year": "rohit ambeldkar",
                    "expenses": 7
                },
				 {
                    "year": "rohit ambeldkar",
                    "expenses": 8
                }, {
                    "year":"rohit ambeldkar",
                    "expenses": 9
                },
				 {
                    "year": "rohit ambeldkar",
                    "expenses": 10
                }, {
                    "year": "rohit ambeldkar",
                    "expenses": 11
                },
				{
                    "year": "rohit ambeldkar",
                    "expenses": 1
                },
                 {
                    "year":"rohit ambeldkar",
                    "expenses": 2
                },
				 {
                    "year":"rohit ambeldkar",
                    "expenses": 3
                },
				 {
                    "year": "rohit ambeldkar",
                    "expenses": 4
                },
				 {
                    "year": "rohit ambeldkar",
                    "expenses": 5
                }, {
                    "year": "rohit ambeldkar",
                    "expenses": 6
                }, {
                    "year": "rohit ambeldkar",
                    "expenses": 7
                },
				 {
                    "year":"rohit ambeldkar",
                    "expenses": 8
                }, {
                    "year": "rohit ambeldkar",
                    "expenses": 9
                },
				 {
                    "year":"rohit ambeldkar",
                    "expenses": 10
                }, {
                    "year": "rohit ambeldkar",
                    "expenses": 11
                }
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
                graph1.title = "Income";
                graph1.valueField = "income";
                graph1.balloonText = "Income:[[value]]";
                graph1.lineAlpha = 0;
                graph1.fillColors = "#ADD981";
                graph1.fillAlphas = 1;
                chart.addGraph(graph1);

                // second graph
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "column";
                graph2.title = "Expenses";
                graph2.valueField = "expenses";
                graph2.balloonText = "Expenses:[[value]]";
                graph2.lineAlpha = 0;
                graph2.fillColors = "#81acd9";
                graph2.fillAlphas = 1;
                chart.addGraph(graph2);

                // LEGEND
                var legend = new AmCharts.AmLegend();
                chart.addLegend(legend);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("demochart");
            });
        </script>
<style>
body{
		overflow-x: hidden;
	}
.amcharts-legend-div { display:none;}	
</style>
 <script src="<?php echo base_url(); ?>js/owl.carousel.js"></script>


    <!-- Demo -->

    <style>
	.sale-prcdiv {
  font-size: 14px;
  font-weight: bold; color:#333;
}
	.wonens-slider .item .product_names {
  
  text-transform: uppercase;
  color: #444444;
  margin-bottom: 0;
}
.wonens-slider .owl-item a {
  cursor: pointer;
  text-decoration: none;
  display: block;
  border-right: 1px solid #f1f1f1;
  transition: all ease-out 0.2s;
  border-bottom: 2px solid #fff;
}
#owl-demo .item{   border-left: 1px solid #ececec !important;}
	.pro-imgdiv {
	  min-height: 120px;
	  max-height: 120px;
	  line-height: 120px;
	}
	.wonens-slider .item img {
	  width: 100px !important;
	  margin: 0 auto 6px auto;
	}
	.prev5{
		 position: absolute;
	  left: 0;
	  top: 0 !important;
	  background-color: #484848 !important;
	  color: #fff;
	  border-radius: 1px !important;
	  font-size: 21px !important;
	  padding: 1px 12px !important;
	  left: 5px;cursor:pointer;
}
.prev5:hover{ color:#fff !important;}
.next5:hover{ color:#fff !important;}
.next5{
	  position: absolute;
  right: 0;
  top: 0 !important;
  background-color: #484848 !important;
  color: #fff;
  border-radius: 1px !important;
  font-size: 21px !important;
  padding: 1px 12px !important;
  right: 5px;cursor:pointer;
}

.btn5.disabled{
   display:none !important;
}
	#owl-demo .item{
  display: block;
  padding: 0px 0px;
  color: #FFF;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  text-align: center;
}
.owl-theme .owl-controls .owl-buttons div {
  padding: 5px 9px;
}
 
.owl-theme .owl-buttons i{
  margin-top: 2px;
}
 
//To move navigation buttons outside use these settings:
 
.owl-theme .owl-controls .owl-buttons div {
  position: absolute;
}
 
.owl-theme .owl-controls .owl-buttons .owl-prev{
  left: -18px;
  top: 55px; 
}
 
.owl-theme .owl-controls .owl-buttons .owl-next{
  right: -20px;
  top: 55px;
}
 .customNavigation {   position: absolute;
   top: 50%;
  z-index: 1000;  width: 100%; }  
  

   </style>


    <script>
   $(document).ready(function() {
     
    var owl = $("#owl-demo");
     
    owl.owlCarousel({
        rewindNav : false,	
		pagination : false,  
		lazyLoad : true,      
        items : 6,
            afterAction: function(){
      if ( this.itemsAmount > this.visibleItems.length ) {
        $('.next5').show();
        $('.prev5').show();

        $('.next5').removeClass('disabled');
        $('.prev5').removeClass('disabled');
        if ( this.currentItem == 0 ) {
          $('.prev5').addClass('disabled');
        }
        if ( this.currentItem == this.maximumItem ) {
          $('.next5').addClass('disabled');
        }

      } else {
        $('.next5').hide();
        $('.prev5').hide();
      }
    }
    });
    // Custom Navigation Events
    $(".next5").click(function(){
    owl.trigger('owl.next');
    })
    $(".prev5").click(function(){
    owl.trigger('owl.prev');
    })
     
});
</script> 


