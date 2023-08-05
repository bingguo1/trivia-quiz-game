const sqlite3 = require("sqlite3");
const dbname="db/bgDatabase_triviaQuiz_sqlite3.db";
const db = new sqlite3.Database(dbname, (err) => {
  if (err) {
    console.log("Getting error " + err);
  }
});

module.exports = db;
