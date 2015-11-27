$(document).ready(function(){
	 $("form#formID").validate({
	 	 rules: {
		 	business_name: 'required',
			business_ph_no: 'required',
			business_owner_name: 'required',
			phone_no: 'required',
			email:
			{
				required : true,
				email: true,
				//remote:base_url+'admin/retailer_management/check_email_exists'
			},
			country_id: 'required',
			state_id: 'required',
			city_id: 'required',
			zone_id: 'required',
			area_id: 'required',
			street: 'required',
		 },
		 messages:{
		 	business_name: 'Please Enter Business Name',
			business_ph_no: 'Please Enter Business Phone Number',
			business_owner_name: 'Please Enter Business Owner Name',
			phone_no: 'Please Enter Phone Number',
			email:
			{
				required : 'Please Enter Email Address',
				email: 'Please Enter Valid Email Address',
			},
			country_id: 'Please Select Country Name',
			state_id: 'Please Select State Name',
			city_id: 'Please Select City Name',
			zone_id: 'Please Select Zone Name',
			area_id: 'Please Select Area Name',
			street: 'Please Enter Street Name',
		 },
		 errorElement : 'div',
		 errorClass : 'error'		 
	 });
});