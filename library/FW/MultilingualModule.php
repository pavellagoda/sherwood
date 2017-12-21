<?php

/**
 * Module Route with Multilingual
 *
 * Default route for module functionality with Multilingual
 */
class FW_MultilingualModule extends Zend_Controller_Router_Route_Module
{

    /**
     * Language key
     * @var string
     */
    protected $_languageKey = 'lang';

    /**
     * Constructor
     *
     * @param array $defaults Defaults for map variables with keys as variable names
     * @param Zend_Controller_Dispatcher_Interface $dispatcher Dispatcher object
     * @param Zend_Controller_Request_Abstract $request Request object
     */
    public function __construct(array $defaults = array(), Zend_Controller_Dispatcher_Interface $dispatcher = null, Zend_Controller_Request_Abstract $request = null)
    {
        $this->_defaults = $defaults;

        if (isset($request)) {
            $this->_request = $request;
        } else {
            $this->_request = Zend_Controller_Front::getInstance()->getRequest();
        }

        if (isset($dispatcher)) {
            $this->_dispatcher = $dispatcher;
        } else {
            $this->_dispatcher = Zend_Controller_Front::getInstance()->getDispatcher();
        }

        if (!array_key_exists($this->_languageKey, $defaults) || strlen($defaults[$this->_languageKey]) != 2) {
            throw new Zend_Controller_Router_Exception('Default language is not specified.');
        }
    }

    /**
     * Matches a user submitted path. Assigns and returns an array of variables
     * on a successful match.
     *
     * If a request object is registered, it uses its setModuleName(),
     * setControllerName(), and setActionName() accessors to set those values.
     * Always returns the values as an array.
     *
     * @param string $path Path used to match against this routing map
     * @return array An array of assigned values or a false on a mismatch
     */
    public function match($path, $partial = false)
    {
        $this->_setRequestKeys();

        $values = array();
        $params = array();

        if (!$partial) {
            $path = trim($path, self::URI_DELIMITER);
        } else {
            $matchedPath = $path;
        }

        if ($path != '') {

            $path = explode(self::URI_DELIMITER, $path);

            if ($this->_defaults[$this->_languageKey] && strlen($path[0]) == 2) {
                $values[$this->_languageKey] = array_shift($path);
            }

            if (count($path) && !empty($path[0]) && $this->_dispatcher && $this->_dispatcher->isValidModule($path[0])) {
                $values[$this->_moduleKey] = array_shift($path);
                $this->_moduleValid = true;
            }

            if (count($path) && !empty($path[0])) {
                $values[$this->_controllerKey] = array_shift($path);
            }

            if (count($path) && !empty($path[0])) {
                $values[$this->_actionKey] = array_shift($path);
            }

            if ($numSegs = count($path)) {
                for ($i = 0; $i < $numSegs; $i = $i + 2) {
                    $key = urldecode($path[$i]);
                    $val = isset($path[$i + 1]) ? urldecode($path[$i + 1]) : null;
                    $params[$key] = (isset($params[$key]) ? (array_merge((array) $params[$key], array($val))) : $val);
                }
            }
        }

        if ($partial) {
            $this->setMatchedPath($matchedPath);
        }

        $this->_values = $values + $params;
        //Zend_Debug::dump($this->_values + $this->_defaults);
        return $this->_values + $this->_defaults;
    }

    /**
     * Assembles user submitted parameters forming a URL path defined by this route
     *
     * @param array $data An array of variable and value pairs used as parameters
     * @param bool $reset Weither to reset the current params
     * @return string Route path with user submitted parameters
     */
    public function assemble($data = array(), $reset = false, $encode = true, $partial = false)
    {
        if (!$this->_keysSet) {
            $this->_setRequestKeys();
        }

        $params = (!$reset) ? $this->_values : array();

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $params[$key] = $value;
            } elseif (isset($params[$key])) {
                unset($params[$key]);
            }
        }

        $params += $this->_defaults;

        $url = '';

        if (array_key_exists($this->_languageKey, $data)) {
            if ($params[$this->_languageKey] != $this->_defaults[$this->_languageKey]) {
                $language = $params[$this->_languageKey];
            }
        } elseif (array_key_exists($this->_languageKey, $this->_values) &&
                $this->_defaults[$this->_languageKey] != $this->_values[$this->_languageKey]) {
            $language = $this->_values[$this->_languageKey];
        }
        unset($params[$this->_languageKey]);

        if ($this->_moduleValid || array_key_exists($this->_moduleKey, $data)) {
            if ($params[$this->_moduleKey] != $this->_defaults[$this->_moduleKey]) {
                $module = $params[$this->_moduleKey];
            }
        }
        unset($params[$this->_moduleKey]);

        $controller = $params[$this->_controllerKey];
        unset($params[$this->_controllerKey]);

        $action = $params[$this->_actionKey];
        unset($params[$this->_actionKey]);

        foreach ($params as $key => $value) {
            $key = ($encode) ? urlencode($key) : $key;
            if (is_array($value)) {
                foreach ($value as $arrayValue) {
                    $arrayValue = ($encode) ? urlencode($arrayValue) : $arrayValue;
                    $url .= '/' . $key;
                    $url .= '/' . $arrayValue;
                }
            } else {
                if ($encode)
                    $value = urlencode($value);
                $url .= '/' . $key;
                $url .= '/' . $value;
            }
        }

        if (!empty($url) || $action !== $this->_defaults[$this->_actionKey]) {
            if ($encode)
                $action = urlencode($action);
            $url = '/' . $action . $url;
        }

        if (!empty($url) || $controller !== $this->_defaults[$this->_controllerKey]) {
            if ($encode)
                $controller = urlencode($controller);
            $url = '/' . $controller . $url;
        }

        if (isset($module)) {
            if ($encode)
                $module = urlencode($module);
            $url = '/' . $module . $url;
        }

        if (isset($language)) {
            if ($encode)
                $language = urlencode($language);
            $url = '/' . $language . $url;
        }

        return ltrim($url, self::URI_DELIMITER);
    }

}