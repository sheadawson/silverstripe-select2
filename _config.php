<?php

define('SELECT2_MODULE', 'select2');

if (basename(dirname(__FILE__)) != SELECT2_MODULE) {
	throw new Exception(SELECT2_MODULE . ' module not installed in correct directory');
}