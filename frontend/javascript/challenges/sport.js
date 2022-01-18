sports = require("./sporten.json")

sporten = new Array(Object.keys(sports).length - 1).fill(0).map((el, i) => sports[Object.keys(sports)[i]]).reduce((lst, el) => {
	return [...lst, ...el]
}, [])




class Sport {
	constructor(name) {
		this.name = name;
		this.isOlympic = sports["olympische_sporten"].includes(this.name);
		this.isBallsport = sports["balsport"].includes(this.name);
	}
}

mijn_sporten = new Array(8).fill(0).map(el => new Sport(sporten[Math.round(Math.random() * sporten.length)]))

console.log("Dit zijn mijn gekozen sporten:")
mijn_sporten.forEach(el => console.log(`\t ${el.name}`));

console.log(`\nHiervan zijn er ${mijn_sporten.reduce((sum, el)=>el.isBallsport ? sum + 1 : sum, 0)} een balsport:`)
mijn_sporten.filter(el => el.isBallsport).forEach(el => console.log(`\t${el.name}`))

console.log(`\nEn zijn er ${
				mijn_sporten.reduce((sum, el) => {
					return el.isOlympic ? sum + 1 : sum
				}, 0)
			} een Olympische sport:`);
mijn_sporten.filter(el => el.isOlympic).forEach(el => console.log(`\t${el.name}`))