class Circle {
	constructor(name, holder) {
		this.name = name;
		this.holder = holder;
		this.x = Math.floor(Math.random() * 1000);
		this.y = Math.floor(Math.random() * 1000);
		this.htmlRef = this.generateInitialHTML();
		this.setStyling();
		this.setUpEvents();
	}
	generateInitialHTML() {
		this.holder.insertAdjacentHTML("beforeend", `<div class="circle"></div>`);
		return this.holder.querySelector(".circle:last-child");
	}
	setStyling() {
		this.htmlRef.style.left = this.x + "px";
		this.htmlRef.style.top = this.y + "px";
	}
	setUpEvents() {
		this.htmlRef.onclick = () => {
			this.x = Math.floor(Math.random() * 1000);
			this.y = Math.floor(Math.random() * 1000);
			this.setStyling();
		}
	}
}

let nr_of_circles = 5;
const all_circles = [];
const holder = document.querySelector("body");
while (nr_of_circles--) {
	all_circles.push(new Circle(Math.random().toString(36).substr(2), holder));
}