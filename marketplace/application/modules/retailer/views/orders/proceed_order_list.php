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
                    <a class="current" href="javascript:void(0);">Proceed Order</a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <div class="panel-heading">
          	Proceed Order
          </div>
          <div class="panel-body">
            <section id="unseen">
              <table class="table table-invoice table-custom">
                <thead>
                  <tr>
                    <th width="5%">S.N.</th>
                    <th width="10%">Order Date</th>
                    <th width="10%">Order Id</th>
                    <th width="40%">Product Details</th>
                    <th width="10%">Price</th>
                    <th width="30%">Status</th>
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
<div id="largeModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
</div>
<script type="text/javascript">
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

ajaxPage('<?php echo base_url().'retailer/proceed_order/order_ajax/'.$total; ?>');
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