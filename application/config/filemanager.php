<?php defined('BASEPATH') OR exit('No direct script access allowed.');
/*
|--------------------------------------------------------------------------
| Optional security
|--------------------------------------------------------------------------
|
| if set to true only those will access RF whose url contains the access key(akey) like:
| <input type="button" href="../filemanager/dialog.php?field_id=imgField&lang=en_EN&akey=myPrivateKey" value="Files">
| in tinymce a new parameter added: filemanager_access_key:"myPrivateKey"
| example tinymce config:
|
| tiny init ...
| external_filemanager_path:"../filemanager/",
| filemanager_title:"Filemanager" ,
| filemanager_access_key:"myPrivateKey" ,
| ...
|
*/

define('USE_ACCESS_KEYS', false); // TRUE or FALSE
// $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && ! in_array(strtolower($_SERVER['HTTPS']), array( 'off', 'no' ))) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

$config['upload_dir'] = '/upload/';
$config['current_path'] = '../upload/';
$config['thumbs_base_path'] = '../thumbs/';
$config['access_keys'] = array();
$config['MaxSizeUpload'] = ((int)(ini_get('post_max_size')));
$config['default_language'] = 'en_EN';
$config['icon_theme'] = 'ico';
$config['show_folder_size'] = true;
$config['show_sorting_bar'] = true;
$config['transliteration'] = false;
$config['convert_spaces'] = false;
$config['replace_with'] = "_";
$config['lazy_loading_file_number_threshold'] = 0;
$config['image_max_width'] = 0;
$config['image_max_height'] = 0;
$config['image_max_mode'] = 'auto';
$config['image_resizing'] = false;
$config['image_resizing_width'] = 0;
$config['image_resizing_height'] = 0;
$config['image_resizing_mode'] = 'auto';
$config['image_resizing_override'] = false;
$config['default_view'] = 0;
$config['ellipsis_title_after_first_row'] = true;
$config['delete_files'] = true;
$config['create_folders'] = true;
$config['delete_folders'] = true;
$config['upload_files'] = true;
$config['rename_files'] = true;
$config['rename_folders'] = true;
$config['duplicate_files'] = true;
$config['copy_cut_files'] = true;
$config['copy_cut_dirs'] = true;
$config['chmod_files'] = false;
$config['chmod_dirs'] = false;
$config['preview_text_files'] = true;
$config['edit_text_files'] = true;
$config['create_text_files'] = true;
$config['previewable_text_file_exts'] = array( 'txt', 'log', 'xml', 'html', 'css', 'htm', 'js' );
$config['previewable_text_file_exts_no_prettify'] = array( 'txt', 'log' );
$config['editable_text_file_exts'] = array( 'txt', 'log', 'xml', 'html', 'css', 'htm', 'js' );
$config['googledoc_enabled'] = true;
$config['googledoc_file_exts'] = array( 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx' );
$config['viewerjs_enabled'] = true;
$config['viewerjs_file_exts'] = array( 'pdf', 'odt', 'odp', 'ods' );
$config['copy_cut_max_size'] = 100;
$config['copy_cut_max_count'] = 200;
$config['ext_img'] = array( 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg' );
$config['ext_file'] = array( 'doc', 'docx', 'rtf', 'pdf', 'xls', 'xlsx', 'txt', 'csv', 'html', 'xhtml', 'psd', 'sql', 'log', 'fla', 'xml', 'ade', 'adp', 'mdb', 'accdb', 'ppt', 'pptx', 'odt', 'ots', 'ott', 'odb', 'odg', 'otp', 'otg', 'odf', 'ods', 'odp', 'css', 'ai' );
$config['ext_video'] = array( 'mov', 'mpeg', 'm4v', 'mp4', 'avi', 'mpg', 'wma', "flv", "webm" );
$config['ext_music'] = array( 'mp3', 'm4a', 'ac3', 'aiff', 'mid', 'ogg', 'wav' );
$config['ext_misc'] = array( 'zip', 'rar', 'gz', 'tar', 'iso', 'dmg' );//Archives

$config['aviary_active'] = true;
$config['aviary_apiKey'] = "2444282ef4344e3dacdedc7a78f8877d";
$config['aviary_language'] = "en";
$config['aviary_theme'] = "light";
$config['aviary_tools'] = "all";
$config['aviary_maxSize'] = "1400";

$config['aviary_defaults_config'] = array(
	'apiKey'     => $config['aviary_apiKey'],
	'language'   => $config['aviary_language'],
	'theme'      => $config['aviary_theme'],
	'tools'      => $config['aviary_tools'],
	'maxSize'    => $config['aviary_maxSize']
);

$config['file_number_limit_js'] = "500";

$config['hidden_folders'] = array();
$config['hidden_files'] = array( 'config.php' );
$config['java_upload'] = false;
$config['JAVAMaxSizeUpload'] = 200;//Gb

$config['fixed_image_creation'] = false;//activate or not the creation of one or more image resized with fixed path from filemanager folder
$config['fixed_path_from_filemanager'] = array( '../test/', '../test1/' );//fixed path of the image folder from the current position on upload folder
$config['fixed_image_creation_name_to_prepend'] = array( '', 'test_' );//name to prepend on filename
$config['fixed_image_creation_to_append'] = array( '_test', '' );//name to appendon filename
$config['fixed_image_creation_width'] = array( 300, 400 ); //width of image (you can leave empty if you set height)
$config['fixed_image_creation_height'] = array( 200, '' ); //height of image (you can leave empty if you set width)
$config['fixed_image_creation_option'] = array( 'crop', 'auto' ); //set the type of the crop

$config['relative_image_creation'] = false; //activate or not the creation of one or more image resized with relative path from upload folder
$config['relative_path_from_current_pos'] = array( './', './' ); //relative path of the image folder from the current position on upload folder
$config['relative_image_creation_name_to_prepend'] = array( '', '' ); //name to prepend on filename
$config['relative_image_creation_name_to_append'] = array( '_thumb', '_thumb1' ); //name to append on filename
$config['relative_image_creation_width'] = array( 300, 400 ); //width of image (you can leave empty if you set height)
$config['relative_image_creation_height'] = array( 200, '' ); //height of image (you can leave empty if you set width)
$config['relative_image_creation_option'] = array( 'crop', 'crop' ); //set the type of the crop
$config['remember_text_filter'] = false; // Remember text filter after close filemanager for future session

$config['ext'] = array_merge($config['ext_img'],$config['ext_file'],$config['ext_misc'],$config['ext_video'],$config['ext_music']);

