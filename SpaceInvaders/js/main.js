  var lastUpdate = Date.now();
  var speed = 500.0;
  var roundCount = 1;
  var currentRound = 1;
  var notOver = true;

  var tankPosX = 497;
  var tankPosY= 730;

  // call the main function
  tank = new Object();
  tank.posX = 497;
  tank.posY = 730;
  tank.onkeydown = tankKeyPress(key, tank);

  main();


  function main() {
      //alert("main");
      //run();
      setInterval(draw, speed);
  };
  
  /*function run() {
    //alert("run");
    var currentUpdate = Date.now();
    var interval = (currentUpdate - lastUpdate) / speed;
    
    //update();
    draw();
    
    lastUpdate = currentUpdate;
    
  };*/


  function draw(){
    //alert("draw");
    var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext("2d");
    context.fillStyle = "#000000";
    context.fillRect(0,0,1024,768);

    //creating tank
    context.fillStyle = "#FF0000";
    context.fillRect(tank.posX,tank.posY,30,20);
  };

 

  function tankKeyPress(key, tank){
    // left = 37, right = 39
    if(key.keyCode == 37 && tank.posX>0){
      tank.posX = tank.posX - 1;
    } else if(key.keyCode == 37 && tank.posX <= 0){
      //tank.posX = tank.posX;
    } else if(key.keyCode == 39 && tank.posX<994){
      tank.posX = tank.posX + 1;
    } else if(key.keyCode == 37 && tank.posX >= 994){
      //tank.posX = tank.posX;
    }
  }

    main();
