<?php

class Redirect
{
    /**
     * Redirect to the specified route
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public static function to(string $route, array $params = [])//: void
    {
        $url = Config::get('domain') . $route . '/';

        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $url .= $key . '/' . $value . '/';
            }
        }

        header('Location: ' . $url);
        exit;
    }    

    /**
     * Store input data in the session
     *
     * @input array $input
     * @return object
     */
    public static function withInput(array $input): object
    {
        Session::set('oldInput', $input);
        return new self();
    }

    /**
     * Store success message in the session
     *
     * @input string $message
     * @return object
     */
    public static function withSuccess($message): object
    {
        Session::set('message', ['type' => 'success', 'text' => $message]);
        return new self();
    }

    /**
     * Store error message in the session
     *
     * @input string $message
     * @return object
     */
    public static function withError($message): object
    {
        Session::set('message', ['type' => 'error', 'text' => $message]);
        return new self();
    }

}
