<?php 
date_default_timezone_set('Europe/Paris');
$config = array (
	'use_cache' => false,
	'json_ah_file' => 'json_ah.pdb',
	'json_ah_data_file' => 'json_ah_data.pdb',
);


$viandes = array(74839, 74834, 75014, 74833, 74838, 74837);

$poissons = array(74866, 74857, 74863, 74856, 74861, 74860, 74865, 74864, 74859);

$legumes = array(74841, 74840, 74842, 74847, 74848, 74850, 74849, 74844, 74846, 74843);

$speciaux = array(74662, 74661, 74853);

$recettes = array (74646, 74656, 74650, 74653, 74648);

$ingredients = array_merge($viandes, $poissons, $legumes, $speciaux, $recettes);

$ingredients_name = array(

	74839 => array('Blanc de sauvagine', 1),

	74834 => array('Côte de mushan', 1),

	75014 => array('Panse de crocolisque crue', 1),

	74833 => array('Steak de tigre cru', 1),

	74838 => array('Viande de crabe crue', 1),

	74837 => array('Viande de tortue crue', 1),

	74866 => array('Carpe dorée', 5),

	74857 => array('Crevette-mante géante', 2),

	74863 => array('Danio joyau', 2),

	74856 => array('Dipneuste de jade', 2),

	74861 => array('Gourami tigre', 2),

	74860 => array('Mandarin ventre-rouge', 2),

	74865 => array('Poisson-spatule de Krasarang', 2),

	74864 => array('Poulpe des récifs', 2),

	74859 => array('Saumon empereur', 2),

	74841 => array('Carotte croquejuteuse', 3),

	74840 => array('Chou vert', 3),

	74842 => array('Citrouille mogu', 3),

	74847 => array('Courge de jade', 3),

	74848 => array('Melon à rayures', 3),

	74850 => array('Navet blanc', 3),

	74849 => array('Navet rose', 3),

	74844 => array('Poireau à fleur rouge', 3),

	74846 => array('Sorcielle', 3),

	74843 => array('Echalote', 3),

	74662 => array('Farine de riz', 4),

	74661 => array('Poivre noir', 4),

	74853 => array('Sauce soja de cent ans d\'âge', 4),

	74646 => array('Côtelettes au poivre noir et aux crevettes', 10),
	74656 => array('Rouleaux de printemps de Chun Tian', 10),
	74650 => array('Ragoût de poisson mogu', 10),
	74653 => array('Surprise de crabe à la vapeur', 10),
	74648 => array('Nouilles de riz à la brume de mer', 10)

	);

	// ID Bouffe, Nom, ID ingrédient spécial, ID ingrédient viande/poisson *5, ID ingrédient viande/poisson *5, ID ingrédient légume *25
$recettes_details = array(
	array(74646, 'Côtelettes au poivre noir et aux crevettes', 74661, 74857, 74834, 74840),
	array(74656, 'Rouleaux de printemps de Chun Tian', 74662, 74860, 74833, 74844),
	array(74650, 'Ragoût de poisson mogu', 74661, 74859, 75014, 74842),
	array(74653, 'Surprise de crabe à la vapeur', 74662, 74863, 74838, 74850),
	array(74648, 'Nouilles de riz à la brume de mer', 74662, 74861, 74837, 74843)
	);