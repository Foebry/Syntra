class Cart {
	constructor() {
		this.items = [];
	}
	addItem(item) {
		this.items.push(item);
		return this;
	}
	removeItem(id) {
		this.items = this.items.filter(el => el.id != id);
	}
	getAmountItems() {
		return this.items.length;
	}
	getTotalAmountItems() {
		return this.items.reduce((sum, el) => sum + el.amount, 0);
	}
	getTotalCost() {
		return this.items.reduce((prod, el) => prod + el.price * el.amount, 0);
	}
}

class CartItem {
	constructor(id, title, price, amount) {
		this.id = id;
		this.title = title;
		this.price = price;
		this.amount = amount;
	}
}


const cart = new Cart();

// 3 appels elk 0.59 euro.
const appels = new CartItem("1", "appel", 0.59, 3);
// 5 bananen elke 0.81
const bananen = new CartItem("2", "banaan", 0.81, 5)

cart.addItem(appels)
	.addItem(bananen);

console.log(cart.getAmountItems()); // 2
console.log(cart.getTotalAmountItems()); // 8
console.log(cart.getTotalCost()); // 5.82

cart.removeItem("2"); // bananen verwijderd

console.log(cart.getAmountItems()); // 1
console.log(cart.getTotalAmountItems()); //3
console.log(cart.getTotalCost()); // 1.77