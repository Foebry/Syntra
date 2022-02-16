const axios = require("axios");

const promise_1 = axios("https://www.thecocktaildb.com/api/json/v1/1/random.php");
const promise_2 = new Promise(function(resolve, reject) {
	resolve("antwoord van promise_2");
});
const promise_3 = new Promise(function(resolve, reject) {
	setInterval(function() {
		resolve("antwoord van promise_3")
	}, 3000)
})

Promise.all([promise_1, promise_2, promise_3]).then(data => console.log(data.map(el => el.data ? el.data.drinks[0].strDrink : el)))