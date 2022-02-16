console.log("Hello World!");
// aanmaken array todo objecten
const todos = [{
        id: 0,
        todo: "Gras afrijden",
        checked: true
    },
    {
        id: 1,
        todo: "Nog eens gras afrijden",
        checked: true
    },
    {
        id: 2,
        todo: "Doet nog maar een keer",
        checked: false
    },
];

const list_ref = document.getElementById('form_list');
const form = document.getElementById('form');
const input = document.getElementById('form__input');
renderData();

input.oninput = function() {
    form.classList.remove("form--error");
};

list_ref.onclick = function(event) {
    if (event.target.classList.contains("list__item__button--remove")) {
        console.log(event)
        item_id = event.target.parentElement.id;
        for (let i = 0; i < todos.length; i++) {
            if (todos[i].id == item_id) {
                todos.splice(i, 1);
                renderData();
                break;
            }
        }
    } else if (event.target.classList.contains("list__item__button--check")) {
        toggleChecked(event);
    }
}
form.onclick = function(event) {
    if (event.target.classList.contains("form__submit")) {
        event.preventDefault();
        if (input.value === "") {
            form.classList.add("form--error");
        } else {

            item_id = Math.random().toString(32).substr(2);
            todos.push({
                "id": item_id,
                "todo": input.value,
                "checked": false
            });
            input.value = "";
            renderData();
        }
    }
}

function renderData() {
    list_ref.innerHTML = "";
    for (let i = 0; i < todos.length; i++) {
        let checked = todos[i].checked ? "list__item list__item--checked" : "list__item"
        list_ref.innerHTML +=
            `<li class="${checked}" id="${todos[i].id}">
                <span class="list__item__text">${todos[i].todo}</span>
                <button class="list__item__button list__item__button--remove"></button>
                <button class="list__item__button list__item__button--check"></button>
            </li>`;
    }
}

function toggleChecked(event) {
    item = event.target.parentElement
    item.classList.contains("list__item--checked") ?
        item.classList.remove("list__item--checked") :
        item.classList.add("list__item--checked");

}