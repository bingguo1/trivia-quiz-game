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

  var showList=[];
  var cleanshowList=[];
  var itemList=[];
  function item(number1,question1,answer1,content1,showing1){
    this.number=number1;
    this.question=question1;
    this.answer=answer1;
    this.showcontent=content1;
    this.showing=showing1;
  }

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

  function askphp(queryString,columnSets,callback){
    $.ajax({    //create an ajax request to load_page.php
      async: false,
      global: false,
      data: {queryString: queryString,columnSets: columnSets},
      type: "POST",
      url: "askphp.php",
      dataType: "json",   //expect html to be returned
      success: function(response){
        callback(response);
      }
    });   // ajax
  }

  function clickitem(i){
    var qc="<button class='eachQuestion' type='button' onclick='clickitem( " +i+")'>" + itemList[i].question +"</button>";
    var ac="<div id='theAnswer'>" + itemList[i].answer +"</div>";

    if(itemList[i].showing) {
      itemList[i].showing=false;
      itemList[i].showcontent=qc;
      showList[i]=qc;
    }
    else {
      itemList[i].showing=true;
      itemList[i].showcontent=qc + ac;
      showList[i]=qc+ac;
    }

    $("#allQuestionsHere").html(showList);


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
    var categoryCondition=" ";
    var chooseAll=false;
    var listshowing=false;
    var showedBefore=false;

    $("#start2").click(function(){
      var str="SELECT number FROM tbquiz where  ";
      if($('#history').prop('checked')) categoryCondition+=" (category>9 AND category<20) OR ";
      if($('#astronomy').prop('checked')) categoryCondition+=" (category>19 AND category<30) OR ";
      if($('#physics').prop('checked')) categoryCondition+=" (category>29 AND category<40) OR ";
      if($('#computer').prop('checked')) categoryCondition+=" (category>39 AND category<50) OR ";
      if($('#politics').prop('checked')) categoryCondition+=" (category>49 AND category<60) OR ";
      if($('#life').prop('checked')) categoryCondition+=" (category>59 AND category<70) OR ";
      if($('#biology').prop('checked')) categoryCondition+=" (category>69 AND category<80) OR ";
      if($('#geography').prop('checked')) categoryCondition+=" (category>79 AND category<90) OR ";
      categoryCondition+=" (category<0)";
      str+=categoryCondition;
      var stringArr=[];
      stringArr.push("number");
      askphp(str,stringArr,function(result){numberlist=result;})
      total=numberlist.length;
      $("#chooseCategory").hide();
      $("#start3").show();
      $("#head").html("Total:"+total);
    }); // start2 click

    $("#start21").click(function(){
      chooseAll=true;
      var str="SELECT number FROM tbquiz";
      var stringArr=["number"];
      askphp(str,stringArr,function(result){numberlist=result;});
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
      var str = "SELECT question,answer,detail FROM tbquiz  WHERE number="+numberlist[i];
      var stringArr=["question","answer","detail"];
      askphp(str,stringArr,function(result){
        $("#showlater").show();
        $("#question").html(result[0]);
        $("#head").html(1+'/'+total);
      });
    }); // start3 click



    $("#nextQuestion").click(function() {
      if(i==(total-1)) return;
      i++
      $("#answer").html("");
      $("#detail").html("");
      var str = "SELECT question,answer,detail FROM tbquiz  WHERE number="+numberlist[i];
      var stringArr=["question","answer","detail"];
      askphp(str,stringArr,function(result){currentSet=result;});
      $("#question").html(currentSet[0]);
      var j=i+1;
      $("#head").html(j+'/'+total);
    });  // click

    $("#preQuestion").click(function() {
      if(i==0) return;
      i--;
      $("#answer").html("");
      $("#detail").html("");
      var str = "SELECT question,answer,detail FROM tbquiz  WHERE number="+numberlist[i];
      var stringArr=["question","answer","detail"];
      askphp(str,stringArr,function(result){currentSet=result;});
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
      $("#head").html("");
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

    $("#showAll").click(function(){
      if(listshowing) {
        listshowing=false;
        $("#allQuestionsHere").html("");
        $(this).html("showAll");
        return;
      }
     else if(showedBefore){
       showList=cleanshowList.slice();   // in javascript, arr1=arr2 will only create a reference to  arr2, how arr1 change will affect arr2
       $(this).html("hideAll");
       listshowing=true;
       $("#allQuestionsHere").html(showList);
       return;
     }
      showedBefore=true;
      var str;
      if(chooseAll) str="SELECT number,question FROM tbquiz ";
      else  str = "SELECT number,question,answer FROM tbquiz  WHERE "+categoryCondition;
      var stringArr=["number","question","answer"];
      askphp(str,stringArr,function(result){
        var n=result.length/3;
        var number;
        var i;
        var oneword;
        var content;
        for(i=0;i<n;i++){
          number=result[3*i];
          question=result[3*i+1];
          answer=result[3*i+2];

          oneword="<button class='eachQuestion' type='button' onclick='clickitem( " +i+")'>" + question +"</button>";
          oneitem=new item(number,question,answer,oneword,false)
          itemList.push(oneitem);
          showList.push(oneword);
        }
        cleanshowList=showList.slice();
        $("#allQuestionsHere").html(showList);
      }); // askphp
      $(this).html("hideAll");
      listshowing=true;


    });

  });  // ready


  </script>



  <div class="container">
    <div class="row">
      Hi,Challenger!
      <button type="button" id="showAll">showAll</button>
      <div id="head">  </div>
    </div>
    <div class="row">
      <form id="chooseCategory">
        <label for="history"><input type="checkbox" id="history" value="1"><img src="images/history.jpg" alt=""  id="imghistory" class="img"/>
        </label><label for="astronomy"><input type="checkbox" id="astronomy" value="1"><img src="images/astronomy.jpeg" alt=""  id="imgastronomy" class="img"/>
        </label><label for="physics"><input type="checkbox" id="physics" value="1"><img src="images/physics.jpg" alt=""  id="imgphysics" class="img" />
        </label><label for="computer"><input type="checkbox" id="computer" value="1"><img src="images/computer.jpg" alt=""  id="imgcomputer" class="img"/>
        </label><label for="politics"><input type="checkbox" id="politics" value="1"><img src="images/politics.jpg" alt=""  id="imgpolitics" class="img"/>
        </label><label for="life">
          <input type="checkbox" id="life" value="1">
          <img src="images/life.jpg" alt=""  id="imglife" class="img"/>
        </label><label for="biology">
          <input type="checkbox" id="biology" value="1">
          <img src="images/biology.jpg" alt=""  id="imgbiology" class="img"/>
        </label><label for="geography">
          <input type="checkbox" id="geography" value="1">
          <img src="images/geography.jpeg" alt=""  id="imggeography" class="img"/>
        </label>
        <div class="text-center bottomspace">
          <button  type="button" class="btn btn-success btn-lg" id="start2"> Select Them! </button>
          <button  type="button" class="btn btn-warning btn-lg" id="start21"> Select All! </button>
        </div>

      </form>
    </div>

    <div class="text-center"> <button  type="button" class="btn btn-success btn-lg" id="start1" > Choose Categories! </button> </div>
    <div class="text-center"> <button  type="button" class="btn btn-success btn-lg" id="start3" > Questions are selected, lets start it! </button> </div>

    <div id="showlater">
      <div class="row text-center alert alert-info" id="question"> </div>
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

    <div id="allQuestionsHere" class="row">  </div>

  </div>

</div>

</body>

</html>
