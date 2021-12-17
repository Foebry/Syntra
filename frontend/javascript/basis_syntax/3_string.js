const naam = "Sander";
const leeftijd = 30;
const naam2 = 'Sander';
const naam3 = `David`;



const begroeting = "Hallo ik ben " + naam + " en ik " + leeftijd + " jaar oud :-)";
const betere_begroeting = `Hallo ik ben ${naam} en ik ben ${leeftijd} jaar oud :-)`;
const begroeting_upper = begroeting.toUpperCase();
console.log(betere_begroeting);

// replaceAll werkt nog niet in nodejs.
console.log(begroeting.replace("e", "i"));


// string methods
const email = "rain_fabry@hotmail.com";
const pos_at = email.indexOf("@");
console.log(pos_at);


console.log("a".repeat(5));

console.log(begroeting.split(" "));

str = "kak";

// method chaining

console.log(str == str.split("").reverse().join(""));
console.log("a" == "A");