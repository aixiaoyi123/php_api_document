<script>
        function download_file(url)  
        {  
            if (typeof (download_file.iframe) == "undefined")  
            {  
                var iframe = document.createElement("iframe");  
                download_file.iframe = iframe;  
                document.body.appendChild(download_file.iframe);  
            }  
            // alert(url);
            download_file.iframe.src = url;
            download_file.iframe.style.display = "none";  
        }  

        function download_file_content(fileName, content)
        {
        	var unicode= BASE64.decoder(content);//返回会解码后的unicode码数组。  
        	var str = '';  
        	for(var i = 0 , len =  unicode.length ; i < len ;++i){  
        	      str += String.fromCharCode(unicode[i]);  
        	}  
            var aLink = document.createElement('a');
            var blob = new Blob([str]);
            var evt = document.createEvent("HTMLEvents");
            evt.initEvent("click", false, false);
            aLink.download = fileName;
            aLink.href = URL.createObjectURL(blob);
            aLink.dispatchEvent(evt);
            
        }
        
</script>