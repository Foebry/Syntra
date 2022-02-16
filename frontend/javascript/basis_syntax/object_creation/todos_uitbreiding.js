const input = require("readline-sync");


function valid_lists(str) {
	if (my_todo_lists.length == 0) {
		console.log("Je hebt nog geen todo-lijstje aangemaakt. Maak eerst een todo-lijstje aan vooraleer je", str);
		return false;
	}
	return true;
}

function checkName(msg) {
	let name;
	let error = "";
	const min_length = 4;

	while (true) {
		name = input.question(`${error}${msg}`);
		if (name.length < min_length) {
			error = `De opgegeven naam moet minstens ${min_length} characters lang zijn. `;
			continue;
		}
		return name;
	}
}


class TodoList {
	constructor(name) {
		console.clear();
		this.name = name;
		this.items = [];
		console.log(`De todo-lijst "${this.name}" werd aangemaakt.\n`);
	}
	add(item) {
		console.clear();
		this.items.push(item);
		console.log(`${item} werd toegevoegd aan ${this.name}`);
	}
	list() {
		if (this.items.length == 0) {
			console.log(`${this.name} is nog leeg. Begin met items toe te voegen`);
			return;
		}
		console.log(`\n${this.name} bevat volgende items: `);
		this.items.forEach((el, i) => console.log(`\t${i+1}. ${el}`));
	}
	remove(item) {
		console.clear();
		this.items = this.items.filter(el => el !== item);
		console.log(`${item} werd verwijderd uit ${this.name}\n`);
	}
	empty() {
		console.clear();
		this.items.length = 0;
		console.log(`${this.name} werd leeg gemaakt.\n`)
	}
	countItems() {
		console.clear();
		return this.items.length;
	}
}


const my_todo_lists = [];
let options = ["nieuwe lijst aanmaken", "item aan lijst toevoegen", "alle items uit lijst tonen", "item uit lijst verwijderen", "lijst leegmaken", "aantal items in lijst weergeven", "alle lijstjes weergeven"];
let keuze;
let lijst;
let name;


while (keuze !== false) {
	const list_names = my_todo_lists.filter(el => el).map(el => el.name);
	keuze = input.keyInSelect(options, "Wat wil je doen? ");

	switch (keuze) {
		// CANCEL
		case -1:
			console.log("Tot de volgende keer!");
			keuze = false;
			break;

		case 0:
			console.clear();
			// nieuwe lijst aanmaken
			name = checkName("Geef een naam voor je nieuwe todo-lijst. ");
			my_todo_lists.push(new TodoList(name));
			break;


		case 1:
			// item aan lijst toevoegen
			let valid_name = false;
			console.clear();
			if (!valid_lists("items kan toevoegen")) break;

			lijst = my_todo_lists[input.keyInSelect(list_names, "Aan welke lijst wil je een item toevoegen? ")];
			if (!lijst) {
				console.clear();
				break;
			}

			name = checkName(`Geef een naam voor het item dat je wil toevoegen aan ${lijst.name}: `);
			lijst.add(name);
			break;

		case 2:
			//alle items uit lijst tonen
			console.clear();
			if (!valid_lists("de verschillende items kan opvragen.")) break;

			lijst = my_todo_lists[input.keyInSelect(list_names, "Van welke lijst wil je de items opvragen? ")];
			if (!lijst) {
				console.clear();
				break
			};
			console.clear();
			lijst.list();
			break;

		case 3:
			//item uit lijst verwijderen
			console.clear();
			if (!valid_lists("items uit een lijst kan verwijderen.")) break;

			lijst = my_todo_lists[input.keyInSelect(list_names, "Van welke lijst wil je een item verwijderen? ")];
			if (!lijst) {
				console.clear();
				break
			};

			item = input.keyInSelect(lijst.items, `Welke item wil je verwijderen uit ${lijst.name} ?`);
			lijst.remove(lijst.items[item]);

			break;

		case 4:
			console.clear();
			if (!valid_lists("items uit een lijst kan verwijderen.")) break;

			lijst = my_todo_lists[input.keyInSelect(list_names, "Welke lijst wil je leeg maken? ")];
			if (!lijst) {
				console.clear();
				break;
			}

			lijst.empty();

			break;

		case 5:
			//aantal items in lijst weergeven
			console.clear();
			if (!valid_lists("items uit een lijst kan verwijderen.")) break;

			lijst = my_todo_lists[input.keyInSelect(list_names, "Van welke lijst wil je het aantal items opvragen? ")];
			if (!lijst) {
				console.clear();
				break;
			}

			console.clear();
			console.log(`${lijst.name} bevat ${lijst.items.length} item(s).\n`);
			break;

		case 6:
			console.clear();
			my_todo_lists.forEach(el => el.list());
	}

}