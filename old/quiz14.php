<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>this is title</title>

  <link rel="stylesheet" type="text/css" href="css/quiz.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


  <!-- Fonts -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


</head>

<body>

  <script type="text/javascript">

  function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    while (0 !== currentIndex) {

      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;
      // And swap it with the current element.
      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }
    return array;
  }

  function getnumberlist(box){
    var arr;
    $.ajax({    //create an ajax request to load_page.php
      async: false,
      global: false,
      data: {categories: box},
      type: "POST",
      url: "getnumberlist.php",
      dataType: "json",   //expect html to be returned
      success: function(response){
        arr=response;
      }
    });   // ajax
    return arr;
  }

  function getcurrentSet(number){
    var arr;
    $.ajax({
      async: false,   // this is a must, if you want to return value to a extern variable like "arr" here
      url: 'next.php', //This is the current doc
      type: "POST",
      data: ({xu: number}),
      dataType: "json",
      contentType: "application/x-www-form-urlencoded;charset=UTF-8",
      success: function(response){
        arr=response;
      }
    }); // ajax
    return arr;
  }


  $(document).ready(function() {

    $("#showlater").hide();
    $("#start3").hide();
    $("#chooseCategory").hide();

    $("#start1").click(function(){
      $("#start1").hide();
      $("#chooseCategory").show();
    });

    var total;
    var i=-1;
    var currentSet;
    var numberlist;

    $("#start2").click(function(){
      var box=[true,true,true,true,true,true,true,true];
      if(!$('#history').prop('checked')) box[0]=false;
      if(!$('#astronomy').prop('checked')) box[1]=false;
      if(!$('#physics').prop('checked')) box[2]=false;
      if(!$('#computer').prop('checked')) box[3]=false;
      if(!$('#politics').prop('checked')) box[4]=false;
      if(!$('#life').prop('checked')) box[5]=false;
      if(!$('#biology').prop('checked')) box[6]=false;
      if(!$('#geography').prop('checked')) box[7]=false;

      numberlist=getnumberlist(box);
      total=numberlist.length;
      $("#chooseCategory").hide();
      $("#start3").show();
      $("#head").html("Total:"+total);
    }); // start2 click

    $("#start21").click(function(){
      var box=[true,true,true,true,true,true,true,true];
      numberlist=getnumberlist(box);
      total=numberlist.length;
      $("#chooseCategory").hide();
      $("#start3").show();
      $("#head").html("Total:"+total);
    }); // start21 click


    $("#start3").click(function(){
      shuffle(numberlist);
      $("#start3").hide();
      i=0;
      $("#answer").html("");
      $("#detail").html("");

      currentSet=getcurrentSet(numberlist[i]);
      $("#showlater").show();
      $("#question").html(currentSet[0]);
      $("#head").html(1+'/'+total);
    }); // start3 click



    $("#nextQuestion").click(function() {
      if(i==(total-1)) return;
      i++
      $("#answer").html("");
      $("#detail").html("");
      currentSet=getcurrentSet(numberlist[i]);
      $("#question").html(currentSet[0]);
      var j=i+1;
      $("#head").html(j+'/'+total);
    });  // click

    $("#preQuestion").click(function() {
      if(i==0) return;
      i--;
      $("#answer").html("");
      $("#detail").html("");
      currentSet=getcurrentSet(numberlist[i]);
      $("#question").html(currentSet[0]);
      var j=i+1;
      $("#head").html(j+'/'+total);
    });  // click

    $("#showAnswer").click(function() {
      $("#answer").html(currentSet[1]);
    });

    $("#giveup").click(function() {
      $("#showlater").hide();
      $("#start3").hide();
      $("#chooseCategory").hide();
      $("#start1").show();

    });

    $("#history").click(function() {
      $("#imghistory").toggleClass("turn");
    });

    $("#astronomy").click(function() {
      $("#imgastronomy").toggleClass("turn");
    });
    $("#physics").click(function() {
      $("#imgphysics").toggleClass("turn");
    });
    $("#computer").click(function() {
      $("#imgcomputer").toggleClass("turn");
    });
    $("#politics").click(function() {
      $("#imgpolitics").toggleClass("turn");
    });
    $("#life").click(function() {
      $("#imglife").toggleClass("turn");
    });
    $("#biology").click(function() {
      $("#imgbiology").toggleClass("turn");
    });
    $("#geography").click(function() {
      $("#imggeography").toggleClass("turn");
    });

  });  // ready


  </script>



  <div class="container">
    <div class="row">
      <span class="text-left col-xs-10"> Hi,Challenger! </span>
      <span class="text-right"> <b id="head">  </b> </span>
    </div>

    <form id="chooseCategory">
      <label for="history">
        <input type="checkbox" id="history" value="1">
        <img src="images/history.jpg" alt=""  id="imghistory" class="img" />
      </label>

      <label for="astronomy">
        <input type="checkbox" id="astronomy" value="1">
        <img src="images/astronomy.jpg" alt=""  id="imgastronomy" class="img"/>
      </label>


      <label for="physics">
        <input type="checkbox" id="physics" value="1">
        <img src="images/physics.jpg" alt=""  id="imgphysics" class="img" />
      </label>
      <label for="computer">
        <input type="checkbox" id="computer" value="1">
        <img src="images/computer.jpg" alt=""  id="imgcomputer" class="img"/>
      </label>
      <label for="politics">
        <input type="checkbox" id="politics" value="1">
        <img src="images/politics.jpg" alt=""  id="imgpolitics" class="img"/>
      </label>
      <label for="life">
        <input type="checkbox" id="life" value="1">
        <img src="images/life.jpg" alt=""  id="imglife" class="img"/>
      </label>
      <label for="biology">
        <input type="checkbox" id="biology" value="1">
        <img src="images/biology.jpg" alt=""  id="imgbiology" class="img"/>
      </label>
      <label for="geography">
        <input type="checkbox" id="geography" value="1">
        <img src="images/geography.jpg" alt=""  id="imggeography" class="img"/>
      </label>
      <div class="row text-center">
        <button  type="button" class="btn btn-success btn-lg" id="start2"> Select Them! </button>
        <button  type="button" class="btn btn-warning btn-lg" id="start21"> Select All! </button>
      </div>

    </form>

    <div class="text-center"> <button  type="button" class="btn btn-success btn-lg" id="start1" > Choose Categories! </button> </div>
    <div class="text-center"> <button  type="button" class="btn btn-success btn-lg" id="start3" > Questions are selected, lets start it! </button> </div>

    <div id="showlater">
      <p class="text-center alert alert-info" id="question"> </p>
      <div class="row" id="buttons">
        <button  class="btn btn-success col-xs-4" type="button" id="preQuestion" > Previous Question </button>
        <button  class="btn btn-danger col-xs-2" type="button" id="giveup" > GIVE UP </button>
        <button  class="btn btn-warning col-xs-2" type="button" id="showAnswer" > Show Answer </button>
        <button  class="btn btn-success col-xs-4" type="button" id="nextQuestion" > Next Question </button>
      </div>
      <div class="row well" id="bganswer">
        <p id="answer"> </p>
      </div>
      <div class="row" id="bgdetail">
        <p id="detail"> </p>
      </div>
    </div>


  </div>

</body>

</html>
