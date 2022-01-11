//1. Write a JavaScript function to check if a certain word is a Palindrome.
function isPalindrome(word) {
	return word == word.split("").reverse().join("");
}
console.log(isPalindrome("ene")); //true
console.log(isPalindrome("een")); //false
console.log("-------------------------------------------------------------------------------------");

//2. Write a JavaScript function to get a random item from an array.
function getRandomItem(arr) {
	return arr[Math.round(Math.random() * (arr.length - 1))];
}
console.log(getRandomItem(["Dit", "is", "een", "test"]));
console.log("-------------------------------------------------------------------------------------");

//3. Write a JavaScript program which accept a string as input and swap the case ofeach character.
//For example if you input 'The Quick Brown Fox' the output should be 'tHE qUICK bROWN fOX'.
function swapCase(str) {
	arr = str.split("");
	arr.forEach((item, i) => {
		if (item == item.toLowerCase()) {
			arr[i] = item.toUpperCase();
		} else {
			arr[i] = item.toLowerCase();
		}
	});
	return arr.join("");

}
console.log("BoOYAa")
console.log(swapCase("BoOYAa"));
console.log("-------------------------------------------------------------------------------------");

//4. Write a JavaScript function to compute the sum of an array of integers.
function totalSum(arr) {
	return arr.reduce((prev, curr) => {
		return prev + curr;
	}, 0);
}
console.log(totalSum([1, 2, 3, 4, 5, 6, 7, 8, 9])); //45
console.log("-------------------------------------------------------------------------------------");
//5. Write a JavaScript function to remove a specific element from an array
let myNames = ["John", "Cindy", "Omer", "Barbie", "Barbie"];

function removeSpecificelement(array, name) {
	return array.filter(el => el != name);
}
console.log(removeSpecificelement(myNames, "Barbie")); //["John", "Cindy", "Omer"]
console.log("-------------------------------------------------------------------------------------");

//6. Write a function to remove all strings with less than X characters from an array of strings

function removeStrings(arr, len) {
	return arr.filter(el => el.length >= len);
};
console.log(removeStrings(["Dit", "is", "een", "test"], 3)); //["Dit", "een", "test"]
console.log("-------------------------------------------------------------------------------------");

//7. Write a JavaScript function to generate an array with the first X Fibonacci numbers.
function fib(n, numbers) {
	if (n in numbers) return numbers[n];
	if (n == 0 || n == 1) return 1;
	numbers[n] = fib(n - 1, numbers) + fib(n - 2, numbers);
	return numbers[n];
}

function getFibNumbers(n, numbers = {}) {
	let arr = [];
	for (i = 0; i < n; i++) {
		arr.push(fib(i, numbers));
	}
	return arr;
}
console.log(getFibNumbers(10)); // [1, 1, 2, 3, 5, 8, 13, 21, 34, 55]
console.log(getFibNumbers(1000))
console.log("-------------------------------------------------------------------------------------");

//8. Write a JavaScript function that returns array elements larger than a number given:
var numbers = [5, 2, 20, 60, 45];
var toCheck = 6;

function arrayLargerNumber(arr, number) {
	return numbers.filter(el => el > number);
}

console.log(arrayLargerNumber(numbers, toCheck)); //[20, 60, 45]
console.log("-------------------------------------------------------------------------------------");

//9. Write a Javascript function to generate a random color in format rgb(0, 0, 0);
function generateRGBcolor() {
	arr = [];
	for (i = 0; i < 3; i++) {
		arr.push(Math.round(Math.random() * 255));
	}
	return `rgb(${arr[0]}, ${arr[1]}, ${arr[2]})`;
}
console.log(generateRGBcolor());
console.log("-------------------------------------------------------------------------------------");

//10. Write a JavaScript program to find the types of a given angle.Go to the editor Types of angles:
//Acute angle: An angle between 0 and 90 degrees.
//Right angle: An 90 degree angle.
//Obtuse angle: An angle between 90 and 180 degrees.
//Straight angle: A 180 degree angle.
function angleType(angle) {
	return angle > 180 ? angleType(angle - 180) : angle == 180 ? "Straight angle" : angle > 90 ? "Obtuse angle" : angle == 90 ? "Right angle" : "Acute angle";
}

console.log(angleType(20)); //"Acute angle"
console.log(angleType(90)); //"Right angle"
console.log(angleType(125)); //"Obtuse angle"
console.log(angleType(180)); //"Straight angle"
console.log(angleType(225)); //"Acute angle"
console.log("-------------------------------------------------------------------------------------");

//11. Write a JavaScript function to merge two arrays and removes all duplicates elements.
function mergeArrays(arr1, arr2) {
	arr = [];
	arr1.forEach((item) => {
		if (!arr.includes(item)) arr.push(item)
	});
	arr2.forEach((item) => {
		if (!arr.includes(item)) arr.push(item)
	});
	return arr;


}
console.log(mergeArrays([1, 2, 3], [4, 5, 6])); //[1, 2, 3, 4, 5, 6]
console.log(mergeArrays([1, 2, 3], ["een", "twee", "drie"])) //[1, 2, 3, "een", "twee", "drie"]
console.log(mergeArrays([1, 2, 3], [1, 2, 3])) //[1, 2, 3]
console.log(mergeArrays([1, "twee", 3], [2, 3, "vier"])) //[1, "twee", 3, 2, "vier"]
console.log("-------------------------------------------------------------------------------------");

//12. given[2, 1, 6, 4]
//expected => [8, 1, 216, 64] => the power 3
function thirdPower(arr) {
	arr.forEach((item, i) => {
		arr[i] = item ** 3;
	});
	return arr;

}
console.log(thirdPower([2, 1, 6, 4])); //[8, 1, 216, 64]
console.log("-------------------------------------------------------------------------------------");

//13. given[2, 1, 6, 4]
//expected => [8, 1, 216, 64] => the power N
function nthPower(arr, n) {
	arr.forEach((item, i) => {
		arr[i] = item ** n;
	});
	return arr;
}
console.log(nthPower([2, 1, 6, 4], 16)); //[65536, 1, 2821109907456, 4294967296]
console.log("-------------------------------------------------------------------------------------");

//14. given[2, 1, 6, 4]
//calc avg
//calc sum(reduce)
function calcSum(arr) {
	return arr.reduce((prev, curr) => {
		return prev + curr;
	}, 0)
}

function calcAvg(arr) {
	return calcSum(arr) / arr.length;
}
console.log(calcSum([2, 1, 6, 4])); //13
console.log(calcAvg([2, 1, 6, 4])); //3.25
console.log("-------------------------------------------------------------------------------------");

//15. given["Ellen", "bert", "Bart", "zaki", "Sandra", "Soroush"]
//remove all the names that do not start with a capital

function removeUncapitaledNames(arr) {
	return arr.filter(el => el[0] == el[0].toUpperCase());
}
console.log(removeUncapitaledNames(["Ellen", "bert", "Bart", "zaki", "Sandra", "Soroush"])); //["Ellen", "Bart", "Sandra", "Soroush"]
console.log("-------------------------------------------------------------------------------------");

//16. Write a Javascript function to find how many times a certain number occurs in that array.
function countOccurences(arr, n) {
	return arr.reduce((prev, curr) => {
		if (curr == n) {
			return prev + 1;
		} else return prev;
	}, 0);

}
console.log(countOccurences([1, 1, 1, 1], 1)); //4
console.log(countOccurences([1, 1, 1, 1], 2)); //0
console.log(countOccurences([1, 2, 3, 4, 2], 2)); //2
console.log("-------------------------------------------------------------------------------------");

//17. Write a JavaScript program to find the most frequent item of an array.

function findMostFrequent(arr, item) {
	let most_freq = ["", 0];
	arr.forEach((item) => {
		const times = countOccurences(arr, item)
		if (times > most_freq[1]) {
			most_freq[0] = item;
			most_freq[1] = times;
		}
	});
	return most_freq[0];
}
console.log(findMostFrequent(["Dit", "is", "een", "test", "een", "test", "eene", "test"])); //"test"
console.log("-------------------------------------------------------------------------------------");