<?php

/**
 * Class AcademicSummaryDaoImpl.
 * 
 * Description.
 * 
 *
 * @author joseph daigle
 */
class AcademicSummaryDaoImpl implements AcademicSummaryDao{
    private $dbConn;      //connection object
    
    public function __construct() {
       try {
            //get the db connection file path
            $connection_file = $_SERVER['DOCUMENT_ROOT'] . '\includes\connection.inc.php';

            //load the file
            require_once($connection_file);
            
            //fetch connection object
            $this->dbConn = dbConnect('read');
            if (!$this->dbConn) {
                throw new Exception(oci_error());
            }

        } catch (Exception $ex) {
            die("Fatal error in StudentDAO: Cannot establish connection to " .
                    "the Banner Database. Please contact Information Technology ".
                    " at (678) 359-5008, if you feel you have reached this message in error.");
        }
    }
    
    public function fetchCoreAreasList() {
        try {
            //query for active student
            $qry = "SELECT DISTINCT 'Area ' || wascore_core_code area,
                        wascore_core_code code
                    FROM baninst1.wascore";
            
            //Setup prepared statement
            $stid = oci_parse($this->dbConn, $qry);
          

            //execute query
            $r = oci_execute($stid);
            
//            die(print_r(oci_error($stid)));
            
            //return false if query fails to commit
            if (!$r) {
                $r =  "Failed to retrieve records from Banner: ";
//                TODO log statement that db query did not retrieve results
            } else {
//                $r = oci_fetch_array($stid, OCI_ASSOC);
                $r = oci_fetch_all($stid, $r, OCI_ASSOC);
                $r = array_merge($r['AREA'], $r['CODE']);
            }

            //release connection objects and return false
            oci_free_statement($stid);
            
            return $r;
            
        } catch (Exception $e) {
            //close connections and return false on error
            oci_free_statement($stid);

            return null;
        }
    }

    public function fetchCoreAreaCourses($coreAreaCode) {
        try {
            //query for active student
            $qry = "SELECT distinct WASCORE_CORE_CODE
                        , WASCORE_SUBJ_CODE
                        , WASCORE_CRSE_NUMB
                        , NVL (a.scbcrse_title, 'No SCACRSE found') Title
                        , NVL (TO_CHAR(a.SCBCRSE_CREDIT_HR_LOW), 'NA') Credithours
                    FROM wascore, scbcrse a
                    WHERE wascore.wascore_subj_code = a.scbcrse_subj_code(+)
                        AND wascore.wascore_crse_numb = a.scbcrse_crse_numb(+)
                        AND WASCORE_CORE_CODE = :CORE_AREA_CODE
                        AND (a.scbcrse_eff_term = (SELECT MAX (b.scbcrse_eff_term)
                                                        FROM scbcrse b
                                                        WHERE b.scbcrse_subj_code = a.scbcrse_subj_code
                                                            AND b.scbcrse_crse_numb = a.scbcrse_crse_numb)
                            OR a.scbcrse_eff_term IS NULL)
                    ORDER BY WASCORE_SUBJ_CODE, WASCORE_CRSE_NUMB";
            
            //Setup prepared statement
            $stid = oci_parse($this->dbConn, $qry);
          
            //bind data to query object
            oci_bind_by_name($stid, ':CORE_AREA_CODE', $coreAreaCode);
            
            //execute query
            $r = oci_execute($stid);
            
//            die(print_r(oci_error($stid)));
            
            //return false if query fails to commit
            if (!$r) {
                $r =  "Failed to retrieve records from Banner: ";
//                TODO log statement that db query did not retrieve results
            } else {
                $r = oci_fetch_array($stid, OCI_ASSOC);
            }

            //release connection objects and return false
            oci_free_statement($stid);
            
            return $r;
            
        } catch (Exception $e) {
            //close connections and return false on error
            oci_free_statement($stid);

            return null;
        }
    }

//put your code here
}
