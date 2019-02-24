<?php

function bs_query_get_product($atts)
{
    $request = wp_remote_post("http://basalam.ir/basalam_api/user", array(
        'method' => 'POST',
        'body' => array(
            'query' => '{
				product(id: '. $atts['id'] .') {
				  id
				  name
				  price
				  brief
				  published
				  score {
					score
					points
				  }
				  category {
					id
					title
				  }
				  vendor {
					id
					name
					identifier
				  }
				  photo(size: LARGE) {
					id
					url
					width
					height
				  }
				  description
				}
			  }
            '
            )
        )
    );
    
    return json_decode($request['body'])->data->product;
}