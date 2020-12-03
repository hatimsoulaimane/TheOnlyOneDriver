 create database if not exists db_theonlyonedriver;

use db_theonlyonedriver;

/* Table User*/

    insert into user (id, email, roles, nom, prenom, password, adresse, created_at, updated_at, nom_complet)
    values (1, 'soulaiman.hatim@gmail.com','[]', 'HATIM', 'Soulaiman', '', '200 rue balard 75015 Paris', '2020-10-16 07:23:44', NULL, 'Soulaiman HATIM');


/* Table Prestation*/

    insert into prestation (id, titre, description, image_name, destination, nb_passager, nb_bagage, slug, created_at, updated_at, prix, dispo)
    values (1, 'Mariage','Pour le plus beau jour de votre vie, ou celui d’un de vos proches, nous vous proposons la location d’une voiture avec chauffeur pour votre mariage. Profitez de cette journée exceptionnelle en toute tranquillité, votre chauffeur s’occupe de tout !<br>La formule inclut 8 heures de disposition, si vous souhaitez personnaliser cette formule n\hésitez pas à nous contacter.</div>', '28069347621-6c42f610f3-c-5f895c5b33318649936548.jpg', NULL, NULL, NULL, 'mariage', 2020-10-16 08:08:05, 2020-10-22 08:25:07, 650, 1)

/* Table Transfert*/

    insert into transfert (id, titre, description, destination, nb_passager, nb_bagage, slug, prix, created_at, updated_at, dispo, image_name)
    values (1, 'Paris - Charles De Gaulle', 'Fini le stress de rater son avion, nous viendrons vous chercher à l\'heure, et vous déposerons à l\'heure. Nos véhicules sont spacieux, et peuvent accueillir vos bagages, famille et amis.', NULL, NULL, NULL, NULL, 60, '2020:02:12', NULL, TRUE, '');

/* Table ligne de commande*/

    insert into ligne_de_cmd (id, prestation_id, commande_id, quantite, prix_unitaire)
    values ();

/* Table Commande*/

    insert into commande (id, user_id, numero, total, status)
    values ();

/* Table Commentaire*/

    insert into commentaire (id, prestation_id, user_id, note, contenu)
    values ();