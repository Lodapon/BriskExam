<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CKEditor 5 classic example with math plugin</title>
</head>

<body>
<h1>CKEditor 5 – classic editor build</h1>
<h2>Math plugin – MathJax demo</h2>

<h2>Example TeX equations</h2>
<b>Math</b>
<pre>x=\frac{-b\pm\sqrt{b^2-4ac}}{2a}</pre>
<b>Chem</b>
<pre>\ce{CH4 + 2 O2 -> CO2 + 2 H2O}</pre>

<h2>Paste from text</h2>
<b>Display</b>
<pre>\[ x=\frac{-b\pm\sqrt{b^2-4ac}}{2a} \]</pre>
<b>Inline</b>
<pre>\( x+\sqrt{1-x^2} \)</pre>

<h2>Editor</h2>
<div id="editor" placeholder="Type the content here!">
    <p>Lorem... <span class="math-tex"> \(x=\frac{-b\pm\sqrt{b^2-4ac}}{2a} \) </span> ...ipsum</p>
    <p>Lorem... <span class="math-tex"> \[ x=\frac{-b\pm\sqrt{b^2-4ac}}{2a} \] </span> ...ipsum</p>
    <p>Lorem... <script type="math/tex">x+\sqrt{1-x^2}</script> ...ipsum</p>
    <p>Lorem... <script type="math/tex; mode=display">x+\sqrt{1-x^2}</script> ...ipsum</p>
</div>

<h2>Preview</h2>
<div id="editor-preview"></div>

<h2>Data</h2>
<pre id="editor-preview-html" style="word-wrap: break-word; white-space: pre-wrap;"></pre>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.6/MathJax.js?config=TeX-MML-AM_CHTML"></script>

{{--<script src="{{asset("vendor/ckeditor5.js")}}"></script>--}}
<script src="{{asset("vendor/ckeditor5/build/ckeditor.js")}}"></script>
<script>
    function getEditorData() {
        const data = window.ckeditor.getData();

        // HTML
        const preview = document.getElementById('editor-preview');
        preview.innerHTML = data;
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, preview]); // MathJax 2

        // Text
        document.getElementById('editor-preview-html').innerText = data;
    }

    ClassicEditor.create(document.querySelector('#editor'), {
        toolbar: {
            items: [
                'heading',
                '|',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'outdent',
                'indent',
                '|',
                'math',
                'imageUpload',
                'blockQuote',
                'insertTable',
                'mediaEmbed',
                'undo',
                'redo'
            ]
        },
        math: {
            engine: 'mathjax',
            outputType: 'script',
            forceOutputType: false,
            enablePreview: true
        }
    })
        .then(editor => {
            window.ckeditor = editor;
            getEditorData();
            editor.model.document.on('change:data', () => {
                getEditorData();
            });
        })
        .catch(err => {
            console.error(err);
        });
</script>
</body>

</html>
