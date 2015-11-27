<section id="main-content">
          <section class="wrapper">
              <!--mail inbox start-->
              <div class="mail-box">
                  <aside class="sm-side">
                      <div class="user-head">
                         <!-- <a href="javascript:;" class="inbox-avatar">
                              <img src="img/mail-avatar.jpg" alt="">
                          </a>-->
                          <div class="user-name">
                              <h3 style="margin-top:15px;">NewsLetter Mails</h3>
                          </div>
                         <!-- <a href="javascript:;" class="mail-dropdown pull-right">
                              <i class="fa fa-chevron-down"></i>
                          </a>-->
                      </div>
                      <div class="inbox-body">
                          <a class="btn btn-compose" data-toggle="modal" href="<?php echo base_url(); ?>admin/news_subscription/test4">
                              Compose
                          </a>
                          <!-- Modal -->
                          <?php /*?><div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog" style="width:650px;">
                                  <div class="modal-content">
                                      <div class="modal-header" style="border-radius:0px;">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title">Compose</h4>
                                      </div>
                                      <div class="modal-body">
                                          <form class="form-horizontal" role="form">
                                             
                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label">Subject</label>
                                                  <div class="col-lg-10">
                                                      <input type="text" class="form-control" id="inputPassword1" placeholder="">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label">Message</label>
                                                  <div class="col-lg-10">
                                                      <textarea name="" id="" class="form-control" cols="30" rows="10"></textarea>
                                                  </div>
                                              </div>

                                              <div class="form-group">
                                                  <div class="col-lg-offset-2 col-lg-10">
                                                      
                                                      <button type="submit" class="btn btn-send">Send</button>
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><?php */?><!-- /.modal -->
                      </div>
                      <ul class="inbox-nav inbox-divider">
                          <li>
                              <a href="<?php echo base_url(); ?>admin/news_subscription/test1"><i class="fa fa-inbox"></i> Newsletter History <span class="label label-warning pull-right">04</span></a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>admin/news_subscription/test2"><i class="fa fa-user"></i> Subscribed <span class="label label-success pull-right">04</span></a>
                          </li>
                          <li  class="active">
                              <a href="<?php echo base_url(); ?>admin/news_subscription/test3"><i class="fa fa-user"></i> Unsubscribed <span class="label label-info pull-right">04</span></a>
                          </li>
                      </ul>
                  </aside>
                  <aside class="lg-side">
                      <div class="inbox-head">
                          <h3>Unsubscribed</h3>
                          <form class="pull-right position" action="#">
                              <div class="input-append">
                                  <input type="text"  placeholder="Search" class="sr-input">
                                  <button type="button" class="btn sr-btn"><i class="fa fa-search"></i></button>
                              </div>
                          </form>
                      </div>
                      <div class="inbox-body">
                         <div class="mail-option">
                             <!--<div class="chk-all">
                                 <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                                 <div class="btn-group" >
                                     <a class="btn mini all" href="#" data-toggle="dropdown">
                                         All
                                         <i class="fa fa-angle-down "></i>
                                     </a>
                                     <ul class="dropdown-menu">
                                         <li><a href="#"> None</a></li>
                                         <li><a href="#"> Read</a></li>
                                         <li><a href="#"> Unread</a></li>
                                     </ul>
                                 </div>
                             </div>-->

                             <div class="btn-group">
                                 <a class="btn mini tooltips" href="#" data-toggle="dropdown" data-placement="top" data-original-title="Refresh"><i class=" fa fa-refresh"></i>
                                 </a>
								  
                             </div>
							  <!--<div class="btn-group">
                                 
								  <a class="btn mini tooltips" href="#" data-toggle="dropdown" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i>
                                 </a>
                             </div>-->
                             <ul class="unstyled inbox-pagination">
                                 <li><span>1-50 of 234</span></li>
                                 <li>
                                     <a href="#" class="np-btn"><i class="fa fa-angle-left  pagination-left"></i></a>
                                 </li>
                                 <li>
                                     <a href="#" class="np-btn"><i class="fa fa-angle-right pagination-right"></i></a>
                                 </li>
                             </ul>
                         </div>
						 
                          
						 	<table class="table table-inbox table-hover">
                            <tbody>
							<tr class="unread">
                                 <td class="inbox-small-cells" width="2%">1</td>
                                 <td class="view-message  dont-show">Rohit@techwatts.com</td>
                             </tr>
                             <tr class="">
                                 <td class="inbox-small-cells" width="2%">2</td>
                                <td class="view-message  dont-show">Rohit@techwatts.com</td>
                              </tr>
                            
							<tr class="unread">
                                 <td class="inbox-small-cells" width="2%">3</td>
                                 <td class="view-message  dont-show">Rohit@techwatts.com</td>
                             </tr>
                             <tr class="">
                                 <td class="inbox-small-cells" width="2%">4</td>
                                 <td class="view-message  dont-show" >Rohit@techwatts.com</td>
                              </tr>
							  </tbody>
                             </table>
							
                  </aside>
              </div>
              <!--mail inbox end-->
          </section>
      </section>
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
