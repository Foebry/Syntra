const profile = document.querySelector("#profile");
const logout = profile.querySelector("form");
const infoMessages = document.querySelectorAll("p.info");


profile.onclick = (e) => logout.classList.toggle("hidden");
infoMessages.forEach( message => {
    message.onclick = (e) =>{
        message.classList.add("hidden");
    }
})