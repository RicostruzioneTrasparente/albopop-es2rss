<?php
function toJson($results) {
	return json_encode(array_map(
		function($el) { return $el["_source"]; },
		$results
	));
}
?>
