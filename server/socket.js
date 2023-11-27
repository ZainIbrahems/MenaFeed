//handle join event
const siofu = require("socketio-file-upload");
const fs = require('fs');
const path = require('path');
const http = require('http');

//handle join event
function handleJoin(socket, data) {
    console.log('join');
    socket.join('chat-' + data.chat_id);
}

function handSendMessage(socket, data) {
    console.log('handSendMessage');
    var options = {
        // host: 'localhost',
        host: 'dashboard.menaplatforms.com',
        port: 80,
        // path: '/mena/public/api/v1/chat/last-message/' + data.chat_id,
        path: '/api/v1/chat/last-message/' + data.chat_id,
        method: 'GET'
    };

    http.request(options, (res) => {
        res.setEncoding('utf8');
        res.on('data', (chunk) => {
            socket.broadcast.to('chat-' + data.chat_id).emit('msg', chunk);
        });
    }).end();
}

//handle disconnect event
function handleDisconnect(socket, io) {

}


module.exports = function (io) {
    io.sockets.on('connection', function (socket) {
        console.log('connection');
        socket.on('join', function (data) {
            handleJoin(socket, data);
        });
        socket.on('send-msg', function (data) {
            handSendMessage(socket, data);
        });

        socket.on('disconnect', function () {
            handleDisconnect(socket, io);
        });
    });
}
