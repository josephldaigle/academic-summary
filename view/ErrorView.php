<?php
/**
 * Description of AccessDenied
 *
 * @author Joseph Daigle
 */
class ErrorView extends View {
    
    public function __contstruct() {
        parent::__construct();
    }
    
    public function output($exception) {
        header("HTTP/1.0 500 Internal Server Error");
        //get the page header
        $html = parent::get_header();
        
        //inject view-specific content
        $html .= <<<HTML
                    <i class="fa fa-exclamation-triangle"></i>
                    <p id="access-denied">An error has occured. {$exception->getMessage()} 
                        If you believe you have received this message in error, 
                    <a href="mailto: helpstar@gordonstate.edu" >Submit a help ticket</a> to
                Information Technology.</p>
HTML;
        
        //get the page footer
        $html .= parent::get_footer();
        
        //return the view
        return $html;
    }
}
