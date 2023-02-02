const http = require('http');
http.createServer(function (req, res) {
	res.writeHead(200, {
		'Content-Type': 'text/plain'
	});
	res.end('Hello World\n');
}).listen(3456);
console.log('Server running at http://localhost:3456/');