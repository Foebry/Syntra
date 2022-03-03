const users_ul = document.querySelector("#users-ul");
const search = document.querySelector("#search");
const template = document.querySelector("#user-template");

async function render() {
	const response = await fetch("https://randomuser.me/api/?results=200");
	const data = await response.json();
	const results = data.results;

	search.oninput = (e) => {
		users_ul.innerHTML = "";
		let value = e.target.value.length >= 3 ? e.target.value.toLowerCase() : "";

		display(value);

	}
	const display = (str = "") => {
		const filtered = results.filter(el => str == "" ? true :
			el.name.first.toLowerCase().includes(str) ||
			el.name.last.toLowerCase().includes(str) ||
			el.location.city.toLowerCase().includes(str));

		filtered.map(el => {
				let template_temp = template.innerHTML;
				const {
					gender,
					email,
					cell,
					picture: {
						large
					},
					name: {
						first,
						last
					},
					location: {
						city,
						country
					}
				} = el;
				template_temp = template_temp.replace("%gender%", gender);
				template_temp = template_temp.replace("%picture_large%", large);
				template_temp = template_temp.replace(/%name_first%/g, first);
				template_temp = template_temp.replace(/%name_last%/g, last);
				template_temp = template_temp.replace("%email%", email);
				template_temp = template_temp.replace("%location_city%", city);
				template_temp = template_temp.replace("%location_country%", country);
				template_temp = template_temp.replace("%cell%", cell);
				return template_temp;
			})
			.forEach(el => users_ul.insertAdjacentHTML("beforeend", el));
	}
	display();
}

render();