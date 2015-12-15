<?php

class Paradox {
	var $doc = NULL;
	var $file = NULL;
	var $row = NULL;
	var $field_default_value = "";
	var $field_slashes = false;
	var $field_trim = false;

	function Open($filename) {
		$this->doc = px_new();
		if (!$this->doc) {
			die("Paradox Error: px_new() failed.");
		}
		$this->file = fopen($filename, "r");
		if (!$this->file) {
			px_delete($this->doc);
			die("Paradox Error: fopen failed. Filename:$filename");
		}
		if (!px_open_fp($this->doc, $this->file)) {
			px_delete($this->doc);
			fclose($this->file);
			die("Paradox Erro: px_open_fp failed.");
		}
		return true;
	}

	function Close() {
		if ($this->doc) {
			px_close($this->doc);
			px_delete($this->doc);
		}
		if ($this->file) {
			fclose($this->file);
		}
	}

	function GetNumRows() {
		return px_numrecords($this->doc);
	}

	function GetRow($id) {
		try {
			$this->row = px_get_record($this->doc, $id);
			throw new Exception('no record');
		} catch (Exception $e) {
			return "Exception: " . $e->getMessage() . "\n";
		}
		return $this->row;
	}

	function GetRows($num = 0) {
		if (function_exists(px_retrieve_record)) {
			return px_retrieve_record($this->doc, $num);
		} else {
			return "Unsupported function (px_retrieve_record) in paradox ext.";
		}
	}

	function GetSchema() {
		return px_get_schema($this->doc);
	}

	function GetInfo() {
		return px_get_info($this->doc);
	}

	function GetStringfromDate($date, $format = "d.m.Y") {
		return px_date2string($this->doc, $date, $format);
	}

	function GetStringfromTimestamp($date, $format = "d.m.Y H:i:s") {
		return px_timestamp2string($this->doc, $date, $format);
	}

	function GetField($field, $trim = 0, $slash = 0) {
		if (!$this->row) {
			return false;
		}
		$value = isset($this->row[$field]) ? $this->row[$field] : $this->field_default_value;
		if ($this->field_slashes or $slash) {
			$value = addslashes($value);
		}
		if ($this->field_trim or $trim) {
			$value = trim($value);
		}
		return $value;
	}

	function GetFieldInfo($id = 0) {
		return px_get_field($this->doc, $id);
	}
}
