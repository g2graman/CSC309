<script>
  var lastUpdate = Date.now();
  var speed = 500.0;
  var roundCount = 1;
  var currentRound = 1;
  var notOver = true;
  function main() {
    while(notOver)
    run();
  };
  
  function run() {
    var currentUpdate = Date.now();
    var interval = (currentUpdate - lastUpdate) / speed;
    
    //update();
    //draw();
    
    lastUpdate = currentUpdate;
    
  };
</script>