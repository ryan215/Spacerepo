<link href="<?php echo base_url(); ?>css/retailer/intlTelInput.css" / rel="stylesheet">

<style>
.error{font-size:12px;
}
.requir-stars{color:red;
}
.main-shi-div option{color:#333;
}
.ajax-upload-dragdrop{width:150px !important;
	margin:0 auto;
	padding:0 !important;
}
.ajax-upload-dragdrop img{border-radius:50% !important;
}

.labels-radio{margin-right:5px;
	font-weight:normal;
}
input[type=radio] {
	    display:none;
	}
	input[type=radio] + label:before {
	    content: "";  
	    display: inline-block;  
	    width: 15px;  
	    height: 15px;  
	    vertical-align:middle;
	    margin-right: 8px;  
		border:1px solid #666;
	    border-radius: 8px;  
	}

	input[type=radio]:checked + label:before {
		content: "\2022";
		color:#99CB5D;
		font-size:2em;
		text-align:center;
		line-height:10.7px;
		text-shadow:0px 0px 3px #eee;
}

body{background:url('../../images/retailer_signup_bg.jpg');
	background-repeat:no-repeat;
	background-size:contain;
}

.intl-tel-input input{padding-left:40px;
	padding-right:1px;
	font-size:13px;
}
	
.intl-tel-input{float:left !important;
}

.rtlr-signup-select{height:38px;
}
	
</style>


<?php $this->load->view('success_error_message'); ?>
<div class="col-sm-12 pd main-shipsignin-div">
        	
        	<div class="col-lg-6 col-sm-6 pd col-sm-offset-3">
            	<div class="col-sm-12 log-in-box  main-shi-div">
					<?php 
$attributes = array('class' => 'form-horizontal shipping-form');
echo form_open('',$attributes);
?>

                    	<h2 style="color:#6DA943; font-size:22px;">Create a new account</h2>
                        <?php /*?><div class="form-group">
                        	<div class="icon-addon addon-md">
                            	<label class="signup-labels" style="margin-bottom:5px;">
									Platform
								</label>
								<br />								
                                <input type="radio" name="associationType" value="1" <?php if($result['associationType']==1){ ?> checked="checked" <?php } ?> id="associationType1" />
								<label for="associationType1" class="labels-radio">Pointemart</label>
								<input type="radio" name="associationType" value="2" <?php if($result['associationType']==2){ ?> checked="checked" <?php } ?> id="associationType2"/>
								<label for="associationType2" class="labels-radio">Pointepay</label>
								<input type="radio" name="associationType" value="3" <?php if($result['associationType']==3){ ?> checked="checked" <?php } ?> id="associationType3"/>
								<label for="associationType3" class="labels-radio">Both</label>
							  	<?php echo form_error('associationType'); ?>
                            </div>
                        </div><?php */?>
						<input type="hidden" name="associationType" value="3"/>
						
						<div class="form-group">
                        	<div class="icon-addon addon-md col-sm-6 pd-left form-group-signup">
                            	<label class="signup-labels">First Name</label> <span class="requir-stars">*</span>
								<input  type="text" name="firstName" value="<?php echo $result['firstName']; ?>" class="form-control ship-input ship-input2" placeholder="First Name" >
                				<?php echo form_error('firstName'); ?>
                            </div>
                            <div class="icon-addon addon-md col-sm-6 pd-right form-group-signup">
                            	<label class="signup-labels">Middle Name</label>
								<input  type="text" name="middleName" value="<?php echo $result['middleName']; ?>" class="form-control ship-input ship-input2" placeholder="Middle Name" >
               					 <?php echo form_error('middleName'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        	<div class="icon-addon addon-md col-sm-6 pd-left form-group-signup">
                            	<label class="signup-labels">Last Name</label> <span class="requir-stars">*</span>
								<input type="text" name="lastName" value="<?php echo $result['lastName']; ?>" placeholder="Last Name" class="form-control ship-input ship-input2">
                				<?php echo form_error('lastName'); ?> 
                            </div>
							
						
                        	<div class="icon-addon addon-md col-sm-6 pd-right form-group-signup">
                            	<label class="signup-labels">User Name</label> <span class="requir-stars">*</span>
                              <div>
                              	  <input type="text" class="form-control ship-input ship-input2" placeholder="User Name" name="userName" value="<?php echo $result['userName']; ?>" onkeyup="check_user(this.value);" onblur="check_user(this.value);" id="userName">
                                <label id="userNameLb" title="username"  class="fa fa-user input-label " for="email" style="top:22px;"></label>
                   
								
                              </div>
							  	<div id="errMsgUn" class="error">
									<?php echo form_error('userName'); ?>
								</div>
							  
                            </div>
                            
                            </div>
                       
                        	<div class="form-group">
                            	<div class="icon-addon addon-md  form-group-signup">
                            	<label class="signup-labels">Email</label>
                                <input type="text" class="form-control ship-input ship-input2" name="email" value="<?php echo $result['email']; ?>" placeholder="Email">
                <?php echo form_error('email'); ?>
                            </div>
                            </div>		
                            
                     
                        <div class="form-group">
                        	<div class="icon-addon addon-md col-sm-6 pd-left form-group-signup">
                            	<label class="signup-labels">Password</label> <span class="requir-stars">*</span>
                                <input type="password" class="form-control ship-input ship-input2" name="password" value="<?php echo $result['password']; ?>" placeholder="Password">
                <?php echo form_error('password'); ?>
                            </div>
                        	<div class="icon-addon addon-md col-sm-6 pd-right form-group-signup">
                            	<label class="signup-labels">Confirm Password</label> <span class="requir-stars">*</span>
                                <input type="password" class="form-control ship-input ship-input2" name="confPassword" value="<?php echo $result['password']; ?>" placeholder="Confirm Password">
                <?php echo form_error('confPassword'); ?> 
                            </div>
                        </div>
                        <div class="form-group">
                        	<div class="icon-addon addon-md col-sm-6 pd-left form-group-signup">
                            	<label class="signup-labels">Business Name</label><span class="requir-stars">*</span>
                                <input type="text"class="form-control ship-input ship-input2" placeholder="Business Name" name="businessName" value="<?php echo $result['businessName']; ?>">
                <?php echo form_error('businessName'); ?>
                            </div>
                      
                      
                      		<div class="icon-addon addon-md col-sm-6 pd-right form-group-signup">
                            	<label class="signup-labels">Business Phone Number</label> <span class="requir-stars">*</span><br>
                              	<?php /*?><div class="col-sm-12 pd" style="display:inline-flex; width:100%;">
                                	
                                	<div class="" style="width:85px; float:left;">
                                    	<input type="tel" name="countryCode" id="mobile-number" placeholder="Enter Phone Number" class="ship-input ship-input2 form-control" data-live-search="true" value="<?php echo $result['countryCode']; ?>" style="width:85px; float:left;">
                                    </div>
									<div class="pull-right" style="width:66%;">
                                    <input type="text" class="form-control ship-input ship-input2" placeholder="Business Phone Number" name="businessPhone" value="<?php echo $result['businessPhone']; ?>"  style="margin-left:-2px; font-size:13px;" / >
                                    </div>
                					
                                </div><?php */?>
								<div class="col-sm-12 pd" style="display:inline-flex; width:100%;">
                               
                                  <div class="input-group">
                                     <span class="input-group-addon" style="background-color: #eee !important; font-size:14px;">+234</span>
                                     <input type="text" name="businessPhone" class="form-control" placeholder="Business Phone Number" value="<?php echo $result['businessPhone']; ?>">
                                  </div>
                           
                      	</div> <?php echo form_error('businessPhone'); ?>
                        </div>
                        </div>
                        <div class="form-group">
                        	<div class="icon-addon addon-md col-sm-6 pd-left form-group-signup">
                            	<label class="signup-labels">State Name</label> <span class="requir-stars">*</span>
								<div id="stateList">
                                 	<select name="stateId" id="stateId" class="form-control rtlr-signup-select">
					                    <option value="">Select State</option>
									</select>                    					
								</div>
 				                 <?php echo form_error('stateId'); ?>
                            </div>
                            
                            <div class="icon-addon addon-md col-sm-6 pd-right form-group-signup">
                            	<label class="signup-labels">Area Name</label> <span class="requir-stars">*</span>
                              	 <div id="areaList">
								  <select name="areaId" class="form-control rtlr-signup-select">
									<option value="">Select Area</option>
								  </select>								  
				  				</div>
             					<?php echo form_error('areaId'); ?> 
                            </div>
                            
                        </div>
                        <div class="form-group">
                        	 <div class="icon-addon addon-md col-sm-6 pd-left form-group-signup">
                            	<label class="signup-labels">City Name</label> <span class="requir-stars">*</span>
                              	 <div id="cityList">
								  <select name="cityId" class="form-control rtlr-signup-select">
									<option value="">Select City</option>
								  </select>								  
				  				</div>
             					<?php echo form_error('cityId'); ?> 
                            </div>
							
                        	<div class="icon-addon addon-md col-sm-6 pd-right form-group-signup">
                            	<label class="signup-labels">Street Address</label> <span class="requir-stars">*</span>
                                <input type="text" class="form-control ship-input ship-input2" placeholder="Street Address" name="street" value="<?php echo $result['street']; ?>">
                <?php echo form_error('street'); ?>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 text-center" style="margin:0 0 20px 0;">
                        	<input type="checkbox" style="top: 2px;position: relative;" id="acceptCond" name="accept" <?php if($result['acceptTermCondition']){ ?> checked="checked" <?php } ?>>
							&nbsp; I accept the<span style="color:#6BB460;"> <a href="#myModal" data-toggle="modal">Terms And Conditions.</a> </span>
							<?php echo form_error('accept'); ?>
                        </div>
						
                        <div class="form-group sign-inbtn-div sign-inbtn-div2">
                            <button type="submit" class="btn btn-block ship-sign-btn" style="width:200px; margin:0 auto;">Sign Up</button>
                        </div>
                        
                    </form>  
                </div>
            </div>
            
        </div>
<div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
    
    
    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">TERMS OF PARTICIPATION</h4>
                </div>
                <div class="modal-body" style="height:550px; overflow-y:scroll;">
                <div class=Section1>
<p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>SPACEPOINTE NIGERIA LIMITED </span></b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>a Limited Liability Company registered
under the Companies and Allied matters Act CAP C20 LFN 2004 with its office at
No. 16, Akin Adesola Street, Victoria Island, Lagos (hereinafter referred to as
the &quot;SpacePointe&quot;) operates the Platform (as defined below). The
following terms and conditions (this &quot;Agreement&quot;), govern your access
to and use of this Platform and related services as a seller of Goods
(&quot;Seller&quot;).<o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>Seller should read this Agreement carefully before using the
Platform. By clicking to accept this Agreement, Seller accepts and agrees to
the terms of this Agreement, SpacePointe's website Terms of Use and Privacy
Policy, found at </span><a href="http://www.pointemart.com/retailer"><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial'>seller.pointemart.com</span></a><a name="_GoBack"></a><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'> (&quot;Privacy Policy&quot;). Seller
may not sell Goods through the Platform unless it agrees to the terms of this
Agreement.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.25in;mso-add-space:auto;
line-height:115%'><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.5in;line-height:115%;
mso-list:l30 level1 lfo35'><![if !supportLists]><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>1.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><u><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>INTERPRETATION<o:p></o:p></span></u></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>1.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>In this Agreement, unless the subject or context
otherwise requires, the following words and expressions shall have the
following meanings : <b style='mso-bidi-font-weight:normal'><o:p></o:p></b></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;mso-add-space:auto;
line-height:115%'><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='margin-left:40.85pt;border-collapse:collapse;border:none;mso-border-alt:
 solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0in 5.4pt 0in 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Agreement<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>This contract entered into between
  SpacePointe and the Seller to use of SpacePointe's Platform for the purchase
  and sale of the Seller's Goods to customers, howsoever formed or concluded.<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Business Day<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>A day (excluding Saturdays and Sundays) on
  which banks generally are open for business in Nigeria.<b style='mso-bidi-font-weight:
  normal'><o:p></o:p></b></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Competitor<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>Any private or corporate person, who
  directly or indirectly, engages in the sale of Goods on the internet in Nigeria.
  For the avoidance of doubt, any person whose direct or indirect business is
  only partially similar to the aforementioned would still be deemed to be a
  Competitor<b style='mso-bidi-font-weight:normal'><o:p></o:p></b></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Handling Time<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>time for dispatch of every Good/Item by the
  Seller (excluding Sundays)<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Conditions<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>means the general terms and conditions set
  out in this document and (unless the context otherwise requires) any special
  terms and conditions agreed in writing between the Seller and SpacePointe<b
  style='mso-bidi-font-weight:normal'><o:p></o:p></b></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Customer<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>a customer, who purchases Goods on the
  Platform<b style='mso-bidi-font-weight:normal'><o:p></o:p></b></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Goods<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>the goods (including any installment of the
  goods or any parts for them) which the Seller intends to sell to Customers
  over the Platform<b style='mso-bidi-font-weight:normal'><o:p></o:p></b></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>In Writing/ Written<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>includes electronic mail to the e-mail
  address</span><span style='font-size:10.0pt;line-height:115%;font-family:
  "Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
  minor-latin;color:black;mso-themecolor:text1'> designated by SpacePointe for
  the purpose of communication between SpacePointe and the Seller,</span><span
  style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'> and any comparable means of
  communication, so long as such form results in a permanent record being made<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:8'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>IntellectualProperty</span></b><b
  style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
  115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
  mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
  mso-themecolor:text1'><o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>any patent, copyright, registered or
  unregistered design, design right, registered or unregistered trademark,
  service mark or other industrial or intellectual property right and includes
  applications for any of them<b style='mso-bidi-font-weight:normal'><o:p></o:p></b></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:9'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Listing Price<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>listing price of the Good<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:10'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>Platform<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>means the website www.pointemart.com and
  related services and applications, including, without limitation, software, code,
  files, images, contained in or generated by the software, accompanying data,
  feeds and other embedded software, documentation and any accompanying fonts<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:11'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>SKU<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>stock keeping unit, every unique item sold
  by the Seller<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:12;mso-yfti-lastrow:yes'>
  <td width=123 valign=top style='width:92.15pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
  mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;color:black;mso-themecolor:text1'>3PL<o:p></o:p></span></b></p>
  </td>
  <td width=469 valign=top style='width:351.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
  line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
  minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  color:black;mso-themecolor:text1'>third party logistics provider <o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraph style='margin-left:1.0in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>1.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Any
reference in this Agreement to any provision of a statute shall be construed as
a reference to that provision as amended re-enacted or extended at the relevant
time.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:35.45pt;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level1 lfo35'><![if !supportLists]><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>2.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>BASIS OF THE AGREEMENT</span></b><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>2.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>The
use of the Platform by a Seller for the Sale of Goods shall be subject to these
Conditions, which shall govern all agreements to the exclusion of any other
terms and conditions contained or referred to in any documentation submitted by
the Seller or in correspondence or elsewhere or implied by trade custom
practice or course of dealing. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>2.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>If Seller signs up for an account in the name of a
corporate entity, it represents that it has full corporate power and authority
to enter into this Agreement on behalf of the entity and to bind the entity to
the obligations in this Agreement.</span><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>2.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Each
party acknowledges and agrees that electronic signatures, whether digital or
encrypted, of the parties shall be acceptable and are intended to authenticate
this writing and to have the same force and effect as manual signatures.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>2.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Any
typographical clerical or other error or omission in any acceptance, invoice or
other document on the part of SpacePointe shall be subject to correction
without any liability on the part of SpacePointe. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>2.5.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Upon
Seller's discovery that any requirement or provision of this Agreement may
conflict with any other requirement or provision, it is Seller's responsibility
to give SpacePointe written notice of such alleged conflict for resolution by SpacePointe
in SpacePointe's sole discretion. If Seller proceeds without notification to SpacePointe
for resolution of such conflict, then all costs incurred in correcting Seller's
erroneous interpretation shall be for Seller's account.<o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%;mso-layout-grid-align:none;
text-autospace:none'><span style='font-size:10.0pt;line-height:115%;font-family:
"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraph style='text-indent:-.5in;line-height:115%;mso-pagination:
widow-orphan lines-together;page-break-after:avoid;mso-list:l30 level1 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>3.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>DROP SHIPMENT PARTNERSHIP<o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Provided
that the Seller adheres to the terms of this Agreement, SpacePointe agrees to
feature the Seller's Goods for sale on the Platform with prompt delivery to
customers; customers bear the cost of shipping and taxes for all purchases made
on the site.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:1.0in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>3.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>This Platform is offered and available to users who
are 18 years of age or older. By using this Platform, Seller represents and
warrants that it meets all of the eligibility requirements in this Agreement. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>3.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>To access the Platform or some of the resources it
offers, Seller may be asked to provide certain registration details or other
information. It is a condition of Seller's use of the Platform that all the
information Seller provides on the Platform is correct, current and complete. Seller
agrees that all information Seller provides to register with this Platform or
otherwise, including but not limited to through the use of any interactive
features on the Platform, is governed by SpacePointe's Privacy Policy, and Seller
consents to all actions SpacePointe takes with respect to Seller's information
consistent with SpacePointe's Privacy Policy.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Customers
would be able to purchase Goods on the Platform. SpacePointe shall process each
order made by Customers for delivery, as provided for herein and receiptpayment
for the processed order's delivery to the Seller's SpacePointe account. For the
avoidance of doubt, each agreement entered into for the sale of Goods shall be
an agreement entered into between the Customer and the Seller direct. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.5.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>The
relationship of the Seller and SpacePointe shall be solely that of independent
contractors. Nothing contained in this Agreement shall be construed to make one
Party the agent for the other for any purpose, and neither of the Parties
hereto shall have any right whatsoever to incur any obligations or liabilities
on behalf of or binding on the other party.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.6.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Seller
agrees to only use the Platform only for lawful purposes and in accordance with
this Agreement. Seller agrees not to use the Platform:<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level3 lfo35'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.6.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>in any
way that violates any applicable federal, state, local or international law or
regulation;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level3 lfo35'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.6.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>to
list or sell products without proper permit, license or authorization for sale
by the appropriate federal, state, local or international regulatory body;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level3 lfo35'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.6.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>to transmit,
or procure the sending of, any advertising or promotional material. &quot;Junk
mail&quot;, &quot;chain letters&quot; or &quot;spam&quot; or any other similar
solicitation;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level3 lfo35'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.6.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>to
engage in any activity that could be considered as fraudulent or misleading,
including providing fake, inferior or substandard products that have been sold
as genuine, such as providing used, refurbished or damaged products that have
been sold as new or unused or failing to promptly deliver or make available
products offered through the Platform;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level3 lfo35'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.6.5.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>to
impersonate or attempt to impersonate SpacePointe, a SpacePointe employee,
another user or any other person or entity (including, without limitation, by
using e-mail addresses, screen names or identifying information associated with
any of the foregoing);<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level3 lfo35'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>3.6.6.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>to engage
in any other conduct that restricts or inhibits anyone's use or enjoyment of
the Platform, or which, as determined by SpacePointe, may harm SpacePointe, its
affiliates, partners or users of the Platform or expose them to liability.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:35.45pt;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraph style='text-indent:-.5in;line-height:115%;mso-pagination:
widow-orphan lines-together;page-break-after:avoid;mso-list:l30 level1 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>4.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>COMMISSION/FEES<span style='mso-bidi-font-weight:
bold'><o:p></o:p></span></span></b></p>

<p class=MsoNormal style='margin-left:67.5pt;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>4.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Selling
Fee: SpacePointeshall be entitled to receive a commission as stipulated in {FEE
SCHEDULE LINK}, which may vary, based on the category of Goods sold by the
Seller to Customers on the Platform.<a style='mso-comment-reference:LL_1;
mso-comment-date:20150422T1939'><i style='mso-bidi-font-style:normal'>This
commission shall be waived for the duration to be agreed between both parties</i></a></span><span
class=MsoCommentReference><span style='font-size:8.0pt;line-height:115%'><![if !supportAnnotations]><a
class=msocomanchor id="_anchor_1"
onmouseover="msoCommentShow('_anchor_1','_com_1')"
onmouseout="msoCommentHide('_com_1')" href="#_msocom_1" language=JavaScript
name="_msoanchor_1">[LL1]</a><![endif]><span style='mso-special-character:comment'>&nbsp;</span></span></span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:67.5pt;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:67.5pt;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>4.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointeshall
issue receipt invoices to Seller on the delivery of each item to be shipped per
order<o:p></o:p></span></p>

<p class=MsoListParagraph><span style='font-size:10.0pt;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:67.5pt;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>4.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointeshall
remit payment of all items sold made by the Seller via the site within 48hours
of the delivery time – this is to ensure that the item isn't returned for
reasons of non-compliance with order made wherein a refund or item reshuffle
[also known as internal cross ordering] is initiated. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:35.45pt;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level1 lfo35'><![if !supportLists]><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>5.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>SCOPE OF GOODS</span></b><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>5.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>The Seller
and SpacePointe shall mutually agree on the identity and typeof the Goods,
which shall be sold on the Platform. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>5.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>These
items will be digitally captured on the sellers site with specific picture
properties none of which should be offensive to any group or type of customer
[within the guidelines of online retailing or merchandising of items]<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>5.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointe
reserves the right to control the look and feel of the website in its entirety;
the personal site of the seller might be allowed to include the logo or brand
profile of the seller should this exist {T&amp;C's will apply where applicable}<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>5.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>At any
given point in time, SpacePointe reserves the right to delist seller's products
that may not contribute to the assortment or when the seller is deemed
operationally incapable.<o:p></o:p></span></p>

<p class=MsoListParagraph><span style='font-size:10.0pt;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level3 lfo35'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>5.4.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>A
seller might also be blocked from the site in instances where the seller has
been found to be consistently non-compliant with the terms and conditions of
sale across the site<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:35.45pt;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level1 lfo35'><![if !supportLists]><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>6.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>INVENTORY AND PRICING OF GOODS</span></b><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>6.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>The Seller
shall be obliged to maintain an inventory of all Goods sold on the Platform and
furnish SpacePointe with an update of its inventory via updating the Platform with
any sales made in-store and physically. Each update will be seen by SpacePointein
real time.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>6.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>The
Parties may establish an automatic electronic update system, on terms and
conditions to be mutually agreed upon in Writing.<o:p></o:p></span></p>

<p class=MsoListParagraph><span style='font-size:10.0pt;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>6.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SMS
short coding will also be a possibility to update and maintain inventory <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>6.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>In the
event that the Seller reasonably anticipates that any Goods sold on the
Platform may go out of stock, the Seller shall inform SpacePointe of this by
text, email or telephone call to the customer care center. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:35.45pt;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.5in;line-height:115%;
mso-list:l30 level1 lfo35'><![if !supportLists]><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>7.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>SALE OF THE GOODS ON THE PLATFORM </span></b><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>7.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Upon
receipt of an order for the purchase of Goods, SpacePointe shall process such
orders and furnish the Seller with details relating to the ordered Goods,
including the Seller's stock keeping unit or bar code relating to the Goods and
the details contained in the customer's purchase order. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>7.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>All
agreements entered into between the Seller and the Customer for the sale of
Goods on the Platform shall be entered into on the basis of SpacePointe's terms
and conditions of sale and SpacePointe's return policy, which are contained on
the Platform. In the event that of SpacePointe's terms and conditions of sale
and SpacePointe's return policy, which are contained on the Platform contradicts
the terms of these conditions, SpacePointe's Terms and Conditions of sale and SpacePointe's
return policy shall prevail. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>7.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>The Seller
is hereby put on notice that SpacePointe reserves the right to change its terms
and conditions of sale and its return policy at any time. SpacePointe shall
give Notice to Seller of such changes, as well as update the Terms and
Conditions onSpacePointe's ecommerce platform for the Seller's attention.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>7.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointe
shall receive and process all payments for Goods purchased on the Platform. SpacePointe
shall make payment of all sums received from Customers, subject to its rights
of set-off, as provided herein, to the Seller on a bi-monthly basis.<span
style='mso-spacerun:yes'>   </span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.55in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraph style='margin-left:35.45pt;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>8.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>ORDER DISPATCHING AND CANCELLATIONS<o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>8.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Upon
receipt of information from SpacePointe, the Seller shall be obliged to process
each Customer order such that all Goods shall have a Handling Time of 2 Days. In
case of delay, either materialized or foreseen, the Seller shall be obliged to
immediately inform SpacePointe of the same in Writing on an immediate basis. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>8.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Seller
is expected to maintain a service level of 90% and above for within Handling
Time dispatch.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>8.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointe
will cancel every order which has not been dispatched within three (3)Days
after the Handling Time, in case the Customers who are informed ofthe delay of
the order decide not to proceed anymore with the purchase.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
minor-latin;color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>8.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>In
case of cancellation of an order,SpacePointe will refund the entire payment to
the Customer;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>9.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>PRODUCT PACKAGING<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level2 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>9.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><span lang=EN-SG style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:ArialMT;color:black;
mso-themecolor:text1;mso-ansi-language:EN-SG'>The Seller shall be responsible
for the basic packaging process; this packaging will be required to have
whatever protective padding is required for the item to be safe during the
shipping process. </span><b><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-pagination:widow-orphan lines-together;page-break-after:
avoid;mso-layout-grid-align:none;text-autospace:none'><b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level2 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>9.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><span lang=EN-SG style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:ArialMT;color:black;
mso-themecolor:text1;mso-ansi-language:EN-SG'>SpacePointe shall provide the
Seller with packaging and delivery processing support to include labelling
prior to delivery. </span><b><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle><span lang=EN-SG style='font-size:10.0pt;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:ArialMT;color:black;mso-themecolor:text1;
mso-ansi-language:EN-SG'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level2 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>9.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><span lang=EN-SG style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:ArialMT;color:black;
mso-themecolor:text1;mso-ansi-language:EN-SG'>All costs for producing the
branding material and packaging will be sustained by SpacePointe and borne by
the customer as part of the shipping costs billed at checkout.</span><b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:35.45pt;mso-add-space:
auto;line-height:115%;mso-pagination:widow-orphan lines-together;page-break-after:
avoid;mso-layout-grid-align:none;text-autospace:none'><b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>10.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>SHIPPING OF THE GOODS<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-pagination:widow-orphan lines-together;
mso-list:l30 level2 lfo35;mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>10.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Seller
agrees that SpacePointe's accredited and preferred local 3PL will be the means
of delivery to the end customer, andSpacePointe reserves the right to change
3PL at its own discretion or at the repeated complaints of customers and as
verified in each case.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-pagination:widow-orphan lines-together;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
background:yellow;mso-highlight:yellow'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>11.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>CUSTOMER SERVICE <o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:.5in;line-height:115%;mso-pagination:
widow-orphan lines-together;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>SpacePointe shall forward to the Seller
all questions and complaints, which it may receive with regards to the Goods.
The Seller shall revert to SpacePointe on all such questions and complaints on
or before the expiry of two days[maximum] of the receipt of such questions and
complaints. All customer complaints and inquiries are expected to be resolved
and closed off within 24-48hours {as a worst case scenario}<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.5in;line-height:115%;
mso-pagination:widow-orphan lines-together;mso-layout-grid-align:none;
text-autospace:none'><span style='font-size:10.0pt;line-height:115%;font-family:
"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>12.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>PAYMENT <o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>12.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>SpacePointe shall make payment of items sold from
the Platform within 48hours of the delivery timeline; payment is made to the
Seller's account as designated in the registration process. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>12.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>All payments made by SpacePointe will be in line
with the amounts agreed for the sale of items per time; exclusive of VAT,
delivery or packaging charges as paid by the customer.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>12.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Any sums due to the Seller hereunder may be applied
by SpacePointe as a set off against any sums owed by the Seller to SpacePointe,
or against any claims of third parties against SpacePointe arising from the Seller's
performance, whether under any purchase order or other document. At its sole
discretion, SpacePointe may withhold from payments to be made to the Seller
amounts legally required to be withheld from such payments and remitted to the
taxing authority of any jurisdiction relevant to the transaction.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>12.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller shall be responsible for payment of all
sales, use, excise, value-added, business, and other taxes, any taxes, which
may be imposed on the basis of any revenue, income, net income, or capital and
any taxes imposed in lieu thereof, and all duties, fees, or other assessments
of whatever nature imposed by governing authorities or any jurisdiction applicable
in connection with performance under this Agreement. The Seller shall release,
defend, indemnify, and hold SpacePointe harmless from and against any fines,
penalties, costs (including attorney's fees and court costs), losses, damages,
liabilities or (whether criminal or civil) claims, arising from, alleged to
arise from, or in any way associated with the Seller's failure to comply with
the terms of this Paragraph.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%;mso-pagination:
widow-orphan lines-together;page-break-after:avoid;mso-layout-grid-align:none;
text-autospace:none'><b><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.25in;mso-add-space:auto;
text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>13.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>WARRANTIES<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller warrants to SpacePointe that all the
Goods sold on the Platform, whether manufactured, fabricated, or otherwise
produced or provided by the Selleror others, will:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.1.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>strictly conform to the specifications, drawings,
samples, performance criteria, and other descriptions referred to or provided
on the Platform;<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.1.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>be of merchantable quality and fit for the
purpose(s) intended;<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.1.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>have all relevant regulatory permits and licenses,
as well asconform with all applicable laws, ordinances, codes and regulations,
and<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.5in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.1.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>be free from defects in materials, performance,
operation, and workmanship for a period of one (1) year after being placed in
service by the Customer or twenty-four (24) months from date of the Seller's
delivery, whichever period expires earlier. <o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller furthermore warrants and represents to SpacePointe
that: <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.2.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The entry into this Agreement and the performance
thereof by the Seller have been duly authorized by all necessary corporate
action and constitutes a valid and binding agreement of the Seller, enforceable
against the Seller in accordance with the terms thereof.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.2.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>All information, including but not limited to all
information furnished to SpacePointe with regards to the Goods are accurate and
up-to-date. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.2.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>All formal consents, waivers, approvals, authorizations,
exemptions, registrations, licenses or declarations of or by or filing with,
any authority or contracting party which are required to be made or obtained by
the Seller in connection with the entry into this Agreement and the performance
of the same, have been duly obtained.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.2.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The entry, delivery and performance of this
Agreement by the Seller will not violate or conflict in any material respect
with any law, statute, rule, regulation, ordinance, code, judgment, order,
writ, injunction, decree or other requirement of any court or of any
governmental body or agency thereof applicable to the Borrower;<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.5in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>13.2.5.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>If necessary, the Seller shall be obliged to
procure all formal consents, waivers, approvals, authorizations, exemptions,
registrations and/or licenses necessary for SpacePointe to feature the Goods on
the Platform, as anticipated in this Agreement, at its own cost; <o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%;mso-layout-grid-align:none;
text-autospace:none'><span lang=EN-GB style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-ansi-language:EN-GB;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.25in;mso-add-space:auto;
text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>14.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>FORCE MAJEURE<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>SpacePointe shall not be liable to the Seller or be
deemed to be in breach of this Agreement by reason of any delay in performing
or any failure to perform any of SpacePointe's obligations if the delay or
failure was due to any cause beyond SpacePointe's reasonable control<span
style='mso-spacerun:yes'>   </span>Without prejudice to the generality of the
foregoing the following shall be regarded as causes beyond SpacePointe's
reasonable control:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.1.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Act of
God, explosion<span style='mso-spacerun:yes'>  </span>flood<span
style='mso-spacerun:yes'>  </span>tempest<span style='mso-spacerun:yes'> 
</span>fire or accident</span><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.1.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>war or
threat of war<span style='mso-spacerun:yes'>  </span>sabotage<span
style='mso-spacerun:yes'>  </span>insurrection<span style='mso-spacerun:yes'> 
</span>civil disturbance or requisition;</span><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.1.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>acts<span
style='mso-spacerun:yes'>  </span>restrictions<span style='mso-spacerun:yes'> 
</span>regulations<span style='mso-spacerun:yes'>  </span>bye-laws<span
style='mso-spacerun:yes'>  </span>prohibitions or measures of any kind on the
part of any governmental<span style='mso-spacerun:yes'>  </span>parliamentary
or local authority;</span><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.1.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>interruption
of traffic, strikes<span style='mso-spacerun:yes'>  </span>lock-outs or other
industrial actions or trade disputes (whether involving employees of SpacePointe
or of a third party related to the service rendering required);</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.1.5.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>interruption
of production or operation, difficulties in obtaining raw materials labour<span
style='mso-spacerun:yes'>  </span>fuel<span style='mso-spacerun:yes'> 
</span>parts or machinery;</span><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.5in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.1.6.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>power
failure or breakdown in machinery or resources.</span><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Upon the happening of any one of the events set out
aboveSpacePointe may at its option and where required:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.2.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>fully
or partially suspend delivery/performance while such event or circumstances
continues; or</span><span style='font-size:10.0pt;line-height:115%;font-family:
"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.5in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>14.2.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>terminate
this Agreement with immediate effect by written notice to the Seller and SpacePointe
shall not be liable for any loss or damage suffered by the Seller as a result
thereof.</span><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:115%;mso-layout-grid-align:
none;text-autospace:none'><span lang=EN-GB style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-ansi-language:EN-GB;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.25in;mso-add-space:auto;
text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;text-transform:uppercase'><span
style='mso-list:Ignore'>15.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;text-transform:uppercase'>Disclaimer of Warranties<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>15.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>SpacePointe reserves the right to withdraw or amend
this Platform, and any service or material provided on the Platform, in SpacePointe's
sole discretion pursuant to Section 18 below. SpacePointe will not be liable if
for any reason all or any part of the Platform is unavailable at any time or
for any period. From time to time, SpacePointe may restrict access to some
parts of the Platform, or the entire Platform, to users, including registered
users.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>15.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Seller is responsible for:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>15.2.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Making all arrangements necessary for Seller to
have access to the Platform.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>15.2.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Ensuring that all persons who access the Platform through
Seller's internet connection are aware of this Agreement and comply with them.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>15.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Seller understands that SpacePointe cannot and do
not guarantee or warrant that files available for downloading from the internet
or the Platform will be free of viruses or other destructive code. Seller is
responsible for implementing sufficient procedures and checkpoints to satisfy
Seller's particular requirements for anti-virus protection and accuracy of data
input and output, and for maintaining a means external to this site for any
reconstruction of any lost data. <span style='text-transform:uppercase'>SpacePointe</span>
WILL NOT BE LIABLE FOR ANY LOSS OR DAMAGE CAUSED BY TECHNOLOGICALLY HARMFUL
MATERIAL THAT MAY INFECT SELLER'S COMPUTER EQUIPMENT, COMPUTER PROGRAMS, DATA
OR OTHER PROPRIETARY MATERIAL DUE TO SELLER'S USE OF THE PLATFORM OR GOODS
SUBMITTED THROUGH THE PLATFORM OR TO SELLER'S DOWNLOADING OF ANY MATERIAL
POSTED ON IT OR ON ANY WEBSITE LINKED TO IT.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>15.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>SELLER'S USE OF THE PLATFORM, ITS CONTENT AND ANY
SERVICES OR ITEMS OBTAINED THROUGH THE PLATFORM IS AT SELLER'S OWN RISK. THE PLATFORM,
ITS CONTENT AND ANY SERVICES OR ITEMS OBTAINED THROUGH THE PLATFORM ARE
PROVIDED ON AN &quot;AS IS&quot; AND &quot;AS AVAILABLE&quot; BASIS, WITHOUT
ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED. NEITHER SPACEPOINTE NOR
ANY PERSON ASSOCIATED WITH SPACEPOINTE MAKES ANY WARRANTY OR REPRESENTATION
WITH RESPECT TO THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY OR
AVAILABILITY OF THE PLATFORM. WITHOUT LIMITING THE FOREGOING, NEITHER
SPACEPOINTE NOR ANYONE ASSOCIATED WITH SPACEPOINTE REPRESENTS OR WARRANTS THAT
THE PLATFORM, ITS CONTENT OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE PLATFORM
WILL BE ACCURATE, RELIABLE, ERROR-FREE OR UNINTERRUPTED, THAT DEFECTS WILL BE
CORRECTED, THAT THE PLATFORM OR THE SERVER THAT MAKES IT AVAILABLE ARE FREE OF
VIRUSES OR OTHER HARMFUL COMPONENTS OR THAT THE PLATFORM OR ANY SERVICES OR
ITEMS OBTAINED THROUGH THE PLATFORM WILL OTHERWISE MEET SELLER'S NEEDS OR
EXPECTATIONS.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>15.5.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>SPACEPOINTE HEREBY DISCLAIMS ALL WARRANTIES OF ANY
KIND, WHETHER EXPRESS OR IMPLIED, STATUTORY OR OTHERWISE, INCLUDING BUT NOT
LIMITED TO ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT AND FITNESS FOR
PARTICULAR PURPOSE.THE FOREGOING DOES NOT AFFECT ANY WARRANTIES WHICH CANNOT BE
EXCLUDED OR LIMITED UNDER APPLICABLE LAW.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.25in;mso-add-space:
auto;line-height:115%;mso-pagination:widow-orphan lines-together;page-break-after:
avoid;mso-layout-grid-align:none;text-autospace:none'><b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.25in;mso-add-space:
auto;text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>16.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>LIMITATION OF LIABILITY<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>16.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>IN NO EVENT WILL SPACEPOINTE, ITS AFFILIATES OR
THEIR LICENSORS, SERVICE PROVIDERS, EMPLOYEES, AGENTS, OFFICERS OR DIRECTORS BE
LIABLE FOR ANY INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL OR PUNITIVE
DAMAGES, INCLUDING BUT NOT LIMITED TO, PERSONAL INJURY, PAIN AND SUFFERING,
EMOTIONAL DISTRESS, LOSS OF REVENUE, LOSS OF PROFITS, LOSS OF BUSINESS OR
ANTICIPATED SAVINGS, LOSS OF USE, LOSS OF GOODWILL, OR LOSS OF DATA, WHETHER IN
BREACH OF CONTRACT, NEGLIGENCE, STRICT LIABILITY, MISREPRESENTATIONS<span
style='mso-spacerun:yes'>  </span>OR UNDER ANY OTHER LEGAL THEORY, EVEN IF
FORESEEABLE, ARISING OUT OF OR IN CONNECTION WITH SELLER'S USE, OR INABILITY TO
USE, THE PLATFORM, ANY CONTENT ON THE PLATFORM OR SUCH OTHER WEBSITES OR ANY
SERVICES OR ITEMS OBTAINED THROUGH THE PLATFORM OR SUCH OTHER WEBSITES.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>16.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>IN NO EVENT WILL SPACEPOINTE'S AGGREGATE LIABILITY
EXCEED THE COMMISSION PAID TO SPACEPOINTE UNDER THIS AGREEMENT IN THE LAST SIX
MONTHS FOR THE SERVICES GIVING RISE TO THE CLAIM.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>16.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>THE FOREGOING DOES NOT AFFECT ANY LIABILITY WHICH
CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.25in;mso-add-space:
auto;line-height:115%;mso-pagination:widow-orphan lines-together;page-break-after:
avoid;mso-layout-grid-align:none;text-autospace:none'><b><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.25in;mso-add-space:
auto;text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>17.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>TERMINATION <o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Either Party may terminate this Agreement by means
of Fourteen (14) Days' notice in writing.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>On or at any time after the occurrence of any of
the events in condition 16.3 below,SpacePointe shall, in addition to any rights
or remedies it may have in law, in equity, or under this Agreement, be entitled
to terminate this Agreement with the Seller with immediate effect by written
notice to the Seller and the Seller shall not be entitled to any cancellation
or other fee or penalty hereunder.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The events are:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>the Seller
being in breach of any warranty or representation under this Agreement;</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>the Seller
being in breach of any obligation under this Agreement and failing to remedy
the same on or before seven (7) days from receipt of a written notice from SpacePointe
of such breach.</span><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>the Seller
passing a resolution for its winding up or a court of competent jurisdiction
making an order for the Seller's winding up or dissolution;</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>the
making of an administration order in relation to the Seller or the appointment
of a receiver over or an encumbrance taking possession of or selling any of the
Seller's assets;</span><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.5.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>the Seller
making an arrangement or composition with its creditors generally or applying
to a Court of competent jurisdiction for protection from its creditors;</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.6.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>the Seller
ceasing<span style='mso-spacerun:yes'>  </span>or threatening to cease<span
style='mso-spacerun:yes'>  </span>to carry on business; or</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.3.7.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointe
reasonably apprehends that any of the events mentioned above is about to occur
in relation to the Seller and notifies the Seller accordingly.</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%'><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Upon termination of this Agreement, the Seller
shall immediately inform SpacePointe of all concluded Agreements entered into
with Customers, which have yet to be fully performed and shall be obliged to
perform these Agreements to its full extent.<span style='mso-spacerun:yes'> 
</span>This will inform SpacePointe's decision and action to block such a
Seller from the platform to prevent further sales or interactions with
customers on the site here onwards. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.5in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>17.4.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Should a customer engage with a Seller outside the
boundaries of the site for further business, this will be done outside of the
warranties, liabilities or indications of SpacePointe and SpacePointe will not
be liable for any consequences or benefits from such a transaction<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.5in;line-height:115%;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level1 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>18.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>INDEMNIFICATION<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>18.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller agrees to release, defend, indemnify and
hold harmless SpacePointe, including its affiliates, and any director, officer,
employee, contractor, or agent, against any costs (including attorney fees and
court costs on an indemnity basis), fines, penalties, damages, and liabilities,
arising from, alleged to arise from, or in any way associated with:</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>18.1.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>any defect
in the Goods sold to any Customer;</span><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>18.1.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>any claim
made by any Customer on the basis of any agreement entered into with the Seller;
</span><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>18.1.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>any
negligence or fault of whatever nature of the Seller or its affiliates, and any
director, officer, employee, contractor, or agent; and/or</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>18.1.4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>Any breach
in any warranty or representation in this Agreement.<span
style='mso-spacerun:yes'>  </span></span><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>18.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller shall insure or self-insure its
obligations under this Agreement and the agreements to be entered into with
Customers and upon request by SpacePointe shall immediately forward a copy of
the said insurance policy to SpacePointe.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.55pt;line-height:115%;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level1 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>19.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>INTELLECTUAL
PROPERTY<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>19.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Platform and its entire contents, features and
functionality (including but not limited to all information, software, text,
images, visualizations, video and audio, and the design, selection and
arrangement thereof), are owned by SpacePointe, its licensors or other
providers of such material and are protected by international copyright,
trademark, patent, trade secret and other intellectual property or proprietary
rights laws. No right, title or interest in or to the Platform or any content
on the Platform is transferred to Seller, and all rights not expressly granted
are reserved by SpacePointe.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>19.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller warrants, represents and covenants that
its manufacture, sale distribution and use of the Goods do not infringe
directly or indirectly any Intellectual Property. The Seller warrants,
represents and covenants that SpacePointe's feature of the Goods on the
Platform does not infringe any Intellectual Property, whether directly or
indirectly. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>19.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller undertakes and represents to SpacePointe
that it </span><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>has all rights and ownership or is a
licensed user of all Intellectual Property in relation to the Goods and the
supply of the Goods and is able to grant and hereby grants and irrevocable,
non-exclusive and royalty free license to use all such Intellectual Property
for the purposes of marketing, promoting and featuring the Goods on the
Platform. SpacePointe acknowledges that it will not acquire any rights in
respect of the Intellectual Property in relation to the Goods and that all
those rights and goodwill are, and will remain, vested in the Seller or the
owner of the Intellectual Property (as the case may be). </span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>19.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller represents and warrants to SpacePointe
that it is not aware of any claims made by any third party with regards to any
alleged or actual patent, copyright, trade secret, trademark, trade name, or
other intellectual property right infringement or other claim, demand or action
resulting from the manufacture, sale, distribution or use of the Goods. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>19.5.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Seller represents and warrants that it owns or
controls all rights in and to any content Seller posts to the Platform and that
Seller has obtained all necessary permits, license or authority to post and
sell such content through the Platform in compliance with this Agreement.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>19.6.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller agrees to release, defend, protect,
indemnify and hold SpacePointe, their affiliates, and their respective
directors, officers, employees, contractors, agents, suppliers, users,
successors, and assigns, harmless from and against any and all costs (including
attorney fees and court costs on an indemnity basis), expenses, fines,
penalties, losses, damages, and liabilities arising out of any alleged or
actual patent, copyright, trade secret, trademark, trade name, or other
intellectual property right infringement or other claim, demand or action
resulting from the advertising, promotion, manufacture, sale, distribution or
use of the Goods or posting of any content through the Platform.<o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%;mso-layout-grid-align:none;
text-autospace:none'><span style='font-size:10.0pt;line-height:115%;font-family:
"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraph style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>19.7.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>Seller acknowledges that the SpacePointe name,
SpacePointe logo and all related names, logos, product and service names,
designs and slogans are trademarks of SpacePointe, or its affiliates or
licensors (&quot;SpacePointe Marks&quot;). Seller agrees not to include the
SpacePointe Marks without the prior written permission of SpacePointe. All
other names, logos, product and service names, designs and slogans on this
Platform are the trademarks of their respective owners.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-35.45pt;line-height:
115%;mso-layout-grid-align:none;text-autospace:none'><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level1 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>20.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>RETURNS OF
GOODS<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>20.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Seller
should accept returns or refunds of Goods on the following cases:</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>20.1.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Faulty
Good</span><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>20.1.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Incorrect
product</span><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>20.1.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Wrong
item delivered</span><span style='font-size:10.0pt;line-height:115%;font-family:
"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>20.1.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Customer's
convenience (as long as it is within SpacePointe's return policy)</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>20.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>There
are three types of Goods return<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>20.2.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>For delivery failures<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>20.2.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>Unopened returns - For items </span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;color:black;
mso-themecolor:text1'>in whose categories SpacePointe offers a return policy and
for items with visible damages</span><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>20.2.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>Opened returns -</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;color:black;
mso-themecolor:text1'>for manufacturing defects, incorrect productandfor categories
where SpacePointe offers an opened returns policy</span><span style='font-size:
10.0pt;line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
color:black;mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>20.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Shipping
costs must be borne by the customer should return reason be in the case of
customer's convenience (as long as it is within SpacePointe's return policy),
the return shipping costs will be borne by the customer.<span
style='mso-spacerun:yes'>  </span><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>20.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Seller
agrees to release, defend, protect, indemnify and hold SpacePointe harmless
from and against any costs, expenses, fines, penalties, losses, damages, and
liabilities arising from any above mentioned situations</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:35.45pt;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:35.45pt;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level1 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>21.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>CONFIDENTIALITY<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>21.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>All customer information and data, designs,
drawings, specifications, communications, whether written, oral, electronic,
visual, graphic, photographic, observational, or otherwise, and documents
supplied, revealed or disclosed in any form or manner to the Seller by SpacePointe,
or produced or created by the Seller for SpacePointe hereunder ("Information")
are proprietary and confidential to SpacePointe and shall be used solely by the
Seller for purposes of this Agreement. All such Information shall be treated
and protected by the Seller as strictly confidential, and shall not be
disclosed to any third party without the prior written consent of SpacePointe,
and shall be disclosed within the Seller's organization only on a need-to-know
basis. The Seller shall, in particular, refrain from using any customer
information and data obtained from SpacePointe for its own marketing,
advertising and/or promotion purposes.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>21.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>SpacePointe may require the Seller's employees and
other personnel involved in the performance of this Agreement to execute an
individual confidentiality agreement prior to any disclosure. Any
non-disclosure agreement heretofore executed by the Seller in connection with SpacePointe's
business, this Agreement, or any other contract pertaining to the Goods, is
hereby expressly incorporated within this Agreement. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>21.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller shall immediately return to SpacePointe
any Information provided, either upon demand, or upon termination of this
Agreement, including all copies made by The Seller.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><span
style='mso-list:Ignore'>21.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller shall not publicize, disclose, or
discuss the existence, content, or scope, whether generalities or details, of this
Agreement or make any reference to SpacePointe, the business of either, or the
project for which this Agreement is made, to any third party by any means, and
through any medium (including but not limited to advertising, web site
references, photographs, articles, press releases or interviews, speeches or
programs) without obtaining the prior written consent of SpacePointe.<o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%;mso-layout-grid-align:none;
text-autospace:none'><b><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.25in;mso-add-space:auto;
text-indent:-.25in;line-height:115%;mso-list:l30 level1 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><b><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>22.0.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b><span style='font-size:10.0pt;line-height:
115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'>COMPLIANCE<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>22.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>In its performance under this Agreement and the
agreements entered into with Customers, the Seller shall strictly comply with
all applicable laws, treaties, ordinances, codes and regulations, and
specifically with any import and export, and health, safety and environmental,
laws, ordinances, codes and regulations of any jurisdiction (whether international,
country, region, state, province, city, or local) where this Agreement may be
performed. Upon SpacePointe's written request, the Seller shall provide any
written certification of compliance required by any federal, state, or local
law, ordinance, code, or regulation. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-bidi-font-weight:bold'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;mso-add-space:auto;
text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1;mso-bidi-font-weight:bold'><span
style='mso-list:Ignore'>22.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller agrees to release, defend, indemnify and
hold harmless SpacePointe and its affiliates from and against any loss, cost
(including attorney fees and court costs), civil or other fines and penalties,
damage or liability, arising from or alleged to arise from any violation,
alleged violation, or failure to comply with, the terms of this Paragraph by
the Seller or any person for whom the Seller may be responsible.
Notwithstanding any other provision in this Agreement to the contrary, nothing
contained herein shall oblige SpacePointe or the Seller to engage in any action
or omission to act which would be prohibited by or penalized under the laws or
regulations of Nigeria or any other country.</span><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1;mso-bidi-font-weight:bold'><o:p></o:p></span></p>

<p class=MsoNormal style='line-height:115%;mso-layout-grid-align:none;
text-autospace:none'><b><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.25in;mso-add-space:auto;
text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>23.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>ASSIGNMENT <o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>23.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Seller may not assign this Agreement, or any
part hereof, or any money due hereunder, without the prior written consent of SpacePointe.
If consent is granted, any such assignment by the Seller shall not increase or
alter SpacePointe's obligations nor diminish the rights of SpacePointe, nor relieve
the Seller of any of its obligations under this Agreement. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>23.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>SpacePointe reserves the right to assign this
Agreement, in whole or in part, to any party, including SpacePointe's
affiliates. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>23.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1;
mso-fareast-language:EN-GB'>The Sellers shall give SpacePointe prompt written
notice of any change in its ownership or organization, and changes in the
manufacture or production of the Goods provided hereunder.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-pagination:widow-orphan lines-together;page-break-after:
avoid;mso-layout-grid-align:none;text-autospace:none'><b style='mso-bidi-font-weight:
normal'><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.25in;mso-add-space:
auto;text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>24.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>NOTICES<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpLast style='margin-left:35.45pt;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>Any notice
required or permitted to be given by either party to the other under these
Conditions shall be in writing addressed, to the relevant party's registered
office or principal place of business. SpacePointe may also provide notice to
Seller through the Platform, which shall satisfy any notice or writing
requirement under this Agreement.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.5in;line-height:115%;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;color:black;
mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.25in;mso-add-space:auto;
text-indent:-.25in;line-height:115%;mso-pagination:widow-orphan lines-together;
page-break-after:avoid;mso-list:l30 level1 lfo35;mso-layout-grid-align:none;
text-autospace:none'><![if !supportLists]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;mso-fareast-language:
EN-GB'><span style='mso-list:Ignore'>25.0.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span></b><![endif]><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1;mso-fareast-language:EN-GB'>GENERAL<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>25.1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>No
waiver by SpacePointe of any breach of this Agreement by the Seller shall be
considered as a waiver of any subsequent breach of the same or any other
provision.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>25.2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>If any
provision of this Agreement is held by any competent authority to be invalid or
unenforceable inwhole or in part the validity of the other provisions of these
Conditions and the remainder of the provision in question shall not be affected
thereby.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>25.3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>No
person who is not a party to this Agreement (including any employee officer
agent representative or sub-contractor of either party) shall have any right to
enforce any terms of this Agreement which expressly or by implication confers a
benefit on that person without the express prior agreement in writing of the
parties</span><span style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
"Cordia New";color:black;mso-themecolor:text1;mso-bidi-language:TH'>.</span><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>25.4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>This
Agreement shall be governed by the laws of Nigeria and the Seller agrees to
submit to the jurisdiction of the Courts in Nigeria, as provided for in Clause 24.6.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level2 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>25.5.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>Except
as provided for in Clause 24.6 below, any dispute, controversy or claim arising
out of or relating to this Agreement, or the breach, termination or invalidity
thereof shall be settled by arbitration in accordance with the Arbitration and
Conciliation Act (Cap A18) Laws of the Federation of Nigeria 2004).The arbitral
tribunal shall consist of a sole arbitrator, to be appointed by the by the
parties herein, or in the absence of such agreement, to an Arbitrator appointed
by the High Court of Lagos State. The place of arbitration shall be Lagos. Any
award by the arbitration tribunal shall be final and binding upon the parties.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>


<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>25.6.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointe
shall be entitled to commence court legal proceedings for the purposes of
protecting its confidential information or any exclusivity rights, as contained
in this Agreement, by means of injunctive or other equitable relief. <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>25.7.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>This
Agreement, SpacePointe'swebsite Terms of Use and Privacy Policy constitute the
sole and entire agreement between Seller and SpacePointe, with respect to the Platform
and supersede all prior and contemporaneous understandings, agreements,
representations and warranties, both written and oral, with respect to the Platform.
Seller may not assign, transfer or sublicense this Agreement to anyone else and
any attempt to do so is in violation of this section and will be null and void.
In the event of any conflict between this Agreement and SpacePointe'swebsite Terms
of Use,this Agreement shall control.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;line-height:115%;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;mso-add-space:
auto;text-indent:-35.45pt;line-height:115%;mso-list:l30 level2 lfo35;
mso-layout-grid-align:none;text-autospace:none'><![if !supportLists]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1'><span
style='mso-list:Ignore'>25.8.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:10.0pt;line-height:115%;
font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'>SpacePointe
reserves their right to terminatethis Agreement at any time.<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle><span style='font-size:10.0pt;font-family:
"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Arial;color:black;mso-themecolor:text1'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>25.8.1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>Without notice: for instances directly
discriminating to the ethics of this agreement, the company reputation and its
customers <o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.5in;mso-add-space:
auto;text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>25.8.2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>With 15days notice: for instances
indirectly discriminating to the ethics of this agreement, the company
reputation and its customers<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.5in;mso-add-space:auto;
text-indent:-.5in;line-height:115%;mso-list:l30 level3 lfo35;mso-layout-grid-align:
none;text-autospace:none'><![if !supportLists]><span style='font-size:10.0pt;
line-height:115%;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;mso-hansi-theme-font:
minor-latin;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
color:black;mso-themecolor:text1'><span style='mso-list:Ignore'>25.8.3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
style='font-size:10.0pt;line-height:115%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
Arial;color:black;mso-themecolor:text1'>Three strike policy: this applies to
any acts committed in the course of business that directly causes for any
action of damage control to be initiated by SpacePointe on behalf or at the
inaction of the Seller to ensure that customer fulfillment is sustained.<o:p></o:p></span></p>


</div>
</div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>-->
            </div>
        </div>
    </div>
</div>        
<!--end of main conatnt-->	
<script type="text/javascript">
function check_user(userName)
{
	if(userName!='')
	{
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'retailer/home/check_username_ajax'; ?>',
			data:'userName='+userName+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			success:function(result){
				if(result==1)
				{
					$('#errMsgUn').html('');
					$('#userName').addClass('user-name-avl');	
					$('#userName').removeClass('user-not-avl');	
					
					$('#userNameLb').addClass('user-iconlabel-avl');	
					$('#userNameLb').removeClass('user-iconlabel-not-avl');	
					
				}
				else if(result==2)
				{
					$('#errMsgUn').html('This user already exists');
					$('#userName').addClass('user-not-avl');
					$('#userName').removeClass('user-name-avl');	
				
					$('#userNameLb').addClass('user-iconlabel-not-avl');	
					$('#userNameLb').removeClass('user-iconlabel-avl');		
				}
			}			
		});
	}
	else
	{
		$('#errMsgUn').html('');
		
		$('#userName').removeClass('user-name-avl');	
		$('#userName').removeClass('user-not-avl');
		$('#userNameLb').removeClass('user-iconlabel-avl');	
		$('#userNameLb').removeClass('user-iconlabel-not-avl');
	}
}
</script>
<script src="<?php echo base_url(); ?>js/chosen.jquery.js"></script>

<script src="<?php echo base_url(); ?>js/retailer/intlTelInput.js"></script>
<script>
$(document).ready(function(){
	$("#mobile-number").intlTelInput();
}); 
     
</script>
<script type="text/javascript">
function state_list(countryId)
{	//alert('<?php //echo base_url().$this->session->userdata('userType').'/location_management/stateCountryList'; ?>');
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'retailer/location_management/stateCountryList'; ?>',
		data:'countryId='+countryId+'&stateId=<?php echo $result['stateId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result);
			area_list($('#stateId').val());			
			//console.log(result);
		}
	});
}

function area_list(stateId)
{	//alert(stateId);
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'retailer/location_management/areaStateList'; ?>',
		data:'stateId='+stateId+'&areaId=<?php echo $result['areaId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#areaList').html(result);
			city_list($('#areaId').val());		
		}
	});
}

function city_list(areaId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'retailer/location_management/cityAreaList'; ?>',
		data:'areaId='+areaId+'&cityId=<?php echo $result['cityId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);	
		}
	});
}

<?php
if($result['countryId'])
{
?>
state_list('<?php echo $result['countryId']; ?>');
<?php
}
if($result['stateId'])
{
?>
area_list('<?php echo $result['stateId']; ?>');
<?php
}
if($result['areaId'])
{
?>
city_list('<?php echo $result['areaId']; ?>');
<?php
}
?>

$(document).ajaxComplete(function(){
	$('.selectpicker').selectpicker();
	$('#stateId').addClass('.form-control1');
	$('#areaId').addClass('.form-control1');
	$('#cityId').addClass('.form-control1');
});
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-select.css">