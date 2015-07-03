<?php
/**
 * JavaScript and CSS loader for Tiuportal theme
 *
 * @package Cotonti
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

cot_rc_add_file('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/font-awesome/css/font-awesome.min.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/simple-line-icons/simple-line-icons.min.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/bootstrap/css/bootstrap.min.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/uniform/css/uniform.default.css');


cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/lock.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/login.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/blog.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/news.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/bootstrap-switch/css/bootstrap-switch.min.css');




cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/timeline.css');

if($_GET["c"] == "reviews") {
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/timeline-old.css');
}


cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/bootstrap-daterangepicker/daterangepicker-bs3.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/fullcalendar/fullcalendar.min.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/jqvmap.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/plug/morris/morris.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/profile.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/tasks.css');

cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/components-rounded.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/plugins.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/layout.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/light.css');
cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/custom.css');



cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jquery-migrate.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jquery-ui/jquery-ui.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/bootstrap/js/bootstrap.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jquery-slimscroll/jquery.slimscroll.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jquery.blockui.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jquery.cokie.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/uniform/jquery.uniform.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/bootstrap-switch/js/bootstrap-switch.min.js');

cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/jquery.vmap.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/maps/jquery.vmap.russia.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/maps/jquery.vmap.world.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/maps/jquery.vmap.europe.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/maps/jquery.vmap.germany.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/maps/jquery.vmap.usa.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jqvmap/jqvmap/data/jquery.vmap.sampledata.js');

cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/morris/morris.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/morris/raphael-min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/jquery.sparkline.min.js');


cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/plug/gmaps/gmaps.min.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/js/metronic.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/js/layout.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/js/demo.js');

cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/js/index3.js');
cot_rc_link_footer($cfg['themes_dir'].'/'.$usr['theme'].'/js/tasks.js');
















require_once cot_rc($cfg['themes_dir'].'/'.$usr['theme'].'/'.$usr['theme'].'.resources.php');

?>