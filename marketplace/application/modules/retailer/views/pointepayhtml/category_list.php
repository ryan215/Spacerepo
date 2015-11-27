<section id="main-content">
	<section class="wrapper"> 
    	<!--contant start-->
    	<div class="row">
      		<div class="col-lg-12">
        		<ul class="breadcrumbs-alt animated fadeInLeft">
          			                     <li> <a href="javascript:void(0);" class="current">Category List</a> </li>
                    		          	<!--<li> <a href="javascript:void(0);" class="current">Category List</a> </li>-->
        		</ul>
      		</div>
<div class="col-lg-12">
	<section class="panel">
        <div class="panel-body">
        	<section class="panel custom-panel">
            	<div style="padding:0;" class="col-lg-12">
                	<div class="col-sm-6 " style="padding: 5px;">
                  		<div class="col-sm-2 col-lg-2 " style="padding-left:0px;">
                        	<a type="button" class="btn btn-sm btn-shadow btn-success hvr-push" href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/add_category">
                            	<i class="fa fa-plus"></i> Add
                            </a> 
						</div>
                        <div class="col-sm-2 pd">
                    		<div class="form-group">
                      			<select class="selectpicker form-control" name="" onchange="" id=""  data-style="btn-success" style="width:75px;display: inline-block;">
                        			<option value="10">10</option>
                        			<option value="50">50</option>
                        			<option value="100">100</option>
                      			</select>
                    		</div>
                  		</div>
                  <div class="col-lg-4 col-sm-4"> <span class="records_per_page">Records Per Page</span> </div>
                </div>
                <div class="col-sm-6 " style="padding: 5px;">
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input id="project" class="form-control ui-autocomplete-input" placeholder="Search" type="search" style="width:100%; border-radius:5px;" onkeyup="auto_search();" autocomplete="off">
                  <input type="hidden" id="project-id">
                  <p id="project-description"></p>
                </div>
              </div>
            </section>
            <section id="unseen" class="table-responsive">
              <table class="table table-invoice  table-hover table-striped table-custom table-search-head">
                <thead>
                  <tr>
                    <th width="5%">S.No.</th>
					<th width="10%">Image</th>
                    <th width="20%"> Category Name</th>
					<th width="30%">Description</th>
                    <th width="6%">Action</th>
                  </tr>
                </thead>
                <tbody id="ajaxData">
				<tr>
					<td>1</td>
					<td><img src="<?php echo base_url();  ?>uploads/product/1431783463TUDPDL.jpg" width="70%" /></td>
					<td>Automotive &amp; Industrial</td>
					
					<td>this is description</td>
					<td>
						<a class="btn btn-primary btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Edit" type="button" href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/add_category"><i class="fa fa-pencil"></i>
						</a>&nbsp;&nbsp;
						
						<a class="btn btn-warning btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="View" type="button" href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/category_view">
							<i class="fa fa-eye"></i>
						</a>
					</td>
				</tr>
				
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
<link href="<?php echo base_url(); ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />	
<script>
$('.selectpicker').selectpicker();	
</script>	