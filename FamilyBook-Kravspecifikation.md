#FamilyBook – Kravspecifikation 

Jag har tänkt att göra en applikation som heter FamilyBook i detta projekt.

I min applikation vill jag ha ett flöde som liknar facebook, där man kan skapa, ta bort och ändra inlägg.
I sin profil har man namn, en bild och en valfri kort text. 
Flödet visas bara för personer som är inloggade i den skapade gruppen, därav blir applikationen mer privat än facebook.
Det ska också gå att lägga till viktiga händelser som visas automatiskt inom en bestämd tid. 

##AF1 - Logga in
###Huvud scenario
1. Startar när användaren vill logga in i applikationen.
2. Systemet frågar efter användarnamn, lösenord och gruppnamn.
3. Användaren ger systemet dessa uppgifter.
4. Användare loggas in i applikationen.

###Alternativt scenario
4a. Användaren kunde inte loggas in i systemet pågrund av felaktigt lämnade uppgifter.
  1. Systemet ger användaren ett felmedelande.
  2. Steg 2 i huvudscenario. 
  
##AF2 - Logga ut
###Förhandsvillkor
1. Användaren är inloggad, se AF1.

###Huvud scenario
1. Startar när användaren vill logga ut från applikationen. 
2. Systemet presenterar en logg ut knapp.
3. Användaren väljer logga ut. 
4. Systemet loggar ut användaren från applikationen.

##AF3 - Registrera Användare
###Huvud scenario
1. Startar när användare vill registrera en ny grupp. 
2. Systemet frågar efter tänkt gruppnamn.
3. Användaren ger systemet ett gruppnamn.
4. Systemet skapar en ny grupp och frågar användaren om antal användare samt användarnamn och lösenord för dessa.
5. Användare ger systemet användaruppgifter. 
6. Systemet skapar användarprofiler till gruppen.

###Alternativt scenario
4a. Användaren har valt ett gruppnamn som redan finns i systemet.
  1. Systemet presenterar ett felmeddelande.
  2. Användaren väljer därefter ett nytt gruppnamn.
  3. Steg 4 i huvudscenario. 
  

##AF4 - Ändra profil bild.
###Förhandsvillkor
1. Användaren är inloggad, se AF1.

###Huvud scenario
1. Användaren vill ändra sin profil bild.
2. Systemet frågar efter ny bild.
3. Användaren ger systemet ny bild.
4. Systemet ändrar profilbilden. 

###Alternativt scenario
3a. Användaren ger systemet en bildfil som inte är korrekt.
  1. Systemet presenterar ett felmeddelande.
  2. Steg 2 i huvudscenariot. 
  

4. Profil text. 
3. Posta inlägg
4. Kommentera på skrivna inlägg.
5. Ta bort inlägg
7. Posta viktiga meddelande. 

// Användningsfall om tid finns till
(Bestäm vem som har makt att ta bort/ lägga till användare i gruppen)
ändra inlägg
