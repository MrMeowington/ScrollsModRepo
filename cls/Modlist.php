<?php
	class Modlist extends JSONRequest {
	
		public function __construct(PDO $pdo){
			parent::__construct($pdo);
			
			// override the json_numeric_check, because it converts "1.0" to 1, 
			// which is not wanted for mod versionCodes
			$this->setJsonEncodeOption(0);
		}
	
		public function parseRequest($params){
			$sth = $this->pdo->prepare("SELECT identifier AS id, name, description, version, versionCode
						FROM mods
						ORDER BY name DESC");
			$sth->execute();
			
			$modList = array();
			while ($mod = $sth->fetch(PDO::FETCH_ASSOC)){
				$newMod = array(
							'id'			=> $mod['id'],
							'name'			=> $mod['name'],
							'description'	=> $mod['description'],
							'version'		=> (int)$mod['version'], // cast needed because json_numeric_check is disabled
							'versionCode'	=> $mod['versionCode']
				);
				
				$modList[] = $newMod;
			}

			// this method doesn't return false, in case of a failure/empty resultset the result is just an empty array
			$this->setResult(true, $modList);
		}
	}