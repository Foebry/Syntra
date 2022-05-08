const closeButtons = document.querySelectorAll("p.info button");
const nameInput = document.querySelector("input#name");
const jumboTitle = document.querySelector(".jumbo h1");
const profile = document.querySelector("#profile");
const logout = document.querySelector("#profile form");
const ratingSelect = document.querySelector("select#rating");
const ratingImg = document.querySelector(".rating img");
const avatars = document.querySelectorAll(".avatar");
const editForm = document.querySelector("form.edit");
const root = document.querySelector("#root").innerHTML;


closeButtons.forEach(button => button.onclick = (e) => e.target.parentElement.classList.add("hidden"));

if (nameInput) nameInput.oninput = () => jumboTitle.innerHTML = nameInput.value;

if (profile) profile.onclick = () => logout.classList.toggle("hidden");

if (ratingSelect) ratingSelect.onchange = (e) => ratingImg.setAttribute("src", `${root}/images/ratings/${e.target.value}-ster.jpg`);
    
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
    image.src = `${root}/images/${table}/${input.value}`;
    const data = await fetch(`${image.src}`);
    if(data.status == 404) image.src = `${root}/images/${table}/default.jpg`;
}

if(editForm){
    const fileNameInput = document.querySelector("input#filename");
    const image = editForm.querySelector(".imgholder img");

    table = image.classList[0];
    resetImage(table, image, fileNameInput);
    
    fileNameInput.onchange = () => formatValue(fileNameInput, table, image);
    editForm.onsubmit = () => formatValue(fileNameInput, table, image);

    if(table == "person"){
        const cobInput = document.querySelector("input.cob");
        const cobValue = document.querySelector("#cob");
        const cityItems = document.querySelectorAll(".stedenList li");
        const citySelect = document.querySelector(".stedenListSelect");
        const cityOptions = Array(cityItems.length).fill(0).map((_, i) => cityItems[i]).slice(0, 5);

        
        cityOptions.forEach(cityItem => cityItem.onclick = (e) => {
            cobInput.setAttribute("value", e.target.innerHTML);
            cobInput.value = e.target.innerHTML;
            }
        )
        cobInput.oninput = (e) => showOptions(e, cityOptions);
        cobInput.onchange = () => setTimeout(setCoB, 300);
        cobInput.onblur = () => setTimeout(setCoB, 300);

        const setCoB = () => {
            const cityArr = cityOptions.filter(item => item.innerHTML.toLowerCase() == cobInput.value.toLowerCase());
            cobValue.value = cityArr.length > 0 ? cityArr[0].id : -1;
            citySelect.classList.add("hidden");
        }
    }
    
}

const formatValue = async (input, table, image) => {
    input.value = input.value.trim().replace(/ /g, "-");
    resetImage(table, image, input);

}

const showOptions = (e, options) => {
    const stedenListSelect = document.querySelector('.stedenListSelect');

    stedenListSelect.classList.remove("hidden");
    stedenListSelect.innerHTML = "";

    options
    .filter(li => li.innerHTML.toLowerCase().includes(e.target.value.toLowerCase()))
    .forEach(el => stedenListSelect.insertAdjacentElement("beforeend", el));    
}