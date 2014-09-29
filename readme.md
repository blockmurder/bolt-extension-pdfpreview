PDFpreview
======

How to use: 

    {{ pdfpre( filename, width, hight ) }}
    
    for example:

        {% for item in record.filelist %}
            <a href="{{ paths.files }}{{ item.filename }}">{{ pdfpre( item.filename, 600, 800 ) }}</a>		
        {% endfor %}


