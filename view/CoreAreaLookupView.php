<?php

/**
 * CoreAreaView.
 *
 * @author Joseph Daigle
 */
class CoreAreaView extends View{
    
    private $errorMessage;
    private $areaList;
  
    public function __construct() {
        parent::__construct();   
    }
    
    public function set_error_message($message) {
        if (!is_null($message) && !empty($message)) {
            $this->errorMessage = $message;
        }
    }
    
    /**
     * 
     * @param type $areaList
     */
    public function setAreaList($areaList) {
        $this->areaList = $areaList;
    }
    
    
    
    public function output() {
        //get the page header
        $html = parent::get_header();
        
        //check for message to display
        if (isset($this->errorMessage)) {
            //inject error messages
            $html .= <<<HTML
                    <div class="user-message">
                        $this->errorMessage
                    </div>
HTML;
        } else {
            //inject welcome message
            $html .= <<<HTML
                    <span></span>
HTML;
        }
        
        //inject the content
        $html .= <<<HTML
                
                <form id="always-alert-form" method="post" action="./?action=find-courses" >

                <span class="form-row">
                    <fieldset>
                        <legend>Course Lookup</legend>
                        
                        <label for="course-area">Which area would you like to look in?</label>
                        <select name="course-area">
HTML;
        $optionString;
        foreach ($this->areaList as $key => $value) {
            $optionString .= "<option value=\"$value\">$key</option>";
        }
        
        $html .= <<<HTML
            {$optionString}
                        </select> 
                        
                        <input type="submit" class="button" value="Submit" />
                    </fieldset>
                </span>
            </form>
HTML;
        
        //get the page footer
        $html .= parent::get_footer();
        
        //return the view
        return $html;
    }
}
