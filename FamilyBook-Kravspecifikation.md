#FamilyBook – Kravspecifikation 

Jag har tänkt att göra en applikation som heter FamilyBook i detta projekt.

I min applikation vill jag ha ett flöde som liknar facebook, där man kan skapa, ta bort och ändra inlägg.
I sin profil har man namn, en bild och en valfri kort text. 
Flödet visas bara för personer som är inloggade i den skapade gruppen, därav blir applikationen mer privat än facebook.
Det ska också gå att lägga till viktiga händelser som visas automatiskt efter bestämd tid. 


----------------- Användningsfall----------------------
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

2. Logga ut
2. Registrera Användare
3. 6. Profil bild.
4. Profil text. 
3. Posta inlägg
4. Kommentera på skrivna inlägg.
5. Ta bort inlägg
7. Posta viktiga meddelande. 

// Användningsfall om tid finns till
(Bestäm vem som har makt att ta bort/ lägga till användare i gruppen)
ändra inlägg
