<?php
/**
 * Created by PhpStorm.
 * User: svk
 * Date: 12.12.2015
 * Time: 0:34
 */

$time_start = microtime(true);


error_reporting(E_ERROR);
require_once("paradox.inc");



function createdb_schema($name, $fields) {
	$query = "CREATE TABLE IF NOT EXISTS `{$name}` (";
	$types = array(
		1  => array(
			'px'     => 'PX_FIELD_ALPHA',
			'sqlite' => 'TEXT',
		),
		2  => array(
			'px'     => 'PX_FIELD_DATE',
			'sqlite' => 'TEXT',
		),
		3  => array(
			'px'     => 'PX_FIELD_SHORT',
			'sqlite' => 'TEXT',
		),
		4  => array(
			'px'     => 'PX_FIELD_LONG',
			'sqlite' => 'TEXT',
		),
		5  => array(
			'px'     => 'PX_FIELD_CURRENCY',
			'sqlite' => 'TEXT',
		),
		6  => array(
			'px'     => 'PX_FIELD_NUMBER',
			'sqlite' => 'TEXT',
		),
		9  => array(
			'px'     => 'PX_FIELD_LOGICAL',
			'sqlite' => 'TEXT',
		),
		12 => array(
			'px'     => 'PX_FIELD_MEMOBLOB',
			'sqlite' => 'TEXT',
		),
		13 => array(
			'px'     => 'PX_FIELD_BLOB',
			'sqlite' => 'BLOB',
		),
		14 => array(
			'px'     => 'PX_FIELD_FMTMEMOBLOB',
			'sqlite' => 'TEXT',
		),
		15 => array(
			'px'     => 'PX_FIELD_OLE',
			'sqlite' => 'TEXT',
		),
		16 => array(
			'px'     => 'PX_FIELD_GRAPHIC',
			'sqlite' => 'TEXT',
		),
		20 => array(
			'px'     => 'PX_FIELD_TIME',
			'sqlite' => 'TEXT',
		),
		21 => array(
			'px'     => 'PX_FIELD_TIMESTAMP',
			'sqlite' => 'TEXT',
		),
		22 => array(
			'px'     => 'PX_FIELD_AUTOINC',
			'sqlite' => 'TEXT',
		),
		23 => array(
			'px'     => 'PX_FIELD_BCD',
			'sqlite' => 'TEXT',
		),
		24 => array(
			'px'     => 'PX_FIELD_BYTES',
			'sqlite' => 'TEXT',
		),
	);
	foreach ($fields as $k => $field) {
		$query .= "`{$k}` {$types[$field['type']]['sqlite']},";
	}
	return rtrim($query, ",") . ");";
}

function brackets($txt) {
	return "'" . $txt . "'";
}

function ConvertDB($fname) {
//	echo "=> {$fname}\n";
	if (!file_exists($fname)) exit(10);
	$db = new SQLite3('base.sqlite');
	$db->exec("pragma synchronous = off;");
	$tablename = pathinfo($fname, PATHINFO_FILENAME);
	$pdx = new Paradox();
	$pdx->Open($fname);
	$db->exec(createdb_schema($tablename,$pdx->GetSchema()));
	$db->exec('DELETE FROM '.$tablename);
	if ($records = $pdx->GetNumRows()) {
		$schema = $pdx->GetSchema();
//		print_r($schema);
		for ($rec = 0; $rec < $records; $rec++) {
			$pdx->GetRow($rec);
//			if ($rec > 2) break;
			$query = 'INSERT INTO `' . $tablename . '` VALUES (';
			$values = '';
			foreach ($pdx->row as $fieldName => $value) {
				switch ($schema[$fieldName]['type']) {
					case 1:
						$value = brackets(iconv('windows-1251', 'UTF-8', $value));
						break;
					case 2:
						$value = brackets($pdx->GetStringfromDate($value));
						break;
					case 21:
						$value = brackets($pdx->GetStringfromTimestamp($value));
						break;
					case 4:
						$value = (int)$value;
						break;
					case 6:
						$value = (float)$value;
						break;
					case 9:
						$value = (int)$value;
						break;
					case 13:
						$value = "X".brackets(bin2hex($value));
						break;
					default:
						$value;
						break;
				}
				$values .= $value . ', ';
//				print "{$schema[$fieldName]['type']}\t{$fieldName}\t{$value}\n";
			}
			$values = rtrim($values, ', ');
			$query .= $values . ");\n";
//			print trim($query).PHP_EOL;
			$db->exec($query);
		}
		return true;
	}
	$pdx->Close();

}

//ConvertDB('db/LogRegCard.DB');

$curfile = '';
if (1) {
foreach (glob("db/*.DB") as $file) {
    $dbstime = microtime(true);
	ConvertDB($file);
	$dbtime = microtime(true) - $dbstime;
	echo "=> {$file} {$dbtime} секунд\n";
}
}


$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Всего $time секунд\n";


