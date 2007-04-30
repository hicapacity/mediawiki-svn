<?php

$messages = array(
	'en' => array(
		'inplace_access_disabled' => 'Access to this service has been disabled for all clients.',
		'inplace_access_denied' => 'This service is restricted by client IP.',
		'inplace_scaler_no_temp' => 'No valid temporary directory, set $wgLocalTmpDirectory to a writeable directory.',
		'inplace_scaler_not_enough_params' => 'Not enough parameters.',
		'inplace_scaler_invalid_image' => 'Invalid image, could not determine size.',
		'inplace_scaler_failed' => 'An error was encountered during image scaling: $1',
		'inplace_scaler_no_handler' => 'No handler for transforming this MIME type',
		'inplace_scaler_no_output' => 'No transformation output file was produced.',
		'inplace_scaler_zero_size' => 'Transformation produced a zero-sized output file.',

		'webstore_access' => 'This service is restricted by client IP.',
		'webstore_path_invalid' => 'The filename was invalid.',
		'webstore_dest_open' => 'Unable to open destination file "$1".',
		'webstore_dest_lock' => 'Failed to get lock on destination file "$1".',
		'webstore_dest_mkdir' => 'Unable to create destination directory "$1".',
		'webstore_archive_lock' => 'Failed to get lock on archive file "$1".',
		'webstore_archive_mkdir' => 'Unable to create archive directory "$1".',
		'webstore_src_open' => 'Unable to open source file "$1".',
		'webstore_src_close' => 'Error closing source file "$1".',
		'webstore_src_delete' => 'Error deleting source file "$1".',

		'webstore_rename' => 'Error renaming file "$1" to "$2".',
		'webstore_lock_open' => 'Error opening lock file "$1".',
		'webstore_lock_close' => 'Error closing lock file "$1".',
		'webstore_dest_exists' => 'Error, destination file "$1" exists.',
		'webstore_temp_open' => 'Error opening temporary file "$1".',
		'webstore_temp_copy' => 'Error copying temporary file "$1" to destination file "$2".',
		'webstore_temp_close' => 'Error closing temporary file "$1".',
		'webstore_temp_lock' => 'Error locking temporary file "$1".',
		'webstore_no_archive' => 'Destination file exists and no archive was given.',

		'webstore_no_file' => 'No file was uploaded.',
		'webstore_move_uploaded' => 'Error moving uploaded file "$1" to temporary location "$2".',

		'webstore_invalid_zone' => 'Invalid zone "$1".',

		'webstore_no_deleted' => 'No archive directory for deleted files is defined.',
		'webstore_curl' => 'Error from cURL: $1',
		'webstore_404' => 'File not found.',
		'webstore_php_warning' => 'PHP Warning: $1',
		'webstore_metadata_not_found' => 'File not found: $1',
		'webstore_postfile_not_found' => 'File to post not found.',
		'webstore_scaler_empty_response' => 'The image scaler gave an empty response with a 200 ' .
			'response code. This could be due to a PHP fatal error in the scaler.',

		'webstore_invalid_response' => "Invalid response from server:\n\n$1\n",
		'webstore_no_response' => 'No response from server',
		'webstore_backend_error' => "Error from storage server:\n\n$1\n",
		'webstore_php_error' => 'PHP errors were encountered:',
		'webstore_no_handler' => 'No handler for transforming this MIME type',
	),
);

?>
