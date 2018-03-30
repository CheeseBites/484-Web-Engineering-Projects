const express = require('express');
const app = express();
var path = require('path');
app.get('/', (req, res) => res.send('Hello World!'));
app.listen(3000, () => console.log('Example app listening on port 3000!'));

app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.get('/1', (req, res) => {
   res.sendFile(__dirname + '/1.html');
});
app.get('/2', (req, res) => {
   res.sendFile(__dirname + '/2.html');
});
app.get('/3', (req, res) => {
   res.sendFile(__dirname + '/3.html');
});
app.get('/4', (req, res) => {
   res.sendFile(__dirname + '/4.html');
});
app.get('/5', (req, res) => {
   res.sendFile(__dirname + '/5.html');
});

app.get('/move', function(req,res){
    res.redirect('/3');
})

app.use(express.static(path.join(__dirname, '/41')));
app.use(express.static(path.join(__dirname, '/42')));
app.use('/img', express.static(path.join(__dirname, '/43')))

app.get('/ree', (req, res) => {
   res.render('index', {'title': 'Home', 'message': 'Welcome to the index'});
});

