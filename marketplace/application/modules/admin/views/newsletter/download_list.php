<section id="main-content">
    <section class="wrapper">
        <!--contant start-->
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs-alt">
                    <li>
						<a href="<?php echo base_url().'admin/news_subscription'; ?>">
							NewsLetter List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Download List
						</a>
					</li>
                </ul>
            </div>
            <div class="col-lg-12">
                <section class="panel">
                    <?php $this->load->view('success_error_message'); ?>
                    <div class="panel-body">
                        <section class="panel custom-panel" style="margin-bottom:0;">
                            <div class="col-lg-12" style="padding:0;">
                                <div class="col-sm-12 " style="padding: 5px;">

                                    <div class="col-sm-6" style="padding-left:0px;">
                                        <div class="form-group" style="width:100px; float:left; margin-left:0px; margin-right:5px;">
                                        </div>
                                        <div class="col-sm-6"  style="padding-left:10px;"></div>
                                    </div>
                                    <div class="col-sm-6  text-right"></div>
                                </div>

                            </div>
                        </section>
                        <section class="table-responsive" id="unseen">
							<?php
							echo form_open();
							?>
								<select class="form-control" name="downloadDt" style="width:500px; !important" onchange="custom_date_add(this.value);">
									<option value='1' <?php echo set_select('downloadDt',1); ?>>This Month</option>
    	                            <option value='2' <?php echo set_select('downloadDt',2); ?>>Last Week</option>
        	                        <option value='3' <?php echo set_select('downloadDt',3); ?>>Custom Date</option>
								</select>
								<?php echo form_error('downloadDt'); ?>
								<br />
								<div id="thisMonth">
									This Month includes: 
									From: <?php echo date('d-m-Y',mktime(0,0,0,date('m'),1,date('Y'))); ?> TO: <?php echo date('d-m-Y',mktime(0,0,0,date('m'),30,date('Y'))); ?>
								</div>
								<div id="lastWeek" style="display:none;">
									<?php
									$previous_week = strtotime("-1 week +1 day");
									$start_week = strtotime("last sunday midnight",$previous_week);
									$end_week = strtotime("next saturday",$start_week);
									$start_week = date("d-m-Y",$start_week);
									$end_week = date("d-m-Y",$end_week);
									?>
									This Week includes: 
									From: <?php echo $start_week; ?> TO: <?php echo $end_week; ?>
								</div>
								<div id="customDt" style="display:none;">
									From Date
									<input type="text" class="form-control default-date-picker" name="from_date" value="<?php echo set_value('from_date'); ?>" id="fromDt" style="width:500px; !important" readonly/>
									<?php echo form_error('from_date'); ?>
									<br />
									To Date
									<input type="text" class="form-control default-date-picker" name="to_date" value="<?php echo set_value('to_date'); ?>" id="toDt" style="width:500px; !important" readonly/>
									<?php echo form_error('to_date'); ?>
								</div>
										<br/>					
								<button class="btn btn-success" type="submit" name="submitExl" value="" /><i class="fa fa-download"></i> Download</button>
							</form>
                        </section>
                    </div>
                </section>
            </div>
        </div>
        <!--contant end-->
    </section>
</section>
<!--main content end-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-datepicker/css/datepicker.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>css/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
<?php
if(($_POST)&&(!empty($_POST['downloadDt']))&&($_POST['downloadDt']==3))
{
?>
	custom_date_add(3);
<?php	
}
?>
function custom_date_add(downloadDt)
{
	if(downloadDt==1)
	{
		$('#thisMonth').css('display','block');
		$('#lastWeek').css('display','none');
		$('#customDt').css('display','none');
	}
	else if(downloadDt==2)
	{
		$('#thisMonth').css('display','none');
		$('#lastWeek').css('display','block');
		$('#customDt').css('display','none');
	}
	else if(downloadDt==3)
	{
		$('#thisMonth').css('display','none');
		$('#lastWeek').css('display','none');
		$('#customDt').css('display','block');
	}
	else
	{
		$('#customDt').css('display','none');
	}
}

//date picker start
$(function(){
	$('.default-date-picker').datepicker({
    	format: 'yyyy-mm-dd'
    });
    $('.dpYears').datepicker();
    $('.dpMonths').datepicker();

	var startDate = new Date(2012,1,20);
    var endDate = new Date(2012,1,25);
    $('.dp4').datepicker().on('changeDate', function(ev){
		if (ev.date.valueOf() > endDate.valueOf()){
        	$('.alert').show().find('strong').text('The start date can not be greater then the end date');
        } else {
        	$('.alert').hide();
            startDate = new Date(ev.date);
            $('#startDate').text($('.dp4').data('date'));
		}
        $('.dp4').datepicker('hide');
	});
    $('.dp5').datepicker().on('changeDate', function(ev){
		if (ev.date.valueOf() < startDate.valueOf()){
        	$('.alert').show().find('strong').text('The end date can not be less then the start date');
        } else {
        	$('.alert').hide();
            endDate = new Date(ev.date);
            $('.endDate').text($('.dp5').data('date'));
		}
        $('.dp5').datepicker('hide');
	});

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('.dpd1').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
        var checkout = $('.dpd2').datepicker({
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                checkout.hide();
            }).data('datepicker');
    });

//date picker end
</script>