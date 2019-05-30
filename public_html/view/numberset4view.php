<?php
class numberset4View extends View{

public function index(){
$mysidia = Registry::get("mysidia");
$document = $this->document;   
$document->setTitle('<center>Number set 4</center>');
$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/arcade'>~Go back to the Arcade</a>"));
$document->add(new Comment("
//HTML
<html>
<h1>Can you set all tiles to 4?</h1>
<fours-game rows="5" cols="5"></fours-game>

<script type="riot/tag">
  <fours-game>
    <div class="grid">
      <div class="row" each={cols in grid}>
        <div class="col" each={cols}><button onclick={turn} class="number-{number}">{number}</button></div>
      </div>
    </div>
    <button onclick={reset}>Reset game</button>

    generateGrid (rows, cols) {
      var grid = [], i, j;
      for (i = 0; i < rows; i = i + 1) {
        grid[i] = [];
          for (j = 0; j < cols; j = j + 1) {
            grid[i].push({
              row: i,
              col: j,
              number: 0
            })
          }
      }
      return grid;
    }

    updateTile (row, col) {
      var row = this.grid[row];
      if (row && row[col]) {
        row[col].number = (row[col].number < 4) ? row[col].number + 1 : 0;
      }
    }

    turn (e) {
      e.item.number = (e.item.number < 3) ? e.item.number + 2 : 0;
      this.updateTile(e.item.row - 1, e.item.col) // above
      this.updateTile(e.item.row, e.item.col + 1) // right
      this.updateTile(e.item.row, e.item.col - 1) // left
      this.updateTile(e.item.row + 1, e.item.col) // below
    }

    reset (e) {
      this.grid = this.generateGrid(opts.rows, opts.cols)
    }

    this.grid = this.generateGrid(opts.rows, opts.cols)
  </fours-game>

</script>
</html>

//CSS

<style>
body {
	text-align: center;
	font-family: sans-serif;
	padding: .5em;
}

h1 {
	margin: 0;
	font-size: 1.2em;
}

button {
	padding: 1em;
	border: 0;
    background-color: #ccc;
    transition: all 300ms linear;
  font-size: 1em
}

.row {
	display: flex;
	justify-content: center;
}

.col {
    padding: .2em;
}

button.number-4 {
	background-color: green;
	color: #fff;
	transform: scale(1.1);
}

</style>


//JS

<script>
riot.mount('*');
</script>"));
 
    }

        }

    ?>