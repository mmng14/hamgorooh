/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
	config.height=450;
	config.contentsLangDirection = 'rtl';
	config.dialog_buttonsOrder = 'rtl';
	config.language = 'fa';
	contentsLanguage: 'fa';

    config.filebrowserUploadUrl = '../../../resources/ckeditor/upload/upload.php';
    config.contentsCss = '../../../resources/shared/css/fonts.css';
	config.font_names = 'B Yekan/BYekan;Iran Sans/Iransans;Iran Sans FaNum/IransansFa;' + config.font_names;

	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'paragraph', groups: [  'align', 'bidi', 'paragraph' ,'list', 'indent'] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'insert', groups : ['SpecialChar' ] },
		{ name: 'styles', groups: ['styles'] },
        { name: 'links', groups: ['Link', 'Unlink', 'Anchor'] },
		{ name: 'colors', groups: ['colors'] }
	  

	];
	config.removeButtons = 'Anchor,Underline,Strike,Subscript,Superscript,HorizontalRule,Smiley,PageBreak,Iframe,Flash';
};


//config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript,Format,Styles,HorizontalRule,Smiley,PageBreak,Iframe,Flash,Image,Table';