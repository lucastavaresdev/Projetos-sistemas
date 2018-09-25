<?php
//=========================================================================================
//
// PDO SQLSRV Database Functions 28/09/2017
//
//=========================================================================================


// PDO_SQLSRV Extension
if (!extension_loaded("pdo_sqlsrv"))
		jsonStatus(2, "A extensão 'pdo_sqlsrv' não foi carregada\nVerifique se o driver está instalado corretamente");

//=========================================================================================
// PDO_SQLSRV Database Open Connection
//=========================================================================================
function sqlserver_openDB() {

	try {
		$connection = new PDO( "sqlsrv:server=" . SERVERNAME . "; Database=" . DATABASE . "; ConnectionPooling=" . POOL, USER, PASSWORD);
		$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    } catch(PDOException $e) {

		jsonStatus(2, $e->getMessage());

    }

	return $connection;

}

//=========================================================================================
// PDO_SQLSRV Database Close Connection
//=========================================================================================
function sqlserver_closeDB($connection) {

}

//=========================================================================================
// PDO_SQLSRV Database Fetch Results
//=========================================================================================
function sqlserver_fetchResults($results) {

	if (gettype($results) == "object") {

		$arr = [];

		while ($row = $results->fetch(PDO::FETCH_ASSOC)) {

			$arr[] = $row;

		}

		return $arr;

	} else {

		dblog("fetchResults: o tipo " . gettype($results) . " não é suportado");
		jsonStatus(2, "fetchResults: o tipo " . gettype($results) . " não é suportado");

	}

}

//=========================================================================================
// PDO_SQLSRV Database Free Results
//=========================================================================================
function sqlserver_freeResults($results) {

}

//=========================================================================================
// PDO_SQLSRV Database SQL Query
//=========================================================================================
function sqlserver_query($query, $param = null, $option = null) {

	if (gettype($query) != "string") {
		dblog("query: o tipo " . gettype($query) . " não é suportado");
		jsonStatus(2, "query: o tipo " . gettype($query) . " não é suportado");
	}

	//Com conexão aberta
	if (gettype($param) == "object") {

		try {

			$results = $param->prepare($query);
			$results->execute();
			
			//INSERT, UPDATE, DELETE
			if ($results->columnCount() == 0) {

				$data = $results->rowCount();

			//SELECT
			} else {

				$data = sqlserver_fetchResults($results);

			}

	    } catch(PDOException $e) {

			if ($option == "skip_errors")
				$data = false;
			else {
				dblog($e->getMessage());
				jsonStatus(2, $e->getMessage());
			}

		}

		return $data;

	//Sem conexão aberta
	} else {

		$connection = sqlserver_openDB();

		try {
			
			$results = $connection->prepare($query);
			$results->execute();
			
		} catch(PDOException $e) {

			dblog($e->getMessage());
			jsonStatus(2, $e->getMessage());

		}
		
		//INSERT, UPDATE, DELETE
		if ($results->columnCount () == 0) {

			$data = $results->rowCount();

		//SELECT
		} else {

			if (gettype($param) == "string") {

				$data = sqlserver_fetchResults($results);
				jsonApp($data, $param);

			} else {

				$data = sqlserver_fetchResults($results);

			}

			sqlserver_freeResults($results);

		}

		sqlserver_closeDB($connection);

		jsonStatus(0, "Sucesso", $data);

	}

}
?>