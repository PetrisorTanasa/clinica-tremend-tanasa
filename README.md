# clinica-tremend-tanasa
Documentatie
-	Aceasta este aplicatia creata de mine pentru aceasta proba.
-	Imi cer scuze pentru mica intarziere pe care am avut-o, din pacate nu am gasit timpul necesar in decurs de o saptamana
-	Aplicatia ar trebui sa fie deployed pe heroku la https://clinica-tremend-tanasa.herokuapp.com/ , insa la momentul acesta nu pare sa se fi facut, sper ca in momentul in care verificati aceasta tema sa fie okay ca sa puteti verifica functionalitatea
Unde  ar trebui lucrat un pic mai mult
-	Ar trebui sa fie adaugate  niste validari pe input. In momentul acesta nu validez inputul, ceea ce poate duce la probleme in baza de date ( nu de sql injection si asa, ci de faptu ca tratamentele si asa nu ar avea un format oarecum standardizat
-	Ar trebui poate facuta partea de management a doctorilor si a asistentelor mai bine facuta, deoarece cred ca ar mai putea fi adaugate anumite chestii pentru gestionarea acestora.
-	As mai face si o interfata web pentru aceasta aplicatie. As putea folosi Sonata Admin cu care lucrez si la serviciul actual, insa asta din nou ar presupune o dezvoltare mai de lunga durata
-	Poate partea de securitate ar trebui revizuita putin
-	Ar trebui facuta optiunea de read la endpoint ul de manageAccounts, din pacate am uitat de acesta
Endpoint-uri
•	/login
Ruta : POST
Descriere : La acest endpoint user ul isi poate lua un bearer_token pe care il poate utiliza in loc de name si password
Apel API:
{
    "name":"Tanasa",
    "password":"parola123"
}
•	/manageAccounts
Ruta : POST
Descriere : La acest endpoint user ul (daca are permisiune) poate manage ui userii
Apel API:
{	(In loc de bearer pot fi puse name si password ca in endpoint ul de mai sus
    "bearer_token":"2EhxmC04DkC8iW0eb3VBxQ1JQcklIhAbKMbrbpTJa5rX3JeiFe",
    "action":"create”/”update”/”delete”,
    "info":{
!!Pentru update si delete obligatoriu : “id” : 15,
        "name":"Asistent",
        "surname":"Asistent",
        "password":"parola123",
        "role":"ASSISTENT",
        "status":"active"
    }
}
•	/treatment
Ruta : POST
Descriere: Aici introduc medicii treatment urile pacientilor
Apel API :
{
    "name":"Dilirici",
    "password":"parola123",
    "action":”create”/”read”/"update"/”delete”,
    "info":{
!! Pentru update si delete obligatoriu : "id":191,
        "pacient_id":841,
        "status":"in progress",
        "age":45,
        "diagnostic":"Picior rupt",
        "medical_conditions":"None",
        "pacient_name":"Xulescu",
        "treatment":"Operatie",
        "assistant_id":811
    }
}

•	/assistant_treatment
Ruta : POST
Descriere : Pe acest endpoint trimit asistentele toate treatment urile pe care le aplica pacientilor
Apel API:
{
    "name":"Besliu",
    "password":"parola123",
    "action":"create"/”read”/”update”/”delete”,
    "info":{
!! Pentru update si delete obligatoriu : “id”:201,
        "pacient_id":871,
        "treatment":"Curat ranile"
    }
}
•	/all_treatments
Ruta : GET
Descriere : Pe acest endpoint se pot vedea toate treatmenturile aplicate unui pacient
Apel API:
{
    "name":"Tanasa",
    "password":"parola123",
    "pacient_id":821
}
•	/all_stats
Ruta : GET
Descriere: endpoint pentru a lua toate tratamentele unui doctor/asistent (nu trebuie specificat in request)
Apel API:
{
    "name":"Tanasa",
    "password":"parola123",
    "pacient_id":821
}
