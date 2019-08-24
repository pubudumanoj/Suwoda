<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

/**
*
* @author roytuts.com
*/
class Backup_control extends CI_Controller {

    public function index(){
        // Load the DB utility class
$this->load->dbutil();

// Backup your entire database and assign it to a variable



$prefs = array(
              
                
                'format'      => 'gzip',             // gzip, zip, txt
                'filename'    => 'suwodadb_backup.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );

$backup =& $this->dbutil->backup($prefs);



// Load the file helper and write the file to your server
$datesql =Date("Y_m_d");
$this->load->helper('file');
write_file(base_url().'/backups/databases/database_backup'.$datesql.'.gz', $backup); 

// Load the download helper and send the file to your desktop
$this->load->helper('download');
force_download('database_backup'.$datesql.'.gz', $backup);
redirect('', 'refresh');
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/backup.php */