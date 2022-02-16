const kinderen = ["Charlotte", "Jasper", "Katarina"];

function ruimKamerOp(kinderen) {
	promises = [];
	kinderen.forEach(kind => {
		promises.push(new Promise((resolve, reject) => {
			const timeout = 5000 + Math.random() * 2000;
			setTimeout(() => {
				const chance = Math.random();
				if (chance < 0.2) reject(`${kind} kreeg een woedeaanval na ${(timeout/1000).toFixed(2)} seconden`);
				else if (chance < 0.5) resolve(`${kind} heeft de kamer wel opgeruimd na ${(timeout/1000).toFixed(2)} seconden`);
				else reject(`${kind} heeft de kamer niet opgeruimd na ${(timeout/1000).toFixed(2)} seconden`);
			}, timeout)
		}))
	})
	return promises;
}

Promise.allSettled(ruimKamerOp(kinderen)).then(data => console.log(data)); //.forEach(el => console.log(el))).catch(data => data.forEach(el => console.log(el))) // => console.log(data)) //data.forEach(el => console.log(el)))
//Promise.race(ruimKamerOp(kinderen)).then(data => console.log(data)).catch(data => console.log(data));