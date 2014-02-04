var roundCount = 1;
var currentRound = 1;
var notOver = true;

// call the main function
tank = new Object();
bullet = new Object();
alien = new Object();
score = new Object();

//initialize default position for tank
tank.posX = 497;
tank.posY = 730;
tank.tankimg = new Image();
tank.tankimg.src = "img/canon.png";

// initialize bullet
bullet.active = false;
bullet.posX = 0;
bullet.posY = 0;
bullet.bulletimg = new Image();
bullet.bulletimg.src = "img/bulletBlack.png";
bullet.alienHit = false;
bullet.animatId = 0;

// initialize alien
alien.posX;
alien.posY;

// initialize score
score.points = 0;


//Install keydown handler
addEventListener("keydown", function tankKeyPress(e) {
  // left = 37, right = 39
  if(e.keyCode == 37 && tank.posX>30){
    tank.posX = tank.posX - 32;
  } else if(e.keyCode == 37 && tank.posX <= 0){
    //tank.posX = tank.posX;
  } else if(e.keyCode == 39 && tank.posX<934){
    tank.posX = tank.posX + 32;
  } else if(e.keyCode == 37 && tank.posX >= 994){
    //tank.posX = tank.posX;
  } else if(e.keyCode == 32 && bullet.active == false){
  	//alert("#shots fired");
  	if(bullet.active == false){
	  	shotsFired();
	}
  }
}, false);


function main() {
    //run();
    setInterval(draw, 1);
};

function shotsFired() {
	//alert("shots fired");
	bullet.active = true;
	
	// draw bullet onto screen
	bullet.posX = tank.posX + 25;
	bullet.posY = tank.posY - 22;
	bullet.bulletimg.src = "img/bulletPurple.png";
	
	// make bullet move upwards until it hits an alien OR reaches the top
	bullet.animateId = window.setInterval( "moveBullet()", 30 );
	
}

// move the bullet upwards until it hits the target or reaches the top
function moveBullet(){
	bullet.posY = bullet.posY - 10;
	
	// check if we're at the top and stop the loop
	if(bullet.posY <= 0){
		bullet.active = false;
		bullet.bulletimg.src = "img/bulletblack.png";
		window.clearInterval(bullet.animateId);
	}
	
	// check if the bullet has hit an alien
	if(bullet.posY - alien.posY < 5){
		bullet.active = false;
		updateScore();
		updateAlien();
		window.clearInterval(bullet.animateId);
	}
}

function updateScore(){
	// update the score
	score.points = score.points + 1;
	var score = "Score: " + score.points;
	context.fillText(score, 5, 5);
}

function updateAlien(){
	// make alien inactive/disappear
}


function draw(){
  var canvas = document.getElementById("myCanvas");
  var context = canvas.getContext("2d");
  context.fillStyle = "#000000";
  context.fillRect(0,0,1024,768);

  //creating tank
  context.drawImage(tank.tankimg, tank.posX, tank.posY);
  
  // creating bullet
  context.drawImage(bullet.bulletimg, bullet.posX, bullet.posY);
  
  // create score points
  var score = "Score: " + score.points;
  context.fillText(score, 5, 5);
};

main();
