<?php

/**
 * CoreAreaLookupView.
 *
 * @author Joseph Daigle
 */
class CoreAreaLookupView extends View{
    
    private $areaList;
  
    public function __construct() {
        parent::__construct();   
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
        
            $html .= "<div class=\"user-message\">" .
                        parent::get_notification();
                    "</div>";
        
        //inject the content
        $html .= <<<HTML
                
                <form id="academic-summary-form" method="post" action="./?action=find-courses" >

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
