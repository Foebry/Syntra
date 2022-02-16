class Fly {
	#id;
	#survived
	constructor(survived = false) {
		this.#id = this.#generateName();
		this.#survived = survived || Boolean(Math.random() < 0.33333333333);
	}
	#generateName() {
		return `FLY-${Math.random().toString(16).substring(2, 6)}`;
	}
	get name() {
		return this.#id;
	}
	get survived() {
		return this.#survived;
	}
}

// exporteren van modules
// slechts 1 default per file
export default Fly;