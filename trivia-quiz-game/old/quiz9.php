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

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

      // Pick a remaining element...
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;

      // And swap it with the current element.
      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }

    return array;
  }

  $(document).ready(function() {
    var numberlist;

    //var re=function () {
        $.ajax({    //create an ajax request to load_page.php
        async: false,
        global: false,
        type: "POST",
        url: "test5.php",
        dataType: "json",   //expect html to be returned
        success: function(response){
          numberlist=response;
          //                 $("#show").html(arr);
        }
      });   // ajax

    var total=numberlist.length;
    shuffle(numberlist);
    var i=-1;
    var currentSet;

    $("#nextQuestion").click(function() {
      if(i==total) return;
      i++
      $("#answer").html("");
      $("#detail").html("");
      $.ajax({
        url: 'next.php', //This is the current doc
        type: "POST",
        data: ({xu: numberlist[i]}),
        dataType: "json",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success: function(response){
          currentSet=response;
          $("#question").html(currentSet[0]);
        }
      }); // ajax
      var j=i+1;
      $("#head").html(j+'/'+total);
    });  // click

    $("#preQuestion").click(function() {
      if(i==0) return;
      i--;
      $("#answer").html("");
      $("#detail").html("");
      $.ajax({
        url: 'next.php', //This is the current doc
        type: "POST",
        data: ({xu: numberlist[i]}),
        dataType: "json",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        success: function(response){
          currentSet=response;
          $("#question").html(currentSet[0]);
        }
      }); // ajax
      var j=i+1;
      $("#head").html(j+'/'+total);
    });  // click

$("#start").click(function(){
  i=0;
  $("#answer").html("");
  $("#detail").html("");
  $.ajax({
    url: 'next.php', //This is the current doc
    type: "POST",
    data: ({xu: numberlist[i]}),
    dataType: "json",
    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
    success: function(response){
      currentSet=response;
      $("#question").html(currentSet[0]);
    }
  }); // ajax
  $("#head").html(1+'/'+total);
});


    $("#showAnswer").click(function() {
      $("#answer").html(currentSet[1]);
    });


  });  // ready


  </script>



  <div class="container">
    <div class="row">
      <div class="col-xs-11"> Hi,Challenger! </div>
      <b id="head">  </b>

    </div>

    <div class="row alert alert-info" id="bgquestion">
      <p class="text-center" id="question">
      <button  class="well" type="button" id="start" > Start! </button>
      </p>
    </div>

    <div class="row" id="buttons">
      <button  class="btn btn-success col-xs-4" type="button" id="preQuestion" > Previous Question </button>
      <button  class="btn btn-success col-xs-4" type="button" id="showAnswer" > Show Answer </button>
      <button  class="btn btn-success col-xs-4" type="button" id="nextQuestion" > Next Question </button>

    </div>

    <div class="row well" id="bganswer">
      <p id="answer"> show answer </p>
    </div>


    <div class="row alert alert-warning" id="bgdetail">
      <p id="detail"> show detail </p>
    </div>

  </div>

</body>

</html>
