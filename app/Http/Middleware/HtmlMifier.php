<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class HtmlMifier
{
    public function handle($request, Closure $next)
    {
  
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type');
        if (strpos($contentType, 'text/html') !== false) {
            $response->setContent($this->minify($response->getContent()));
        }

        return $response;

    }

    public function minify($input)
    {
        $search = array( 
          
					// Remove whitespaces after tags 
					'/\>[^\S ]+/s', 
					
					// Remove whitespaces before tags 
					'/[^\S ]+\</s', 
					
					// Remove multiple whitespace sequences 
					'/(\s)+/s', 
					
					// Removes comments 
					'/<!--(.|\s)*?-->/'
				); 
				
				$replace = array('>', '<', '\\1'); 
				
        return preg_replace($search, $replace, $input);
    }
}