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
function getit(key){
  var result;
  $.ajax({    //create an ajax request to load_page.php
    async: false,
    global: false,
    data: {task: "get", key: key},
    type: "POST",
    url: "phpsessionwork.php",
    success: function(response){
    //  $("#test").html(response);
      result=response;
    }
  });   // ajax
  return result;

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
