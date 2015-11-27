<style>
.intl-tel-input {
	margin: 5px 0 0 0 !important;
}
.intl-tel-input .selected-flag {
	padding: 12px 17px 12px 6px !important;
}
.intl-tel-input .country-list {
	top: 42px !important;
}
.dropdown-custom-signup-form .dropdown-menu {
	box-shadow: 1px 1px 6px rgba(0, 0, 0, 0.2);
	max-height: 250px !important;
}
.dropdown-custom-signup-form .show-menu-arrow{height:48px;
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/intlTelInput.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/frontend/intlTelInput.css">
<section class="main-container col1-layout">
  <div class="main container">
    <div class="col-main"> 
      <!--breadcrumb-->
      <div class="breadcrumbDiv">
        <ul class="breadcrumb">
          <li> <a href="<?php echo base_url(); ?>">Home</a></li>
          <li class="active">Register</li>
        </ul>
      </div>
      <!--breadcrumb-->
      
      <div class="account-login">
        <fieldset class="col2-set">
          <legend>Login or Create an Account</legend>
          <div class="new-users">
            <center>
              <h2>+ New Customers</h2>
            </center>
            <img src="<?php echo base_url() ?>images/frontend/user_icon.png" style="width:100%;" /><br>
            <br>
          <?php 
echo form_open();
?>                                                                                           
              <div class="content">
                <div class="col-sm-12 pd">
                  <div class="col-sm-6 sign-left-div" style="padding-left:0px;">
                    <ul class="form-list">
                      <li>
					 
                        <input type="text" title="First Name" class="input-text" name="first_name" placeholder="First Name" value="<?php echo set_value('first_name'); ?>">
						<span class="error signup_error">*</span>
					 
                        <?php echo form_error('first_name'); ?> 
						
						</li>
                    </ul>
                  </div>
                  <div class="col-sm-6 sign-right-div" style="padding-right:0px;">
                    <ul class="form-list">
                      <li>
                        <input type="text" title="Last Name" id="last_name" class="input-text" name="last_name" placeholder="Last Name" value="<?php echo set_value('last_name'); ?>">	
						<span class="error signup_error">*</span>
                        <?php echo form_error('last_name'); ?> </li>
                    </ul>
                  </div>
                </div>
                <div class="col-sm-12 pd">
                  <div class="col-sm-6 sign-left-div" style="padding-left:0px;">
                    <ul class="form-list">
                      <li>
                        <input type="text" title="Email Id" id="email" class="input-text" name="email" placeholder="Email Address" value="<?php echo set_value('email'); ?>">
                        <span class="error signup_error">*</span>
						<?php echo form_error('email'); ?> </li>
                    </ul>
                  </div>
                  <div class="col-sm-6 sign-right-div" style="padding-right:0px;">
                    <ul class="form-list">
                      <li>
                        <?php /*?> <input type="tel" id="mobile-number" name="phone"  value="<?php echo set_value('phone');?>" class="input-text" style="margin-top:0; height:42px; padding-left:40px;"><?php */?>
                        <div class="input-group" style="padding-top:5px;"> <span class="input-group-addon" style="background-color:#F7F7F7 !important; border-radius:0; border-left:1px solid #f0f0f0; border-top:1px solid #f0f0f0; border-bottom:1px solid #f0f0f0; border-right:0; color:#aaa;">+234</span>
                          <input type="text" title="Mobile No." id="mobileno" class="input-text" name="phone" placeholder="Mobile No." value="<?php echo set_value('phone'); ?>" style="margin-top:0;">
						  <span class="error signup_error">*</span>
                        </div>
                        <?php echo form_error('phone'); ?> </li>
                    </ul>
                  </div>
                </div>
                <div class="col-sm-12 pd">
                  <div class="col-sm-6 sign-left-div" style="padding-left:0px;">
                    <ul class="form-list">
                      <li>
                        <input type="password"  title="Password" id="password" class="input-text" name="password" type="password" placeholder="Password" value="<?php echo set_value('password'); ?>">
						<span class="error signup_error">*</span>
                        <?php echo form_error('password'); ?> </li>
                    </ul>
                  </div>
                  <div class="col-sm-6 sign-right-div" style="padding-right:0px;">
                    <ul class="form-list">
                      <li>
                        <input type="password"  title="Confirm Password" id="cpassword" class="input-text" name="cpassword" type="password" placeholder="Confirm Password" value="<?php echo set_value('cpassword'); ?>">
						<span class="error signup_error">*</span>
                        <?php echo form_error('cpassword'); ?> </li>
                    </ul>
                  </div>
                </div>
                <br />
                <br />
                <img src="<?php echo base_url() ?>images/frontend/location_icon.png" style="width:100%;" /><br>
                <br>
                <div class="col-sm-12 pd">
                  <div class="col-sm-6 sign-left-div" style="padding-left:0px;">
                    <ul class="form-list">
                      <li>
                        <div class="dropdown-custom-signup-form">
                          <div id="stateList">
                            <select name="stateId" id="stateId" class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true">
                              <option value="">Select State</option>
                            </select>
							
                          </div>
						 
                        </div>
						 <span class="error signup_error_sel">*</span>
                        <?php echo form_error('stateId'); ?> </li>
                    </ul>
                  </div>
                  <div class="col-sm-6 sign-right-div" style="padding-right:0px;">
                    <ul class="form-list">
                      <li>
                        <div id="areaList" class="dropdown-custom-signup-form">
                          <select name="areaId" class="form-controll selectpicker input-text" data-live-search="true">
                            <option value="">Select Area</option>
                          </select>
                        </div>
						<span class="error signup_error_sel">*</span>
                        <?php echo form_error('areaId'); ?> </li>
                    </ul>
                  </div>
                </div>
                <div class="col-sm-12 pd">
                  <div class="col-sm-6 sign-left-div" style="padding-left:0px;">
                    <ul class="form-list">
                      <li>
                        <div id="cityList" class="dropdown-custom-signup-form">
                          <select name="cityId" class="form-controll selectpicker input-text" data-live-search="true">
                            <option value="">Select City</option>
                          </select>
                        </div>
						<span class="error signup_error_sel">*</span>
                        <?php echo form_error('cityId'); ?> </li>
                    </ul>
                    <ul class="form-list">
                      <li>
                        <input type="text" title="Street" class="input-text" name="street" placeholder="Street" value="<?php echo set_value('street'); ?>" style="margin-top:0;">
                        <span class="error signup_error_sel">*</span>
						<?php echo form_error('street'); ?> </li>
                    </ul>
                  </div>
                  <div class="col-sm-6 sign-right-div" style="padding-right:0px;">
                    <ul class="form-list">
                      <li>
                        <input type="text" title="zipcode" id="zipcode" class="input-text" name="zipcode" placeholder="Zip Code / Postal Code" value="<?php echo set_value('zipcode'); ?>" style="margin-top:0;">
                        <?php echo form_error('zipcode'); ?> </li>
                    </ul>
                  </div>
                </div>
                <div class="clearfix"></div>
                <!--<p class="required">* Required Fields</p>--> 
                <br>
                <div class="col-sm-12 sign-left-div" style="padding-left:0px;">
                  <Center>
                    <button id="send2" name="send" type="submit" class="button register" style="width:100%;background: #78ce7b; color:#fff;padding: 12px 12px;"><span>Sign Up</span></button>
                  </center>
                </div>
                <br />
              </div>
            </form>
          </div>
          <br />
          <b class="help-block"> <i style="color:#ed4e6a !important;" class="fa fa-star"></i> Thank You For Giving Your Information! <br>
          Please Take A Look At Our <a href="#myModal" style="color:#78ce7b; text-decoration:none;" data-toggle="modal"> TERMS &amp; CONDITTION </a> And Sign Up </b>
        </fieldset>
      </div>
    </div>
  </div>
</section>
				
<script>
$( document ).ajaxComplete(function() {
 $('.selectpicker').selectpicker();
});

function state_list(countryId)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/stateCountryList'; ?>',
		data:'countryId='+countryId+'&stateId=<?php echo htmlentities($stateId); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
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
		url:'<?php echo base_url().'frontend/location_management/areaStateList'; ?>',
		data:'stateId='+stateId+'&areaId=<?php echo htmlentities($areaId); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
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
		url:'<?php echo base_url().'frontend/location_management/cityAreaList'; ?>',
		data:'areaId='+areaId+'&cityId=<?php echo htmlentities($cityId); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);	
		}
	});
}

<?php
if($countryId)
{
?>
state_list('<?php echo htmlentities($countryId); ?>');
<?php
}
if($stateId)
{
?>
area_list('<?php echo htmlentities($stateId); ?>');
<?php
}
if($areaId)
{
?>
city_list('<?php echo htmlentities($areaId); ?>');
<?php
}
?>
</script>
<style>
.signup_error{
  position: absolute;
  float: right;
  top: 5px;
  right: 5px;
  font-size: 16px;
  }
  .signup_error_sel{
  position: absolute;
  float: right;
  top: 0px;
  right: 5px;
  font-size: 16px;
  }
  .error {
  color: red;
  font-size: 12px;
  padding-top: 2px;
}
.static-contain p{ font-size:11px;}
.static-contain h4{ font-size:16px;}
</style>
<div class="bs-example"><div id="myModal" class="modal fade" style="z-index:100000;"> 
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">TERMS &amp; CONDITTION</h4>
                </div>
                <div class="modal-body" style="height:550px; overflow-y:scroll;">
				<div class="static-contain">
				
          <h4>Acceptance of the Terms of Use</h4>
          <p>SpacePointe, Inc. (referred to in these Terms of Service as "SpacePointe," "we," or "us") operates this website, including the webpages located on the domain pointemart.com (collectively, the "Website"). The following terms and conditions (these "Terms of Service"), govern your access to and use of this website or application, including any content, functionality, software, code, files, images, fonts, services, accompanying documentation contained in or generated by the Website.SpacePointe, Inc. (referred to in these Terms of Service as "SpacePointe," "we," or "us") operates this website, including the webpages located on the domain pointemart.com (collectively, the "Website"). The following terms and conditions (these "Terms of Service"), govern your access to and use of this website or application, including any content, functionality, software, code, files, images, fonts, services, accompanying documentation contained in or generated by the Website.</p>
        
         <p>Please read the Terms of Service carefully before you start to use the Website. By clicking to accept or using the website you accept and agree to the Terms of Service and our Privacy Policy, found at <a href="htt://www.pointemart.com">www.pointemart.com</a>("Privacy Policy"). If you do not want to agree to these Terms of Service, you will not have access or use of the Website. </p>
          
		  <h4>Authorized Users</h4>
          <p>This Website is offered and available to users who are 18 years of age or older. By using this Website, you represent and warrant that you meet all of the foregoing eligibility requirements. If you do not meet all of these requirements, you must not access or use the Website.</p>
		
		<h4>Changes to the Terms of Use</h4>
		<p>We may revise and update these Terms of Use from time to time in our sole discretion. All changes are effective immediately when we post them.  Your continued use of the Website following the posting of revised Terms of Use means that you accept and agree to the changes. You are expected to check this page so you are aware of any changes, as they are binding on you.For certain types of updates and revisions, we may decide, in our sole discretion, to notify you of such changes via email or other method of written notice. </p>
		
        <h4>Accessing the Website and Account Security</h4>
		<p>We reserve the right to withdraw or amend this Website, and any service or material we provide on the Website, in our sole discretion without notice. We will not be liable if for any reason all or any part of the Website is unavailable at any time or for any period. From time to time, we may restrict access to some parts of the Website, or the entire Website, to users, including registered users.</p>
        <p>You are responsible for:</p>
        <ul>
        	<li>Making all arrangements necessary for you to have access to the Website.</li>
            <li>Ensuring that all persons who access the Website through your internet connection are aware of these Terms of Use and comply with them.</li>
        </ul>
        <p>To access the Website or some of the resources it offers, you may be asked to provide certain registration details or other information. It is a condition of your use of theWebsite that all the information you provide on the Website is correct, current and complete.You agree that all information you provide to register with this Website or otherwise, including but not limited to through the use of any interactive features on the Website, is governed by our Privacy Policy, and you consent to all actions we take with respect to your information consistent with our Privacy Policy.</p>
        
        <p>To access the Website or some of the resources it offers, you may be asked to provide certain registration details or other information. It is a condition of your use of theWebsite that all the information you provide on the Website is correct, current and complete.You agree that all information you provide to register with this Website or otherwise, including but not limited to through the use of any interactive features on the Website, is governed by our Privacy Policy, and you consent to all actions we take with respect to your information consistent with our Privacy Policy.</p>
        <p>From time to time, we may restrict access to some parts of the Website, or the entire Website, to users, including registered users.We have the right to disable any account, whether chosen by you or provided by us, at any time if, in our opinion, you have violated any provision of these Terms of Use.</p>
        
        <h4>User Contributions</h4>
        <p>You represent and warrant that you own or control all rights in and to any contentyou post to the Website and that all content you post to the Website complies with these Terms of Use. </p>
        <p>You understand and acknowledge that you are responsible for any content you submit or contribute to the Website, and you, not SpacePointe, have full responsibility for such content, including its legality, reliability, accuracy and appropriateness. Your content and contributions must in their entirety comply with all applicable federal, state, local and international laws and regulationsand must not infringe any patent, trademark, trade secret, copyright or other intellectual property or other rights of any other person; be likely to deceive any person; or impersonate any person, or misrepresent your identity or affiliation with any person or organization.</p>
        <p>We are not responsible, or liable to any third party, for the content or accuracy of any content posted by any other user of the Website.</p>
        <p>If you believe that content you own has been copied and made accessible in a manner that violates your intellectual property rights, please notify us immediately.  You may submit a notification pursuant to the Digital Millennium Copyright Act ("DMCA") by providing our designated agent at 905 Blackwell Road, Suite 513, Marietta, Georgia, 30066 and <a href="mailto:info@spacepointe.com">info@spacepointe.com</a> with the information required in 17 U.S.C. § 512(c)(3).  In appropriate circumstances, SpacePointewill terminate the accounts of repeat infringers.</p>
        
        <h4>Intellectual Property Rights</h4>
        <p>The Website and its entire contents, features and functionality (including but not limited to all information, software, text, images, visualizations, video and audio, and the design, selection and arrangement thereof), are owned by SpacePointe, its licensors or other providers of such material and are protected by international copyright, trademark, patent, trade secret and other intellectual property or proprietary rights laws.</p>
        <p>You must not reproduce, distribute, modify, create derivative works of, publicly display, publicly perform, republish, or transmit any of the material on our Website. If you provide any other person with access to any part of the Website in breach of the Terms of Use, your right to use the Website will cease immediately and you must, at our option, return or destroy any copies of the materials you have made. No right, title or interest in or to the Website or any content on the Website is transferred to you, and all rights not expressly granted are reserved by SpacePointe. Any use of the Website not expressly permitted by these Terms of Use is a breach of these Terms of Use and may violate copyright, trademark and other laws.</p>
        
         <h4>Trademarks</h4>
        <p>The SpacePointe name, SpacePointe logo and all related names, logos, product and service names, designs and slogans are trademarks of SpacePointe, or its affiliates or licensors.You must not use such marks without the prior written permission of SpacePointe. All other names, logos, product and service names, designs and slogans on this Website are the trademarks of their respective owners.</p>
       
        <h4>Prohibited Uses</h4>
        <p>You may use the Website only for lawful purposes and in accordance with these Terms of Use. Additionally, you agree not to:</p>
        
        <ul>
        	<li>Use the Website in any manner that could disable, overburden, damage, or impair the site or interfere with any other party's use of the Website, including their ability to engage in real time activities through the Website.</li>
            <li>Use any robot, spider or other automatic device, process or means to access the Website for any purpose, including monitoring or copying any of the material on the Website.</li>
            <li>Use any manual process to monitor or copy any of the material on the Website or for any other unauthorized purpose without our prior written consent.</li>
            <li>Introduce any viruses, worms, Trojan horses, worms, logic bombs or other material which is malicious or technologically harmful.</li>
            <li>Attempt to gain unauthorized access to, interfere with, damage or disrupt any parts of the Website, the server on which the Website is stored, or any server, computer or database connected to the Website.</li>
        </ul>
	
		<h4>Reliance on Information Posted</h4>
        <p>This Websiteincludes content provided by third parties, including materials provided by other users. All statements and/or opinions expressed in these materials, and all articles and responses to questions and other content, other than the content provided by SpacePointe, are solely the responsibility of the person or entity providing those materials. We are not responsible, or liable to you or any third party, for the content or accuracy of any materials provided by any third parties.</p>
        
        <h4>Disclaimer of Warranties</h4>
        <p>You understand that we cannot and do not guarantee or warrant that files available for downloading from the internet or the Website will be free of viruses or other destructive code. You are responsible for implementing sufficient procedures and checkpoints to satisfy your particular requirements for anti-virus protection and accuracy of data input and output, and for maintaining a means external to our site for any reconstruction of any lost data. WE WILL NOT BE LIABLE FOR ANY LOSS OR DAMAGE CAUSED BY TECHNOLOGICALLY HARMFUL MATERIAL THAT MAY INFECT YOUR COMPUTER EQUIPMENT, COMPUTER PROGRAMS, DATA OR OTHER PROPRIETARY MATERIAL DUE TO YOUR USE OF THE WEBSITE OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE OR TO YOUR DOWNLOADING OF ANY MATERIAL POSTED ON IT OR ON ANY WEBSITE LINKED TO IT.</p>
        <p>YOUR USE OF THE WEBSITE, ITS CONTENT AND ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE IS AT YOUR OWN RISK. THE WEBSITE, ITS CONTENT AND ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE ARE PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED. NEITHER SPACEPOINTENOR ANY PERSON ASSOCIATED WITH SPACEPOINTE MAKES ANY WARRANTY OR REPRESENTATION WITH RESPECT TO THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY OR AVAILABILITY OF THE WEBSITE. WITHOUT LIMITING THE FOREGOING, NEITHER SPACEPOINTENOR ANYONE ASSOCIATED WITH SPACEPOINTE REPRESENTS OR WARRANTS THAT THE WEBSITE, ITS CONTENT OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE WILL BE ACCURATE, RELIABLE, ERROR-FREE OR UNINTERRUPTED, THAT DEFECTS WILL BE CORRECTED, THAT OUR SITE OR THE SERVER THAT MAKES IT AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS OR THAT THE WEBSITE OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE WILL OTHERWISE MEET YOUR NEEDS OR EXPECTATIONS. </p>
		<p>SPACEPOINTEHEREBY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED,STATUTORY OR OTHERWISE, INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT AND FITNESS FOR PARTICULAR PURPOSE.</p>
        <p>THE FOREGOING DOES NOT AFFECT ANY WARRANTIES WHICH CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>
        
        <h4>Limitation on Liability</h4>
        <p>IN NO EVENT WILL SPACEPOINTE, ITS AFFILIATES OR THEIR LICENSORS, SERVICE PROVIDERS, EMPLOYEES, AGENTS, OFFICERS OR DIRECTORS BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL OR PUNITIVE DAMAGES, INCLUDING BUT NOT LIMITED TO, PERSONAL INJURY, PAIN AND SUFFERING, EMOTIONAL DISTRESS, LOSS OF REVENUE, LOSS OF PROFITS, LOSS OF BUSINESS OR ANTICIPATED SAVINGS, LOSS OF USE, LOSS OF GOODWILL, OR LOSS OF DATA, WHETHER IN BREACH OF CONTRACT, NEGLIGENCE, STRICT LIABILITY, MISREPRESENTATIONS  OR UNDER ANY OTHER LEGAL THEORY, EVEN IF FORESEEABLE, ARISING OUT OF OR IN CONNECTION WITH YOUR USE, OR INABILITY TO USE, THE WEBSITE, ANY CONTENT ON THE WEBSITE OR SUCH OTHER WEBSITES OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE OR SUCH OTHER WEBSITES.</p>
        <p>THE FOREGOING DOES NOT AFFECT ANY LIABILITY WHICH CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>
        
         <h4>Indemnification</h4>
         <p>You agree to defend, indemnify and hold harmless SpacePointe, its affiliates, licensors and service providers, and its and their respective officers, directors, employees, contractors, agents, licensors, suppliers, successors and assigns from and against any claims, liabilities, damages, judgments, awards, losses, costs, expenses or fees (including reasonable attorneys' fees) arising out of or relating to your violation of these Terms of Use, violations of the Acceptable Use Policy or your use of the Website, including without limitation your Submitted Content, any use of the Website's services, data and information other than as expressly authorized in these Terms of Useor your use of any information obtained from the Website.</p>
         
          <h4>Governing Law and Jurisdiction</h4>
         <p>All matters relating to the Website and these Terms of Service and any dispute or claim arising therefrom or related thereto (in each case, including non-contractual disputes or claims), shall be governed by and construed in accordance with the internal laws of the State of Georgia without giving effect to any choice or conflict of law provision or rule (whether of such state or any other jurisdiction). Venue for all actions related to these Terms of Service shall be located in courts located in Marietta, Georgia.  The parties consent to the personal jurisdiction and subject matter jurisdiction of such courts.  Further, the parties waive any defenses of lack of personal or subject matter jurisdiction and improper venue related to the validity, enforceability, and damages and injunctions that may result from breach of these Terms of Service.</p>
         
         <h4>Waiver of Jury Trial</h4>
         <p>EACH OF THE PARTIES HEREBY KNOWINGLY, VOLUNTARILY AND INTENTIONALLY WAIVES ANY RIGHT IT MAY HAVE TO A TRIAL BY JURY IN RESPECT OF ANY LITIGATION ARISING OUT OF, RELATING TO OR IN CONNECTION WITH THESE TERMS. FURTHER, EACH PARTY CERTIFIES THAT NO REPRESENTATIVE OR AGENT OF EITHER PARTY HAS REPRESENTED, EXPRESSLY OR OTHERWISE, THAT SUCH PARTY WOULD NOT, IN THE EVENT OF SUCH LITIGATION, SEEK TO ENFORCE THIS WAIVER OF RIGHT TO JURY TRIAL PROVISION. Each of the parties acknowledges that this section is a material inducement for the other party to enter into these Terms of Use.</p>
         
         <h4>Limitation on Time to File Claims</h4>
         <p>ANY CAUSE OF ACTION OR CLAIM YOU MAY HAVE ARISING OUT OF OR RELATING TO THESE TERMS OF USE OR THE WEBSITE MUST BE COMMENCED WITHIN ONE YEAR AFTER THE CAUSE OF ACTION ACCRUES, OTHERWISE, SUCH CAUSE OF ACTION OR CLAIM IS PERMANENTLY BARRED.</p>
         
         <h4>Waiver and Severability</h4>
         <p>No waiver by SpacePointe of any term or condition set forth in these Terms of Use shall be deemed a further or continuing waiver of such term or condition or a waiver of any other term or condition, and any failure of SpacePointe to assert a right or provision under these Terms of Use shall not constitute a waiver of such right or provision.</p>
         <p>If any provision of these Terms of Use is held by a court or other tribunal of competent jurisdiction to be invalid, illegal or unenforceable for any reason, such provision shall be eliminated or limited to the minimum extent such that the remaining provisions of the Terms of Use will continue in full force and effect.</p>
         
         <h4>Entire Agreement</h4>
         <p>TheseTerms of Use and our Privacy Policy constitute the sole and entire agreement between you and SpacePointe, with respect to the Website and supersede all prior and contemporaneous understandings, agreements, representations and warranties, both written and oral, with respect to the Website.You may not assign, transfer or sublicense theseTerms of Useto anyone else and any attempt to do so is in violation of this section and will be null and void.</p>
        </div>
				</div></div>
			</div>
</div>
</div>
</div>