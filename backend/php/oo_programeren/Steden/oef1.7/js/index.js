const profile = document.querySelector("#profile");
const logout = profile.querySelector("form");

profile.onclick = (e) => logout.classList.toggle("hidden");