function getdata(data){
    return data;
}


function setit(key,value){
    $.post("phpsessionwork.php",
	   {
	       task: "set",
	       key : key,
	       value : value
	   },
	   function(data){
	       //     $("#test").html(data);
	   });
}

function checkSignined(){  // 
	return new Promise((resolve, reject) => {
		$.ajax({    //create an ajax request to load_page.php
			// async: false,
			// global: false,
			xhrFields: {
				withCredentials: true
			},
			type: "POST",
			url: "/checkSignined",
			success: function(response){
				//  $("#test").html(response);
				resolve(response);
			},
			error: function (err) {
				reject(err);
			}
		});
	});
}
function navbar_init(route_to_home_if_unauthenticated=false, is_home_page=true){
	console.log("checksigned ============");
	$("#logout_button").hide();
	checkSignined().then(res=>{
		if(res.result=='succeed'){
			// $("#navbar_left1").show();
			$("#logout_button").show();
			$("#signin_button").hide();
			$("#signup_button").hide();
			$("#navbar_right1").show();
			$("#nav_username").html(res.username);
			console.log("succeeded authenticated user");
		}else{
			
			console.log(`user not authenticated........route_to_home_if_unauthenticated:${route_to_home_if_unauthenticated} `);
			$("#navbar_right1").show();
			if(route_to_home_if_unauthenticated===true){
				window.location.href = "/";
			}
		}
	}).catch(err=>{
		
	}).finally(()=>{
		$("#navbar_rightpanel").show();
	})
	document.getElementById("logout_button").addEventListener("click", function(){
		$.ajax({    //create an ajax request to load_page.php
			xhrFields: {
				withCredentials: true
			},
			type: "POST",
			url: "/logout",
			success: function(response){
				//  $("#test").html(response);
				console.log(`logout result from server: ${response.result}`);
				window.location.href = "/";
			},
			error: function (err) {
				window.location.href = "/";
			}
		});
	});
}
function removeit(key){
    $.post("phpsessionwork.php",
	   {
	       task: "remove",
	       key : key,
	   },
	   function(data){
	       //     $("#test").html(data);
	   });
}

function clearit(){
    $.post("phpsessionwork.php",
	   {
	       task: "clear",
	       key : key,
	   },
	   function(data){
	       //     $("#test").html(data);
	   });
}
