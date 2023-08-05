require('dotenv').config();

const mongoose = require('mongoose');
const password=process.env.MONGODB_USER_PASSWORD;
const dbName = process.env.MONGODB_DBNAME;
const db_url = `mongodb+srv://bguo:${encodeURIComponent(password)}@cluster0.8x2gj.mongodb.net/${dbName}?retryWrites=true&w=majority`;
console.log(` db url: ${db_url}`);
const db = (async () => {
    try {
        await mongoose.connect(
            //"mongodb://localhost:27017/node-blog", 
            db_url,
            {
            useNewUrlParser: true,
            useUnifiedTopology: true,
        });
        console.log("Database connected!");
    } catch (error){
        console.log(error);
    }
})();

module.exports = {db, db_url};