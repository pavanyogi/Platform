<?php
function Assets_batch_response_batch () {
	if (empty($_REQUEST['batch'])) {
		throw new Q_Exception_RequiredField(array('field' => 'batch'));
	}
	
	try {
		$batch = json_decode($_REQUEST['batch'], true);
	} catch (Exception $e) {}

	if (empty($batch)) {
		throw new Q_Exception_WrongValue(array('field' => 'batch', 'range' => 'valid JSON'));
	}
	
	if (empty($batch['args'])) {
		throw new Q_Exception_RequiredField(array('field' => 'args'));
	}

	// Now, build the result
	$result = array();
	foreach ($batch['args'] as $args) {
		try {
			$action = $args[0];
			$slots = $args[1];
			if (!is_array($slots)) {
				$slots = array($slots);
			}
			$params = array();

			foreach ($slots as $slot) {
				if (
					($action == "NFT" && $slot == "getLikes")
					|| ($action == "NFT" && $slot == "getInterests")
				) {
					$params = array(
						'publisherId' => $args[2],
						'streamName' => $args[3]
					);
				} elseif ($action == "NFT" && $slot == "getInfo") {
					$params = array(
						'tokenId' => $args[2],
						'network' => $args[3],
						'updateCache' => (bool)$args[4]
					);
				}

				$result[] = Q::event("Assets/$action/response/$slot", $params);
			}
		} catch (Exception $e) {
			$result[] = array('errors' => Q_Exception::toArray(array($e)));
		}
	}
	
	return $result;
}