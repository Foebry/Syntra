const randomcolor = require("randomcolor");
const readline = require("readline-sync");

//const kleuren = new Array(10).fill(0).map(el => randomcolor());
//console.log(kleuren);

const aantal_kleuren = readline.question("Hoeveel kleuren wil je genereren?");
const kleuren = randomcolor({
	count: parseInt(aantal_kleuren, 10),
	hue: "green"
})
console.log(kleuren);