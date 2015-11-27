<style>
	.tabs-content {border:1px solid #e9e9e9;
	border-radius:4px;
}

/* Menu das abas */
.tabs-menu {  background: #eee;
	 
 
}
.tabs-menu ul {
   list-style: none;
}
.tabs-menu ul li {
  float: left;
  width:50%;
  text-align:center;
}
.tabs-menu ul li a {
  display: block;
  padding: 10px 20px;
  text-decoration: none;
  font-size:16px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: #666;
  text-align:center;
  position:relative;
}
.tabs-menu ul li a.active-tab-menu {
   background: #94C359;
  color: #fff;
   border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

.tabs-menu ul li a.active-tab-menu::before{border-bottom: 11px solid #fff;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    bottom: -1px;
    content: " ";
    display: inline-block;
    height: 10px;
    left: 49%;
    position: absolute;
    width: 0;
}

/* Conteúdo das abas */
.tabs {
  display: none;
  padding: 8px;
}
.first-tab {
  display: block;
}
</style>

<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
    	<div class="col-md-12">
            <ul class="breadcrumbs-alt">
                <li>
                    <a href="javascript:void(0);">Dashboard</a>
                </li>
                <li>
                    <a class="current" href="javascript:void(0);">History Order</a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <div class="panel-heading">
          	History Order
          </div>
          <div class="panel-body" style="padding:3px;">
            <section id="unseen">
            	<div class="tabs-content">
                    <div class="tabs-menu clearfix">
                      <ul>
                        <li>
							<a href="<?php echo base_url().'retailer/new_order'; ?>">
								New Order
							</a>
						</li>
                        <li>
							<a class="active-tab-menu" href="<?php echo base_url().'retailer/new_order/history_order'; ?>">
								History
							</a>
						</li>
                      </ul>
                    </div> <!-- tabs-menu -->
                    
	<table class="table table-invoice table-custom">
    	<thead>
			<tr>
            	<th width="5%">S.No.</th>
                <th width="10%">Order Date</th>
                <th width="10%">Order Id</th>
                <th width="40%">Product Details</th>
                <th width="10%">Price</th>
                <th colspan="2" width="10%">Status</th>
			</tr>        	
		</thead>
		<tbody id="ajaxData">
			
		</tbody>
	</table>
                    
                  </div> 
            </section>
          </div>
        </section>
      </div>
    </div>
    <!--contant end--> 
  </section>
</section>

<div id="largeModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
</div>

<script>
function product_details(order_id)
{
	ajax_function('<?php echo base_url(); ?>retailer/new_order/product_details/'+order_id,'#largeModal'); 
	$('#largeModal').modal('show');
}

function ajaxPage(urlLink)
{	
	//postData = 'search='+$('#search').val()+'&sel_no_entry='+$('#sel_no_entry').val()+'&sorting='+$('#sorting').val();
	ajax_function(urlLink,'#ajaxData'); 
}

ajaxPage('<?php echo base_url().'retailer/new_order/history_order_ajax/'.$total; ?>');
</script>



	
	<style>
	.pr_detail{
		cursor:pointer;
	}
	td , th{
		padding-bottom:8px;
		font-size:12px;
	}
	</style>
