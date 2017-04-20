$(document).ready(function(){
	base_url = $('body').data('baseurl');
		 $('.slider-background').backstretch([
			 base_url+"assest/img/fondos/Zeoarts_Artbook.jpg",
			 base_url+"assest/img/fondos/Zeoarts_index.jpg",
			 base_url+"assest/img/fondos/Zeoarts_Services.jpg",
			 base_url+"assest/img/fondos/Zeoarts_Shop.jpg"
		  ], {duration: 4000, fade: 1000});
});