@php
    foreach ($topicsArray as $topic){
        $nameTopic;
        $category;
        preg_match('(/.*/(.*?)/)',$topic,$category);
        $categories[]=explode("/",$topic)[1];
                preg_match('([^\/]+$)',$topic,$nameTopic);
        $content[]=['type' => 'highCharts', 'wrapperClass' => 'cols-2 card', 'name' => $nameTopic[0], 'topicToPost' => $topic,'test'=>$test[2],'index'=>$index,'topics' =>$topicsArray];
        $widgets['after_content'][1]['content'][]=$content[$index];
        $index++;
}




	$widgets['before_content'][] = [

	  'type' => 'div',
	  'class' => 'row',
      'content' => [ // widgets

	        [
			    'type'        	=> 'progress_white',
			    'class'       	=> 'card mb-2',
	     		'progressClass'	=> 'progress-bar bg-primary',
			    'value'       	=> $deviceCount,
			    'description' 	=> 'Devices.',
			    'progress'    	=> 100, // integer
			],


	[
			    'type'        => 'progress_white',
			    'class'       => 'card mb-2',
			    'progressClass' => 'progress-bar bg-info',
			    'value'       => $requestCount,
			    'description' => 'Requests.',
			    'progress'    => 100, // integer
            ],
            [
			    'type'        => 'progress_white',
			    'class'       => 'card mb-2',
			    'progressClass' => 'progress-bar bg-success',
			    'value'       => $topicsCount,
			    'description' => 'Topics.',
			    'progress'    => 100, // integer
            ],
            [
			    'type'        => 'progress_white',
			    'class'       => 'card mb-2',
			    'progressClass' => 'progress-bar bg-danger',
			    'value'       => 0,
			    'description' => 'Errors.',
			    'progress'    => 100, // integer
            ],
            [
			    'type'        => 'Map',
			    'wrapperClass'       => 'row',
]


	  ]
	];

@endphp
