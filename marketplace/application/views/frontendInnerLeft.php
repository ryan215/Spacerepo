<link href="<?php echo base_url(); ?>css/new_css/my-account.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/new_css/skin-1.css" rel="stylesheet" />

<style>
.active_cat
{
	color: #A3CE62 !important;
}
.star
{
	color:red;
}
</style>
<?php
$uriSeg2 = $this->uri->segment(2);
$uriSeg3 = $this->uri->segment(3);
?>
<div class="container">
	<?php 
	$this->load->view('frontendBreadCrumb'); 
	?>
	<div class="row">
  		<div class="col-lg-3 col-md-3 col-sm-12">
         	<div class="panel-group" id="accordionNo">          
            	<div class="panel panel-default">
             		 <div class="panel-heading">
               		 <h4 class="panel-title"> 
                	 <a data-toggle="collapse"  href="#collapseCategory" class="collapseWill"> 
               			 <span class="pull-left"> <i class="fa fa-caret-right"></i></span> ORDERS 
                	 </a> 
               		</h4>
                </div>              
                <div id="collapseCategory" class="panel-collapse collapse in">
                 	<div class="panel-body">
                  	<ul class="nav nav-pills nav-stacked tree">
                   		 <li class="" > <a  class="dropdown-tree-a"  href="my_account.html">My Orders </a></li>
                 	</ul>
               		</div>
             	</div>
           </div>               
          </div>
         	<div class="panel-group" id="accordionNo">          
            	<div class="panel panel-default">
             		 <div class="panel-heading">
               		 <h4 class="panel-title"> 
                	 <a data-toggle="collapse"  href="#collapseCategory1" class="collapseWill"> 
               			 <span class="pull-left"> <i class="fa fa-caret-right"></i></span> PAYMENTS 
                	 </a> 
               		</h4>
                </div>              
                <div id="collapseCategory1" class="panel-collapse collapse in">
                 	<div class="panel-body">
                  	<ul class="nav nav-pills nav-stacked tree">
                   		 <li class=" " > <a  class="dropdown-tree-a" href="wallet.html" >Wallet   </a></li>
                         <li class=" " > <a  class="dropdown-tree-a" href="my_saved_cards.html" >My Saved Cards    </a></li>
                 	</ul>
               		</div>
             	</div>
           </div>               
          </div>
			<div class="panel-group" id="accordionNo">          
            	<div class="panel panel-default">
             		 <div class="panel-heading">
               		 <h4 class="panel-title"> 
                	 <a data-toggle="collapse"  href="#collapseCategory2" class="collapseWill"> 
               			 <span class="pull-left"> <i class="fa fa-caret-right"></i></span> MY STUFF 
                	 </a> 
               		</h4>
                </div>              
                <div id="collapseCategory2" class="panel-collapse collapse in">
                 	<div class="panel-body">
                  	<ul class="nav nav-pills nav-stacked tree">
                   		 <li class="" > <a  class="dropdown-tree-a" href="my_review_rating.html" >My Reviews & Ratings  </a></li>    
                         <li class="" > <a  class="dropdown-tree-a" href="my_wishlist.html" >My Wishlist   </a></li>
                        
                 	</ul>
               		</div>
             	</div>
           </div>               
          </div>

			<div class="panel-group" id="accordionNo">          
            	<div class="panel panel-default">
             		<div class="panel-heading">
               			<h4 class="panel-title"> 
                	 		<a data-toggle="collapse"  href="#collapseCategory3" class="collapseWill"> 
               			 		<span class="pull-left"> <i class="fa fa-caret-right"></i></span> SETTINGS 
                	 		</a> 
               			</h4>
                	</div>              
					
					<div id="collapseCategory3" class="panel-collapse collapse in">
                 		<div class="panel-body">
							<ul class="nav nav-pills nav-stacked tree">
                    	 		<li> 
									<a class="dropdown-tree-a <?php if(($uriSeg2=='myaccount')&&(($uriSeg3=='')||($uriSeg3=='index'))){ echo 'active_cat'; } ?>" href="<?php echo base_url(); ?>frontend/myaccount">
										Personal Information
									</a>
								</li> 	
                   		 		<li> 
									<a class="dropdown-tree-a <?php if($uriSeg3=='change_password'){ echo 'active_cat'; } ?>" href="<?php echo base_url(); ?>frontend/myaccount/change_password">
										Change Password
									</a>
								</li>
								<li> 
									<a class="dropdown-tree-a <?php if($uriSeg3=='billing_info'){ echo 'active_cat'; } ?>" href="<?php echo base_url(); ?>frontend/myaccount/billing_info">
										Billing Information
									</a>
								</li>
							</ul>
               			</div>
             		</div>
				</div>               
			</div>
			
		</div>