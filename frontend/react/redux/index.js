import store from "./data/index.js";
import { increment, decrement, multiplyBy5 } from "./data/counter.js";
import { addFriend, removeFriend } from "./data/Vrienden.js";

//1) function = .getState() => opvragen van de huidige STATE
console.log(store.getState());
//2) function = .dispatch() => functie waarmee we action-objecten kunnen sturen naar de store.
store.dispatch(increment());
store.dispatch(decrement());
store.dispatch(decrement());
console.log(store.getState());

function updateCounterUi() {
  document.querySelector("h2 span").innerText = store.getState().counterState.counter;
}

document.querySelector(".inc").onclick = function () {
  store.dispatch(increment());
};
document.querySelector(".dec").onclick = function () {
  store.dispatch(decrement());
};

document.querySelector(".multiplyBy5").addEventListener("click", function () {
  store.dispatch(multiplyBy5());
});

updateCounterUi();

store.subscribe(updateCounterUi);



// UI logica voor vrienden
function renderVrienden() {
  document.querySelector("ul.vrienden").innerHTML = store.getState().vriendenState.map(vriend => `<li>${vriend.name} <button data-id="${vriend.id}" class="wis">wis</button></li>`).join("")
}

renderVrienden();

document.querySelector("ul.vrienden").onclick = (e) => {
  if (e.target.classList.contains("wis")){
    console.log("jos");
    store.dispatch(removeFriend(e.target.dataset.id))
  }
}

const form = document.querySelector("form");

form.onsubmit = (e) => {
  e.preventDefault();
  const name = form.querySelector(".name").value;
  store.dispatch(addFriend(name));
  form.reset();
}
// document.querySelector("form").onsubmit = (e) => {
//   e.preventDefault();
//   const name = document.querySelector("form .name").value;

//   store.dispatch(addFriend(name))
//   document.querySelector("form .name").value = "";
// }

store.subscribe(renderVrienden);
