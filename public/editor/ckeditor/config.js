/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
    { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
    { name: 'forms' },
    '/',
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
    { name: 'links' },
    { name: 'insert' },
    '/',
    { name: 'styles' },
    { name: 'colors' },
    { name: 'tools' },
    { name: 'others' },
    { name: 'youtube' }
];
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	   //config.extraPlugins = 'imageuploader';
	   //config.extraPlugins = 'image';
	   //config.extraPlugins = 'easyimage';
	   	config.filebrowserBrowseUrl = 'ckeditor/ckfinder/ckfinder.html',
		config.filebrowserImageBrowseUrl = 'ckeditor/ckfinder/ckfinder.html?type=Images',
		config.filebrowserFlashBrowseUrl = 'ckeditor/ckfinder/ckfinder.html?type=Flash',
		config.filebrowserUploadUrl = 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
		config.filebrowserImageUploadUrl = 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		config.filebrowserFlashUploadUrl = 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		config.extraPlugins = 'youtube',
		config.skin = 'office2013'



};
