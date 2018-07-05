<?php 
if(function_exists("register_field_group"))
{
	/****************************************************
			Modèle de page : Page Formulaire
	*****************************************************/
	register_field_group(array (
		'id' => 'acf_page-formulaire',
		'title' => 'Page formulaire',
		'fields' => array (
			array (
				'key' => 'field_5b3c9b9a701d6',
				'label' => 'Formulaire shortcode',
				'name' => 'formulaire_shortcode',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3c9be2701d8',
				'label' => 'Call to action titre',
				'name' => 'call_to_action_title',
				'type' => 'text',
				'default_value' => 'Demander un devis',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3c9bf9701d9',
				'label' => 'Bloc additionnel',
				'name' => 'additionnal_bloc',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5b3c9bb1701d7',
				'label' => 'Titre formulaire',
				'name' => 'title_formulaire',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-page-form.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/****************************************************
						Résidents
	*****************************************************/
	register_field_group(array (
		'id' => 'acf_residents',
		'title' => 'Résidents',
		'fields' => array (
			array (
				'key' => 'field_5b3cddf9a3ff9',
				'label' => 'Savoirs faires',
				'name' => 'savoirs_faires',
				'type' => 'select',
				'choices' => array (
					'bois' => 'Bois',
					'metal' => 'Métal',
					'numeric' => 'Numérique',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'residents',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
