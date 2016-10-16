<?php

/**
 * CoreAreaLookupView.
 *
 * @author Joseph Daigle
 */
class CoreAreaCourseView extends View
{
    
    private $areaList;
    private $selectedArea;
    private $courseList;
    
  
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
    
    public function setCourseList($courseList) {
        $this->courseList = $courseList;
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
                
                <form id="always-alert-form" method="post" action="./?action=find-courses" >

                <span class="form-row">
                    <fieldset>
                        <legend>Course Lookup</legend>
                        
                        <label for="course-area">Which area would you like to look in?</label>
                        <select name="course-area">
HTML;
        $optionString;
        foreach ($this->areaList as $key => $value) {
            if (strcasecmp($this->selectedArea, $value) === 0) {
                $optionString .= "<option value=\"$value\" selected=\"selected\""
                        . "aria-selected=\"selected\">$key</option>";
            } else {
                $optionString .= "<option value=\"$value\">$key</option>";

            }
        }
        
        $html .= <<<HTML
            {$optionString}
                        </select> 
                        
                        <input type="submit" class="button" value="Submit" />
                    </fieldset>
                </span>
            </form>
HTML;
        $html .= <<<HTML
                <table class="output_table" summary="table displaying core area
                course requirements" dir="ltr">
                    <tbody>
                        <tr>
                            <th>Subject</th>
                            <th>No.</th>
                            <th>Course Title</th>
                            <th>Credit<br/> Hours</th>
                            <th>Delete</th>
                        </tr>
HTML;
        
        for($i = 0; $i < count($this->courseList['CORE_CODE']); $i++) {
            $html .= <<<HTML
                    <tr>
                        <td>{$this->courseList['SUBJECT_CODE'][$i]}</td>
                        <td>{$this->courseList['COURSE_NUMBER'][$i]}</td>
                        <td>{$this->courseList['TITLE'][$i]}</td>
                        <td class="center-text">{$this->courseList['CREDIT_HOURS'][$i]}</td>
                        <td class="center-text"><a href="#"><i class="fa fa-trash-o" /></a></td>
                    </tr>
HTML;
        }
        
        $html .= "</tbody></table>";
            
            
            
        //get the page footer
        $html .= parent::get_footer();
        
        //return the view
        return $html;
    }
}
