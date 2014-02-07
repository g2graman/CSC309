CSC309H
Aashni Shah | g2aashni | 999019663
Francesco Gramano | g2graman | 999203767
============================

SpaceInvaders
-------------
This project is a reconstruction of the classical "Space Invaders" in HTML and JavaScript, to be played entirely on the client-side. It is played by moving the tank left or right with the according left and right arrow keys, and by shooting the opposing aliens with the spacebar but beware to use your bullets efficiently, because you can only shoot one bullet at a time! Your score can be seen in the upper left-hand corner and your remaining lives can be seen in the upper right-hand corner in the form of heart pictorials. When your lives run out or the aliens reach the bottom, it's game over, after which you will be prompted to play again.

Under The Hood
—-------------
This SpaceInvaders project was created using 4 files, and a few images.

style.css
This file contains the style elements. It is an external stylesheet that is accessed by both the index.html and game.html files.

index.html
This is the main entry page. We decided to create splash intro page that users must click on to start the game. This then leads to the game.html page, where the SpaceInvaders is located.

game.html
We created the canvas in the game.html. The game is implemented on this canvas with the use of an external javascript file called main.js.

main.js
This is the file that contains all the javascript, and controls how the game will run. There are many elements to this javascript file. We begin by creating the context and canvas, then creating some of the flag variables we will need later on in the file.
Next we created a tank and score object. The tank object is used to keep track of the tanks location, along with the tank’s image, and lives. The score object keeps track of the score, which directly correlates to the number of aliens that have been killed. We chose to create single objects of these as we only need one object of each. We also created a bullet for the tank which works in a different direction to the other bullets.
We knew we would be using multiple enemies and multiple bullets in the game. We decided to create these in an array to track them easily. We create a row of aliens, and each alien object is added into the enemies array. The alien object keeps track of their current and original positions, the direction that they are travelling, src to their image and whether the alien is still alive. The alien object then has added functions such as kill, detect, update, fire and shouldfire. Kill is called when an alien has been killed. Detect checks to see if the tank’s bullet has hit the alien. The update function makes the alien swipe left to write, and at the end of the row it moves lower on the screen. It also checks to see if the aliens have reached the bottom of the screen, i.e. if the invasion has been successful. The fire function and shouldfire functions are used to determine if the enemy can fire a bullet, and then creates one. 
The bullet object keeps track of it’s position, as well as it’s image source and whether or not it has hit an alien. We are also able to specify the offset value of the bullet to determine if the bullet is moving up (from the tank) or down (from the aliens). The bullet functions include an update function that moves the bullet up or down, and determines whether the extremes of the screen has been reached, or the tank was hit. It also contains a hide function, which hides the bullet.
The tank is controlled by a real-world user through keyboard buttons. We have an eventListener that waits for any keydown movements, checks the key code pressed, and moves the tank in the desired direction. Additionally, it calls the shotsFired function if the spacebar has been hit.
We have some smaller functions such as shotsFired (to create a bullet fired by the tank), incScore (to increase the score if an alien has been hit), setup (part of the setup process), addRowEnemies creates a new row of enemies at the top of the game and finally the restart and gameOver functions. Our largest function is the draw function, which is constantly being called. The draw function is responsible for drawing the updated locations of the bullet, tank, scores, lives etc. It also performs checks to see if the bullets should be moving, and if aliens have been hit. 

The game is run by creating a listener or setInterval that constantly calls the main function. The main function checks to make sure the game is not over, and then calls the draw function to update the positions of all the objects on the screen.
