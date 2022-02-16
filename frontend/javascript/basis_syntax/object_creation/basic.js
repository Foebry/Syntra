const person = {
	name: "Sander",
	age: 30,
	hobbies: [
		"lopen",
		"coding"
	]
};

console.log(person);

for (prop in person) {
	console.log(prop, person[prop]);
}