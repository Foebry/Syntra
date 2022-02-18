const users_ul = document.querySelector("#users-ul");
const search = document.querySelector("#search");
let users = [];

getRandomUsers();

async function getRandomUsers() {
	const response = await fetch("https://randomuser.me/api/?results=200")
	const data = await response.json();
	results = await data.results;
	results.forEach(el => {
		const li = document.createElement("li");
		li.innerHTML = `<div class="imgholder">
    <img src='${el.picture.large}' alt='profile picture of ${el.name.first} ${el.name.last}'>
</div>
<div class='info'>
    <h3>${el.name.first} ${el.name.last}</h3>
    <p>${el.email}</p>
    <p>${el.location.state}, ${el.location.country}</p>
    <p>${el.cell}</p>
</div>`
		users.push(li);
	});
	render();
}

function render(search = "") {
	const filtered = users.filter(li => {
		const li_name = li.children[1].children[0].innerHTML.toLowerCase();
		const li_gemeente = li.children[1].children[2].innerHTML.toLowerCase();
		const match = li_name.includes(search.toLowerCase()) || li_gemeente.includes(search.toLowerCase());
		return search == "" ? true : match;
	}).map(el => el.outerHTML);
	users_ul.innerHTML = filtered.join("");
}

search.oninput = function(e) {
	const value = e.target.value.length >= 3 ? e.target.value : "";
	render(value);
}