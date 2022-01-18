const {
	uniqueNamesGenerator,
	names,
} = require('unique-names-generator');

class Person {
	constructor(name, pet_name) {
		this.name = name;
		this.pet = pet_name;
	}
}
console.log("Dit zijn de namen van de huisdieren van onze mensen:");
const people = new Array(5).fill("").map(el => new Person(uniqueNamesGenerator({
	dictionaries: [names],
	length: 1
}), uniqueNamesGenerator({
	dictionaries: [names],
	length: 1
}))).forEach(el => console.log(`\t${el.name} heeft een huisdier genaamd ${el.pet}`));