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
var newRow = true;

// call the main function
tank = new Object();
score = new Object();

function bullet (x, y, offset) {
	// initialize bullet
	this.active = true;
	this.posX = x;
	this.posY = y;
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
		
		// check if we hit the tank
		if(tank.posY - this.posY <= 10 && this.posX - tank.posX <= 80 && this.posX - tank.posX >= 0){
			this.hide();
			tank.lives = tank.lives - 1;
			tank.livesText = "Lives: " + tank.lives;
			this.active = false;
			if(tank.lives == 0){
				//tank.tankimg.src = "img/canonExplode.png";
				notOver = true;
				context.fillStyle = "#000000";
				context.fillRect(0,0,1024,768);
				var ng=confirm("Click OK to start a new game!");
				if (ng==true)
				{
					restart();
				} else {
					window.clearInterval(listener);
					gameOver();
				}
			}
			
		}
	};

	this.hide=function () {
		this.bulletimg.src = "img/emptySpace.png";
	};
};

//initialize default position for tank
tank.posX = 497;
tank.posY = 730;
tank.canfire = true;
tank.tankimg = new Image();
tank.tankimg.src = "img/canon.png";
tank.lives = 5;
//tank.livesText = "Lives: " + tank.lives;
tank.livesimg = new Image();
tank.livesimg.src = "img/lives.png";

var mybullet = new bullet(tank.posX, tank.posY, -10);
mybullet.active=false;
var enemyshots = [];
var enemies = [];
var newRows = 0;
var rand = Math.floor(Math.random() * (enemies.length*150 - 1) + 1);

function alien(x, y) {
	this.posX = x;
	this.posY = y;
	this.origX = x;
	this.origY = y;
	this.direction = 'l';
	this.newRow = 0;
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
				rand = Math.floor(Math.random() * (enemies.length*150 - 1) + 1);
			}
		}
	};

	// update alien movements, add new rows as needed
	this.update=function() {
		// extreme left
		if(this.posX == this.origX){
			this.posY = this.posY + 5;
			this.direction = 'l';
			newRow = newRow + 1;
		}
		
		// extreme right
		if(this.posX - this.origX == 100){
			this.posY = this.posY + 5;
			this.direction = 'r';
			newRow = newRow + 1;
		}
	
		// shift aliens left/right
		if(this.direction == 'l'){
			this.posX = this.posX + 1;
		} else if(this.direction == 'r'){
			this.posX = this.posX - 1;
		}
		
		// add new row
		if(newRow >= 15 * enemies.length){
			newRow = true;
			addRowEnemies();
			newRow = 0;
		}
		
		// reached bottom, end of the game
		if(this.posY + 30 >= tank.posY){
			notOver = false;
		}
		
	};

	this.fire=function() {
		var bull = new bullet(this.posX, this.posY, Math.floor(Math.random() * (10 - 7) + 7));
		enemyshots.push(bull);
	};

	this.shouldfire=function(match) {
		//Aliens shoot more often when some die as part of speed-up
		return Math.floor(Math.random() * (enemies.length*150 - 1) + 1)==match;
	}
};

// initialize score
score.points = 0;
var scoreText = "Score: " + score.points;

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
	//setup();

	if(notOver){
		draw();
	}

	//notOver = enemies.length > 0 && notOver;
	//Got rid of above line to not have repeated confirm box
	
	if(notOver == false && !ended) {
		draw();
		ended = true;

		//Alert the user for gameover
	}
};

// tank has fired a shot, create the bullet
function shotsFired() {
	tank.canfire = false;
	mybullet.active = true;
	mybullet.posX = tank.posX + 25;
	mybullet.posY = tank.posY - 22;
	mybullet.bulletimg.src = "img/bulletPurple.png";
};

// increase the score
function incScore(){
	// update the score
	score.points = score.points + 1;
	scoreText = "Score: " + score.points;
};

// the game is over, so we reset everything for another round
function setup(){
	addRowEnemies();
}

function restart() {
	roundCount = 1;
	currentRound = 1;
	notOver = true;
	ended = false;
	newRow = true;
	tank.lives = 3;
	enemies = [];
	context.fillStyle = "#000000";
	context.fillRect(0,0,1024,768);
	setup();
	tank.livesText = "Lives: " + tank.lives;
	score.points = 0;
	scoreText = "Score: " + score.points;
}

function gameOver () {
	enemies = [];
	bullets = [];
	context.fillStyle = "#000000";
	context.fillRect(0,0,1024,768);
	scoreText = "";
	tank.tankimg.src = "img/emptySpace.png";
	
}

function addRowEnemies(){
	//alert("addRowEnemies() function");
	for(var i = 0; i < 8; i++){
		enemies.push(new alien(50 + (i * 100), 50));
	}
	newRow = false;
}


function draw(){
	// check to see if the game is over
	if(!notOver){
		context.fillStyle = "#000000";
		context.fillRect(0,0,1024,768);
		var newGame=confirm("Click OK to start a new game!");
		if (newGame==true) {
			restart();
		}
		else {
			window.clearInterval(listener);
			gameOver();
		}
	}

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
  
  if(mybullet.active){
  	context.drawImage(mybullet.bulletimg, mybullet.posX, mybullet.posY);
  }

  enemies.forEach(function(alie) {
  	if(mybullet.active){
  		alie.detect(mybullet.posX, mybullet.posY);
  	}
  	context.drawImage(alie.alienimg, alie.posX, alie.posY); 
  	if(alie.shouldfire(rand)) {
  		alie.fire();
  	}
  	alie.update();
  });
  
  // show lives
  context.font = '20pt Verdana';
  context.fillStyle = 'red';
  //context.fillText(tank.livesText, 800, 30);
  for(var i = 0; i < tank.lives; i++){
  	context.drawImage(tank.livesimg, 800+i*30, 10);
  }

  //Remove all dead aliens from the stack
  enemies = enemies.filter(function(alie) {
    return alie.alive;
  });

  enemyshots.forEach(function(bull) {
  	if (notOver && bull.active) {
  		bull.update();
  	} else {
  		bull.hide();
  	}

  	context.drawImage(bull.bulletimg, bull.posX, bull.posY);  
  });

  enemyshots = enemyshots.filter(function(bull) {
    return bull.active;
  });
};

setup();
var listener = setInterval(main, 1);
