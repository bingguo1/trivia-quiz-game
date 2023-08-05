// result={};
// result[1]={};
// result[1].topcat=1;
// result[1].subcats=[5];
// result[1].subids=[5];


// result[1].subcats.push(1);
// console.log(result[1]);

// a=[];
// a.push(1);
// console.log(a);

// 0\

THRESHOLD_A = 5;
let promise = new Promise(
    function(resolve, reject) 
    { setTimeout(() => { 
        const randomInt = Date.now(); 
        const value = randomInt % 10; 
        if (value < THRESHOLD_A) 
        { resolve(value); } 
        else { reject(`Too large: ${value}`); 
    } }, 500); 
});

promise.then(
    (result) => { 
       console.log(result);
    },
    (error) => { 
       console.log(error);
    }
  );

  promise.then(
    (result) => { 
        console.log(result);
    }
  );
  promise.then(
    null,
    (error) => { 
        console.log(error)
    }
  );
  