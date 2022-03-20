const closeButtons = document.querySelectorAll("p.info button");
const nameInput = document.querySelector("input#name");
const jumboTitle = document.querySelector(".jumbo h1");
const profile = document.querySelector("#profile");
const logout = document.querySelector("#profile form");
const ratingSelect = document.querySelector("select#rating");
const ratingImg = document.querySelector(".rating img");
const avatars = document.querySelectorAll(".avatar");
const editForm = document.querySelector("form.edit");




const cobInput = document.querySelector("input.cob");
const cobValue = document.querySelector("#cob");
const cityItems = document.querySelectorAll(".stedenList li");
const stedenListSelect = document.querySelector('.stedenListSelect');
const stedenList =document.querySelector(".stedenList");
const changePass = document.querySelector


closeButtons.forEach(button => button.onclick = (e) => e.target.parentElement.classList.add("hidden"));

if (nameInput) nameInput.oninput = (e) => jumboTitle.innerHTML = nameInput.value;

if (profile) profile.onclick = (e) => logout.classList.toggle("hidden");

if (ratingSelect) ratingSelect.onchange = (e) => ratingImg.setAttribute("src", `../images/ratings/${e.target.value}-ster.jpg`);
    
if(avatars){
    const profileAvatar = document.querySelector("#usr_avatar");
    avatars.forEach(avatar => {
        if (avatar.attributes.value.value == profileAvatar.value){
            avatar.classList.add("avatar--active");
        }
        avatar.onclick = (e) => {
            avatars.forEach(avatar => avatar.classList.remove("avatar--active"));
            e.target.classList.add("avatar--active");
            profileAvatar.setAttribute("value", e.target.attributes.value.value);
        }
    })
}
const resetImage = async (table, image, input) => {
    image.src = `../images/${table}/${input.value}`;
    const data = await fetch(`${image.src}`);
    if(data.status == 404) image.src = `../images/${table}/default.jpg`;
}

if(editForm){
    const fileNameInput = document.querySelector("input#filename");
    const image = editForm.querySelector(".imgholder img");
    table = image.classList[0];
    resetImage(table, image, fileNameInput);
    
    fileNameInput.onchange = () => formatValue(fileNameInput, table, image);
    editForm.onsubmit = () => formatValue(fileNameInput, table, image);
}

const formatValue = async (input, table, image) => {
    input.value = input.value.trim().replace(/ /g, "-");
    resetImage(table, image, input);

}