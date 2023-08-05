const bcrypt = require('bcrypt');
const User = require("../models/User");

const register = async (req, res) => {
    console.log("========= received register=========== ");
    console.log(` body: ${Object.keys(req.body)}, username: ${req.body.username}`);
    
    User.create(req.body)
    .then((result) => {
        console.log("create user account succeeded !");
        res.json({result:"succeed"});
    })
    .catch((err) => {
        console.log(err);
        res.json({result:"fail", error: err});
    });
};


const loginUser = async (req, res) =>{
    try{
        const {username, password} = req.body;
        // console.log(` request body keys: ${Object.keys(req.body)}, req.body.email: ${req.body.email}, req keys: ${Object.keys(req)}`);
        // console.log(`log in user now, look for email: ${email}`);
        const user = await User.findOne({username});
        if (user){
            const result = await bcrypt.compare(password, user.password);
            if (result){
                req.session.userId = user._id;
                console.log("password match, logging in");
                res.json({result: "succeed"});
            }else{
                console.log("wrong password, refresh to same page");
                res.json({result:"wrong_password"});
            }
        }else{
            res.json({result:"no_such_username"});
        }
    }catch(error){
        console.log(error);
        res.json({result:"error", message: error});
    }
};

const logoutUser = (req, res) =>{
    try{
        req.session.destroy(()=>{
            console.log("sessioni distroyed ======");
            res.json({result:"succeed"});
        });
    }catch(err){
        console.log(err);
        res.json({result:"fail"});
    }
    
}

const authenticateUser = async (req, res)=>{
    if (req.session && req.session.userId) { 
        // Get the user using the session.
        const user = await User.findById(req.session.userId);
        if(user){
            console.log("user authenticated");
            res.json({result:"succeed", username: user.username});
        }else{
            console.log("user have userid in cookie but cannot find userid from db, destroy session");
            req.session.destroy();
            res.json({result: "fail", message:"have no such user"});
        }
        
    } else {
        // if(req.session){
        //     console.log(`still have session: ${req.session.cookie._expires}`)
        // }
        console.log("no userid in user cookie, return fail");
        // Redirect to the login page
        res.json({result: "fail", message:"have no userid in cookie"});
    }
}
module.exports = {
    register, loginUser, logoutUser, authenticateUser
};



