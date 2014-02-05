var context;
var canvas;

window.onload=function() {
  canvas = document.getElementById("myCanvas");
  context = canvas.getContext("2d");
};

var roundCount = 1;
var currentRound = 1;
var notOver = true;
var ended = false;

// call the main function
tank = new Object();
score = new Object();

function bullet (x, y, offset) {
	// initialize bullet
	this.active = true;
	this.posX = 0;
	this.posY = 0;
	this.bulletimg = new Image();
	this.bulletimg.src = "img/bulletPurple.png";
	this.alienHit = false;

	/* allow user to specify offset value so bullets can move
	up or down.*/
	this.offset = offset;

	this.update=function (){
		this.posY = this.posY + offset/3;
		
		// check if we're at the top and stop the loop
		if(this.posY > 768){
			this.active = false;
			this.bulletimg.src = "img/emptySpace.png";
		}
	}
};

//initialize default position for tank
tank.posX = 497;
tank.posY = 730;
tank.canfire = true;
tank.tankimg = new Image();
tank.tankimg.src = "img/canon.png";

var mybullet = new bullet(tank.posX, tank.posY, -10);

function alien(x, y) {
	this.posX = x;
	this.posY = y;
	this.alienimg = new Image();
	this.alienimg.src = "img/alien.png";
	this.alive = true;

	this.kill=function(){
		// make alien inactive/disappear
		this.posX = 0;
		this.posY = 0;
		this.alienimg.src = "img/emptySpace.png";
		this.alive = false;
	}

	this.detect=function(bulletX, bulletY){
		// check if the bullet has hit an alien
		if(bulletY > 0 && bulletX > 0){
			if(bulletY - this.posY < 58 && (bulletX - this.posX < 80 && bulletX > this.posX) && this.alive == true){
				tank.canfire = true;
				mybullet.active = false;
				mybullet.bulletimg.src = "img/emptySpace.png";
				incScore();
				this.kill();
			}
		}
	}
};

// initialize score
score.points = 0;
var scoreText = "Score: " + score.points;
var enemies = [];

//Add 3 monsters to the stack. Layout of monsters pending.
enemies.push(new alien(50, 50));
enemies.push(new alien(150, 50));
enemies.push(new alien(550, 50));
enemies.push(new alien(250, 50));
enemies.push(new alien(350, 50));
enemies.push(new alien(450, 50));

//Install keydown handler
addEventListener("keydown", function (e) {
  // left = 37, right = 39
  if(e.keyCode == 37 && tank.posX>30){
    tank.posX = tank.posX - 32;
  } else if(e.keyCode == 37 && tank.posX <= 0){
    //tank.posX = tank.posX;
  } else if(e.keyCode == 39 && tank.posX<934){
    tank.posX = tank.posX + 32;
  } else if(e.keyCode == 37 && tank.posX >= 994){
    //tank.posX = tank.posX;
  } else if(e.keyCode == 32 && tank.canfire){
	  	shotsFired();
  }
}, false);


function main() {
	if(notOver){
		draw();
	}

	notOver = enemies.length > 0 && notOver;
	
	if(notOver == false && !ended) {
		draw();
		ended = true;

		//Alert the user for gameover
	}
};

function shotsFired() {
	tank.canfire = false;
	mybullet.active = true;
	mybullet.posX = tank.posX + 25;
	mybullet.posY = tank.posY - 22;
	mybullet.bulletimg.src = "img/bulletPurple.png";
};

function incScore(){
	// update the score
	score.points = score.points + 1;
	scoreText = "Score: " + score.points;
};


function draw(){
  context.fillStyle = "#000000";
  context.fillRect(0,0,1024,768);
  
  context.font = '20pt Verdana';
  context.fillStyle = 'red';
  context.fillText(scoreText, 20, 30);

  // creating tank
  context.drawImage(tank.tankimg, tank.posX, tank.posY);
  
  // draw my tank's bullet
  mybullet.update();
  tank.canfire = (mybullet.posY < 0 && !tank.canfire);
  context.drawImage(mybullet.bulletimg, mybullet.posX, mybullet.posY);
  
  enemies.forEach(function(alie) {
  	alie.detect(mybullet.posX, mybullet.posY);
  	context.drawImage(alie.alienimg, alie.posX, alie.posY);  
  });

  //Remove all dead aliens from the stack
  enemies = enemies.filter(function(alie) {
    return alie.alive;
  });
};

setInterval(main, 1);
