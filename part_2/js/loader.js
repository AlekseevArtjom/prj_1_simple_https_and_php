function load_module(src)
{
	var script_to_load = document.createElement('script');
	
	script_to_load.src = src;
	script_to_load.type="module";
	script_to_load.async = false ;
	
	document.body.append(script_to_load);
}


window.addEventListener('load', function ()
{
	load_module("/js/authorization_module.js");
	load_module("/js/logout_module.js");
	load_module("/js/show_hide_password_module.js");
});