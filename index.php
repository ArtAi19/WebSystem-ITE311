<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use CodeIgniter\Boot;
use Config\Paths;

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

// Load our paths config file
require FCPATH . 'app/Config/Paths.php';

$paths = new Paths();

// Load the framework bootstrap file
require $paths->systemDirectory . '/Boot.php';

exit(Boot::bootWeb($paths));
