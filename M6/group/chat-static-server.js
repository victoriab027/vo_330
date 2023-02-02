// Require the functionality we need to use:
const http = require('http'),
	url = require('url'),
	mime = require('mime'),
	path = require('path'),
	fs = require('fs');

// Make a simple fileserver for all of our static content.
// Everything underneath <STATIC DIRECTORY NAME> will be served.
const app = http.createServer(function(req, resp){
	const filename = path.join(__dirname, "/static/", url.parse(req.url).pathname);
	(fs.exists || path.exists)(filename, function(exists){
		if (exists) {
			fs.readFile(filename, function(err, data){
				if (err) {
					// File exists but is not readable (permissions issue?)
					resp.writeHead(500, {
						"Content-Type": "text/plain"
					});
					resp.write("Internal server error: could not read file");
					resp.end();
					return;
				}
				
				// File exists and is readable
				const mimetype = mime.getType(filename);
				resp.writeHead(200, {
					"Content-Type": mimetype
				});
				resp.write(data);
				resp.end();
				return;
			});
		}else{
			// File does not exist
			resp.writeHead(404, {
				"Content-Type": "text/plain"
			});
			resp.write("Requested file not found: "+filename);
			resp.end();
			return;
		}
	});
});
app.listen(3456);

// CHAT SERVER STUFFS
// Import Socket.IO and pass our HTTP server object to it.
const socketio = require("socket.io")(http, {
    wsEngine: 'ws'
});

//track all online users
let users = []; // holds all online users  => could switch to the map thing below

// Create the rooms and autoadd the homeroom object
const rooms = [
	{name: 'homeroom', members: []},//later add owener and who is banned
	{name: 'test', members: []}
];

// Attach our Socket.IO server to our HTTP server to listen
const io = socketio.listen(app);

io.sockets.on("connection", function (socket) {
	socket.join("homeroom");//upon logging on, the user should join the home room
	rooms[0].members.push("");//adding this so some thigns will work

	//Creating nickname TODO: NEEDS WORK
	socket.on('set_nickname', function(nickname) {
		socket.name = nickname;
		console.log(`${socket.name}: connected`);
		rooms[0].members.push(socket.name);
		//Update the online list for those in this room
		io.emit("onlineList", rooms[0].members);
		//add this new user to the lsit of users
		users.push(socket.name);
		//socket.logged_on = true;
	});
	socket.on("getOnline", function() {
		let room = getSocketRoom(socket);
		let members = room.members;
		// Send the "roomList" event to the client, with the list of rooms
		socket.emit("onlineList", members);
		//console.log("getOnline: 9");
	});

		// When the "joinRoom" event is received
		socket.on("joinRoom", function(roomName) {
			changeRoom(roomName, socket);
		});

		// When the "createRoom" event is received
		socket.on("createRoom", function(roomName) {
			let newRoom = {name: roomName, members: []}
			let console_output_2 = socket.name + " created " +roomName;
			rooms.push(newRoom);
			console.log(console_output_2);
			//io.sockets.emit("roomList",rooms);
			//roomList
			//console.log("homeroom members:");
			changeRoom(roomName, socket);
			//onsole.log("return");
		});

		// When the "getRooms" event is received
		socket.on("getRooms", function() {
			// Send the "roomList" event to the client, with the list of rooms
			socket.emit("roomList", rooms);
		});
	
		socket.on('message_to_server', function (data) {
			// This callback runs when the server receives a new message from the client.
			let output = socket.name+": " + data["message"];
			console.log(output);
			io.in(room_name).emit("message_to_client", {message:output}); // broadcast the message to other users
		});

		// When the "sendMessage" event is received
		socket.on("sendMessage", function(message) {
			// Get the room that the socket is in
			const room = getSocketRoom(socket);
			let room_name = room.name;
			
			let console_message = socket.name + " to "+ room_name+ ": " + message;//TODO: change to nickname!
			let output_message = socket.name + ": " + message;//TODO: change to nickname!
			console.log(console_message);
			io.in(room_name).emit("message_to_client", {
				//sender: socket.id,
				message: output_message
			});
		});
		// send a private message
		socket.on("privateMessage", function(to, message) {
			console.log(to);
			let recieverSocket = io.sockets.sockets[to];//this line doesn't actually work
			io.sockets.sockets.forEach((socket_loop) => {
				if(socket_loop.id == to){
					recieverSocket = socket_loop;
				}
			});
			let console_message = socket.name + " DM "+ recieverSocket.name + ": " + message;//TODO: change to nickname!
			let output_message = socket.name + ": " + message;//TODO: change to nickname!
			recieverSocket.emit("message_to_indiv", {
				message: output_message
			});
		});

		//dissconnect
		socket.on('disconnect', function () {
			console.log(socket.name);
			let leaving_room = getSocketRoom(socket);
			let members = leaving_room.members;
			members = members.filter(element => element !== socket.name);
			leaving_room.members = members;
			io.sockets.emit("onlineList", members);
			socket.leave(leaving_room.name);
			users = users.filter(element => element !== socket.name);//remove the dissconnecting user

			//CHANGE
			//io.sockets.emit('online users', users);

			console.log(`${socket.name} disconnected`);
		});
	});

	function getSocketRoom(socket) {
		// Iterate over the list of rooms
		for(i = 0; i < rooms.length; i++){
			let room = rooms[i];
			let mems = room.members;
			console.log(room);
			console.log(mems);
			for(j = 0; j < mems.length; j++){
				if(mems[j] == socket.name){
					return room;
				}
			}
		}
}

function changeRoom(roomName, socket){
	let leaving_room = getSocketRoom(socket);
	let members = leaving_room.members;
	
	members = members.filter(element => element !== socket.name);
	leaving_room.members = members;
	
	//Before actually leaving the room, we will want to update the list of members for everyone in that room
	//THEN, after emitting that message, can the socket actually leave

	socket.to(leaving_room).emit("onlineList", members);
	
	//actually leave the room
	socket.leave(leaving_room.name); //leave the old room
	let console_output = socket.name + " left " +leaving_room.name;
	console.log(console_output);
	let room = rooms.find(room => room.name === roomName);
	socket.join(roomName) // join socket to new room


	//socket.to(room).emit('user left', socket.id);
	room.members.push(socket.name);
	let printer = room.members;
	let console_output_2 = socket.name + " joined " +roomName;
	console.log(console_output_2);
	socket.emit("onlineList", printer);//to(roomName)
}
  