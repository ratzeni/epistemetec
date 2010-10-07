<?php
module_load_include('php', 'Fedora_Repository', 'SearchClass');

class SearchingClass extends SearchClass {

	function build_home_search_form($pathToSearchTerms = null, $query = null) {
		$form = array ();
		$form['pattern'] = array (
			'#size' => '24',
			'#type' => 'textfield',
			'#title' => t(''),
			'#required' => true,
			'#default_value' => ''
		);

		$form['submit'] = array (
			'#type' => 'submit',
			'#value' => t('search')
		);
		return $form;
	}

	function theme_home_search_form($form) {
		$output .= drupal_render($form['pattern']);
		$output .= drupal_render($form['submit']);
		$output .= drupal_render($form);
		return $output;
	}

	function submit_home_search_form($form, & $form_state) {
		//print_r($form_state);exit;
		$searchTerms = $this->get_search_terms_array();
		$types = array_keys($searchTerms);
		$searchString = '';
		foreach ($types as $type) {
			if ($type != 'dsm.text') {
				$searchString .= $type . ':' . $form_state['values']['pattern'];
				if (next($types))
					$searchString .= '+OR+';
			}
		}
		
		drupal_goto("fedora/repository/mnpl_advanced_search/$searchString");
	}
}
?>