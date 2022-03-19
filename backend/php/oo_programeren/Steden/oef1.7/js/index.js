const profile = document.querySelector("#profile");
const logout = profile.querySelector("form");
const closeButtons = document.querySelectorAll("p.info button");
const nameField = document.querySelector(".jumbo h1");
const nameValue = nameField.innerHTML;
const nameInput = document.querySelector("form input#name");
const ratingImg = document.querySelector(".rating img");
const ratingSelect = document.querySelector("select#rating");
const fileNameInput = document.querySelector("input#filename");
const cityImage = document.querySelector("img.image-stad");
const personImage = document.querySelector("img.image-person");
const cobInput = document.querySelector("input.cob");
const cobValue = document.querySelector("#cob");
const cityItems = document.querySelectorAll(".stedenList li");
const stedenListSelect = document.querySelector('.stedenListSelect');
const stedenList =document.querySelector(".stedenList");


closeButtons.forEach(button => button.onclick = (e) =>{
    e.target.parentElement.classList.add("hidden");
})

cobInput.onclick = (e)=>{
    stedenListSelect.classList.remove("hidden");
    [...cityItems]
        .filter(item => item.innerText
            .toLowerCase()
            .includes(e.target.value.toLowerCase()))
            .slice(0, 5)
        .forEach(el => stedenListSelect.insertAdjacentElement("beforeend", el));
    
    const items = stedenListSelect.querySelectorAll("li");
    items.forEach(item => item.onclick = (e) => {
        console.log("clicked");
        stedenListSelect.classList.add("hidden");
        cobValue.setAttribute("value", e.target.id);
        cobInput.setAttribute("value", e.target.innerText);
    });
}
cobInput.oninput = (e) => {
    stedenListSelect.classList.remove("hidden");
    stedenListSelect.innerHTML = "";
    [...cityItems]
        .filter(item => 
            item.innerText
            .toLowerCase()
            .includes(e.target.value.toLowerCase()))
        .forEach(el => stedenListSelect.insertAdjacentElement("beforeend", el));
    
    let items = stedenListSelect.querySelectorAll("li");

    items.forEach(item => item.onclick = (e) => {
        console.log("clicked");
        stedenListSelect.classList.add("hidden");
        cobValue.setAttribute("value", e.target.id);
        cobInput.value = e.target.innerText;
        cobInput.innerText = e.target.innerText;
        console.log(cobInput);
    });
}
cobInput.onblur = (e) => {
    setTimeout(() => {
        stedenListSelect.classList.add("hidden");
        console.log("blurred");
    }, 300)
}

// console.log(cobInput);
// console.log(cobValue);
// console.log(cityItems);


profile.onclick = (e) => logout.classList.toggle("hidden");
infoMessages.forEach( message => {
    message.onclick = (e) =>{
        message.classList.add("hidden");
    }
})

nameInput.oninput = (e) => {
    nameField.innerHTML = nameInput.value;
    fileNameInput.value = nameInput.value.replace(/ /g, "-");
}
nameInput.onchange = (e) => {
    if( e.target.value == "" ){
        nameField.innerHTML = nameValue;
        nameInput.value = nameValue;
    }
    fileNameInput.value = `${nameInput.value.replace(/ /g, "-")}.jpg`;

    if (cityImage != null) cityImage.setAttribute("src", `../images/stad/${fileNameInput.value}`);
    if (personImage != null) personImage.setAttribute("src", `../images/person/${fileNameInput.value}`);
    
}
ratingSelect.onchange = (e) => {
    console.log("ratingSelect");
    selectValue = e.target.value;
    ratingImg.setAttribute("src", `../images/ratings/${selectValue}-ster.jpg`);
}