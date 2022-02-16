import Fly from "./Fly.js";
const {
	uniqueNamesGenerator,
	animals,
	names
} = require('unique-names-generator');


class Animal {
	#name;
	#age;
	#isDomestic;
	#killList;
	#type;
	constructor(name) {
		this.#name = uniqueNamesGenerator({
			dictionaries: [names],
			length: 1
		});
		this.#type = uniqueNamesGenerator({
			dictionaries: [animals],
			length: 1
		});
		this.#age = Math.ceil(Math.random() * 13);
		this.#isDomestic = Boolean(Math.round(Math.random()));
		this.#killList = [];
	}
	#catchFlies(amount) {
		while (amount--) {
			this.#killList.push(new Fly());
		}
	};
	#makeOlder() {
		this.#age++;
	}
	toString() {
		return `${this.#name} is een ${this.#isDomestic ? "gedomesticeerde" : "wilde"} ${this.type} van ${this.age} jaar oud.`
	}
	static printAnimals(arr) {
		console.log("Dit zijn mijn animals:");
		arr.forEach(animalObj => console.log(`\t${animalObj.toString()}`))
	}
	static getOldest(arr) {
		return arr.reduce((oldest, AnimalObj) => AnimalObj.#age > oldest.#age ? AnimalObj : oldest, {
			#age: 0
		});
	}
	static printKillCounts(arr) {
		console.log("\nDit zijn de kill counts:");
		arr.forEach(animalObj => console.log(`\tVan de ${animalObj.#killList.length} vliegen gevangen door ${animalObj.#name} zijn er ${animalObj.#getNumFLiesKilled.length} gedood.`))
	}
}

export default Animal;