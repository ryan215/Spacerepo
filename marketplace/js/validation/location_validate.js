$(document).ready(function(){
	 $("form#formID").validate({
	 	 rules: {
		 	country_id: 'required',
			state_id: 'required',
			city_id: 'required',
			zone_id: 'required',
			area_id: 'required',
			country_name: 'required',
			state_name: 'required',
			city_name: 'required',
			zone_name: 'required',
			area_name: 'required',
		 },
		 messages:{
		 	country_id: 'Please Select Country Name',
			state_id: 'Please Select State Name',
			city_id: 'Please Select City Name',
			zone_id: 'Please Select Zone Name',
			area_id: 'Please Select Area Name',
			country_name: 'Please Enter Country Name',
			state_name: 'Please Enter State Name',
			city_name: 'Please Enter City Name',
			zone_name: 'Please Enter Zone Name',
			area_name: 'Please Enter Area Name'
		 },
		 errorElement : 'div',
		 errorClass : 'error'		 
	 });
});