const {Category, Quiz} = require('./Quiz');
const {db, db_url} = require('../db');
const mongoose = require('mongoose');
const sqlite3 = require('sqlite3').verbose();
const sqlitedb = new sqlite3.Database('../db/bgDatabase_triviaQuiz_sqlite3.db');



console.log(`url : ${db_url}`);
catnames= [
    "history",
    "world history",
    "china history",
    "history timeline",
    "greek myths",
    "astronomy",
    "physics",
    "computer",
    "algorithms and database",
    "machineLearning",
    "politicsEconomy",
    "economy",
    "health",
    "biology",
    "geography",
    "english",
];
ids=[1, 101, 102, 103, 104, 2, 3, 4, 401, 405, 5, 501, 6, 7, 8, 9];
topids=[1,1,1,1,1, 2,3,4,4,4,5,5,6,7,8,9]

async function runme(){
    
    await db();
    for(let i=0;i<catnames.length;i++){
        let cat = new Category({
            categoryId: ids[i],
            topCategoryId: topids[i],
            name: catnames[i],
        });
        console.log(cat);
        cat.save().then(res=>{
            console.log(`${i} saved`);
        })
    }
    // mongoose.connection.close();
};
var count=0;

async function runme2(){
    
    await db();
    sqlitedb.each("SELECT * FROM tbquiz", (err, row) => {
        count+=1;
        console.log(row.number);
        var cid = row.category;
        if(row.category%100==0){
            cid=row.category/100;
        }
        let quiz = new Quiz({
            questionId: row.number,
            categoryId: cid,
            question: row.question,
            answer: row.answer,
            detail: row.detail
        })
        quiz.save().then(res=>{
            console.log(`${row.number} saved`);
        })
        // if(count>3){
        //     console.log("exit now");
        //     process.exit(0);
        // }
    });
};

runme2();


    
// }