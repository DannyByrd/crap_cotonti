<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=footer.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');
if(!defined('COT_ADMIN')) {
	cot_rc_link_footer($cfg['plugins_dir'].'/simpleorders/js/jquery.validation/jquery.validate.min.js');
	cot_rc_link_footer($cfg['plugins_dir'].'/simpleorders/js/jquery.validation/localization/messages_ru.min.js');
	cot_rc_link_footer($cfg['plugins_dir'].'/simpleorders/js/simpleorders.js');
}
