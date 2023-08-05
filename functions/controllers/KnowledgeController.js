//const db = require('./db');
const {Category, Quiz} = require('../models/Quiz');


const getAllCategories = async (req, res)=>{

    const categories = await Category.find({});
    const result = {};
    categories.forEach( cat=>{
      if(cat.categoryId == cat.topCategoryId){
         result[cat.topCategoryId] = {};
         result[cat.topCategoryId].name= cat.name;
         result[cat.topCategoryId].Id = cat.categoryId;
         result[cat.topCategoryId].subcats = [];
         result[cat.topCategoryId].subids = [];
         result[cat.topCategoryId].subnames = [];
      }
    })
    categories.forEach( cat=>{
      if(cat.topCategoryId != cat.categoryId){
         result[cat.topCategoryId].subcats.push(cat.name);
         result[cat.topCategoryId].subids.push(cat.categoryId);
         result[cat.topCategoryId].subnames.push(cat.name);
      }
    })
    console.log(result);
    res.json(result);
};
  
const getQuestions = async (req, res)=>{
  // console.log(`============ getQuestions received ======================= keys: ${Object.keys(req.body)}, req.body.questionIdOnly:${req.body.questionIdOnly}`)
  var select_condition={};
  if(!req.body.allCategories){
    console.log(`req.body.selectedCategoryIds: ${req.body.selectedCategoryIds}`);
    select_condition['categoryId'] = req.body.selectedCategoryIds;
  }
  let projection = {'questionId':1, '_id':0};
  if(req.body.questionIdOnly=="no"){
    projection.question = 1;
    projection.answer = 1;
    projection.categoryId = 1;

  }
  //console.log(`projection: ${JSON.stringify(projection)}, select_condition: ${JSON.stringify(select_condition)}`);

  Quiz.find(select_condition, projection).then((rows)=>{

    //res.json({result: JSON.parse(JSON.stringify(rows)), state: 'succeed'});
    if(req.body.questionIdOnly=="yes"){
      
      const ids=[];
      rows.forEach(q=>{
        ids.push(q.questionId);
      })
      res.json({state:"succeed", result: ids});
    }else{
      res.json({state: 'succeed', result: rows});
    }

  })

};
const getOneQuiz = async (req, res)=>{
  // console.log(`================ get one quiz ================================questionid: ${req.body.questionId}`)
   const questionId = req.body.questionId;
   const quiz = await Quiz.findOne({'questionId': questionId});
   res.json({result: quiz});
};
const updateAddQuestion=async(req, res)=>{
  // console.log("updateadd question received ==============");
  // data: { sqlmode: sqlmode, number: number, category: category, question: question, answer: answer, detail: detail },
  if(req.body.sqlmode=='insert'){
    let last_quiz = (await Quiz.find({}).sort({questionId: -1}).limit(1))[0];
    // console.log(`last_quiz: ${last_quiz}`);
    
      let quiz = new Quiz({
        questionId: last_quiz.questionId+1,
        categoryId: req.body.category,
        question: req.body.question,
        answer: req.body.answer,
        detail: req.body.detail
    })
    quiz.save().then(resp=>{
        console.log(`quiz saved`);
        res.json({result:"succeed"});
    })
  }else{
    // console.log("============== update  question");
    updatedQuiz={
      categoryId: req.body.category,
      question: req.body.question,
      answer: req.body.answer,
      detail: req.body.detail
    }
    let quiz2=await Quiz.findOneAndUpdate({questionId: req.body.questionId}, updatedQuiz);
    res.json({result:"succeed"});
  }
}
const generalQuery= async (req, res)=>{
    const a = {
      state: "succeed",
      result: [],
    };
    const queryString = req.body.queryString;
    const columnSets = req.body.columnSets;
    // db.each(queryString, (err, row) => {
    //   // console.log(row.id + ": " + row.info);
    //   columnSets.forEach((col)=>{
    //     a.result.push(row[col]);
    //   });
    // }, ()=>{
    //   res.json(a);
    // } );
};
module.exports={ getAllCategories, getQuestions, getOneQuiz,  updateAddQuestion, generalQuery};