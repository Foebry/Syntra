import Fly from "./components/Fly.js";
import Animal from "./components/Animal.js";


// bepalen hoeveel vliegen ieder dier zal vangen tussen 0 en 100
const amount_of_flies = Math.round(Math.random() * 100);

// dieren aanmaken
const my_animals = new Array(3).fill(0).map(el => new Animal());


my_animals.forEach(el => el.#catchFlies(amount_of_flies));
Animal.printAnimals(my_animals);
console.log(`${Animal.getOldest(my_animals).#name} is de oudste`);
Animal.printKillCounts(my_animals);

console.log(`\n${my_animals.reduce((prev, el) => {
	return el.killList.filter(fly => fly.survived).length < prev.killList.filter(fly => fly.survived).length ? el : prev
}, {
	deathkill: new Array(amount_of_flies+1).fill(0).map(el => new Fly(true))
}).name} heeft effectief de meeste vliegen gevangen`);