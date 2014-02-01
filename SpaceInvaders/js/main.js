var roundCount = 1;
var currentRound = 1;
var notOver = true;

// call the main function
tank = new Object();

//initialize default position
tank.posX = 497;
tank.posY = 730;

tank.tankimg = new Image();
tank.tankimg.src = "img/canon.png";

//Install keydown handler
addEventListener("keydown", function tankKeyPress(e) {
  // left = 37, right = 39
  if(e.keyCode == 37 && tank.posX>0){
    tank.posX = tank.posX - 32;
  } else if(e.keyCode == 37 && tank.posX <= 0){
    //tank.posX = tank.posX;
  } else if(e.keyCode == 39 && tank.posX<832){
    tank.posX = tank.posX + 32;
  } else if(e.keyCode == 37 && tank.posX >= 994){
    //tank.posX = tank.posX;
  }
}, false);


function main() {
    //run();
    setInterval(draw, 1);
};


function draw(){
  var canvas = document.getElementById("myCanvas");
  var context = canvas.getContext("2d");
  context.fillStyle = "#000000";
  context.fillRect(0,0,1024,768);

  //creating tank
  context.drawImage(tank.tankimg, tank.posX, tank.posY);
};

main();
