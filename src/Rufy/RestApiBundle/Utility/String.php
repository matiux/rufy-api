<?php namespace Rufy\RestApiBundle\Utility; 

class String
{
    private $_str;
    private $_strLength;
    private $_lowerAlphabet = [];
    private $_upperAlphabet = [];

    public function __construct($string = '')
    {
        if ('' != $string)
            $this->init($string);
    }

    public function set($string) {

        $this->init($string);
    }

    private function init($string)
    {
        $string                     = $this->checkType($string);

        $this->_str                 = $string;
        $this->_strLength           = $this->strLength();
        $this->_lowerAlphabet       = $this->lowerAlphabet();
        $this->_upperAlphabet       = $this->upperAlphabet();
    }

    private function lowerAlphabet()
    {
        $alphabet = [];

        for ($alpha = 'a'; $alpha != 'aa'; $alpha++)
            $alphabet[] = $alpha;

        return $alphabet;
    }

    private function upperAlphabet()
    {
        $alphabet = [];

        for ($alpha = 'A'; $alpha != 'AA'; $alpha++)
            $alphabet[] = $alpha;

        return $alphabet;
    }

    private function checkType($string)
    {
        $type = gettype($string);

        switch($type)
        {
            case 'array':
                throw new \Exception('String non accetta "array"');
                break;
            case 'resource':
                throw new \Exception('String non accetta "resource"');
                break;
            case 'NULL':
                throw new \Exception('String non accetta "NULL"');
                break;
            case 'object':
                throw new \Exception('String non accetta "object"');
                break;
            case 'unknown type':
                throw new \Exception('String non accetta "unknown type"');
                break;
            case 'boolean':
                return  $string ? 'true' : 'false';
                break;
            default:
                return (string) $string;
                break;
        }
    }

    /**
     * Checks if the letters in the string are all lower case. Checks only the letters
     *
     * @return bool
     */
    public function isLower() {

        return $this->isUpperLower('upper');
    }

    /**
     * Checks if the letters in the string are all upper case. Checks only the letters
     *
     * @return bool
     */
    public function isUpper() {

        return $this->isUpperLower('lower');
    }

    private function isUpperLower($case)
    {
        $case = '_'.$case.'Alphabet';

        for($i = 0; $i < $this->_strLength; $i++)
            foreach($this->$case as $letter)
                if($this->_str[$i] == $letter)
                    return false;

        return true;
    }

    /**
     * Returns:
     * true if the pattern matches given subject
     * false if it does not
     * 0 if an error occurred.
     *
     * @param $pattern
     * @return int
     */
    public function contains($pattern)
    {
        $pattern = "/$pattern/";

        $res = preg_match($pattern, $this->_str);

        switch ($res) {

            case 1:
                return true;
                break;
            case 0:
                return false;
                break;
            case FALSE:
                return 0;
                break;
            default:
                return 0;
                break;
        }
    }

    private function strLength()
    {
        $len = 0;

        while (@$this->_str[$len] != '')
            $len++;

        return $len;
    }

    public function length()
    {
        return $this->_strLength;
    }

    /**
     * Se $return = true, la stringa minuscola viene restituita ma internamente rimane originale
     * Se $return = false, il metodo non restituisce niente e la strina minuscola viene settata internamente
     * @param bool $return
     * @return string
     */
    public function lower($return = false)
    {
        if (!$return)
            $this->_str = strtolower($this->_str);
        else
            return strtolower($this->_str);
    }

    /**
     * Se $return = true, la stringa con le sostituzioni viene restituita ma internamente rimane originale
     * Se $return = false, il metodo non restituisce niente e la strina con le sostituzioni viene settata internamente
     * @param $search
     * @param $replace
     * @param bool $return
     * @return mixed
     */
    public function replace($search, $replace, $return = false)
    {
        $str = str_replace($search, $replace, $this->_str);

        if (!$return)
            $this->_str = $str;
        else
            return $str;
    }

    public function __toString()
    {
        return $this->_str;
    }

    /**
     * Se $return = true, la stringa md5 viene restituita ma internamente rimane originale
     * Se $return = false, il metodo non restituisce niente e la strina md5 viene settata internamente
     *
     * @param bool $return
     * @return string
     */
    public function md5($return = false)
    {
        if (!$return)
            $this->_str = md5($this->_str);
        else
            return md5($this->_str);
    }
}
