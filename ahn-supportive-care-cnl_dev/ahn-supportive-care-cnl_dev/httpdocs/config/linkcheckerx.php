<html>
<head>
<title>MR LinkChecker</title>
<style>
	h1{
		font-size:20px;
		margin:0;
		padding:0;
	}
	.status-200, .status-301, .status-302 {
		font-weight:bold;
		color:#008800;
	}
	.status-000, .status-0, .status-404, .status-403, .status-400, .status-402, .status-401{
		color:#880000;
		font-weight:bold;
	}
</style>
</head>
<body>
<?php

	function clean_xml_content($string){
		return trim(preg_replace("/\s+/", " ", $string));
	}
	function check_url($url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,            $url);
		curl_setopt($ch, CURLOPT_HEADER,         true);
		curl_setopt($ch, CURLOPT_NOBODY,         true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT,        5);

		$r = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($httpCode == '0'){
			$httpCode = '000';
		}
		return $httpCode;
	}
	/* PROJECT */
		if (isset($_GET["project"])){
			$project = htmlspecialchars($_GET["project"]);
			$index_file = $project.'/index.xml';
			$xml_string = file_get_contents($index_file);
			$index_string = simplexml_load_string($xml_string);
		}else{
			$project = '';
			$index_string = array();
		}
		echo "<h1>Linkchecking: ".$project."</h1>";
		echo "<small><em>(Note: This thing takes a while to load... Have a coffee and wait a few minutes...)</em></small><br/>";
		echo "<hr/>";
		echo '<label for="ss">Project: </label><select id="ss" name="ss" onchange="location = \'/config/linkchecker.php\' + \'?project=\' + this.value">';
		foreach(glob('./*', GLOB_ONLYDIR) as $dir) {
			$dir = str_replace('./', '', $dir);
			echo '<option value="'.$dir.'">'.$dir.'</option>';
		}
		echo '</select>';
		echo "<ol>";
		foreach ($index_string->Response as $r){
			// Look for media in the index xml
			if (isset($r->MediaList)) {
				foreach ($r->MediaList->Media as $media_instance) {
					if (isset($media_instance->Location) && isset($media_instance->Description)){
						$url = clean_xml_content($media_instance->Location);
						$desc = clean_xml_content($media_instance->Description);
						if ($url !== 'TBD'){
							$headers = check_url($media_instance->Location);
							echo '<li><span class="status-'.$headers.'">[Status: '.$headers.']</span> <a href="'.$url.'" target="_blank">'.$desc.'</a></li>';
						}
					}
				}
			}
		}
	echo "</ol>";
?>
</body>
</html>
