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
	'ar' => array(
	'inplace_scaler_not_enough_params' => 'لا محددات كافية.',
	'inplace_scaler_invalid_image' => 'صورة غير صحيحة، لم يمكن تحديد الحجم.',
	'webstore_path_invalid' => 'اسم الملف كان غير صحيح.',
	'webstore_no_file' => 'لم يتم رفع أي ملف.',
	'webstore_invalid_zone' => 'منطقة غير صحيحة "$1".',
	'webstore_404' => 'لم يتم إيجاد الملف.',
	'webstore_php_warning' => 'تحذير PHP: $1',
	'webstore_metadata_not_found' => 'الملف غير موجود: $1',
	'webstore_postfile_not_found' => 'الملف للإرسال غير موجود.',
	'webstore_invalid_response' => 'رد غير صحيح من الخادم:

$1',
	'webstore_no_response' => 'لا رد من الخادم',
	),
	'ext' => array(
	'webstore_rename' => 'Marru rehucheandu el archivu "$1" a "$2".',
	'webstore_no_file' => 'Nu s´á empuntau dengún archivu.',
	'webstore_404' => 'Archivu nu alcuentrau.',
	),
	'hsb' => array(
	'inplace_access_disabled' => 'Přistup k tutej słužbje bu za wšě klienty znjemóžnjeny.',
	'inplace_access_denied' => 'Tuta słužba so přez klientowy IP wobmjezuje.',
	'inplace_scaler_no_temp' => 'Žadyn płaćiwy temporerny zapis, staj wariablu $wgLocalTmpDirectory na popisajomny zapis',
	'inplace_scaler_not_enough_params' => 'Falowace parametry.',
	'inplace_scaler_invalid_image' => 'Njepłaćiwy wobraz, wulkosć njeda so zwěsćić.',
	'inplace_scaler_failed' => 'Při skalowanju je zmylk wustupił: $1',
	'inplace_scaler_no_handler' => 'Žadyn rjadowak, zo by so tutón MIME-typ přetworił',
	'inplace_scaler_no_output' => 'Njeje so žana wudawanska dataja spłodźiła.',
	'inplace_scaler_zero_size' => 'Přetworjenje spłodźi prózdnu wudawansku dataju.',
	'webstore_access' => 'Tuta słužba so přez klientowy IP wobmjezuje.',
	'webstore_path_invalid' => 'Datajowe mjeno bě njepłaćiwe.',
	'webstore_dest_open' => 'Njeje móžno cilowu dataju "$1" wočinić.',
	'webstore_dest_lock' => 'Zawrjenje ciloweje dataje "$1" njeje so poradźiło.',
	'webstore_dest_mkdir' => 'Njeje móžno cilowy zapis "$1" wutworić.',
	'webstore_archive_lock' => 'Zawrjenje archiwneje dataje "$1" njeje so poradźiło.',
	'webstore_archive_mkdir' => 'Njeje móžno archiwowy zapis "$1" wutworić.',
	'webstore_src_open' => 'Njeje móžno žórłowu dataju "$1" wočinić.',
	'webstore_src_close' => 'Zmylk při začinjenju žórłoweje dataje "$1".',
	'webstore_src_delete' => 'Zmylk při zničenju dataje "$1".',
	'webstore_rename' => 'Zmylk při přemjenowanju dataje "$1" do "$2".',
	'webstore_lock_open' => 'Zmylk při wočinjenju blokowaceje dataje "$1".',
	'webstore_lock_close' => 'Zmylk při začinjenju blokowaceje dataje "$1".',
	'webstore_dest_exists' => 'Zmylk, cilowa dataja "$1" eksistuje.',
	'webstore_temp_open' => 'Zmylk při wočinjenju temporerneje dataje "$1".',
	'webstore_temp_copy' => 'Zmylk při kopěrowanju temporerneje dataje "$1" do ciloweje dataje "$2".',
	'webstore_temp_close' => 'Zmylk při začinjenju temporerneje dataje "$1".',
	'webstore_temp_lock' => 'Zmylk při zawrjenju temporerneje dataje "$1".',
	'webstore_no_archive' => 'Cilowa dataja eksistuje a žadyn archiw njebu podaty.',
	'webstore_no_file' => 'Žana dataja njebu nahrata.',
	'webstore_move_uploaded' => 'Zmylk při přesunjenju nahrateje dataje "$1" k nachwilnemu městnu "$2".',
	'webstore_invalid_zone' => 'Njepłaćiwy wobłuk "$1".',
	'webstore_no_deleted' => 'Njebu žadyn archiwowy zapis za zničene dataje definowany.',
	'webstore_curl' => 'Zmylk z cURL: $1',
	'webstore_404' => 'Dataja njenamakana.',
	'webstore_php_warning' => 'Warnowanje PHP: $1',
	'webstore_metadata_not_found' => 'Dataja njenamakana: $1',
	'webstore_postfile_not_found' => 'Dataja, kotraž ma so wotesłać, njebu namakana.',
	'webstore_scaler_empty_response' => 'Wobrazowy skalowar wróći prózdnu wotmołwu z wotmołwnym kodom 200. Přičina móhła ćežki zmylk PHP w skalowarju być.',
	'webstore_invalid_response' => 'Njepłaćiwa wotmołwa ze serwera:

$1',
	'webstore_no_response' => 'Žana wotmołwa ze serwera',
	'webstore_backend_error' => 'Zmylk ze składowanskeho serwera:

$1',
	'webstore_php_error' => 'Zmylki PHP su wustupili:',
	'webstore_no_handler' => 'Žadyn rjadowak, zo by so tutón MIME-typ přetworił',
	),
	'nl' => array(
		'inplace_access_disabled' => 'Toegang tot deze dienst is uitgeschakeld voor alle clients.',
		'inplace_access_denied' => 'Deze dienst is afgeschermd op basis van het IP-adres van een client.',
		'inplace_scaler_no_temp' => 'Geen juiste tijdelijke map, geef schrijfrechten op $wgLocalTmpDirectory.',
		'inplace_scaler_not_enough_params' => 'Niet genoeg parameters.',
		'inplace_scaler_invalid_image' => 'Onjuiste afbeelding. Grootte kon niet bepaald worden.',
		'inplace_scaler_failed' => 'Er is een fout opgetreden bij het schalen van de afbeelding: $1',
		'inplace_scaler_no_handler' => 'Dit MIME-type kan niet getransformeerd worden',
		'inplace_scaler_no_output' => 'Er is geen uitvoerbestand voor de transformatie gemaakt.',
		'inplace_scaler_zero_size' => 'De grootte van het uitvoerbestand van de transformatie was nul.',

		'webstore_access' => 'Deze dienst is afgeschermd op basis van het IP-adres van een client.',
		'webstore_path_invalid' => 'De bestandnaam was ongeldig.',
		'webstore_dest_open' => 'Het doelbestand "$1" kon niet geopend worden.',
		'webstore_dest_lock' => 'Het doelbestand "$1" was niet te locken.',
		'webstore_dest_mkdir' => 'De doelmap "$1" kon niet aangemaakt worden.',
		'webstore_archive_lock' => 'Het archiefbestand "$1" was niet te locken.',
		'webstore_archive_mkdir' => 'De archiefmap "$1" kon niet aangemaakt worden.',
		'webstore_src_open' => 'Het bronbestand "$1" was niet te openen.',
		'webstore_src_close' => 'Fout bij het sluiten van bronbestand "$1".',
		'webstore_src_delete' => 'Fout bij het verwijderen van bronbestand "$1".',

		'webstore_rename' => 'Fout bij het hernoemen van "$1" naar "$2".',
		'webstore_lock_open' => 'Fout bij het openen van lockbestand "$1".',
		'webstore_lock_close' => 'Fout bij het sluiten van lockbestand "$1".',
		'webstore_dest_exists' => 'Fout, doelbestand "$1" bestaat al.',
		'webstore_temp_open' => 'Fout bij het openen van tijdelijk bestand "$1".',
		'webstore_temp_copy' => 'Fout bij het kopiren van tijdelijk bestand "$1" naar doelbestand "$2".',
		'webstore_temp_close' => 'Fout bij het sluiten van tijdelijk bestand "$1".',
		'webstore_temp_lock' => 'Fout bij het locken van tijdelijk bestand "$1".',
		'webstore_no_archive' => 'Doelbestand bestaat en er is geen archief opgegeven.',

		'webstore_no_file' => 'Er is geen bestand geuploaded.',
		'webstore_move_uploaded' => 'Fout bij het verplaatsen van geupload bestand "$1" naar tijdelijke locatie "$2".',

		'webstore_invalid_zone' => 'Ongeldige zone "$1".',

		'webstore_no_deleted' => 'Er is geen archiefmap voor verwijderde bestanden gedefinieerd.',
		'webstore_curl' => 'Fout van cURL: $1',
		'webstore_404' => 'Bestand niet gevonden.',
		'webstore_php_warning' => 'PHP-waarschuwing: $1',
		'webstore_metadata_not_found' => 'Bestand  niet gevonden: $1',
		'webstore_postfile_not_found' => 'Te posten bestand niet gevonden.',
		'webstore_scaler_empty_response' => 'De afbeeldingenschaler gaf een leeg antwoorden met een 200 ' .
			'antwoordcode. Dit kan te maken hebben met een fatale PHP-fout in de schaler.',

		'webstore_invalid_response' => "Ongeldig antwoord van de server:\n\n$1\n",
		'webstore_no_response' => 'Geen antwoord van de server',
		'webstore_backend_error' => "Fout van de opslagserver:\n\n$1\n",
		'webstore_php_error' => 'Er zijn PHP-fouten opgetreden:',
		'webstore_no_handler' => 'Dit MIME-type kan niet getransformeerd worden',
	),
);
