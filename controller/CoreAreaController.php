<?php

/**
 * Class CoreAreaController.
 * 
 * This class implements program flow for the Course Area section of
 * the Academic Summary.
 *
 * @author joseph daigle
 */
class CoreAreaController {
    private $view;
    private $academicSummaryDao;
    
    public function __construct() {
        $this->academicSummaryDao = new AcademicSummaryDaoImpl();
    }
    
    public function do_request($httpRequest) {
        
        //route request
        switch($httpRequest->get_arg('action')) {
            
            case 'init':
                try {
                    $areaList = $this->academicSummaryDao->fetchCoreAreasList();
                    $view = new CoreAreaLookupView();
                    
                    $view->setAreaList($areaList);
                    echo $view->output();
                } catch (Exception $ex) {
                    $view = new ErrorView();
                    echo $view->output($ex);
                }
                break;
            case 'find-courses':
                $courseList = $this->academicSummaryDao->fetchCoreAreaCourses($httpRequest->get_arg('course-area'));
                
                $areaList = $this->academicSummaryDao->fetchCoreAreasList();

                //display view
                if (empty($courseList['CORE_CODE'])) {
                    $this->view = new CoreAreaLookupView();
                    $this->view->setAreaList($areaList);
                    $this->view->set_notification("No records were returned.");
                    echo $this->view->output();
                }
                $this->view = new CoreAreaCourseView();
                $this->view->setAreaList($areaList);
                $this->view->setCourseList($courseList);
                $this->view->setSelectedArea($httpRequest->get_arg('course-area'));
                echo $this->view->output();
                
                break;
            case 'add-core-course':
                $this->view = new AddCoreCourseView();
                
                $this->view->setSelectedArea($httpRequest->get_arg('course-area'));
                $this->view->setAreaList($this->academicSummaryDao->fetchCoreAreasList());
                $this->view->setSubjectList($this->academicSummaryDao->fetchCourseSubjectCodes());
//                $this->view->setCourseNumberList($this->academicSummaryDao->fetchCourseNumberList($subjectCode));
                
                echo $this->view->output();
            break;
        
            default:
                $this->view = new ResourcesNotAvailableView();
                echo $this->view->output();
            break;
        }
    }
}
