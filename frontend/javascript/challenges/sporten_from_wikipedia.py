import requests
import json
from bs4 import BeautifulSoup

olympische_sporten = []
sporten_dict = {}

page = requests.get("https://nl.wikipedia.org/wiki/Lijst_van_sporten")
soup = BeautifulSoup(page.content, "html.parser")

content = soup.find("div", {"class": "mw-parser-output"})
dls = content.findAll("dl")
titles = [title.text.split("[")[0].lower().replace("\u00eb", "e") for title in content.findAll("h2")[1:]]


j = 0
for i in range(len(titles)):
    title = titles[i]
    sporten = []

    times = 4 if i == 1 else 1
    for _ in range(times):
        section = dls[j].findAll("dd")
        # quit(print(namen))
        namen = section[0].findAll("a")
        for naam in namen:
            sporten.append(naam.text.lower().strip().replace("\u00eb", "e").replace("\u00f6", "o"))
        j += 1

    sporten_dict[title] = sporten


page = requests.get("https://nl.m.wikipedia.org/wiki/Olympische_sport")
soup = BeautifulSoup(page.content, "html.parser")
content = soup.find("table", class_="wikitable")
content_rows = content.findAll("tr")

for row in content_rows[1:]:
    column = row.findAll("td")[-1]
    for link in column.findAll("a"):
        link_items = link.text.split(",")
        for sport in link_items:
            olympische_sporten.append(sport.split("(")[0].strip().lower())

sporten_dict["olympische_sporten"] = olympische_sporten


with open("./sporten_test.json", "w") as file:
    json.dump(sporten_dict, file, indent=4)
