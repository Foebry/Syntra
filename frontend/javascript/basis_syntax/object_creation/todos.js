// oldschool prototype syntax
function Todo(name, items = []) {
	this.name = name;
	this.items = items;
}
Todo.prototype.add = function(item) {
	this.items.push(item);
};
Todo.prototype.list = function() {
	this.items.forEach(console.log);
};

Todo.prototype.remove = function(el) {
	this.items = this.list.filter(curr => curr !== el);
};
Todo.prototype.empty = function() {
	this.items.length = 0;
};
Todo.prototype.countItems = function() {
	return this.items.length;
};

const todos = new Todo("groepswerk");





// class syntax
/*class Todo {
	constructor(name, items = []) {
		this.name = name;
		this.items = items;
	}
	add(item) {
		this.items.push(item);
	}
	list() {
		this.items.forEach((el, i) => {
			console.log(`${i+1}: ${el}`);
		});
	}
	remove(el) {
		const index = this.items.indexOf(el);
		this.items.splice(index, 1);
	}
	empty() {
		this.items.length = 0;
	}
	countItems() {
		return this.items.length;
	}
}
const todos = new Todo("groepswerk");*/


console.log(todos);
todos.list();
todos.add("presentatie voorbereiden");
console.log("\n");
todos.list();
console.log("\n");
todos.add("naam bedenken");
todos.list();
console.log("\n");
console.log(todos.countItems());
console.log("\n");
todos.remove("presentatie voorbereiden");
todos.list();
console.log("\n");
todos.add("paper uitschrijven");
todos.list();
console.log("lijst leegmaken");
todos.empty();
todos.list();