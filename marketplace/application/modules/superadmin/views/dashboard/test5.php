<style>
.btn-group {
	margin-bottom: 0 !important;
}
</style>
 <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      <!--contant start-->
      <div class="row">
        <div class="col-md-12">
          <ul class="breadcrumbs-alt animated fadeInLeft">
            <li> <a class="" href="#">Retailer Management</a> </li>
            <li> <a class="current" href="#">Pointepay</a> </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading panel-heading1 col-sm-12">
            <div class="col-sm-5" style="padding-top:8px; padding-left:0;"> Pointepay</div>
            <div style="padding: 5px;" class="col-sm-7 ">
              <div class="input-group">
                <div class="input-group-btn ">
                  <div style="">
                    <div class="btn-group bootstrap-select chosen-select form-control">
                      <button data-toggle="dropdown" class="btn dropdown-toggle selectpicker btn-success" type="button" data-id="sorting" title="Brand Name"><span class="filter-option pull-left">Brand Name</span>&nbsp;<span class="caret"></span></button>
                      
                      <div class="dropdown-menu open">
                        <ul role="menu" class="dropdown-menu inner selectpicker">
                          <li rel="0" class="selected"><a style="" class="" tabindex="0"><span class="text">Business Name</span><i class="fa fa-check icon-ok check-mark"></i></a></li>
                          <li rel="0" class="selected"><a style="" class="" tabindex="0"><span class="text">Owner Name</span><i class="fa fa-check icon-ok check-mark"></i></a></li>
                          <li rel="0" class="selected"><a style="" class="" tabindex="0"><span class="text">Email</span><i class="fa fa-check icon-ok check-mark"></i></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="search" placeholder="Search" id="search" name="search" onkeyup="ajax_search();" style="width:100%; border-radius: 0px  5px 5px 0px !important; " class="form-control">
              </div>
            </div>
          </header>
            
            
            <div class="panel-body">
              <section class="panel custom-panel">
                <section id="unseen">
                  <table class="table table-custom table-invoice">
                    <thead>
                      <tr>
                        <th width="5%">S.No.</th>
                        <th width="15%">Business Name</th>
                        <th width="15%">Store Manager</th>
                        <th width="15%">SM Phone No.</th>
                        <th width="15%">SM Email id</th>
						<th width="15%">Country</th>
                        <th width="5%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Franchise Business</td>
                        <td>Kishan</td>
                        <td>7509267252</td>
                        <td>kishan@techwatts.com</td>
						<td>India</td>
                        <td><a href="<?php echo base_url(); ?>admin/dashboard/test6" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Business</td>
                        <td>Rohit</td>
                        <td>7898267252</td>
                        <td>rohit@techwatts.com</td>
						<td>India</td>
                        <td><a href="<?php echo base_url(); ?>admin/dashboard/test6" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Franchise Business</td>
                        <td>Kishan</td>
                        <td>7509267252</td>
                        <td>kishan@techwatts.com</td>
						<td>India</td>
                        <td><a href="<?php echo base_url(); ?>admin/dashboard/test6" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Business</td>
                        <td>Rohit</td>
                        <td>7898267252</td>
                        <td>rohit@techwatts.com</td>
						<td>India</td>
                        <td><a href="<?php echo base_url(); ?>admin/dashboard/test6" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </section>
              </section>
            </div>
          </section>
        </div>
      </div>
      <!--contant end--> 
    </section>
  </section>
  <!--main content end--> 