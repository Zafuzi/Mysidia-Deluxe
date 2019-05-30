<?php
namespace ajax\Farming;

class Farming {
	protected $type;
	protected $db;

	function __construct($type = 'Farm', $db) {
		if (in_array(['Farm', 'Garden', 'Orchard'], $type)) throw new Exception('Invalid growing area selected.');
		$this->type = $type;
		$this->db = $db;
	}

	protected function getPlantedPlants($plotId) {

	}

	protected function getPossiblePlants() {

	}
}
$id = 'none set';
if (isset($_POST['value'])) {
	$id = $_POST['value'];
	$plotid = $_POST['plot'];
	if ($id == null) $id = 'none';
}
$result = ['error'=>false,'statusText'=>'No error','result'=>'ajax worked for '.$id. ' on '.$plotid];
echo json_encode($result);