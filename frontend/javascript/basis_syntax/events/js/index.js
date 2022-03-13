const main = document.querySelector("main");

main.onclick = function(e) {
	const colors = ["red", "green", "yellow", "blue", "orange", "lightgreen", "salmon", "grey", "black"];
	const circle = document.createElement("div");
	const color = Math.floor(Math.random() * colors.length);
	circle.classList.add("circle", colors[color]);
	const x_pos = Math.random() * 1000;
	const y_pos = Math.random() * 1000;
	const width = Math.round(Math.random() * 500);
	circle.setAttribute("style", `width:${width}px; height:${width}px; top:${x_pos}px;left:${y_pos}px`);
	console.log(circle.outerHTML);
	main.insertAdjacentHTML("beforeend", circle.outerHTML.toString());
}