<?php
class lightsoutView extends View{

public function index(){
$mysidia = Registry::get("mysidia");
$document = $this->document;   
$document->setTitle('<center>Lights out game</center>');
$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/arcade'>~Go back to the Arcade</a>"));
$document->add(new Comment("
//HTML
<html>
<header>
  <nav><ul>
    <li><button id="new" href="#">New</button></li>
    <li><button id="reset" href="#">Reset</button></li>

    </ul> 
  </nav>
</header>
<main>
<Board style="--columns: 12; --rows: 12;">
</Board>
</main> 
</html>

//CSS

<style>
body { 
  margin: 0;
  font-family: Roboto, sans-serif;
  background: #000; 
  width: 100vw; 
  height: 100vh;
  display: flex;
  flex-direction: column;
}

header {
  width: 100vmin;
  margin: auto;
  height: 60px;
}

main {
  width: 100vmin; 
  margin: auto;
  height: 1px;
  flex-grow: 1;
}


Board {
  --columns: 3;
  --rows: 3;
  display: grid;
  width: 100%;
  height: 100%;
  grid-template-columns: repeat(var(--columns), 1fr);
  grid-template-rows: repeat(var(--rows), 1fr);
  grid-gap: .25em;
}

Cell {
  background: #224;
  border-radius: 5px;
  transition: background 1000ms ease;
  cursor: pointer;
}

Cell:active {
  background: #fff;
}

Cell[activated] {
  background: #fe0;
}



header nav {
  height: 100%;
  width: 100%;
} 

header nav ul {
  height: 100%;
  width: 100%;
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

header nav li {
  width: 100%;
  height: 100%;
  display: block;
}

header nav button {
  width: 100%;
  height: 100%;
  background: #25a;
  color: #ff0;
  border: 2px solid black;
  border-radius: 5px;
  vertical-align: middle;
  font-size: calc(1em + 2vmin);
  box-sizing: border-box;
  text-decoration: none; 
}

button:active {
  background-color: #ff0;
  color: #25a;
}
</style>


//JS

<script>
let difficulty = 4
const { random, min, max } = Math
const d = document
const $ = d.querySelector.bind(d)
const B = $('Board')
const cols = B.style.getPropertyValue('--columns') | 0
const rows = B.style.getPropertyValue('--rows') | 0
const state = {
  cheated: false,
  won: false,
  computerMoves: [],
  initialBoardSetup: ""
}
const locked = () => B.getAttribute('disabled') !== null
const lock = () => B.setAttribute('disabled', 'disabled')
const unlock = () => B.removeAttribute('disabled')
const boardIsEmpty = () => B.querySelectorAll('[activated]').length === 0
const isActivated = (cell) => cell.getAttribute("activated")
const toggleCell = (cell) => cell[isActivated(cell) ? "removeAttribute":"setAttribute"]('activated', 'activated')
const getCell = (x,y) => B.querySelectorAll('Cell')[y*cols+x]

function fillBoard() {
  B.innerHTML = ''
  Array(rows * cols).fill(0).map(el => {
    const cell = d.createElement('Cell')
    cell.setAttribute('tabindex', 0)
    cell.setAttribute('role', 'button')
    B.appendChild(cell)
  })
  state.computerMoves = []
  Array(difficulty).fill(0).map(el => {
   const randX = (random() * cols) | 0
   const randY = (random() * rows) | 0
   state.computerMoves.push({x: randX, y: randY})
   makeMove(randX, randY)
  })
  if (boardIsEmpty()) {
    fillBoard()
  }
  state.cheated = false
  state.won = false
  state.initialBoardSetup = B.innerHTML
}

function solve() {
  let index = 0
  state.cheated = true
  B.innerHTML = state.initialBoardSetup
  lock()
  window.setTimeout(function anim() {
    const move = state.computerMoves[index]
    makeMove(move.x, move.y)
    index++;
    if (index === state.computerMoves.length) {
      unlock()
    } else {
      setTimeout(anim, 1000)
    }
  }, 1000)
}

function setup() {
  fillBoard()
  B.onclick = (e) => {
    if (locked()) return;
    const cell = e.target
    if (cell.nodeName !== "CELL") {
      return
    }
    const idx = Array.prototype.slice.call(B.children).indexOf(cell)
    makeMove(idx % cols, (idx / cols)|0)
    if (!state.won && !state.cheated && boardIsEmpty()) {
      state.won = true;
      lock()
      window.setTimeout(() => {
        unlock()
       
        if (confirm("You WON! Try the next level?"))         {
          difficulty++
          fillBoard()
        }
      }, 2000)
    }
  }
  $('#new').onclick = () => fillBoard()
  $('#reset').onclick = () => {
    B.innerHTML = state.initialBoardSetup
    state.won = false
    state.cheated = false
  }
  $('#solve').onclick = () => {
    solve()
  }
}

function makeMove(x,y) {
  for (let yy=0;yy<rows;yy++)
    toggleCell(getCell(x,yy))
  for (let xx=0;xx<cols;xx++) 
    if (x!==xx) toggleCell(getCell(xx,y))
}



setup()
</script>"));
 
    }

        }

    ?>