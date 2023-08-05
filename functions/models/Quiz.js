const mongoose  = require('mongoose');


const Schema = mongoose.Schema;
const CategorySchema=new Schema({
    categoryId:{
        type: Number,
        required: true,
        unique: true,
    },
    topCategoryId:{
        type: Number,
        required: true
    },
    name:{
        type: String,
        required: true,
    },
    description:{
        type: String
    }
});
const Category = mongoose.model('Category', CategorySchema);

const QuizSchema= new Schema({
    questionId:{
        type: Number,
        required: true,
    },
    categoryId:{
        type:Number,
        required: true,
    },
    question:{
        type:String,
        required: true,

    },
    answer:{
        type:String,
        // required: true,
    },
    detail:{
        type:String,
    }
})
const Quiz = mongoose.model("Quiz", QuizSchema);
module.exports = { Category, Quiz};

