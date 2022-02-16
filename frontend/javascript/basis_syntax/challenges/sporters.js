const sports = ["zwemmen", "fietsen", "lopen"];
const {
	uniqueNamesGenerator,
	names,
} = require('unique-names-generator');


const min_logs = 500;
const max_logs = 1000;

class Sporter {
	constructor(fname = null, lname = null, log = null) {
		this.fname = fname || uniqueNamesGenerator({
			"dictionaries": [names],
			length: 1
		});
		this.lname = lname || uniqueNamesGenerator({
			"dictionaries": [names],
			length: 1
		});
		this.fullname = `${this.fname} ${this.lname}`;
		this.log = log || new Array(Math.floor(min_logs + Math.random() * (max_logs - min_logs)))
			.fill(0)
			.map(el => this.train());
	}
	// create a new Log for the sporter
	train(sport = null, distance = null, time = null) {
		return new Log(sport, distance, time);
	}
	// calculate total amount of km across all sports or a specific, given sport
	calculateTotalkm(sport = null) {
		return this.log.filter(logObject => logObject.sport == (sport || logObject.sport))
			.reduce((tot, logObject) => tot + logObject.distance, 0);
	}
	// calculate the furthest training across all sports or a specific, given sport
	furthestTraining(sport = null) {
		return this.log.filter(logObject => logObject.sport == (sport || logObject.sport))
			.sort((a, b) => b.distance - a.distance)[0];
	}
	// calculates the total training time across all sports or a specific, given sport.
	calculateTotalTime(sport = null) {
		return this.log.filter(logObject => logObject.sport == (sport || logObject.sport))
			.reduce((tot, logObject) => tot + logObject.time, 0);

	}
	// calculates the average distance across all sports or a specific, given sport
	getAverageDistance(sport = null) {
		return this.calculateTotalkm(sport) / (this.log.filter(logObj => logObj.sport == (sport || logObj.sport)).length)
	}
	// calculates the average speed across all sports or a specific, given sport.
	getAverageSpeed(sport = null) {
		return this.calculateTotalkm(sport) / this.calculateTotalTime(sport) * 3600;
	}
	static getTotalkm(arr, sport = null) {
		return parseFloat((arr.reduce((tot, sporterObj) => tot + sporterObj.calculateTotalkm(sport), 0)).toFixed(2));
	}
	static getTotalTime(arr, sport = null) {
		return parseInt(arr.reduce((tot, sporterObj) => tot + sporterObj.calculateTotalTime(sport), 0));
	}
	static getSporterFurthestDistanceTrained(arr, sport = null) {
		return arr.sort((a, b) => b.calculateTotalkm(sport) - a.calculateTotalkm(sport))[0];
	}
	static getSporterFurthestTraining(arr, sport = null) {
		return arr.sort((a, b) => b.furthestTraining(sport).distance - a.furthestTraining(sport).distance)[0];
	}
	static getTotalAvgSpeed(arr, sport = null) {
		return parseFloat((Sporter.getTotalkm(arr, sport) / Sporter.getTotalTime(arr, sport) * 3600).toFixed(2));
	}
	static getSporterHighestAvgSpeed(arr, sport = null) {
		return arr.sort((a, b) => b.getAverageSpeed(sport) - a.getAverageSpeed(sport))[0];
	}
	static getHighestAvgSpeed(arr, sport = null) {
		return parseFloat(Sporter.getSporterHighestAvgSpeed(arr, sport).getAverageSpeed(sport).toFixed(2));
	}
	static getSporterHighestAvgDistance(arr, sport = null) {
		return arr.sort((a, b) => b.getAverageDistance(sport) - a.getAverageDistance(sport))[0];
	}
}


class Log {
	constructor(sport, distance, time) {
		this.sport = sport || sports[Math.floor(Math.random() * 3)];
		this.distance = distance || this.setDistance();
		this.time = time || this.setTime();
	}
	setDistance() {
		let distance;
		let min_distance;
		let max_distance;

		switch (this.sport) {
			case "zwemmen":
				min_distance = 2;
				max_distance = 3;
				distance = (min_distance + Math.random() * (max_distance - min_distance)).toFixed(2);
				break;
			case "fietsen":
				min_distance = 75;
				max_distance = 200;
				distance = (min_distance + Math.random() * (max_distance - min_distance)).toFixed(2);
				break;
			case "lopen":
				min_distance = 5;
				max_distance = 20;
				distance = (min_distance + Math.random() * (max_distance - min_distance)).toFixed(2);
				break;

		}
		return parseFloat(distance);

	}
	setTime() {
		let time;
		let min_time;
		let max_time;
		const seconds_in_minutes = 60;

		switch (this.sport) {
			case "zwemmen":
				min_time = 60 * seconds_in_minutes;
				max_time = 160 * seconds_in_minutes;
				time = Math.floor(Math.random() * min_time + (max_time - min_time))
				break;
			case "fietsen":
				min_time = 200 * seconds_in_minutes;
				max_time = 320 * seconds_in_minutes;
				time = Math.floor(Math.random() * min_time + (max_time - min_time))
				break;
			case "lopen":
				min_time = 25 * seconds_in_minutes;
				max_time = 120 * seconds_in_minutes;
				time = Math.floor(Math.random() * min_time + (max_time - min_time));
				break;
		}
		return parseInt(time);
	}
	toString() {
		return `De ${this.sport} training met afstand ${this.distance} en tijd ${this.time}`;
	}
}

const people = 5000;
const sporters_group = new Array(people).fill(0).map(el => new Sporter());

const totaal_km = Sporter.getTotalkm(sporters_group)
const verste_zwemmer = Sporter.getSporterFurthestDistanceTrained(sporters_group, "zwemmen").fullname;
const sporter_verste_zwemtraining = Sporter.getSporterFurthestTraining(sporters_group, "zwemmen").fullname;
const totale_loop_afstand = Sporter.getTotalkm(sporters_group, "lopen");
const totaal_avg_loop_snelheid = Sporter.getTotalAvgSpeed(sporters_group, "lopen");
const sporter_hoogste_avg_fiets_snelheid = Sporter.getSporterHighestAvgSpeed(sporters_group, "fietsen");
const hoogste_avg_fiets_snelheid = Sporter.getHighestAvgSpeed(sporters_group, "fietsen");

console.log(`Samen hebben alle sporters ${totaal_km} kilometer afgelegd.`);
console.log(`De sporter met de hoogste zwemafstand is ${verste_zwemmer}`);
console.log(`De sporter met de verste zwemtraining is ${sporter_verste_zwemtraining}`);
console.log(`De totale loopafstand van alle sporters samen is ${totale_loop_afstand}`);
console.log(`De gemiddelde loop snelheid over alle sporters heen is ${totaal_avg_loop_snelheid}`);
console.log(`De hoogste gemiddelde fietssnelheid is ${hoogste_avg_fiets_snelheid} km/h`);
console.log(`De sporter met de hoogste gemiddelde fietssnelheid is ${sporter_hoogste_avg_fiets_snelheid.fullname}`);







/* Tests
 sporters aanmaken
const log1 = [new Log("fietsen", 156, 12729), new Log("zwemmen", 1, 1)];
const log2 = [new Log("fietsen", 151, 10896), new Log("zwemmen", 2.9, 9088), new Log("zwemmen", 2.5, 6879), new Log("fietsen", 175, 14616), new Log("lopen", 19, 6634)];
46.00
const log3 = [new Log("zwemmen", 2.2, 5285), new Log("fietsen", 173, 14282), new Log("fietsen", 161, 13910), new Log("lopen", 12, 2937), new Log("zwemmen", 2.2, 5421)];
const log4 = [new Log("zwemmen", 2.8, 8513), new Log("zwemmen", 3, 8064), new Log("lopen", 18, 6285), new Log("fietsen", 1, 720)];
const log5 = [new Log("lopen", 6, 972), new Log("fietsen", 1, 720), new Log("zwemmen", 4, 15963)];

const sporter_1 = new Sporter("Andy", "Zulu", log1);
const sporter_2 = new Sporter("Bert", "Yankee", log2);
const sporter_3 = new Sporter("Christal", "Xray", log3);
const sporter_4 = new Sporter("Dean", "Whiskey", log4);
const sporter_5 = new Sporter("Eve", "Victor", log5);

let sporters_group = new Sportersclub([sporter_1, sporter_2, sporter_3, sporter_4, sporter_5]);
//console.log(JSON.stringify(sporters_group, null, 4));
const totalDistance = sporters_group.getTotalkm();
const furthest_swimmer = sporters_group.getSporterFurthestDistanceTrained("zwemmen");
const furthest_runner = sporters_group.getSporterFurthestDistanceTrained("lopen");
const furthest_biker = sporters_group.getSporterFurthestDistanceTrained("fietsen");
const furthest_bike_training = sporters_group.getSporterFurthestTraining("fietsen").furthestTraining("fietsen");
const totalDistanceRunning = sporters_group.getTotalkm("lopen");
const sporter_highest_avg_cycling_distance = sporters_group.getSporterHighestAvgDistance("fietsen");
const sporter_highest_avg_cycling_speed = sporters_group.getSporterHighestAvgSpeed("fietsen");
const highest_avg_cycling_speed_speed = sporter_highest_avg_cycling_speed.getAverageSpeed("fietsen").toFixed(2);
const sporter_verste_zwemtraining = sporters_group.getSporterFurthestTraining("zwemmen");
console.log(totalDistance); //893.6
console.log(furthest_swimmer.fullname); //Dean Whiskey
console.log(furthest_runner.fullname); //Bert Yankee
console.log(furthest_biker.fullname); //Christal Xray
console.log(furthest_bike_training.distance); //175
console.log(totalDistanceRunning); //55
console.log(sporter_highest_avg_cycling_distance.fullname); //Christal Xray
console.log(sporter_highest_avg_cycling_speed.fullname); // Bert Yankee
console.log(highest_avg_cycling_speed_speed); //46.00
console.log(sporter_verste_zwemtraining.fullname); //Eve Victor*/