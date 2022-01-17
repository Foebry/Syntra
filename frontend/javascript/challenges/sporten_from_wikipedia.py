import requests
import json
from bs4 import BeautifulSoup

page = requests.get("https://nl.wikipedia.org/wiki/Lijst_van_sporten")
# print(vars(data).keys())
soup = BeautifulSoup(page.content, "html.parser")
content = soup.find(class_="mw-parser-output")
titles = content.findAll("h2")
dls = content.findAll("dl")

# print(dls[1].findAll("dd")[0].findAll("a")[i].text)

sporten = {titles[i].text.split("[")[0].lower(): "" for i in range(1, len(titles))}


for i in range(len(list(sporten.keys()))):
    sport = list(sporten.keys())[i]
    sporten[sport] = [
        dls[i].findAll("dd")[0].findAll("a")[j].text
        # for i in range(len(dls))
        for j in range(len(dls[i].findAll("dd")[0].findAll("a")))
    ]


with open("./sporten.json", "w") as file:
    json.dump(sporten, file)
