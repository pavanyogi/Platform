<?php

function Streams_before_Q_Utils_canWriteToPath($params, &$result)
{
	extract($params);
	/**
	 * @var $path
	 * @var $throwIfNotWritable
	 * @var $mkdirIfMissing
	 */
	
	// Assume that Users/before/Q/Utils/canWriteToPath already executed

	$user = Users::loggedInUser();
	$userId = $user ? $user->id : "";
	$app = Q::app();
	$len = strlen(APP_DIR);
	if (substr($path, 0, $len) === APP_DIR) {
		$sp = str_replace(DS, '/', substr($path, $len+1));
		if (substr($sp, -1) === '/') {
			$sp = substr($sp, 0, strlen($sp)-1);
		}
		$prefix = "files/$app/uploads/Streams/";
		$len = strlen($prefix);
        $parts = explode('/', substr($sp, $len));
        $c = count($parts);
        $stream = null;

        // get stream
        if ($c > 6) {
            $publisherId = $parts[0].$parts[1].$parts[2];
            $streamName = $parts[3].'/'.$parts[4].'/'.$parts[5];
            if ($publisherId && $streamName) {
                $stream = Streams::fetchOne($userId, $publisherId, $streamName);
            }
        }

        if (substr($sp, 0, $len) === $prefix) {
			$splitId = Q_Utils::splitId($userId, 3, '/');
			$prefix2 = $prefix.$splitId;
			if ($userId and substr($sp, 0, strlen($prefix2)) === $prefix2) {
				$result = true; // user can write any invitations here
                Streams::$cache['canWriteToStream'] = $stream;
				return;
			}

			// check if user can manage streams published by publisherId
			if (Streams::canManage($publisherId)) {
				$result = true; // user can write any invitations here
				Streams::$cache['canWriteToStream'] = $stream;
				return;
			}

			if ($c >= 3) {
				$result = false;
				for ($j=0; $j<$c-3; ++$j) {
					$publisherId = implode('', array_slice($parts, 0, $j+1));
					$l = $j;
					for ($i=$c-1; $i>$j; --$i) {
						$l = $i;
						if (in_array($parts[$i], array('icon', 'file'))) {
							break;
						}
					}
                    $streamName = implode('/', array_slice($parts, $j+1, $l-$j-1));
					if ($streamName && $stream = Streams::fetchOne($userId, $publisherId, $streamName)) {
						$result = $stream->testWriteLevel('edit');
						Streams::$cache['canWriteToStream'] = $stream;
						break;
					}
				}
			}
		}
	}
	if (!$result and $throwIfNotWritable) {
		throw new Q_Exception_CantWriteToPath();
	}
}
