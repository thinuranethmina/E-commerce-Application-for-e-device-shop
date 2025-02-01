
const {
    ClassicEditor,
    Alignment,
    Autoformat,
    AutoImage,
    AutoLink,
    Autosave,
    BlockQuote,
    Bold,
    Bookmark,
    CKBox,
    CKBoxImageEdit,
    CloudServices,
    Code,
    Essentials,
    FindAndReplace,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HorizontalLine,
    ImageBlock,
    ImageCaption,
    ImageInline,
    ImageInsert,
    ImageInsertViaUrl,
    ImageResize,
    ImageStyle,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    Indent,
    IndentBlock,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    Mention,
    PageBreak,
    Paragraph,
    PasteFromOffice,
    PictureEditing,
    RemoveFormat,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    Strikethrough,
    Style,
    Subscript,
    Superscript,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextTransformation,
    TodoList,
    Underline
} = window.CKEDITOR;
const {
    CaseChange,
    ExportPdf,
    ExportWord,
    FormatPainter,
    ImportWord,
    MergeFields,
    MultiLevelList,
    PasteFromOfficeEnhanced,
    SlashCommand,
    TableOfContents,
    Template
} = window.CKEDITOR_PREMIUM_FEATURES;

const LICENSE_KEY =
    'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3Mzk0OTExOTksImp0aSI6IjcwNWFhNDhkLTAxZjMtNGM3Yi05MGFlLWVhYzkyZDg2NTIyYiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6IjM3ODhmOTQ5In0.sUwK06gU4bNJVk2BUHEUDihY7lV-UXpSyPZULos3yOjdhcqPtKU4I2l4awIPXRusZ5u9aYtmVkjBGB_Ziicfiw';

const CLOUD_SERVICES_TOKEN_URL =
    'https://4sqpx2o9a721.cke-cs.com/token/dev/ca381a402b285b4ab63ad7d6dc36d37475577be618881a8cb2ea2a7a09c5?limit=10';

const editorConfig = {
    toolbar: {
        items: [
            'insertMergeField',
            'previewMergeFields',
            '|',
            'formatPainter',
            '|',
            'heading',
            'style',
            '|',
            'fontSize',
            'fontFamily',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'link',
            'insertImage',
            'insertTable',
            'highlight',
            'blockQuote',
            '|',
            'alignment',
            '|',
            'bulletedList',
            'numberedList',
            'multiLevelList',
            'todoList',
            'outdent',
            'indent'
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        Alignment,
        Autoformat,
        AutoImage,
        AutoLink,
        Autosave,
        BlockQuote,
        Bold,
        Bookmark,
        CaseChange,
        CKBox,
        CKBoxImageEdit,
        CloudServices,
        Code,
        Essentials,
        ExportPdf,
        ExportWord,
        FindAndReplace,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        FormatPainter,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        HorizontalLine,
        ImageBlock,
        ImageCaption,
        ImageInline,
        ImageInsert,
        ImageInsertViaUrl,
        ImageResize,
        ImageStyle,
        ImageTextAlternative,
        ImageToolbar,
        ImageUpload,
        ImportWord,
        Indent,
        IndentBlock,
        Italic,
        Link,
        LinkImage,
        List,
        ListProperties,
        Mention,
        MergeFields,
        MultiLevelList,
        PageBreak,
        Paragraph,
        PasteFromOffice,
        PasteFromOfficeEnhanced,
        PictureEditing,
        RemoveFormat,
        SlashCommand,
        SpecialCharacters,
        SpecialCharactersArrows,
        SpecialCharactersCurrency,
        SpecialCharactersEssentials,
        SpecialCharactersLatin,
        SpecialCharactersMathematical,
        SpecialCharactersText,
        Strikethrough,
        Style,
        Subscript,
        Superscript,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableOfContents,
        TableProperties,
        TableToolbar,
        Template,
        TextTransformation,
        TodoList,
        Underline
    ],
    cloudServices: {
        tokenUrl: CLOUD_SERVICES_TOKEN_URL
    },
    exportPdf: {
        stylesheets: [
            /* This path should point to application stylesheets. */
            /* See: https://ckeditor.com/docs/ckeditor5/latest/features/converters/export-pdf.html */
            './style.css',
            /* Export PDF needs access to stylesheets that style the content. */
            'https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css',
            'https://cdn.ckeditor.com/ckeditor5-premium-features/44.1.0/ckeditor5-premium-features.css'
        ],
        fileName: 'export-pdf-demo.pdf',
        converterOptions: {
            format: 'Tabloid',
            margin_top: '20mm',
            margin_bottom: '20mm',
            margin_right: '24mm',
            margin_left: '24mm',
            page_orientation: 'portrait'
        }
    },
    exportWord: {
        stylesheets: [
            /* This path should point to application stylesheets. */
            /* See: https://ckeditor.com/docs/ckeditor5/latest/features/converters/export-word.html */
            './style.css',
            /* Export Word needs access to stylesheets that style the content. */
            'https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css',
            'https://cdn.ckeditor.com/ckeditor5-premium-features/44.1.0/ckeditor5-premium-features.css'
        ],
        fileName: 'export-word-demo.docx',
        converterOptions: {
            document: {
                orientation: 'portrait',
                size: 'Tabloid',
                margins: {
                    top: '20mm',
                    bottom: '20mm',
                    right: '24mm',
                    left: '24mm'
                }
            }
        }
    },
    fontFamily: {
        supportAllValues: true
    },
    fontSize: {
        options: [10, 12, 14, 'default', 18, 20, 22],
        supportAllValues: true
    },
    heading: {
        options: [{
            model: 'paragraph',
            title: 'Paragraph',
            class: 'ck-heading_paragraph'
        },
        {
            model: 'heading1',
            view: 'h1',
            title: 'Heading 1',
            class: 'ck-heading_heading1'
        },
        {
            model: 'heading2',
            view: 'h2',
            title: 'Heading 2',
            class: 'ck-heading_heading2'
        },
        {
            model: 'heading3',
            view: 'h3',
            title: 'Heading 3',
            class: 'ck-heading_heading3'
        },
        {
            model: 'heading4',
            view: 'h4',
            title: 'Heading 4',
            class: 'ck-heading_heading4'
        },
        {
            model: 'heading5',
            view: 'h5',
            title: 'Heading 5',
            class: 'ck-heading_heading5'
        },
        {
            model: 'heading6',
            view: 'h6',
            title: 'Heading 6',
            class: 'ck-heading_heading6'
        }
        ]
    },
    htmlSupport: {
        allow: [{
            name: /^.*$/,
            styles: true,
            attributes: true,
            classes: true
        }]
    },
    image: {
        toolbar: [
            'toggleImageCaption',
            'imageTextAlternative',
            '|',
            'imageStyle:inline',
            'imageStyle:wrapText',
            'imageStyle:breakText',
            '|',
            'resizeImage',
            '|',
            'ckboxImageEdit'
        ]
    },
    initialData: typeof productContent !== 'undefined' ? productContent : '',
    licenseKey: LICENSE_KEY,
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    mention: {
        feeds: [{
            marker: '@',
            feed: [
                /* See: https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html */
            ]
        }]
    },
    menuBar: {
        isVisible: true
    },
    mergeFields: {
        /* Read more: https://ckeditor.com/docs/ckeditor5/latest/features/merge-fields.html#configuration */
    },
    placeholder: 'Type or paste your content here!',
    style: {
        definitions: [{
            name: 'Article category',
            element: 'h3',
            classes: ['category']
        },
        {
            name: 'Title',
            element: 'h2',
            classes: ['document-title']
        },
        {
            name: 'Subtitle',
            element: 'h3',
            classes: ['document-subtitle']
        },
        {
            name: 'Info box',
            element: 'p',
            classes: ['info-box']
        },
        {
            name: 'Side quote',
            element: 'blockquote',
            classes: ['side-quote']
        },
        {
            name: 'Marker',
            element: 'span',
            classes: ['marker']
        },
        {
            name: 'Spoiler',
            element: 'span',
            classes: ['spoiler']
        },
        {
            name: 'Code (dark)',
            element: 'pre',
            classes: ['fancy-code', 'fancy-code-dark']
        },
        {
            name: 'Code (bright)',
            element: 'pre',
            classes: ['fancy-code', 'fancy-code-bright']
        }
        ]
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
    },
};

if (document.querySelector('#editor')) {
    configUpdateAlert(editorConfig);

    ClassicEditor.create(document.querySelector('#editor'), editorConfig);
}



/**
 * This function exists to remind you to update the config needed for premium features.
 * The function can be safely removed. Make sure to also remove call to this function when doing so.
 */
function configUpdateAlert(config) {
    if (configUpdateAlert.configUpdateAlertShown) {
        return;
    }

    const isModifiedByUser = (currentValue, forbiddenValue) => {
        if (currentValue === forbiddenValue) {
            return false;
        }

        if (currentValue === undefined) {
            return false;
        }

        return true;
    };

    const valuesToUpdate = [];

    configUpdateAlert.configUpdateAlertShown = true;

    if (!isModifiedByUser(config.licenseKey, '<YOUR_LICENSE_KEY>')) {
        valuesToUpdate.push('LICENSE_KEY');
    }

    if (!isModifiedByUser(config.cloudServices?.tokenUrl, '<YOUR_CLOUD_SERVICES_TOKEN_URL>')) {
        valuesToUpdate.push('CLOUD_SERVICES_TOKEN_URL');
    }

    if (valuesToUpdate.length) {
        window.alert(
            [
                'Please update the following values in your editor config',
                'to receive full access to Premium Features:',
                '',
                ...valuesToUpdate.map(value => ` - ${value}`)
            ].join('\n')
        );
    }
}
