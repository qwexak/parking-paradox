<?
error_reporting(E_ERROR);
require_once("paradox.inc");

$types = [
	1  => [
		'px'     => 'PX_FIELD_ALPHA',
		'sqlite' => 'TEXT',
	],
	2  => [
		'px'     => 'PX_FIELD_DATE',
		'sqlite' => 'TEXT',
	],
	3  => [
		'px'     => 'PX_FIELD_SHORT',
		'sqlite' => 'TEXT',
	],
	4  => [
		'px'     => 'PX_FIELD_LONG',
		'sqlite' => 'TEXT',
	],
	5  => [
		'px'     => 'PX_FIELD_CURRENCY',
		'sqlite' => 'TEXT',
	],
	6  => [
		'px'     => 'PX_FIELD_NUMBER',
		'sqlite' => 'TEXT',
	],
	9  => [
		'px'     => 'PX_FIELD_LOGICAL',
		'sqlite' => 'TEXT',
	],
	12 => [
		'px'     => 'PX_FIELD_MEMOBLOB',
		'sqlite' => 'TEXT',
	],
	13 => [
		'px'     => 'PX_FIELD_BLOB',
		'sqlite' => 'TEXT',
	],
	14 => [
		'px'     => 'PX_FIELD_FMTMEMOBLOB',
		'sqlite' => 'TEXT',
	],
	15 => [
		'px'     => 'PX_FIELD_OLE',
		'sqlite' => 'TEXT',
	],
	16 => [
		'px'     => 'PX_FIELD_GRAPHIC',
		'sqlite' => 'TEXT',
	],
	20 => [
		'px'     => 'PX_FIELD_TIME',
		'sqlite' => 'TEXT',
	],
	21 => [
		'px'     => 'PX_FIELD_TIMESTAMP',
		'sqlite' => 'TEXT',
	],
	22 => [
		'px'     => 'PX_FIELD_AUTOINC',
		'sqlite' => 'TEXT',
	],
	23 => [
		'px'     => 'PX_FIELD_BCD',
		'sqlite' => 'TEXT',
	],
	24 => [
		'px'     => 'PX_FIELD_BYTES',
		'sqlite' => 'TEXT',
	],
];

$pdx = new Paradox();
$pdx->m_default_field_value = "?";//" "; 

//if ($pdx->Open("LogAutoCash.DB")) {
if ($pdx->Open("db/Card.DB")) {

	$scheme = $pdx->GetSchema();
	print_r($scheme);
	$tot_rec = $pdx->GetNumRows();
	print_r($pdx->GetInfo());
	if ($tot_rec) {
		for ($rec = 0; $rec < $tot_rec; $rec++) {
			$pdx->GetRow($rec);
			//if ($rec > 10) break;
//			var_dump($query);
//            echo $rec;
//            echo $pdx->GetField(CODE); 
//            echo $pdx->GetField(NAME); 
		}
	}

	$pdx->Close();
}
?>