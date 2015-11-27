<style>
.inventory-form-group{margin-bottom:14px !important;
}
.popover-content{font-size:11px;
	font-weight:normal;
	text-transform:inherit !important;
}
.popover .arrow{top:100 !important;
}

.input-group-addon{background-color:#F0F0F0;
}
input[type=checkbox] {
  margin: 4px 8px 0px !important;
  line-height: normal;
}
.sizes_label{   top: -2px;
  position: relative}
  .color-filter small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 14px;
}
.block-element label {
  float: left;
  margin-right: 18px;
}
label { background-image:none;}
input[type=radio] {
  display:inline-block;
}
</style>

<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>  
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().'superadmin/price_management'; ?>">Price Management</a>
					</li>
					<li>
						<a class="current" href="javascript:void(0);">
                        	<?php
							if($priceMngtId)
							{
								echo 'Edit Price Management';
							}
							else
							{
								echo 'Add Price Management';
							}
							?>
						</a>
					</li>
				</ul>
			</div>
        </div>
		<!------form start--------> 
<?php 
echo form_open();
?>                                                                                           <div class="row">
	<div style="padding:0;" class="col-md-12">
    	<div class="col-lg-12">
        	<section style="" class="panel">
            	<header class="panel-heading panel-heading1">
                	<?php
							if($priceMngtId)
							{
								echo 'Edit Price';
							}
							else
							{
								echo 'Add Price';
							}
							?>
                </header>
				<div class="panel-body">
                	<div class="col-sm-12" style="padding-top:20px;">
                    	<div class="col-sm-2"></div>                        
							<div class="col-sm-12 inventory-form-group">
                            	<div class="col-sm-4">
                                	<label for="">Price From</label> <span class="error">*</span>
                                </div>
								<div class="col-sm-3">
                                	<div class="input-group">
                                    	<span class="input-group-addon">&#x20A6;</span>
                                        	<input type="text" class="form-control" value="<?php echo $result['fromPrice']; ?>" name="fromPrice">
                                        </div>
										<?php echo form_error('fromPrice'); ?>
									</div>
								</div>		
							<div class="col-sm-12 inventory-form-group" id="toPriceDiv">
                            	<div class="col-sm-4">
                                	<label for="">Price To</label> <span class="error">*</span>
                                </div>
								<div class="col-sm-3">
                                	<div class="input-group">
                                    	<span class="input-group-addon">&#x20A6;</span>
                                        	<input type="text" class="form-control" value="<?php echo $result['toPrice']; ?>" name="toPrice" id="toPrice">
                                        </div>
										<?php echo form_error('toPrice'); ?>
									</div>
								</div>
                                
                                <div class="col-sm-12 inventory-form-group">
                            	<div class="col-sm-4">
                                	<label for="">Or Above</label>
                                </div>
								<div class="col-sm-3">
                                	<div class="input-group">
                                        	<input type="radio" name="above" id="aboveVal" onclick="above_val();">
                                            <div id="fromPriceAbove">
                                            </div>
                                        </div>
									</div>
								</div>
                                
							<div class="col-sm-12 inventory-form-group">
                                	<div class="col-sm-4">
                                    	<label for="">Spacepointe Comission</label>
									</div>
                                    <div class="col-sm-3">
									 <div class="checkboxes">
                                              <label for="checkbox-01" style="display:initial;">
                                                  <input name="spacePointeCommission" <?php if($result['spacePointeCommission']){?> checked="checked" <?php } ?> id="checkbox-01" type="checkbox" style="margin:0px !important;"/> 
                                              </label>
									 <?php echo form_error('spacePointeCommission'); ?>
									 </div>		  
                                    	
                                        </div>
                                    </div>
							<div class="col-sm-12 inventory-form-group">
                                	<div class="col-sm-4">
                                    	<label for="" title="Cash Fee">Cash Fee</label> <span class="error">*</span>
									</div>
                                    <div class="col-sm-8">
                                    
											  
											  <div class="col-sm-12 pd">
													<div class="" style="padding-top:0px;">
														  <label class="" for="radio-01">
															  <input name="cashFee" <?php if($result['cashFee']==1){?> checked="checked" <?php } ?> id="radio-01" type="radio" value="1"/> <strong>Cash admin Fee</strong>
														  </label><br />
														  <label class="" for="radio-02">
															  <input name="cashFee" <?php if($result['cashFee']==2){?> checked="checked" <?php } ?> id="radio-02"  type="radio" value="2"/> <strong>Genuine Shipping Fee</strong>
														  </label>
													</div>
													
													<?php echo form_error('adminPrice'); ?>
												</div>
                                     
                                    </div>
                             </div>		
							
						</div>
                        <div class="col-sm-2"></div>
					</div>
				</div>
				<div class="col-sm-12 form-div" style="padding:0px 0;">
                	<div class="col-sm-12 text-right ">
                    	<button class="btn btn-success btn-save">Save</button>
                    </div>
                </div>
                    </section>
                    </div>
                                
                </div></div>
</form>
<!------form End--------> 
	</section>
</section>
<script>
function above_val()
{
	$('#aboveVal').prop("checked", true);
	$('#toPriceDiv').css('display','none');
	$('#fromPriceAbove').html('<input type="hidden" class="form-control" value="100000000000000" name="toPrice">');
}
<?php
if($result['toPrice']==100000000000000)
{
?>
above_val();
<?php
}
?>
var d = document;
    var safari = (navigator.userAgent.toLowerCase().indexOf('safari') != -1) ? true : false;
    var gebtn = function(parEl,child) { return parEl.getElementsByTagName(child); };
    onload = function() {

        var body = gebtn(d,'body')[0];
        body.className = body.className && body.className != '' ? body.className + ' has-js' : 'has-js';

        if (!d.getElementById || !d.createTextNode) return;
        var ls = gebtn(d,'label');
        for (var i = 0; i < ls.length; i++) {
            var l = ls[i];
            if (l.className.indexOf('label_') == -1) continue;
            var inp = gebtn(l,'input')[0];
            if (l.className == 'label_check') {
                l.className = (safari && inp.checked == true || inp.checked) ? 'label_check c_on' : 'label_check c_off';
                l.onclick = check_it;
            };
            if (l.className == 'label_radio') {
                l.className = (safari && inp.checked == true || inp.checked) ? 'label_radio r_on' : 'label_radio r_off';
                l.onclick = turn_radio;
            };
        };
    };
    var check_it = function() {
        var inp = gebtn(this,'input')[0];
        if (this.className == 'label_check c_off' || (!safari && inp.checked)) {
            this.className = 'label_check c_on';
            if (safari) inp.click();
        } else {
            this.className = 'label_check c_off';
            if (safari) inp.click();
        };
    };
    var turn_radio = function() {
        var inp = gebtn(this,'input')[0];
        if (this.className == 'label_radio r_off' || inp.checked) {
            var ls = gebtn(this.parentNode,'label');
            for (var i = 0; i < ls.length; i++) {
                var l = ls[i];
                if (l.className.indexOf('label_radio') == -1)  continue;
                l.className = 'label_radio r_off';
            };
            this.className = 'label_radio r_on';
            if (safari) inp.click();
        } else {
            this.className = 'label_radio r_off';
            if (safari) inp.click();
        };
    };

</script>