# Restaurant-Menu-API

Viele Restaurants bieten ihre Speisekarten im Internet zur Einsicht an. Diese Karten sind häufig
als PDF aber auch in Form normaler Webseiten einsehbar. Aggregatoren wie bspw. pizza.de
oder lieferheld.de, um nur einige zu nennen, verlangen von teilnehmenden Restaurants die
Speisekarte in einer für sie verarbeitbaren Form. Letztlich müssen also die Restaurants ihre Daten,
neben der selbst gepflegten Webpräsenz, auch verschiedenen anderen Diensten bereitstellen.

Ziel dieser Praxisaufgabe soll sein, eine Webanwendung zu entwickeln, welche verschiedene
öffentlich einsehbare Speisekarten abfragt und in einer gemeinsamen Oberfläche präsentiert. Für
den Nutzer ergibt sich dann u. a. der Vorteil, nicht mehr alle Speisekarten nach einem Gericht
durchsuchen zu müssen. Er bekommt einfach eine Karte mit allen Menüs und gleichzeitig das
günstigste Restaurant dazu angezeigt.

Frontend:

(a) Abfrage der Speisekarten von drei realen Restaurants 
(b) Alle in der Datenbank verfügbaren Speisen können aufgelistet werden (MySQL Datenbank).
(c) Suche nach Speisen und Zutaten möglich.
(d) Für einzelne Speisen sind Detailinformationen abrufbar:
    i. Zutatenliste pro Restaurant
    ii. Preis pro Restaurant
(e) Restaurantdaten wie Adresse, Telefonnummer, etc. sind abrufbar
(f) Bei der Entscheidung, ob zwei Speisen verschiedener Restaurants gleich sind, erfolgt zunächst nur ein einfacher, 
    caseinsensitiver Stringvergleich aus.

Backend: Die serverseitige Struktur des Projektes ist in zwei Teile gegliedert:

(a) Der Verarbeitungsteil fragt die Daten aus den jeweiligen Speisekarten ab und speichert
die Ergebnisse in eine Datenbank. Er sollte dabei so gestaltet sein, dass die Webseiten der
Restaurants nicht überlastet und maximal einmal pro Tag die kompletten Speisekarten
nachfragt werden!

(b) Die REST-basierte Schnittstelle fragt bei der Datenbank die benötigten Daten ab und
stellt sie dem Client zur Verfügung.
