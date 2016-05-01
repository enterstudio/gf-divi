<?php
class DS_Gravity_Form_Module extends ET_Builder_Module {
	/*initialize plugin*/
	function init() {
		$this->name = esc_html__( 'Gravity Form', 'et_builder' );
		$this->slug = 'et_pb_gravity_form5';

		/*initialize the field */
		$this->whitelisted_fields = array(
			'form_id',
			'show_title',
			'show_description',
			'enable_ajax',
		);

		/*the field default */
		$this->fields_defaults = array(
			'form_id' 			=> array( '0' ),
			'show_title' 		=> array( 'off' ),
			'show_description' 	=> array( 'off' ),
			'enable_ajax' 		=> array( 'off' ),
		);
	}
	/*
	Get the detail field setting
	*/
	function get_fields() {
		global $wpdb;
		//get all gravity forms
		$forms = $wpdb->get_results("select * from ".$wpdb->prefix."rg_form");
		$arr[0] = "Please select";
		foreach($forms as $form)
		{
			//setup the array for select box
			$arr[$form->id] = $form->title;
		}

		//setup the fields
		$fields = array(
			'form_id' => array(
				'label'             => esc_html__( 'Form', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => $arr,
			),
			'show_title' => array(
				'label' => esc_html__( 'Show Form Title', 'et_builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description' => esc_html__( 'This will show gravity form title.', 'et_builder' ),
			),
				
			'show_description' => array(
				'label' => esc_html__( 'Show Form Description', 'et_builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description' => esc_html__( 'This will show gravity form description', 'et_builder' ),
			), 
			
			'enable_ajax' => array(
				'label' => esc_html__( 'Enable Ajax', 'et_builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description' => esc_html__( 'This will enable Ajax', 'et_builder' ),
			),
		);
		return $fields;
	}

	/*
	show the module on front end
	*/
	function shortcode_callback( $atts, $content = null, $function_name ) {
		//get the setting value
		$show_title = $this->shortcode_atts['show_title'];
		$show_description = $this->shortcode_atts['show_description'];
		$enable_ajax = $this->shortcode_atts['enable_ajax'];
		$id = $this->shortcode_atts['form_id'];
		
		$output = 'gravityform id="'.$id.'" ';
		
		//create the shortcut
		if($show_title =="on") $output.='title="true" ';
		else $output.='title="false" ';

		if($show_description =="on") $output.='description="true" ';
		else $output.='description="false" ';
		
		if($enable_ajax =="on") $output.='ajax="true"';

		//show gravity form
		ob_start();
		echo do_shortcode( '['.$output.']' );
		$content = ob_get_contents();

		ob_end_clean();
		
		return $content;
	}
}

new DS_Gravity_Form_Module;
?>