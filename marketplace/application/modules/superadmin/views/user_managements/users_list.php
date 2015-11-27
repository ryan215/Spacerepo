<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />
<style>
#project-label {
	display: block;
	font-weight: bold;
	margin-bottom: 1em;
}
#project-icon {
	float: left;
	height: 32px;
	width: 32px;
}
#project-description {
	margin: 0;
	padding: 0;
}
.ui-helper-hidden-accessible {
	display: none;
}
.ui-menu {
	list-style: none;
	padding: 2px;
	margin: 0;
	display: block;
	outline: none;
}
.ui-menu .ui-menu-item a {
	text-decoration: none;
	display: block;
	padding: 5px .4em;
	line-height: 1.5;
	min-height: 0; /* support: IE7 */
	font-weight: normal;
	font-size: 14px;
}
.ui-menu .ui-menu-item a.ui-state-focus, .ui-menu .ui-menu-item a.ui-state-active {
	font-weight: normal;
}
.ui-menu .ui-state-disabled {
	font-weight: normal;
	margin: .4em 0 .2em;
	line-height: 1.5;
}
.ui-menu .ui-state-disabled a {
	cursor: default;
}
/* icon support */
.ui-menu-icons {
	position: relative;
}
.ui-menu-icons .ui-menu-item a {
	position: relative;
	padding-left: 2em;
}
/* left-aligned */
.ui-menu .ui-icon {
	position: absolute;
	top: .2em;
	left: .2em;
}
/* right-aligned */
.ui-menu .ui-menu-icon {
	position: static;
	float: right;
}
.ui-autocomplete {
	position: absolute;
	top: 0;
	left: 0;
	cursor: default;
	max-height: 400px;
	overflow-y: scroll;
}
.ui-menu .ui-menu-item {
	margin: 0;
	padding: 0;
	width: 100%;
}
.ui-menu .ui-menu-divider {
	margin: 5px -2px 5px -2px;
	height: 0;
	font-size: 0;
	line-height: 0;
	border-width: 1px 0 0 0;
}
.ui-menu .ui-menu-item a {
	padding: 2px 5px!important;
	text-decoration: none;
	display: block;
	padding: 4px .4em;
	line-height: 1.5;
	min-height: 0; /* support: IE7 */
	font-weight: normal;
	color:#666 !important;
}

.ui-menu .ui-menu-item a:hover {
	background:#F1F2F7;
}

.ui-widget-content {
	border-radius: 0 !important;
	background:#fff !important;
	box-shadow:2px 2px 4px rgba(0,0,0,0.5);
}

.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus {
	background:#F1F2F7;
	font-weight: bold;
	color: #000 !important;

}
.ui-state-hover a,
.ui-state-hover a:hover,
.ui-state-hover a:link,
.ui-state-hover a:visited,
.ui-state-focus a,
.ui-state-focus a:hover,
.ui-state-focus a:link,
.ui-state-focus a:visited {
	color: #c77405;
	text-decoration: none;
	color: #000 !important;
}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active {
	border: 1px solid #fbd850;
	font-weight: bold;
	color: #eb8f00;
}
.ui-state-active a,
.ui-state-active a:link,
.ui-state-active a:visited {
	color: #eb8f00;
	text-decoration: none;
}

</style>
<!--main content start-->
<section id="main-content">
	<section class="wrapper"> 
    	<!--contant start-->
    	<div class="row">
      		<div class="col-lg-12">
        		<ul class="breadcrumbs-alt animated fadeInLeft">
          			<li>
                    	<a href="javascript:void(0);" class="current">User Managment</a>
                    </li>
                </ul>
      		</div>
			<div class="col-lg-12">
	<section class="panel">
		<?php $this->load->view('success_error_message'); ?>
        <div class="panel-body">
        	<section class="panel custom-panel">            	
				<div style="padding:0;" class="col-lg-12">
                	<div class="col-sm-5 pd ">
						<div class="col-sm-2 col-lg-2" style="padding-left:0px;"><a href="<?php echo base_url();?>superadmin/user_management/add_user" class="btn btn-sm btn-shadow btn-success hvr-push"  >
										<i class="fa fa-plus"></i>&nbsp;Add
									</a></div>
						<div class="col-sm-4 col-lg-3">
								<div class="form-group">
									<select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
										<option value="10">10</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
								</div>
							</div>
						<div class="col-lg-5 col-sm-6"  style="padding:0px;">
							<span class="records_per_page">Records Per Page</span> 
						</div>
                    </div>
			   </div>
			   
			</section>

<section id="unseen" class="table-responsive">
	<table class="table table-invoice  table-hover table-striped table-custom table-search-head">
    	<thead>
        	<tr>
				<th width="5%">S.No.</th>
				<th width="5%">Image</th>
				<th>
					Name
					<input type="text" class="form-control search table-head-search" id="name" onkeyup="ajax_search();" placeholder="Name">
				</th>
				<th>
					Email
					<input type="text" class="form-control search table-head-search" id="email" onkeyup="ajax_search();" placeholder="Email">
				</th>
				<th width="13%">User Type</th>
				<th width="3%">Action</th>
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

<script type="text/javascript">
function ajax_search()
{
	ajaxPage('<?php echo base_url().'superadmin/user_management/ajaxFun'; ?>');
}

function ajaxPage(urlLink)
{	
	$.ajax({
		type: "POST",
		url:urlLink,
		data:'name='+$('#name').val()+'&email='+$('#email').val()+'&sel_no_entry='+$('#sel_no_entry').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#ajaxData').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#ajaxData').html(result);				
		}
	});
}
ajaxPage('<?php echo base_url().'superadmin/user_management/ajaxFun'; ?>');
</script>