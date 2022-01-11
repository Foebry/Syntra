//1. Write a JavaScript function that returns an array with generated  Multiplication Table of a given number (max. 1000 iterations)

const generateMultiplicationTable = (number) => new Array(1000).fill(0)
	.map((item, i) => (i * number))
	.map((item) => (item != 0 && item % 20 == 0) ? item + "*" : item.toString());

console.log("oefening 1 en 2")
console.log(generateMultiplicationTable(5));
console.log("-------------------------------------------------------------------------------------");


//3. Write a Javascript function to return wether a value is divisible by a certain number
const isDivisible = (number, divisor) => number % divisor == 0;

console.log("oefening 3")
console.log(isDivisible(333, 7)); //=> false
console.log("-------------------------------------------------------------------------------------");

//4. Write a Javascript function that return an array with even numbers between a range
const getEvenNumbersInRange = (start, end) => new Array(end - start).fill(0).map((el, i) => start + i).filter(el => el % 2 == 0);

console.log("oefening 4")
console.log(getEvenNumbersInRange(56, 1211));
console.log("-------------------------------------------------------------------------------------");

//5. Write a Javascript function that calculate the distance between two coordinates.
const getDistance = (p1, p2) => Math.sqrt((p2[0] - p1[0]) ** 2 + (p2[1] - p1[1]) ** 2);

console.log("oefening 5")
console.log(getDistance([20, 100], [50, 800])); //700.6425622241344
console.log(getDistance([0, 0], [7.2, 5])); //8.765842800324451
console.log("-------------------------------------------------------------------------------------");