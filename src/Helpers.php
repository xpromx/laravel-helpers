<?php

/*
|--------------------------------------------------------------------------
| Helpers functions 
|--------------------------------------------------------------------------
|
| Add here all the independent functions that will simplify your work.
| You can access to this functions from everywhere inside your application.
|
*/

if (! function_exists('pagination')) {

    /**
    * Return paginator for specified Collection
    *
    * @param Collection $search
    * @param Array $filters
    * @return String
    */
    function pagination($search, $filters=true)
    {
        if(method_exists($search, 'appends'))
        {
            $html  = '<div class="text-center">';
            $html .= $search->appends( $filters ? $_GET : null);
            $html .= "</div>";

            return $html;
        }

        return '';
    }

}

if (! function_exists('pagination_item_position')) {

    /**
    * Get the real position of one item depending of the page you are
    *
    * @param Integer $key
    * @param Collection $search
    * @return Integer
    */
    function pagination_item_position( $key, $search )
    {
        return ( $key + ( $search->currentPage() * $search->perPage() ) ) - $search->perPage();
    }

}

if (! function_exists('is_active')) {
    /**
    * Get 'is-active' String if the values passed are equals
    *
    * @param String $haystack
    * @param String $needle
    * @return String
    */
    function is_active( $haystack, $needle, $class='active' )
    {
        if( $haystack == $needle )
        {
            return $class;
        }

        return '';
    }
}

if (! function_exists('get_class_name')) {

    /**
    * Get base Class name from one Object
    *
    * @param Object $class
    * @return String
    */
    function get_class_name( $class )
    {
        $name = get_class($class);
        $name = explode('\\', $name);

        return last($name);
    }

}

if (! function_exists('route_prefixes')) {

    /**
    * Generate Route prefix for the specified prefix
    *
    * @param String $prefix
    * @return Array
    */
    function route_prefixes( $prefix = '' )
    {
        return [
            'index'   => $prefix . '.index',
            'create'  => $prefix . '.create',
            'store'   => $prefix . '.store',
            'show'    => $prefix . '.show',
            'edit'    => $prefix . '.edit',
            'update'  => $prefix . '.update',
            'destroy' => $prefix . '.destroy'
        ];
    }
}

if (! function_exists('alert')) {

    /**
    * Set a flash session to save te alerts in the system
    *
    * @param String $message
    * @param String $class
    * @return void
    */
    function alert($message, $class='success')
    {
        session()->flash('alert.message', $message);
        session()->flash('alert.class', $class);
    }

}

if (! function_exists('current_url')) {

    /**
    * Return the current url without the get params
    *
    * @return string
    */
    function current_url( $full=false )
    {
        $url = $_SERVER['REQUEST_URI'];

        if( $url )
        {
            $url = explode( '?', $url );
            $url = $url[0];
        }

        if( $full )
        {
            return config('app.url') . $url;
        }

        return $url;
    }

}

if (! function_exists('is_controller')) {

    /**
    * Validate if the given Controller name is the current Controller
    *
    * @param String $name
    * @return boolean
    */
    function is_controller($name)
    {

        if(preg_match('/('. $name .')/i' , Route::currentRouteAction() , $m) === 1)
        {
            return true;
        }

        return false;
    }

}

if (! function_exists('is_route')) {

    /**
    * Check if you are inside of one spesific route
    * mostly used to active a menu inside template
    *
    * @param String $name
    * @return boolean
    */
    function is_route( $name )
    {
        if( Route::currentRouteName() == $name)
        {
        return true;
        }

        return false;
    }

}

if (! function_exists('is_route_path')) {

    /**
    * Determines if the given string contains the given value inside the current route
    * mostly used to active a menu inside template
    *
    * @param String $name
    * @return boolean
    */
    function is_route_path( $name )
    {
        if(preg_match('/('. $name .')/i' , Route::currentRouteName() , $m) === 1)
        {
            return true;
        }

        return false;
    }

}

if (! function_exists('current_route')) {

    /**
    * Return the current route name, shortcut
    *
    * @return boolean
    */
    function current_route()
    {
        return Route::currentRouteName();
    }

}

if (! function_exists('is_route_active')) {

    /**
    * Check if you are inside one spesific route
    * mostly used to active a menu inside template
    * return the string 'active' for the class in the menu
    *
    * @param String $route
    * @param String $class
    * @return String
    */
    function is_route_active( $route, $class='active' )
    {
        if( is_route($route) )
        {
            return $class;
        }

        return false;
    }

}

if (! function_exists('is_route_active')) {

    /**
    * Check if you are inside one spesific route
    * mostly used to active a menu inside template
    * return the string 'active' for the class in the menu
    *
    * @param String $route
    * @param String $class
    * @return String
    */
    function is_route_path_active( $route, $class='active' )
    {
        if( is_route_path($route) )
        {
            return $class;
        }

        return false;
    }

}

if (! function_exists('is_page_active')) {

    /**
    * Return the String 'active' if the current page include the given String
    *
    * @param String $page
    * @param String $class
    * @return String
    */
    function is_page_active( $page, $class='active' )
    {
        if( is_page($page) )
        {
            return $class;
        }

        return false;
    }

}

if (! function_exists('is_page')) {

    /**
    * Validate if the given String is included in the current url
    *
    * @param String $page
    * @return boolean
    */
    function is_page( $page )
    {
        if(preg_match('/('. $page .')/i' , current_url() , $m) === 1)
        {
            return true;
        }

        return false;
    }

}

if (! function_exists('is_route_path_active')) {

    /**
        * Check if you are inside one spesific route
        * mostly used to active a menu inside template
        * return the string 'active' for the class in the menu
        *
        * @param String $route
        * @param String $class
        * @return String
        */
    function is_route_path_active( $route, $class='active' )
    {
        if( is_route_path($route) )
        {
            return $class;
        }

        return false;
    }

}

if (! function_exists('array_to_object')) {
    
    /**
    * Converts the given array to a object
    * Mainly to use inside blade $item->name and not $item['name'] to make it looks more pretty
    *
    * @param Array $array
    * @return [](object)
    */
    function array_to_object($array)
    {
        return (object) $array;
    }

}

if (! function_exists('object_to_array')) {

    /**
    * Converts the given object to a array
    *
    * @param Object $object
    * @return Array
    */
    function object_to_array($object)
    {
        return (array) $object;
    }

}

if (! function_exists('redirect_force')) {

    /**
    * Force a redirection
    *
    * @param String $url
    * @param Boolean $permanent
    * @return void
    */
    function redirect_force($url, $permanent = false)
    {
        if($permanent)
        {
            header('HTTP/1.1 301 Moved Permanently');
        }

        header('Location: '.$url);

        exit();
    }

}

if (! function_exists('token')) {

    /**
    * Just generate a randon unique token
    *
    * @return String
    */
    function token()
    {
        return Hash::make(csrf_token());
    }

}

if (! function_exists('page_class')) {

    /**
    * Get the class names in base of the current route you are
    *
    * @return String
    */
    function page_class()
    {
        $path[0] = 'home';

        if( strpos( current_route(), '.' ) !== false )
        {
            $path = explode('.', current_route());
        }

        $class[] = 'app_' . str_replace('.', '-', current_route());
        $class[] = 'app_' . $path[0];
        $class[] = 'app_' . current_language();

        if( is_route_path('auth.') )
        {
            $class[] = 'app_login';
        }

        return implode(' ', $class);
    }

}

if (! function_exists('status_class')) {

    /**
    * Return a CSS Class name for the given String
    *
    * @param String $status
    * @return String
    */
    function status_class( $status )
    {

        switch( $status )
        {
            case 'active':
            case 'publish':
                return 'is-success';
                break;

            case 'inactive':
            case 'draft':
                return 'is-default';
                break;

            case 'deleted':
            case 'error':
                return 'is-danger';
                break;

        }

        return 'is-default';

    }

}

if (! function_exists('domain_url')) {

    /**
    * Return host name from the given url
    *
    * @param String $url
    * @return String
    */
    function domain_url($url)
    {
        $parse = parse_url($url);

        return isset($parse['host']) ? $parse['host'] : $url;
    }

}

if (! function_exists('current_language')) {

    /**
    * Get the current language
    *
    * @return String
    */
    function current_language()
    {
        return app()->getLocale();
    }

}

if (! function_exists('response_with_pagination')) {

    /**
    * Response with pagination
    *
    * @param Array $data
    * @param Collection $search
    * @return String
    */
    function response_with_pagination( $data, $search )
    {
        return [
                'data' => $data,
                'pagination' => array_except( $search->toArray(), 'data' )
               ];
    }

}

if (! function_exists('array_to_table')) {

    /**
    * Get html of a table for the given array
    *
    * @param Array $data
    * @param String $style
    * @param String $class
    * @return String
    */
    function array_to_table($data, $class='', $style='')
    {
        $html = "<table class='table {$class}' style='font-family:Arial; font-size:14px;' cellpadding='10'>";

        if( $data )
        {
            foreach($data as $key=>$value)
            {
                $html .= "<tr >";

                $html .= "<td width='140' style='{$style}'><b>" . Str::title($key) . "</b></td>";
                $html .= "<td style='{$style}'>{$value}</td>";

                $html .= "</tr>";
            }
        }

        $html .= "</table>";

        return $html;
    }

}

if (! function_exists('array_to_ul')) {

    /**
    * Get html of a ul for the given array
    *
    * @param Array $data
    * @param String $style
    * @param String $class
    * @return String
    */
    function array_to_ul( $array, $class='', $style='' )
    {
        if( !is_array($array) ){ return false; }
        
        $html = "<ul class='{$class}' style='{$style}'>";

        foreach( $array as $key=>$value )
        {
            if( is_numeric($key) )
            {
                $html .= "<li>{$value}</li>";
            }
            else
            {
                $html .= "<li><b>{$key}:</b> {$value}</li>";
            }
            
        }

        $html .= "</ul>";

        return $html;
        
    }

}

if (! function_exists('numbers')) {

    /**
    * Get a array list of numbers from ~ to 
    *
    * @param Integer $from
    * @param integer $to
    * @return Array
    */
    function numbers( $from=1, $to=10 )
    {
        $data = [];

        for($i=$from; $i<=$to;$i++)
        {
            $data[$i] = $i;
        }

        return $data;
    }

}

if (! function_exists('json_prop')) {

    /**
    * Convert a Object to Json string formatted to pass as prop for VueJS
    *
    * @param Object $json
    * @return String
    */
    function json_prop( $json )
    {
        $json = json_encode($json);
        $json = htmlspecialchars($json);

        return $json;
    }

}

if (! function_exists('print_l')) {

    /**
    * Print with and HR without die
    *
    * @param String $text
    * @return String
    */
    function print_l( $text )
    {
        echo $text;
        echo '<hr />';
    }

}

if (! function_exists('getSQL')) {

    /**
    * Print the final SQL from the builder
    *
    * @param Builder $json
    * @return String
    */
    function getSQL($builder) 
    {
        $sql = $builder->toSql();
        foreach ( $builder->getBindings() as $binding ) {
            $value = is_numeric($binding) ? $binding : "'".$binding."'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

}

if (! function_exists('user')) {

    /**
    * Return Auth user or empry user instance
    *
    * @return User
    */
    function user()
    {
        if( !auth()->check() )
        {
            return app()->make( config('auth.providers.users.model') );
        }

        return auth()->user();
    }

}