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
    
    public function fetchCoreAreaCourses($coreAreaCode);
}
