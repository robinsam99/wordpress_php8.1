<?php

class acf_field_picturefill_field extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'picturefill_field';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Picturefill', 'acf-picturefill_field');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'content';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'breakpoints'	=> '',
			'images' => array(),
			'preview_size' => 'thumbnail',
			'return_size' => 'full',
			'library' => 'all',
			'mime_types' => '',
			'return_type' => 'picture',
			'classes' => '',
			'picture_id' => '',
		);
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('picturefill_field', 'error');
		*/
		
		$this->l10n = array();
		
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts') );
		
				
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		
		$breakpoint_string = '';
		$breakpoints = $field['breakpoints'];
		if($breakpoints) {
			foreach($breakpoints as $breakpoint){
				if($breakpoint != 'default') {
					$breakpoint_string .= $breakpoint;
				}
			}
			$field['breakpoints'] = $breakpoint_string;
		}
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Breakpoints','acf-picturefill_field'),
			'instructions'	=> __('The min-width breakpoints (in px) for your image. There will be a default image breakpoint added automatically.','acf-picturefill_field'),
			'type'			=> 'textarea',
			'name'			=> 'breakpoints',
		));
		
		// preview_size
        acf_render_field_setting( $field, array(
            'label'         => __('Preview Size','acf'),
            'instructions'  => __('Shown when entering data','acf'),
            'type'          => 'select',
            'name'          => 'preview_size',
            'choices'       =>  acf_get_image_sizes()
        ));
        
        // returned_size
        acf_render_field_setting( $field, array(
            'label'         => __('Return Size','acf'),
            'instructions'  => __('Shown when displaying','acf'),
            'type'          => 'select',
            'name'          => 'return_size',
            'choices'       =>  acf_get_image_sizes()
        ));
        
        // returned_size
        acf_render_field_setting( $field, array(
            'label'         => __('Return Type','acf'),
            'instructions'  => __('Return as an HTML picture element or an array of all image objects','acf'),
            'type'			=> 'radio',
			'layout'		=> 'horizontal',
            'name'          => 'return_type',
            'choices'		=> array(
				'picture'			=> __("Picture Element",'acf'),
				'array'				=> __("Array",'acf'),
			),
        ));
        
        // CSS Classes
        acf_render_field_setting( $field, array(
            'label'         => __('CSS Classes','acf'),
            'instructions'  => __('Enter any classes you would like on the HTML picture element','acf'),
            'type'          => 'text',
            'name'          => 'classes',
        ));
        
        // Element ID
        acf_render_field_setting( $field, array(
            'label'         => __('Element ID','acf'),
            'instructions'  => __('Enter the id attribute for the HTML picture element','acf'),
            'type'          => 'text',
            'name'          => 'picture_id',
        ));
	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {

		// enqueue
		acf_enqueue_uploader();

?>
<table <?php acf_esc_attr_e(array( 'class' => "acf-table acf-input-table" )); ?>>
	<thead>
		<tr>
			<th class="acf-th" style="width: 80px;">Breakpoint</th>
			<th class="acf-th" style="width: auto;">Image</th>
		</tr>
	</thead>
	
	
	<?php $i = 0; ?>
	<?php foreach($field['breakpoints'] as $breakpoint) { ?>
		<?php 
			$breakpoint = trim($breakpoint);
			// vars
			$div = array(
				'data-breakpoint'		=> $breakpoint,
				'class'					=> 'acf-image-uploader acf-cf',
				'data-preview_size'		=> $field['preview_size'],
				'data-library'			=> $field['library'],
				'data-mime_types'		=> $field['mime_types']
			);
			
			$url = '';
			
			// has value?
			if( $field['value'][$breakpoint] && is_numeric($field['value'][$breakpoint]) ) {
				$url = wp_get_attachment_image_src($field['value'][$breakpoint], $field['preview_size']);
				if( $url ) {
					$url = $url[0];
					$div['class'] .= ' has-value';
				}
			}
		?>
			<tr class="acf-row">
				<td>
					<?php 
						if($breakpoint == 'default') :
							echo "Default";
						else :
							echo $breakpoint.'px';
						endif;
					?>
				</td>
				<td>
					<div <?php acf_esc_attr_e( $div ); ?>>
					    <div class="acf-hidden">
					        <?php acf_hidden_input(array( 'name' => $field['name'].'['.$breakpoint.']', 'value' => $field['value'][$breakpoint], 'data-name' => 'id' )); ?>
					    </div>
					    <div class="view show-if-value acf-soh">
					        <ul class="acf-hl acf-soh-target">
					            <li><a class="acf-icon dark" data-name="edit" href="#" data-breakpoint="<?php echo $breakpoint; ?>"><i class="acf-sprite-edit" data-breakpoint="<?php echo $breakpoint; ?>"></i></a></li>
					            <li><a class="acf-icon dark" data-name="remove" href="#" data-breakpoint="<?php echo $breakpoint; ?>"><i class="acf-sprite-delete" data-breakpoint="<?php echo $breakpoint; ?>"></i></a></li>
					        </ul>
					        <img data-name="image" src="<?php echo $url; ?>" alt=""/>
					    </div>
					    <div class="view hide-if-value">
					        <p><?php _e('No image selected','acf'); ?> <a data-name="add" class="acf-button" href="#" data-breakpoint="<?php echo $breakpoint; ?>"><?php _e('Add Image','acf'); ?></a></p>
					    </div>
					</div>
				</td>
			</tr>
	<?php $i++; } ?>
</table>
<?php
	}
	
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	
	function input_admin_enqueue_scripts() {
		
		$dir = plugin_dir_url( __FILE__ );
		
		
		// register & include JS
		wp_register_script( 'acf-input-picturefill_field', "{$dir}js/input.js" );
		wp_enqueue_script('acf-input-picturefill_field');
		
		
		// register & include CSS
		wp_register_style( 'acf-input-picturefill_field', "{$dir}css/input.css" ); 
		wp_enqueue_style('acf-input-picturefill_field');
		
		
	}


	function enqueue_frontend_scripts() {
		
		$dir = plugin_dir_url( __FILE__ );
		
		// register & include JS
		wp_register_script( 'acf-picturefill_field', "{$dir}js/picturefill.min.js" );
		wp_enqueue_script('acf-picturefill_field');
	}
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_head() {
	
		
		
	}
	
	*/
	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_enqueue_scripts() {
		
	}
	
	*/

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function load_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function update_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
		
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) ) {
		
			return $value;
			
		}
		
		if($field['return_type'] == 'picture') {
			$picture_class = '';
			$picture_id = '';
			if($field['classes'] != '') {
				$picture_class = 'class="'.$field['classes'].'"';
			}
			if($field['picture_id'] != '') {
				$picture_id = 'id="'.$field['picture_id'].'"';
			}
			
			$return_value = "<picture $picture_class $picture_id>";
			
			$breakpoints = $field['breakpoints'];
			foreach($breakpoints as $breakpoint) {
				$breakpoint = trim($breakpoint);
				//$url = wp_get_attachment_image_src($images[$breakpoint], $field['return_size']);
				$image = acf_get_attachment( $value[$breakpoint] );
				$image_url = ($field['return_size'] == 'full') ? $image['url'] : $image['sizes'][$field['return_size']];
				
				if($breakpoint == 'default') {
					$return_value .= '<img srcset="'.$image_url.'" alt="'.$image['alt'].'">';
				} else {	
					$return_value .= '<source srcset="'.$image_url.'" media="(min-width: '.$breakpoint.'px)">';
				}
			}
	
			$return_value .= "</picture>";
			
			// return
			return $return_value;
		} else {
			$value_array = array(
				'breakpoints' => array()
			);
			
			$breakpoints = $field['breakpoints'];
			foreach($breakpoints as $breakpoint) {
				$breakpoint = trim($breakpoint);
				$value_array['breakpoints'][] = $breakpoint;
				$value_array[$breakpoint] = acf_get_attachment( $value[$breakpoint] );
			}
			
			return $value_array;
		}
	}

	
	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	
	/*
	
	function validate_value( $valid, $value, $field, $input ){
		
		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}
		
		
		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','acf-picturefill_field'),
		}
		
		
		// return
		return $valid;
		
	}
	
	*/
	
	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	
	
	function load_field( $field ) {
		$field['breakpoints'] = explode("\n", $field['breakpoints']);
		$field['breakpoints'][] = 'default';
		
		return $field;
	}	
	
	
	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function update_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	/*
	
	function delete_field( $field ) {
		
		
		
	}	
	
	*/
	
	
}


// create field
new acf_field_picturefill_field();

?>
