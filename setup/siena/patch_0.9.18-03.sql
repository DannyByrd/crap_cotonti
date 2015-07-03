/* patch_0.9.18-03.sql - add congigs */
INSERT INTO `cot_config` (`config_owner`, `config_cat`, `config_subcat`,`config_order`, `config_name`, `config_type`, `config_value`, `config_default`, `config_variants`, `config_text`, `config_donor`) VALUES
('module','page', '__default', '09','show_items_inner_cats',2,'global','global','global,show,not_show','', '');