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
const avatars = document.querySelectorAll(".avatar");
const changePass = document.querySelector


closeButtons.forEach(button => button.onclick = (e) =>{
    e.target.parentElement.classList.add("hidden");
})

if (cobInput != null) {
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
        stedenListSelect.classList.add("hidden");
        cobValue.setAttribute("value", e.target.id);
        cobInput.value = e.target.innerText;
        cobInput.innerText = e.target.innerText;
    });
}
cobInput.onblur = (e) => {
    setTimeout(() => {
        stedenListSelect.classList.add("hidden");
    }, 300)
}
}


profile.onclick = (e) => logout.classList.toggle("hidden");


if (nameInput != null ){
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
}
if (ratingSelect != null){
    ratingSelect.onchange = (e) => {
        console.log("ratingSelect");
        selectValue = e.target.value;
        ratingImg.setAttribute("src", `../images/ratings/${selectValue}-ster.jpg`);
    }
}

if(avatars != null){
    const profileAvatar = document.querySelector("#usr_avatar");
    avatars.forEach(avatar => {
        if (avatar.attributes.value.value == profileAvatar.value){
            avatar.classList.add("avatar--active");
        }
        avatar.onclick = (e) => {
            avatars.forEach(avatar => avatar.classList.remove("avatar--active"));
            e.target.classList.add("avatar--active");
            console.log(profileAvatar);
            profileAvatar.setAttribute("value", e.target.attributes.value.value);
        }
    })
}