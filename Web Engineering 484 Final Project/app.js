let app = require('http').createServer(); // create HTTP server
let io = require('socket.io')(app, {path: '/socket.io'}); // bind Socket to HTTP server
app.listen(3000); // listen on port 3000
console.log('Listening for connections on port 3000');
var playercount= 0;
var players = [];
var player1_hand = [];
var player1_total = 0;
var player2_hand = [];
var player2_total = 0;
var dealer_hand = [];
var dealer_total = 0;
var turn = 0;
var turncount = 0;

var bust = [];
var deck = [
"A", "A", "A", "A",
2,2,2,2,
3,3,3,3,
4,4,4,4,
5,5,5,5,
6,6,6,6,
7,7,7,7,
8,8,8,8,
9,9,9,9,
10,10,10,10,
10,10,10,10,
10,10,10,10,
10,10,10,10
];

function new_game(){
		deck=[
"A", 9, "A", "A",
2,2,2,2,
3,3,3,3,
4,4,4,4,
5,5,5,5,
6,6,6,6,
7,7,7,7,
8,8,8,8,
9,9,9,9,
10,10,10,10,
10,10,10,10,
10,10,10,10,
10,10,10,10
];
	return;
}

function shuffle(originalArray) {
  var array = [].concat(originalArray);
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}


function hit(){
	return deck.shift();
}
function addToTwo(){
	card = deck.shift();
	if( card != "A"){
		player2_total+=card;
	}
	else if(card === "A" && player2_total<11){
		player2_total+=11;
	}
	else if(card ==="A" && player2_total>=11){
		player2_total+=1;
	}
	player2_hand.push(card);
}

function addToOne(){
	card = deck.shift();
	if( card != "A"){
		player1_total+=card;
	}
	else if(card === "A" && player1_total<11){
		player1_total+=11;
	}
	else if(card ==="A" && player1_total>=11){
		player1_total+=1;
	}
	player1_hand.push(card);
}

function addToDealer(){
	card = deck.shift();
	if( card != "A"){
		dealer_total+=card;
	}
	else if(card === "A" && dealer_total<11){
		dealer_total+=11;
	}
	else if(card ==="A" && dealer_total>=11){
		dealer_total+=1;
	}
	dealer_hand.push(card);
}

function compare(){

}
io.on('connection', function(socket) {
   console.log('Socket connected');
   playercount+=1;
   console.log(playercount);
   players.push(socket.id);
   socket.emit('myID', {id: socket.id});
   socket.join('my-room');


   if(playercount==2){
   	console.log("playercount is 2");
   	//start the game
   	deck = shuffle(deck);
   	//first player is player 0
   	socket.in('my-room').emit('startGame', {gameStarted: true, playerNumber: 0});
   	//second player is player 1
   	socket.emit('startGame',{gameStarted: true, playerNumber: 1});

   	socket.on('getHand', function(data) { // listen for fromClient message 
   		//initial hand
   		addToOne();
   		addToOne();
   		addToTwo();
   		addToTwo();
   		addToDealer();
   		addToDealer();
   		console.log( player1_hand[0]+','+ player1_hand[1]);

   		socket.emit("giveHand", {
   			hand0: player1_hand, hand0T: player1_total, 
   			hand1: player2_hand, hand1T: player2_total, 
   			handD: dealer_hand, handDT: dealer_total,
   		});

   		socket.in('my-room').emit('giveHand', {
   			hand0: player1_hand, hand0T: player1_total, 
   			hand1: player2_hand, hand1T: player2_total, 
   			handD: dealer_hand, handDT: dealer_total,
   		});
	});

}
   	

   		socket.on('hit', function(data){
   		var whichPlayer = data.whosTurn;
   		console.log("hit");
   		turncount +=1;
   		if(whichPlayer == 0){
   			addToOne();
   			socket.emit("hit", {
   				whoHit: whichPlayer, 
   				newCard: player1_hand[1+turncount],
   				newTotal: player1_total
   			});
   			socket.in('my-room').emit('hit',{
   				whoHit: whichPlayer, 
   				newCard: player1_hand[1+turncount],
   				newTotal: player1_total
   			});
   		}
   		else if(whichPlayer ==1){
   			addToTwo();
   			socket.emit("hit", {
   				whoHit: whichPlayer, 
   				newCard: player2_hand[1+turncount],
   				newTotal: player2_total
   			});

   			socket.in('my-room').emit('hit',{
   				whoHit: whichPlayer, 
   				newCard: player2_hand[1+turncount],
   				newTotal: player2_total
   			});
   		}
   		else if(whichPlayer == 2){
   			addToDealer();
   			socket.emit("hit", {
   				whoHit: whichPlayer, 
   				newCard: dealer_hand[1+turncount],
   				newTotal: dealer_total
   			});

   			socket.in('my-room').emit('hit',{
   				whoHit: whichPlayer, 
   				newCard: player1_hand[1+turncount],
   				newTotal: player1_total
   			});
   		}
   	});
	
	socket.on('stand', function(data){
   		turn = data.whoStood + 1;
   		turncount = 0;
   		if(turn!=2){
   		socket.emit('turnChange', {nextTurn: turn});
   		socket.in('my-room').emit('turnChange',{nextTurn: turn});
   		}
   		else{
   			console.log("AI turn");
   			while(dealer_total<17){
   				addToDealer();
   				turncount++;

   				socket.emit("hit", {
   				whoHit: 2, 
   				newCard: dealer_hand[1+turncount],
   				newTotal: dealer_total
   			});

   			socket.in('my-room').emit('hit',{
   				whoHit: 2, 
   				newCard: dealer_hand[1+turncount],
   				newTotal: dealer_total
   			});

   				console.log(dealer_total);
   			}
   			//games over now compare
   		}
   	});

   	socket.on('bust',function(data){
   		turn = data.nextTurn;
   		console.log("Turn number" +turn);
   		turncount=0;
   		bust[data.whoBust]=1;
   		if(turn == 2){
   			console.log("AI turn");

   			while(dealer_total<17){
   				addToDealer();
   				turncount++;

   				socket.emit("hit", {
   				whoHit: 2, 
   				newCard: dealer_hand[1+turncount],
   				newTotal: dealer_total
   			});

   			socket.in('my-room').emit('hit',{
   				whoHit: 2, 
   				newCard: dealer_hand[1+turncount],
   				newTotal: dealer_total
   			});

   				console.log(dealer_total);
   			}
   			//games over now compare
   		}

   		else{
   		socket.emit('bust', {nextTurn: turn});
   		socket.in('my-room').emit('bust', {nextTurn: turn});
   		}
   	});


   	socket.on('whoBusted', function(data){
   		sockeet.emit('whoBusted', {whoBusted: bust});
   		socket.in('my-room').emit('whoBusted', {whoBusted: bust});
   	});

   		
   	
   

   

   });
   //send to a specific id
   //*********io.to(socket.id).emit('message', 'for your eyes only');
   // join the socket into the room called 'my-room'
  
   