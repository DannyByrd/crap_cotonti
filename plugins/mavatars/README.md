#In page.add.tpl:

{PAGEADD_FORM_MAVATAR}



#In page.edit.tpl:

{PAGEEDIT_FORM_MAVATAR}



#In page.tpl:

    <!-- IF {PAGE_MAVATAR} -->
        <!-- IF {PAGE_MAVATAR.1} -->
        <img src="{PAGE_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" alt="{PAGE_MAVATAR.1.DESC}" />
        <!-- ENDIF -->
    <!-- ENDIF -->


#In page.list.tpl,products.list.tpl:
##Блок MAIN:
    <!-- IF {LIST_CAT_MAVATAR} -->
        <!-- IF {LIST_CAT_MAVATAR.1} -->
        <img src="{LIST_CAT_MAVATAR.1|cot_mav_thumb($this, 200, 200, width)}" alt="{LIST_CAT_MAVATAR.1.DESC}" />
        <!-- ENDIF -->
    <!-- ENDIF -->

##Блок MAIN:



#In admin.structure.tpl:
                <tr>
                    <td>Изображения:</td>
                    <td>{ADMIN_STRUCTURE_EDIT_FORM_MAVATAR}</td>
                </tr>

ALTER TABLE  `cot_structure` CHANGE  `structure_desc`  `structure_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '';