import scriptjs from 'scriptjs'

export class EditorTextarea extends HTMLTextAreaElement {
    connectedCallback()
    {
        scriptjs('//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js', () => {
            new SimpleMDE({
                spellChecker: false,
                toolbar: [
                    {
                        name: "bold",
                        action: SimpleMDE.toggleBold,
                        className: "icon ni ni-bold",
                        title: "Bold",
                },
                    {
                        name: 'italic',
                        action: SimpleMDE.toggleItalic,
                        className: 'icon ni ni-italic',
                        title: "Italic"
                },
                    {
                        name: 'code',
                        action: SimpleMDE.toggleCodeBlock,
                        className: 'icon ni ni-code',
                        title: "Code"
                },
                    {
                        name: 'quote',
                        action: SimpleMDE.toggleBlockquote,
                        className: 'icon ni ni-quote-left',
                        title: 'Quote'
                },
                    '|',
                    {
                        name: 'link',
                        action: SimpleMDE.drawLink,
                        className: 'icon ni ni-link',
                        title: 'Create Link'
                },
                    {
                        name: 'image',
                        action: SimpleMDE.drawImage,
                        className: 'icon ni ni-img',
                        title: 'Insert Image'
                },
                    '|',
                    {
                        name: 'preview',
                        action: SimpleMDE.togglePreview,
                        className: 'icon ni ni-eye no-disable',
                        title: 'Preview'
                },
                    {
                        name: 'side-by-side',
                        action: SimpleMDE.toggleSideBySide,
                        className: 'icon ni ni-col-2s no-disable no-mobile',
                        title: 'Toggle Side by Side'
                },
                    {
                        name: 'fullscreen',
                        action: SimpleMDE.toggleFullScreen,
                        className: 'icon ni ni-maximize-alt',
                        title: 'Fullscreen'
                }
                ],
                element: this,
                autoDownloadFontAwesome: true,
                autosave: {
                    enabled: true,
                    delay: 10000,
                    uniqueId: this.id,
                },
                renderingConfig: {
                    codeSyntaxHighlighting: true,
                }
            });
        })
    }
}
