<?php

return [
	'mode'             => 'utf-8',
	'format'           => 'A4', // See https://mpdf.github.io/paging/page-size-orientation.html
	'author'           => 'Mohammad Saiful Islam',
	'subject'          => 'CRM Report',
	'keywords'         => 'CRM,Report', // Separate values with comma
	'creator'          => 'Laravel Pdf',
	'display_mode'     => 'fullpage',
	'tempDir'               => base_path('../temp/'),

	#'font_path' => base_path('resources/fonts/'),
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'bangla' => [
			'R'  => 'SolaimanLipi.ttf',    // regular font
			'B'  => 'SolaimanLipi.ttf',       // optional: bold font
			'I'  => 'SolaimanLipi.ttf',     // optional: italic font
			'BI' => 'SolaimanLipi.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,
			'useKashida' => 75
		]
	]

];