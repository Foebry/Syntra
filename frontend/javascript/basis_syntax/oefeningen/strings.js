//1- Write a JavaScript function to check whether a string is blank or not.
function is_Blank(str) {
	return str == "";
}
console.log("oefening 1")
console.log(is_Blank('')); //= true
console.log(is_Blank('abc')); //= false
console.log("---------------------------------------------------------------------------------------")

//2- Write a JavaScript function to hide email addresses to protect from unauthorized user.
function protect_email(email) {
	return email.replace(email.substring(Math.floor(email.indexOf("@") / 2), email.indexOf("@")), "...");
}

console.log("oefening 2")
console.log(protect_email("robin_singh@example.com")); //robin...@example.com
console.log(protect_email("g@"))
console.log("---------------------------------------------------------------------------------------")


//3- Write a JavaScript function to insert a string within a string at a particular position (default is 1).
function insert(str, substr = "", pos = 0) {
	return `${str.substring(0, pos)}${substr}${str.substr(pos)}`;
}

console.log("oefening 3")
console.log(insert('We are doing some exercises.')); //= We are doing some exercises.
console.log(insert('We are doing some exercises.', 'JavaScript ')); //= JavaScript We are doing some exercises.
console.log(insert('We are doing some exercises.', 'JavaScript ', 18)); //= We are doing some JavaScript exercises.
console.log("---------------------------------------------------------------------------------------")


//4- Write a JavaScript function to chop a string into chunks of a given length.
function string_chop(str, len = 0) {
	// return [[i:min(len(str),i+len)] for i in range(len(str), len)] if len > 0 else [str]
	if (len == 0) return [str];
	const arr = [];
	let i = 0;
	while (i < str.length) {
		arr.push(str.substr(i, len));
		i += len;
	}
	return arr;
}

console.log("oefening 4")
console.log(string_chop('w3resource')); //= [w3resource]
console.log(string_chop('w3resource', 2)); // = [w3, re, so, ur, ce]
console.log(string_chop('w3resource', 3)); //= [w3r, eso, urc, e]
console.log("---------------------------------------------------------------------------------------")


//5- Write a JavaScript function to truncate a string to a certain length.
function truncate_string(str, pos) {
	return str.substring(0, pos);
}
console.log("oefening 5")
console.log(truncate_string("Robin Singh", 4)); //= Robi
console.log("---------------------------------------------------------------------------------------")


//6- Write a JavaScript function to test whether the character at the provided (character) index is lower case.
function isLowerCaseAt(str, pos) {
	return str[pos] == str[pos].toLowerCase();
}
console.log("oefening 6")
console.log(isLowerCaseAt('Js STRING EXERCISES', 1)); //= true
console.log("---------------------------------------------------------------------------------------")


//7- Write a JavaScript function to test whether a string ends with a specified string.
function endsWith(str, substr) {
	return str.split(" ")[str.split(" ").length - 1] == substr;
}
console.log("oefening 7")
console.log(endsWith('JS string exercises', 'exercises')); //= true
console.log("---------------------------------------------------------------------------------------")


//8- Write a JavaScript function to get unique guid (an acronym for 'Globally Unique Identifier) of the specified length, or 32 by default.
const options = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];

function guid(length = 32) {
	//return "".join([options[random.randrange(len(options)) for _ in range(length)])
	let str = "";
	for (i = 0; i < length; i++) {
		str += options[Math.floor(Math.random() * options.length)];
	}
	return str;
}
console.log("oefening 8")
console.log(guid()); //= hRYilcoV7ajokxsYFl1dba41AyE0rUQR
console.log(guid(15)); //= b7pwBqrZwqaDrex
console.log("---------------------------------------------------------------------------------------")