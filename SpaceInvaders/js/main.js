  var lastUpdate = Date.now();
  var speed = 500.0;
  var roundCount = 1;
  var currentRound = 1;
  var notOver = true;

  // call the main function

  var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext("2d");
    context.fillStyle = "#000000";
    context.fillRect(0,0,1024,768);


  function main() {
      //alert("main");
      run();
  };
  
  function run() {
    //alert("run");
    //var currentUpdate = Date.now();
    //var interval = (currentUpdate - lastUpdate) / speed;
    
    //update();
    draw();
    
    lastUpdate = currentUpdate;
    
  };

  function draw(){
    //alert("draw");
    var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext("2d");
    context.fillStyle = "#000000";
    context.fillRect(0,0,1024,768);
  };

    main();
