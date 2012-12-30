<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_View
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\View\Driver;

use Fonto\View\Driver\DriverInterface;
use Fonto\Application\ObjectHandler;

use Exception;

/**
 * PHP based view helper.
 *
 * Extends ObjectHandler and implements DriverInterface.
 *
 * @package    Fonto_View
 * @subpackage Driver
 * @link       https://github.com/kenren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class Native extends ObjectHandler implements DriverInterface
{
    /**
     * Extension for this driver
     *
     * @var string
     */
    protected $extension = '.php';

    /**
     * Searchable path
     *
     * @var string
     */
    protected $path;

    /**
     * Data
     *
     * @var array
     */
    protected $data = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = VIEWPATH;
    }

    /**
     * @param  string $field
     * @return string
     */
    public function post($field)
    {
        return isset($_POST[$field]) ? $_POST[$field] : '';
    }

    /**
     * Filters output based on key
     *
     * @param $data
     * @param $filter
     * @return string
     */
    public function filter($data, $filter)
    {
        switch($filter) {
            case 'purifier':
                $data = nl2br($this->purify($data));
                break;
            case 'bbcode':
                $data = nl2br($this->bbcode(_e($data)));
                break;
            case 'plain':
                $data = nl2br(_e($data));
                break;
            default:
                $data = nl2br(_e($data));
        }

        return $data;
    }

    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string text The text to be converted.
     * @return mixed
     * @return string the formatted text.
     */
    function bbcode($text) {
        $search = array(
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        );
        $replace = array(
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        );
        return preg_replace($search, $replace, $text);
    }

    /**
     * Loads a view
     *
     * @param  string $view
     * @return void
     */
    public function load($view)
    {
        echo $this->render($view, $this->data);
    }

    /**
     * Cleans user data with purifier. Returns cleaned data
     *
     * @param  string $data
     * @return mixed
     */
    public function purify($data)
    {
        $purifier = $this->purifier();
        return $purifier->purify($data);
    }

    /**
     * Uses renderView
     *
     * @param  string $view
     * @param  array  $data
     * @return mixed
     */
    public function render($view, $data = array())
    {
        return $this->renderView($view, $data);
    }

    /**
     * Renders a view and extracts its data
     *
     * @param  string $view
     * @param  array  $data
     * @return mixed
     * @throws Exception
     */
    public function renderView($view, $data = array())
    {
        $view = strtolower($view);
        ob_start(); // Starts output buffering

        if (!empty($data)) {
            $this->data = $data;
            extract($data);
            unset($data); // Removes from local
        }

        $config = $this->config();
        $theme = $config->read('app#theme');

        if ($theme) {
            extract($theme);
        }

        $session = $this->session();

        if ($session->has('redirectData')) {
            extract($session->get('redirectData')); // Extracts saved session data from redirect
            $session->forget('redirectData');
        }

        if ($this->findView($view, $this->path, $this->extension)) {
            require $this->path . $view . $this->extension;
            $view = ob_get_clean(); // Gets buffer and clear it
            return $view;
        } else {
            ob_end_clean();
            throw new Exception("The view file, {$view} wasn't found.");
        }
    }

    /**
     * Checks if a view file exists
     *
     * @param  string $view
     * @param  string $path
     * @param  string $extension
     * @return mixed
     */
    public function findView($view, $path, $extension)
    {
        if (file_exists($path . $view . $extension)) {
            return true;
        }

        return false;
    }

    /**
     * Returns a html link
     *
     * @param  array  $args
     * @param  string $text
     * @return string
     */
    protected function createLink($args = array(), $text)
    {
        return $this->html()->createLink($this->url()->baseUrl(), $args, $text);
    }

    /**
     * Returns a image
     *
     * @param  string $link
     * @param  string $alt
     * @return string
     */
    protected function createImgLink($link, $alt)
    {
        return $this->html()->createImgLink($this->url()->baseUrl(), $link, $alt);
    }

    /**
     * Returns a formatted source of a file
     *
     * @param  string $file
     * @return string
     */
    protected function getContent($file)
    {
        return "<pre>" . htmlentities(file_get_contents($file)) . "</pre>";
    }
}