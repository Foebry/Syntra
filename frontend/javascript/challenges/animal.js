const {
	uniqueNamesGenerator,
	animals,
	names
} = require('unique-names-generator');


class Animal {
	constructor(name) {
		this.name = name;
		this.type = uniqueNamesGenerator({
			dictionaries: [animals],
			length: 1
		});
		this.age = Math.ceil(Math.random() * 13);
		this.isDomestic = Boolean(Math.round(Math.random()));
		this.deathkill = [];
	}
	catchFlies(amount) {
		for (let i = 0; i < amount; i++) {
			this.deathkill.push(new Fly());
		}
	};
	makeOlder() {
		this.age++;
	}
	toString() {
		return `${this.name} is een ${this.isDomestic ? "gedomesticeerde" : "wilde"} ${this.type} van ${this.age} jaar oud.`
	}
}

class Fly {
	constructor(survived = false) {
		this.id = Math.random().toString(16).substring(2);
		this.survived = survived || Boolean(Math.random() < 0.33333333333);
	}
}


// bepalen hoeveel vliegen ieder dier zal vangen tussen 0 en 100
amount_of_flies = Math.round(Math.random() * 100);


// dieren aanmaken
my_animals = new Array(3).fill(0).map(el => new Animal(uniqueNamesGenerator({
	dictionaries: [names],
	length: 1
})));

// dieren vliegen laten vangen
my_animals.forEach(el => {
	el.catchFlies(amount_of_flies)
});

console.log("Dit zijn mijn animals:");
my_animals.forEach(el => console.log(`\t${el.toString()}`))

const oldest_age = my_animals.reduce((age, el) => el.age > age ? el.age : age, 0)
console.log(`\n${my_animals.filter(el => el.age == oldest_age)[0].name} is de oudste`);

console.log("\nDit zijn de killcounts");
my_animals.forEach(el => console.log(`\tVan de ${el.deathkill.length} vliegen gevangen door ${el.name} zijn er ${el.deathkill.filter(fly=>fly.survived).length} ontsnapt.`))


console.log(`\n${my_animals.reduce((prev, el) => {
	return el.deathkill.filter(fly => fly.survived).length < prev.deathkill.filter(fly => fly.survived).length ? el : prev
}, {
	deathkill: new Array(amount_of_flies+1).fill(0).map(el => new Fly(true))
}).name} heeft effectief de meeste vliegen gevangen`);