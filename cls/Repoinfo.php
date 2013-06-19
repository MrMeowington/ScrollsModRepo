<?php
	/**
	 * General repository information containing the name and number of mods
	 */
	class Repoinfo extends JSONRequest {
	
		public function parseRequest($params){
			$sth = $this->getDB()->prepare("SELECT COUNT(*) AS c
						FROM mods");
			$sth->execute();
			
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			
			$modsInRepo = !empty($result) ? $result["c"] : 0;
			
			$this->setResult(true, array(
						"name" 	=> REPO_NAME, 
						"url" 	=> REPO_URL, 
						"version"	=> 1,
						"mods" 	=> $modsInRepo
			));
		}
		
		public function getCacheId($params){
			return "repoinfo";
		}
	}