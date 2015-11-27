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
                            <h2>+ new dropship center</h2>
                        </center>
                        <img src="<?php echo base_url() ?>images/frontend/user_icon.png" style="width:100%;" /><br>
                        <br>
<?php 
echo form_open();
?>                                                                                                                       <div class="content">

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
                                                <?php echo form_error('cityId'); ?> </li>
                                        </ul>

                                        <ul class="form-list">
                                            <li>
                                                <input type="text" title="Street" class="input-text" name="street" placeholder="Street" value="<?php echo set_value('street'); ?>" style="margin-top:0;">
                                                <?php echo form_error('street'); ?> </li>
                                        </ul>



                                    </div>
                                     </div>
                                <div class="clearfix"></div>
                                <!--<p class="required">* Required Fields</p>-->

                                    <ul class="form-list">
                                        <li>
                                            <input type="text" title="secondaryPhone" class="input-text" name="phone" placeholder="phone" value="<?php echo set_value('street'); ?>" style="margin-top:0;">
                                            <?php echo form_error('street'); ?> </li>
                                    </ul>


                                    <ul class="form-list">
                                        <li>
                                            <input type="text" title="secondaryPhone" class="input-text" name="secondaryPhone" placeholder="secondary phone" value="<?php echo set_value('street'); ?>" style="margin-top:0;">
                                           </li>
                                    </ul>

                                <ul class="form-list">
                                    <li>
                                        <input type="text" title="dropshipcenter" class="input-text" name="dropCenterName" placeholder="dropshipcenter" value="<?php echo set_value('street'); ?>" style="margin-top:0;">
                                        <?php echo form_error('street'); ?> </li>
                                </ul>
                                <ul class="form-list">
                                    <li>
                                        <input type="text" title="businessDays" class="input-text" name="businessDays" placeholder="businessDays" value="<?php echo set_value('street'); ?>" style="margin-top:0;">
                                        <?php echo form_error('street'); ?> </li>
                                </ul>
                                <ul class="form-list">
                                    <li>
                                        <input type="text" title="businessHours" class="input-text" name="businessHours" placeholder="businessHours" value="<?php echo set_value('street'); ?>" style="margin-top:0;">
                                        <?php echo form_error('street'); ?> </li>
                                </ul>
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
                                                                                                        Please Take A Look At Our <a href="#" style="color:#78ce7b; text-decoration:none;"> TERMS &amp; CONDITTION </a> And Sign Up </b>
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