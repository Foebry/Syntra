const xmlhttprequest = require("xmlhttprequest").xmlhttprequest;

const test = () => {
	return new Promise((resolve, reject) => {
		setTimeout(() => {
			resolve("promise ok!")
		}, 2000)
	})
}

response = test().then(data => console.log(data));