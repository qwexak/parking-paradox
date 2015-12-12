<?php

class Paradox {
	var $doc = NULL;
	var $file = NULL;
	var $row = NULL;
	var $m_default_field_value = "";
	var $m_use_field_slashes = false;
	var $m_use_field_trim = false;

	function Open($filename) {
		$this->doc = px_new();
		if (!$this->doc) {
			die("cParadox Error: px_new() failed.");
		}
		$this->file = fopen($filename, "r");
		if (!$this->file) {
			px_delete($this->doc);
			die("cParadox Error: fopen failed. Filename:$filename");
		}
		if (!px_open_fp($this->doc, $this->file)) {
			px_delete($this->doc);
			fclose($this->file);
			die("cParadox Erro: px_open_fp failed.");
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
		$this->row = px_get_record($this->doc, $id);
		return $this->row;
	}

	function GetRows() {
		if (function_exists(px_retrieve_record)) {
			return px_retrieve_record($this->doc, $num = 0);
		} else {
			return "Unsupported function in paradox ext.";
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

	function GetField($field, $type = 0, $format = 0) {
		if (!$this->row) {
			return false;
		}
		$value = isset($this->row[$field]) ? $this->row[$field] : "";
		if ($this->m_use_field_slashes) {
			$value = addslashes($value);
		}
		if ($this->m_use_field_trim) {
			$value = trim($value);
		}
		return $value;
	}

	function GetFieldInfo($id = 0) {
		return px_get_field($this->doc, $id);
	}
}
