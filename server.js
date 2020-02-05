require('dotenv').config();
let redis = require('redis')
let redisClient = redis.createClient({
    host: process.env.REDIS_HOST,
    // password: process.env.REDIS_PASSWORD,
    port: process.env.REDIS_PORT,
});

let io = require('socket.io')(process.env.SOCKET_PORT);

io.set('origins', '*:*');

redisClient.subscribe('events');

redisClient.on('message', function(channel, payload) {
    
    payload = JSON.parse(payload);
    console.log({
        channel : channel,
        event : payload.event,
        data : payload.data
    });

    switch (payload.event) {
        case 'device':
            io.emit(payload.event, payload.data);
            break;
        case 'component':
            io.emit(payload.event, payload.data);
            break;
        case 'value':
            io.emit(payload.event, payload.data);
            break;
        case 'activity':
            io.emit(payload.event, payload.data);
            break;
    }

});

io.on('connection', socket => {

    console.log(`connected ${socket.id}`)
    socket.emit('connected', 'user connect')

    socket.on('events', data => {

        console.log(data);
        
    });

    socket.on('disconnect', function () {
        console.log(`disconnected ${socket.id}`)
    })

});