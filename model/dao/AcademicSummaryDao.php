<?php
/**
 *
 * @author joseph daigle
 */
interface AcademicSummaryDao {
    
    /**
     * Fetches the list of core areas from Banner DB.
     * Examples are Area A, Area B, and so on.
     */
    public function fetchCoreAreasList();
    
    /**
     * Fetches courses assigned to $coreAreaCode.
     * @param type $coreAreaCode
     */
    public function fetchCoreAreaCourses($coreAreaCode);
    
    
    public function fetchCourseSubjectCodes();
    
    public function fetchCourseNumbersList($subjectCode);
}
