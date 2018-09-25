<?php
//=========================================================================================
//
// 03/06/2018
//
//=========================================================================================

// MYSQLI Extension
if (!extension_loaded("mysqli")) {
		echo jsonResponse(2, SQL_NO_MYSQLI_DRIVER);
		exit;
}

//=========================================================================================
// MYSQLI Database Open Connection
//=========================================================================================
function openDB() {

	if (DB_DEV) {

		if (DB_DEV_HOST && DB_DEV_USER && DB_DEV_PWD & DB_DEV_BASE) {

			$connection = mysqli_connect(DB_DEV_HOST, DB_DEV_USER, DB_DEV_PWD, DB_DEV_BASE);

		} else if (DB_HOST && DB_USER && DB_PWD & DB_BASE) {

			$connection = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_BASE);

		} else {

			dblog(SQL_NO_DB_CONFIG);
			echo jsonResponse(2, SQL_NO_DB_CONFIG);
			exit;

		}

	}

	if (!$connection) {

		dblog(SQL_NO_CONNECTION);
		echo jsonResponse(2, SQL_NO_CONNECTION);
		exit;

	}

	if (mysqli_connect_errno()) {

		dblog(mysqli_connect_errno() . ' ' . mysqli_connect_error());
		echo jsonResponse(2, mysqli_connect_errno() . ' ' . mysqli_connect_error());
		exit;

	}

	$query = "SET session wait_timeout=30";
	query($query, $connection);

	return $connection;

}

//=========================================================================================
// MYSQLI Database Close Connection
//=========================================================================================
function closeDB($connection) {
	
	if (gettype($connection) == "object")
		mysqli_close($connection);

}

//=========================================================================================
// MYSQLI Database Fetch Results
//=========================================================================================
function fetchResults($results) {

	if (gettype($results) == "object") {

		$arr = [];

		while ($row = mysqli_fetch_assoc($results)) {

			$arr[] = $row;

		}

		return $arr;

	} else {

		exit;

	}

}

//=========================================================================================
// MYSQLI Database Free Results
//=========================================================================================
function freeResults($results) {

	if (gettype($results) == "object")
		mysqli_free_result($results);

}

//=========================================================================================
// MYSQLI Database SQL Query
//=========================================================================================
function query($query, $connection = null, $duplicate = true) {

	if (gettype($query) == "string") {

		$echo = false;

		if (gettype($connection) != "object") {
			$connection = openDB();
			$echo = true;
		}

		mysqli_set_charset($connection, 'utf8');

		mysqli_multi_query($connection ,$query);

		if (mysqli_error($connection)) {

			dblog(mysqli_error($connection));

			if (mysqli_errno($connection) == 1062) {

				if ($duplicate) {
					closeDB($connection);
					echo jsonResponse(1, SQL_DUPLICATE_ENTRY);
					exit;
				}

			} else if (mysqli_errno($connection) == 1451) {

				closeDB($connection);
				echo jsonResponse(1, SQL_ROW_DEPENDECY);
				exit;

			} else {
				closeDB($connection);
				echo jsonResponse(2, mysqli_error($connection) . '\nErrNo: ' . mysqli_errno($connection));
				exit;
			}

		}

		$i = 0;

		do {

			$results = mysqli_store_result($connection);

			//SELECT
			if (gettype($results) == "object") {

				$arr[$i] = fetchResults($results);
				freeResults($results);

			//INSERT, UPDATE, DELETE
			} else {

				$arr[$i] = mysqli_affected_rows($connection);

			}

			$i++;

		} while (mysqli_more_results($connection) && mysqli_next_result($connection));

		if ($echo) {
			closeDB($connection);
			echo jsonResponse(0, SQL_DONE, $arr);
			exit;
		} else
			return $arr;

	}

}

?>