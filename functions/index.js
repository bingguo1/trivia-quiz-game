const functions = require("firebase-functions");
const express = require("express");
const app = express();
const cors = require('cors');
// app.use(express.static('../trivia-quiz-game'));
const {db, db_url} = require('./db');

const session = require("express-session");
const MemoryStore = require('memorystore')(session);
const cookieParser = require("cookie-parser");
// const PORT = 8080;

// const corsOptions = {
//     origin: 'http://localhost:5000',  //Your Client, do not write '*'
//     credentials: true,
// };
// app.use(cors(corsOptions));

app.use(cookieParser());
app.use(session({
    cookie: { maxAge: 86400000 },
    secret: "thisissecretkey",
    store: new MemoryStore({
        checkPeriod: 86400000 // prune expired entries every 24h
      }),
    resave: false,
    saveUninitialized: false
}));

app.use(express.urlencoded({extended: true}));
app.use(express.json());


const {register, loginUser, logoutUser, authenticateUser}  = require('./controllers/UserController');
const { getAllCategories, getQuestions, getOneQuiz, updateAddQuestion, generalQuery} = require('./controllers/KnowledgeController');


app.post("/getAllCategories", getAllCategories);
app.post("/asknode", generalQuery);


app.post("/checkSignined", authenticateUser);
app.post("/register", register);
app.post("/signin", loginUser);
app.post("/logout", logoutUser);
app.post("/getQuestions", getQuestions);
app.post("/getOneQuiz", getOneQuiz);
app.post("/updateAddQuestion", updateAddQuestion);



// app.listen(PORT, () => {
//     console.log(`App listening on port ${PORT}`);
// });
exports.app = functions.https.onRequest(app);
