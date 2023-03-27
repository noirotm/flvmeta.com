public/flvmeta.1.html: flvmeta.1.md html.template
	pandoc flvmeta.1.md --standalone --css style.css --template html.template -o public/flvmeta.1.html
