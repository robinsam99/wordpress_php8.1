<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
$cli_admin_view_path=plugin_dir_path(CLI_PLUGIN_FILENAME).'admin/views/';
$cli_img_path=CLI_PLUGIN_URL . 'images/';
$plugin_name = CLI_ACTIVATION_ID;
$cli_activation_status=get_option($plugin_name.'_activation_status');
//taking pages for privacy policy URL.
$args_for_get_pages=array(
    'sort_order'    => 'ASC',
    'sort_column'   => 'post_title',
    'hierarchical'  => 0,
    'child_of'      => 0,
    'parent'        => -1,
    'offset'        => 0,
    'post_type'     => 'page',
    'post_status'   => 'publish'
);
$all_pages=get_pages($args_for_get_pages);
?>
<script type="text/javascript">
    var cli_settings_success_message='<?php echo __('Settings updated.', 'webtoffee-gdpr-cookie-consent');?>';
    var cli_settings_error_message='<?php echo __('Unable to update Settings.', 'webtoffee-gdpr-cookie-consent');?>';
    var cli_reset_settings_success_message='<?php echo __('Settings reset to defaults.', 'webtoffee-gdpr-cookie-consent');?>';
    var cli_reset_settings_error_message='<?php echo __('Unable to reset settings.', 'webtoffee-gdpr-cookie-consent');?>';
    var cli_renew_consent_success_message='<?php echo __('Consent has renewed.', 'webtoffee-gdpr-cookie-consent');?>';
    var cli_renew_consent_error_message='<?php echo __('Unable to renew consent.', 'webtoffee-gdpr-cookie-consent');?>';
</script>
<div class="wrap">
    <h2 class="wp-heading-inline"><?php _e('Cookie Law Settings', 'webtoffee-gdpr-cookie-consent'); ?></h2>
    
    <table class="cli_notify_table cli_bar_state">
        <tr valign="middle" class="cli_bar_on" style="<?php echo $the_options['is_on'] == true ? '' : 'display:none;';?>">
            <th scope="row" style="padding-left:15px;">
                <label><img id="cli-plugin-status-icon" src="<?php echo $cli_img_path;?>tick.png" /></label>
            </th>
            <td style="padding-left: 10px;">
                <?php _e('Your Cookie Law Info bar is switched on', 'webtoffee-gdpr-cookie-consent'); ?>
            </td>
        </tr>
        <tr valign="middle" class="cli_bar_off" style="<?php echo $the_options['is_on'] == true ? 'display:none;' : '';?>">
            <th scope="row" style="padding-left:15px;">
                <label><img id="cli-plugin-status-icon" src="<?php echo $cli_img_path;?>cross.png" /></label>
            </th>
            <td style="padding-left: 10px;">
                <?php _e('Your Cookie Law Info bar is switched off', 'webtoffee-gdpr-cookie-consent'); ?>
            </td>
        </tr>
    </table>

    <div class="nav-tab-wrapper wp-clearfix cookie-law-info-tab-head">
        
        <?php
        if($cli_activation_status)
        {
            $activate_icon='<span class="dashicons dashicons-yes" style="color:#03da01; font-size:25px;"></span>';   
        }else
        {
            $activate_icon='<span class="dashicons dashicons-warning" style="color:#ff1515; font-size:25px;"></span>';
        }
        $tab_head_arr=array(
            'cookie-law-info-general'=>__('General', 'webtoffee-gdpr-cookie-consent'), //no need to add translation here
            'cookie-law-info-message-bar'=>__('Customise Cookie Bar', 'webtoffee-gdpr-cookie-consent'),
            'cookie-law-info-buttons'=>__('Customise Buttons', 'webtoffee-gdpr-cookie-consent'),
            'cookie-law-info-advanced'=>__('Advanced', 'webtoffee-gdpr-cookie-consent'),
            'cookie-law-info-licence'=>array(__('Licence', 'webtoffee-gdpr-cookie-consent'),$activate_icon),
            'cookie-law-info-help'=>__('Help Guide', 'webtoffee-gdpr-cookie-consent')
        );
        if(isset($_GET['debug']))
        {
            $tab_head_arr['cookie-law-info-debug']='Debug';
        }
        Cookie_Law_Info::generate_settings_tabhead($tab_head_arr);
        ?>
    </div>
    <div class="cookie-law-info-tab-container">
        <?php
        //inside the settings form
        $setting_views_a=array(
            'cookie-law-info-general'=>'admin-settings-general.php',
            'cookie-law-info-message-bar'=>'admin-settings-messagebar.php',
            'cookie-law-info-buttons'=>'admin-settings-buttons.php',                      
            'cookie-law-info-advanced'=>'admin-settings-advanced.php',          
        );

        //outside the settings form
        $setting_views_b=array(                    
            'cookie-law-info-licence'=>'admin-settings-licence.php',           
            'cookie-law-info-help'=>'admin-settings-help.php',           
        );
        if(isset($_GET['debug']))
        {
            $setting_views_b['cookie-law-info-debug']='admin-settings-debug.php';
        }
        ?>
        <form method="post" action="<?php echo esc_url($_SERVER["REQUEST_URI"]);?>" id="cli_settings_form">
            <input type="hidden" name="cli_update_action" value="" id="cli_update_action" />
            <?php
            // Set nonce:
            if (function_exists('wp_nonce_field'))
            {
                wp_nonce_field('cookielawinfo-update-' . CLI_SETTINGS_FIELD);
            }
            foreach ($setting_views_a as $target_id=>$value) 
            {
                $settings_view=$cli_admin_view_path.$value;
                if(file_exists($settings_view))
                {
                    include $settings_view;
                }
            }
            ?>
            <?php 
            //settings form fields for module
            do_action('cli_module_settings_form');?>           
        </form>
        <?php
        foreach ($setting_views_b as $target_id=>$value) 
        {
            $settings_view=$cli_admin_view_path.$value;
            if(file_exists($settings_view))
            {
                include $settings_view;
            }
        }
        ?>
        <?php do_action('cli_module_out_settings_form');?> 
    </div>
</div>