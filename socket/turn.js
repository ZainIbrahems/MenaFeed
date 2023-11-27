var Turn = require('node-turn');
var server = new Turn({
  // set options
  listeningPort: 1025,
  authMech: 'long-term',
  credentials: {
    admin: "13658485"
  }
});
server.start();