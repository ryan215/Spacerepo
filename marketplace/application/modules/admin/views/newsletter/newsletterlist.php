<?php
/**
 * Created by PhpStorm.
 * User: VIJJU
 * Date: 8/4/2015
 * Time: 11:59 AM
 */
?>
<style>
    .btn-reqt {
        border: 1px solid #ccc;
    }
    .notifi {
        position: absolute !important;
        top: -8px !important;
    }
    #header_notification_bar {
        list-style-type: none !important;
        float: left;
        padding-left: 20px;
    }
    .table-choosen .bootstrap-select.btn-group:not(.input-group-btn), .bootstrap-select.btn-group[class*="span"] {
        margin-bottom: 0 !important;
        height: 28px !important;
    }
    .table-choosen .dropdown-toggle {
        height: 28px !important;
        line-height: 15px !important;
    }
</style>

<section id="main-content">
    <section class="wrapper">
        <!--contant start-->
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs-alt">
                    <li> <a href="javascript:void(0);" class="current ">NewsLetter List</a> </li>
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
                                            <select class="selectpicker chosen-select form-control"  size="1" name="sel_no_entry" onchange="ajax_search();" id="sel_no_entry" style="width:100px; !important">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6"  style="padding-left:10px;"><span class="records_per_page">Records Per Page</span></div>
                                    </div>
                                    <div class="col-sm-6  text-right">
									<?php
									if($this->session->userdata('userType')=='admin')
									{
									?>
										<a href="<?php echo base_url().'admin/news_subscription/download_list'; ?>" class="btn btn-success">
											Download List
										</a>
									<?php
									}
									?>
                                    </div>
                                </div>

                            </div>
                        </section>
                        <section class="table-responsive" id="unseen">
							<table class="table table-invoice  table-hover table-custom table-search-head" style="100%">
                                <thead>
                                <tr>
                                    <th width="1%">S.no.</th>
                                     <th>
									 	Email
										<input type="text" class="form-control search table-head-search" id="emailId" onkeyup="ajax_search();" placeholder="Email">
									 </th>
									 <th width="30%">
									 	Date & Time
										<input type="text" class="form-control search table-head-search" id="dateTime" onkeyup="ajax_search();" placeholder="Date & Time">
									 </th>
                                </tr>
                                </thead>
                                <tbody id="ajaxData">
                                </tbody>
                            </table>
                        </section>
                    </div>
                </section>
            </div>
        </div>
        <!--contant end-->
    </section>
</section>
<!--main content end-->

<script>
function ajax_search()
{
	ajaxPage('<?php echo base_url().'admin/news_subscription/ajax_subscription_list'; ?>');
}

function ajaxPage(urlLink)
{
	if($("#emailId").val())
	{
		$("#emailId").css('width','98%');
		$("#emailId").css('background','white');
	}
	else
	{
		$("#emailId").css('width','');
		$("#emailId").css('background','');
	}
	
	if($("#dateTime").val())
	{
		$("#dateTime").css('width','98%');
		$("#dateTime").css('background','white');
	}
	else
	{
		$("#dateTime").css('width','');
		$("#dateTime").css('background','');
	}
		
	$.ajax({
		type: "POST",
		url:urlLink,
		data:'sel_no_entry='+$('#sel_no_entry').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&email='+$('#emailId').val()+'&dateTime='+$('#dateTime').val(),
		beforeSend: function() {
			$('#ajaxData').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#ajaxData').html(result);				
		}
	});
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/news_subscription/ajax_subscription_list'; ?>');
</script>