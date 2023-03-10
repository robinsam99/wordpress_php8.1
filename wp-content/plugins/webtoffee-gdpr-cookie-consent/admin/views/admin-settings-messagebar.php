<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>
<div class="cookie-law-info-tab-content" data-id="<?php echo $target_id;?>">
    <h3><?php _e('Cookie Bar', 'webtoffee-gdpr-cookie-consent'); ?></h3>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><label for="bar_heading_text_field"><?php _e('Message Heading', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
            <td>
                <input type="text" name="bar_heading_text_field" value="<?php echo stripslashes($the_options['bar_heading_text']) ?>" />
                <span class="cli_form_help"><?php _e('Leave it blank, If you do not need a heading', 'webtoffee-gdpr-cookie-consent'); ?>
                </span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="notify_message_field"><?php _e('Message', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
            <td>
                <?php
                    echo '<textarea name="notify_message_field" class="vvv_textbox">';
                    echo apply_filters('format_to_edit', stripslashes($the_options['notify_message'])) . '</textarea>';
                ?>
                <span class="cli_form_help"><?php _e('Shortcodes allowed: see the Help guide', 'webtoffee-gdpr-cookie-consent'); ?> <br /><?php _e('Examples: "We use cookies on this website [cookie_accept] to find out how to delete cookies [cookie_link]."', 'webtoffee-gdpr-cookie-consent'); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="background_field"><?php _e('Cookie Bar Colour', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
            <td>
                <?php
                /** RICHARDASHBY EDIT */
                //echo '<input type="text" name="background_field" id="cli-colour-background" value="' .$the_options['background']. '" />';
                echo '<input type="text" name="background_field" id="cli-colour-background" value="' . $the_options['background'] . '" class="my-color-field" data-default-color="#fff" />';
                ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="text_field"><?php _e('Text Colour', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
            <td>
                <?php
                /** RICHARDASHBY EDIT */
                echo '<input type="text" name="text_field" id="cli-colour-text" value="' . $the_options['text'] . '" class="my-color-field" data-default-color="#000" />';
                ?>
            </td>
        </tr>
        <!--
        <tr valign="top">
            <th scope="row"><label for="border_on_field"><?php _e('Show Border?', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
            <td>
                <input type="radio" id="border_on_field_yes" name="border_on_field" class="styled" value="true" <?php echo ( $the_options['border_on'] == true ) ? ' checked="checked" />' : ' />'; ?> <?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
                <input type="radio" id="border_on_field_no" name="border_on_field" class="styled" value="false" <?php echo ( $the_options['border_on'] == false ) ? ' checked="checked" />' : ' />'; ?> <?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="border_field"><?php _e('Border Colour', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
            <td>
                <?php
                    echo '<input type="text" name="border_field" id="cli-colour-border" value="' . $the_options['border'] . '" class="my-color-field" />';
                ?>
            </td>
        </tr>
        -->

        <tr valign="top">
            <th scope="row"><label for="font_family_field"><?php _e('Font', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
            <td>
                <select name="font_family_field" class="vvv_combobox">
                    <?php $this->print_combobox_options($this->get_fonts(), $the_options['font_family']) ?>
                </select>
            </td>
        </tr>
    </table>

    <?php 
    include "admin-settings-save-button.php";
    ?>
</div>