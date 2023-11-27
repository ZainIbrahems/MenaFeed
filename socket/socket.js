/*jshint esversion: 6 */
/*jshint node: true */
//handle join event
const siofu = require("socketio-file-upload");
const Redis = require("ioredis");

var redis = new Redis();
const fs = require('fs');
const path = require('path');
// const NodeJsRecordingHandler = require('record-entire-meeting\\Nodejs-Recording-Handler.js');
let meetings = [];
let users = [];

redis.subscribe('user-channel', function (err, count) {
    console.log('subscribed to user-channel');
});

//handle join event
function handleJoin(socket, data) {
    console.log("Joined: " + data.type + "-" + data.user_id);
    users[data.type + "-" + data.user_id] = {
        'user_id': data.user_id,
        'type': data.type,
        'socket': socket.id
    };
}//handle join event
function handleLeave(socket, data) {
    const index = array.indexOf(data.type + "-" + data.user_id);
    if (index > -1) { // only splice array when item is found
        users.splice(index, 1); // 2nd parameter means remove one item only
    }
}

//handle disconnect event
function handleDisconnect(socket, io) {

}


module.exports = function (io) {
    //handle connection event
    io.sockets.on('connection', function (socket) {
        // NodeJsRecordingHandler(socket);

        socket.on('join', function (data) {
            handleJoin(socket, data);
        });
        socket.on('leave', function (data) {
            handleLeave(socket, data);
        });

        socket.on('join-feed', function (data) {
            console.log('join-feed-' + data.feed_id);
            socket.join('feed-' + data.feed_id);
        });

        socket.on('leave-feed', function (data) {
            console.log('leave-feed-' + data.feed_id);
            socket.leave('feed-' + data.feed_id);
        });

        socket.on('disconnect', function () {
            handleDisconnect(socket, io);
        });
    });

    redis.on('message', function (channel, message) {
        message = JSON.parse(message);
        var event = message.event;
        console.log(event);
        var data = message.data;
        console.log(data);

        switch (event) {
            case 'counters':
                if (users[data.type + "-" + data.user_id] && users[data.type + "-" + data.user_id].socket) {
                    io.to(users[data.type + "-" + data.user_id].socket).emit(event, data.data);
                }
                break;
            case 'new-message':
                if (users[data.type + "-" + data.user_id] && users[data.type + "-" + data.user_id].socket) {
                    io.to(users[data.type + "-" + data.user_id].socket).emit(event, data.data);
                }
                break;
            case 'message':
                if (users[data.type + "-" + data.user_id] && users[data.type + "-" + data.user_id].socket) {
                    io.to(users[data.type + "-" + data.user_id].socket).emit(event, data.data);
                }
                break;
            case 'feed-update':
                io.to('feed-' + data.user_id).emit(event, data);
                break;
        }
    });
}
