//1. Write a JavaScript function that returns an array with generated  Multiplication Table of a given number (max. 1000 iterations)
let table = [];

function generateMultiplicationTable(number) {
	//return [ i*number for i in range(1000)]
	for (i = 0; i < 1000; i++) {
		table.push((i * number).toString());
	}
	return table;
}
var result = generateMultiplicationTable(5);
console.log("oefening 1")
console.log(result);
console.log("-------------------------------------------------------------------------------------");

//2. extension of first challenge:
//Every time a value in the array is divisible by 20 add an (asterisk)* to it
table.forEach((item, i) => {
	if (item % 20 == 0) {
		table[i] = table[i].toString() + "*";
	}
});
console.log("oefening 2")
console.log(table);
console.log("-------------------------------------------------------------------------------------");

//3. Write a Javascript function to return wether a value is divisible by a certain number
function isDivisible(number, divisor) {
	return number % divisor == 0;
}
console.log("oefening 3")
console.log(isDivisible(333, 7)); //=> false
console.log("-------------------------------------------------------------------------------------");

//4. Write a Javascript function that return an array with even numbers between a range
function getEvenNumbersInRange(start, end) {
	// return [i for i in range(start, end) if i%2 == 0]
	let lst = [];
	for (i = start; i < end; i++) {
		if (i % 2 == 0) lst.push(i);
	}
	return lst;
}
console.log("oefening 4")
console.log(getEvenNumbersInRange(56, 1211));
console.log("-------------------------------------------------------------------------------------");

//5. Write a Javascript function that calculate the distance between two coordinates.
function getDistance(p1, p2) {
	return Math.sqrt((p2[0] - p1[0]) ** 2 + (p2[1] - p1[1]) ** 2);
}
console.log("oefening 5")
console.log(getDistance([20, 100], [50, 800]));
console.log(getDistance([0, 0], [7.2, 5]))
console.log("-------------------------------------------------------------------------------------");