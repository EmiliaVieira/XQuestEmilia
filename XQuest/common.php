<?php

/**
 * Escapes HTML para saída
 *
 */

function escape($html) {
	return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

?>