const fs = require("fs");
const path = require("path");
const folder = `./${process.argv[2]}`;
const files = fs.readdirSync(folder);
console.time();
let words = "";

files.forEach((file) => {
	let content = fs.readFileSync(path.join(folder, file), "utf-8");
	words += content;

});

words = words.trim()
	.toLowerCase()
	.replace(/[0-9:,->?'"!().&`�\n\r]/g, " ")
	.replace(/(color)/g, " ")
	.replace(/(font)/g, " ")
	.replace(/(ff)/g, " ")
	.replace(/  +/g, " ")
	.split(" ")
	.filter((word) => word.length >= 5)
	.reduce(function(obj, word) {
		obj[word] = obj[word] + 1 || 1
		return obj;
	}, {});

console.log(words);
console.log(Object.keys(words).sort(function(a, b) {
	return (words[b] - words[a]);
}));
console.timeEnd();
//console.log(Object.keys(words).length);