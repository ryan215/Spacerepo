<section id="main-content">
	<section class="wrapper">
		<!--mail inbox start-->
		<div class="mail-box">
			<aside class="sm-side">
				<div class="user-head" style="background:#94c359;">
					<div class="user-name">
                    	<h3 style="margin-top:15px;">NewsLetter Mails</h3>
					</div>
				</div>
				<div class="inbox-body">
					<a class="btn btn-compose" href="<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email'; ?>">
						Compose
					</a>
				</div>
				
				<ul class="inbox-nav inbox-divider">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email/mail_history_list'; ?>">
							<i class="fa fa-inbox"></i> 
							Newsletter History 
							<span class="label label-warning pull-right">
								<?php echo $result['totalMails']; ?>
							</span>
						</a>
					</li>
					<li class="active">
						<a href="<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email/subscribe_list'; ?>">
							<i class="fa fa-user"></i>
							Subscribed 
							<span class="label label-success pull-right">
								<?php echo $result['totalSubscribe']; ?>
							</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email/unsubscribe_list'; ?>">
							<i class="fa fa-user"></i> Unsubscribed 
							<span class="label label-info pull-right">
								<?php echo $result['totalUnsubscribe']; ?>
							</span>
						</a>
					</li>
				</ul>
			</aside>
			
			<aside class="lg-side">
				<div class="inbox-head" style="background:#739A63;">
					<h3>Subscribed</h3>
					<div class="input-append pull-right position">
						<input type="text"  placeholder="Search" class="sr-input" id="search">
						<button type="button" class="btn sr-btn" onclick="ajax_search();" style="background:#94C359;"><i class="fa fa-search"></i></button>
					</div>
				</div>
                
				<div class="inbox-body" id="ajaxData">
                </div>
			</aside>
		<!--mail inbox end-->
	</section>
</section>
<script type="text/javascript">
function ajax_search()
{
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email/ajax_subscribe_list'; ?>');	
}

function ajaxPage(urlLink)
{
	$.ajax({
		type: "POST",
		url:urlLink,
		data:'search='+$('#search').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#ajaxData').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#ajaxData').html(result);				
		}
	});
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email/ajax_subscribe_list'; ?>');
</script>
<style>
label{ background-image:none;}
/* ------------------------------------- 
		GLOBAL 
------------------------------------- */
.collapse {
	margin:0;
	padding:0;
}


/* ------------------------------------- 
		ELEMENTS 
------------------------------------- */



p.callout {
	padding:15px;
	background-color:#ECF8FF;
	margin-bottom: 15px;
}
.callout a {
	font-weight:bold;
	color: #2BA6CB;
}

table.social {
/* 	padding:15px; */
	background-color: #ebebeb;
	
}
.social .soc-btn {
	padding: 3px 7px;
	font-size:12px;
	margin-bottom:10px;
	text-decoration:none;
	color: #FFF;font-weight:bold;
	display:block;
	text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
	display:block;
	width:100%;
}

/* ------------------------------------- 
		HEADER 
------------------------------------- */
table.head-wrap { width: 100%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}


/* ------------------------------------- 
		BODY 
------------------------------------- */
table.body-wrap { width: 100%;}


/* ------------------------------------- 
		FOOTER 
------------------------------------- */
table.footer-wrap { width: 100%;	clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
	font-size:10px;
	font-weight: bold;
	
}


/* ------------------------------------- 
		TYPOGRAPHY 
------------------------------------- */
/*h1,h2,h3,h4,h5,h6 {
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}
*/
.collapse { margin:0!important;}

p, ul { 
/*	margin-bottom: 10px; 
	font-weight: normal; 
	font-size:14px; 
	line-height:1.6;
*/}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
/*	margin-left:5px;
	list-style-position: inside;
*/}

/* ------------------------------------- 
		SIDEBAR 
------------------------------------- */
ul.sidebar {
	background:#ebebeb;
	display:block;
	list-style-type: none;
}



/* --------------------------------------------------- 
		RESPONSIVENESS
		Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
	display:block!important;
	max-width:600px!important;
	margin:0 auto!important; /* makes it centered */
	clear:both!important;
}

/* This should also be a block element, so that it will fill 100% of the .container */

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; }


/* Odds and ends */
.column {
	width: 300px;
	float:left;
}
.column tr td { padding: 15px; }
.column-wrap { 
	padding:0!important; 
	margin:0 auto; 
	max-width:600px!important;
}
.column table { width:100%;}
.social .column {
	width: 280px;
	min-width: 279px;
	float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }


/* ------------------------------------------- 
		PHONE
		For clients that support media queries.
		Nothing fancy. 
-------------------------------------------- */
@media only screen and (max-width: 600px) {
	
	a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

	div[class="column"] { width: auto!important; float:none!important;}
	
	table.social div[class="column"] {
		
	}

}

</style>
