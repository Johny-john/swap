USE swap


CREATE FULLTEXT INDEX ft_annonce_recherche
ON annonce (titre, description_courte);


USE swap


CREATE FULLTEXT INDEX ft_categorie_recherche
ON categorie (titre, motscles);

