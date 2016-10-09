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
        $this->AcademicSummaryDao = new AlwaysAlertDaoImpl();
    }
    
    public function do_request($httpRequest) {
        
        //route request
        switch($httpRequest->get_arg('action')) {
            
            case 'find-courses':
                
                //search for courses in user-selected area
//                $ = $this->academicSummaryDao->fetchCoreAreaCourses($httpRequest->get_arg('core-area'));
                                
                //display view
                if (empty($alwaysAlertRecord)) {
                    //could not find student - display error message
                    $this->view = new LookupView();
                    $this->view->set_error_message("I'm sorry, but I can't find that student." .
                            " If you feel this is an error, please check that you are using the correct GCID (929xxxxxx).");
                    echo $this->view->output();
                } else {
                    $this->view = new LookupView();
                    $this->view->setAlwaysAlertDetail($alwaysAlertRecord);
                    echo $this->view->output();
                }
                
                break;
            
            default:
                $this->view = new ResourcesNotAvailableView();
                echo $this->view->output();
                break;
        }
    }
}