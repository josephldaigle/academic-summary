<?php
/**
 * Description of AddCoreCourseView
 *
 * @author Joseph Daigle
 */
class AddCoreCourseView extends View {
    private $areaList;
    private $subjectList;
    private $courseNumberList;
    private $selectedArea;
  
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
    
    public function setSubjectList($subjectList) {
        $this->subjectList = $subjectList;
    }
    
    public function setCourseNumberList($courseNumberList) {
        $this->courseNumberList = $courseNumberList;
    }
    
    public function setSelectedArea($selectedArea) {
        $this->selectedArea = $selectedArea;
    }
    
    public function output() {
        //get the page header
        $html = parent::get_header();
        
            $html .= "<div class=\"user-message\">" .
                        parent::get_notification() .
                    "</div>";
        
        //inject the content
        $html .= <<<HTML
                
                <form id="academic-summary-form" method="post" action="./?action=write&payload=core-area-course" >

                <span class="form-row">
                    <fieldset>
                        <legend>Course Lookup</legend>
                        
                        <label for="course-area">Course Area:</label>
                        <select name="course-area">
HTML;
        
        $optionString = '';
        foreach ($this->areaList as $key => $value) {
            if (strcasecmp($this->selectedArea, $value) === 0) {
                $optionString .= "<option value=\"$value\" selected=\"selected\""
                        . "aria-selected=\"selected\">$key</option>";
            } else {
                $optionString .= "<option value=\"$value\">$key</option>";

            }
        }
        
        $html .= $optionString . "</select></br/>";
        
        $html .= <<<HTML
                <label for="course-subject">Course Subject:</label>
                <select name="course-subject">
HTML;
        
        $optionString = '';
        foreach ($this->subjectList['SUBJECT_CODE'] as $value) {
            $optionString .= "<option value=\"$value\">$value</option>";
        }
//        die(print_r($this->subjectList));
        
        $html .= $optionString . "</select></br/>";
        
        $html .= <<<HTML
                </select><br/>
                
                <label for="course-number">Course Number:</label>
                <select name="course-number">
HTML;
        
        $optionString = '';
        foreach ($this->courseNumberList as $key => $value) {
            $optionString .= "<option value=\"$value\">$key</option>";
        }
        
        $html .= <<<HTML
                </select><br/>
        
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
