<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Validation
 * @subpackage  Components
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Validation\Components;

use Fonto\Validation\Validator;

/**
 * Match validation class.
 *
 * @package    Fonto_Validation
 * @subpackage Components
 * @link       https://github.com/kenren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class ValidateMatch extends Validator
{
    /**
     * Rule
     *
     * @var array
     */
    protected $rule = array();

    /**
     * Error message
     *
     * @var
     */
    protected $message;

    /**
     * Flag for error
     *
     * @var bool
     */
    protected $error = false;

    /**
     * Constructor
     */
    public function __construct($options = array())
    {
        $this->rule = $this->validators['match'];

        $input = $options['input'];
        $value = $options['value'];
        $field = $options['field'];
        $message = $options['message'];

        $values = explode(',', $value);

        if (sizeof($values)) {
            if (!in_array($input, $values)) {
                $this->error = true;

                if (!$message) {
                    $this->message = $this->rule['message'];
                    $this->message = str_replace(array('{field}', '{value}'), array($field, $value), $this->message);
                } else {
                    $this->message = $message;
                }
            }
        }
    }

    /**
     * Returns message
     *
     * @return mixed
     */
    public function getMessage()
    {
        return (string)$this->message;
    }

    /**
     * Returns true if there is an error false otherwise
     *
     * @return bool
     */
    public function hasError()
    {
        return (bool)$this->error;
    }
}
