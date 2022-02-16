class Rectangle {
	#x;
	#y;
	constructor(name, x, y, w, h) {
		this.name = name;
		this.#x = x;
		this.#y = y;
		this.width = w;
		this.height = h
	}
	getSurface() {
		return this.width * this.height;
	}
	get position() {
		return [this.#x, this.#y];
	}
	set position(position) {
		this.#x = position[0];
		this.#y = position[1];
	}
}

const rect1 = new Rectangle("r-001", 100, 200, 500, 300);
console.log(rect1.getSurface());
console.log(rect1.position);
rect1.position = [300, 50];
console.log(rect1.position);
//rect1.#x = 5;
console.log(rect1.position);
console.log(rect1);