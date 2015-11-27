
<style>
.form-group{margin-bottom:25px;}
.tab-bg-green{background:#e0e1e6 !important; }
.panel-heading{padding:12px 15px;}
.panel-heading .nav > li.active > a, .panel-heading .nav > li > a:hover{background-color:#8CB94D;}
.panel-heading .nav > li > a{color:#666;}
.panel{box-shadow: 1px 5px 8px rgba(0, 0, 0, 0.2);}
label{background-image:none;}



/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
  margin-bottom:100px;
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #31CEAF;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #8CB94D;
  background-image: #31CEAF;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #8FBB52;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}

.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus{border:none;
}

</style>

<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
            <div class="col-sm-12">
            	<section class="panel">
                <header class="panel-heading">
                      Setting 
                </header>
                <div style="padding:30px 0 10px;" class="panel-body">
                <div class="row">
                    <div class="col-lg-11 bhoechie-tab-container">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                          <div class="list-group">
                            <a href="#" class="list-group-item active text-center">
                              <h4 class="fa fa-lock"></h4><br/> Change Password 
                            </a>
                            <a href="#" class="list-group-item text-center">
                              <h4 class="fa fa-envelope-o"></h4><br/>Change Email
                            </a>                            
                          </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                            <!-- flight section -->
                           <div class="bhoechie-tab-content active">
                                <div style="line-height:21px; padding-bottom:40px;" class="panel-body">
                                    <div class="col-sm-12">
										<?php 
$attributes = array('style' => 'margin-top:20px;','class' => 'form-horizontal');
echo form_open('',$attributes);
?>

                                          <div class="form-group">
                                              <label for="" class="col-sm-4 control-label">New Password</label>
                                              <div class="col-sm-8">
                                                  <input  type="password" name="newPassword" class="form-control" id="" placeholder="New Password">
                                                  <?php echo form_error('newPassword'); ?>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label for="" class="col-sm-4 control-label">Confirm Password</label>
                                              <div class="col-sm-8">
                                                  <input type="password"  name="confirmPassword" class="form-control" id="" placeholder="Confirm Password"> <?php echo form_error('confirmPassword'); ?>
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <div class="col-lg-12 text-right">
                                                  <button type="submit" class="btn btn-danger">Submit</button>
                                              </div>
                                          </div>
                                      </form>
                                    </div>
                                    <div class="col-sm-2">
                                    
                                    </div>
                                 </div>
                            </div>
                        
                            <div class="bhoechie-tab-content">
                                <div class="panel-body" style="line-height:21px; padding-bottom:40px;">
                                    <div class="col-sm-12">
										<?php 
										$attributes = array('class' => 'form-horizontal','style' => 'margin-top:20px;');
										echo form_open('',$attributes);
										?>
                                          <div class="form-group">
                                              <label class="col-sm-4 control-label" for="inputEmail1">New Email</label>
                                              <div class="col-sm-8">
                                                  <input type="text" name="email" placeholder="New Email" id="" class="form-control" value="<?php echo set_value('email');?>"><?php echo form_error('email');?>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-4 control-label" for="inputEmail1">Confirm Email</label>
                                              <div class="col-sm-8">
                                                  <input type="Email" name="confirmemail" placeholder="Confirm Email" id="" class="form-control" value="<?php echo set_value('confirmemail');?>">
                                                  <?php echo form_error('confirmemail');?>
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <div class="col-lg-12 text-right">
                                                  <button class="btn btn-danger" type="submit">Submit</button>
                                              </div>
                                          </div>
                                      </form>
                                    </div>
                                    <div class="col-sm-2">
                                    
                                    </div>
                                </div>
                            </div>
               
                            
                        </div>
					
                    </div>
              </div>
          
            </div>
            </section>
                
            </div>
        </div>
        
        
       <!--contant end-->
    </section>
</section>

<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>