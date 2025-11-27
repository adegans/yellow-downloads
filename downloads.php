<?php
/*
 Downloads extension

 Files are expected to be in the downloads folder of Yellow (default: media/downloads/)
 You can specify a subfolder by adding it to the filename.
 Usage: [download filename.zip]
 		[download filename.zip another.zip] (As many as you need)
 		[download routes/filename.gpx] (for a subfolder, ex: media/downloads/routes/)
*/

class YellowDownloads {
    const VERSION = "1.0";
    public $yellow; // access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    
    // Handle page content element
    public function onParseContentElement($page, $name, $text, $attributes, $type) {
        $output = null;
        if ($name=="download" && ($type=="block" || $type=="inline")) {

			$output = "";
			$download_location = $this->yellow->lookup->findMediaDirectory("CoreDownloadLocation");			
            $downloads = array_filter($this->yellow->toolbox->getTextArguments($text));

            if(!empty($downloads)) {				
				foreach($downloads as $key => $filename) {
					if(!is_dir($download_location.$filename) AND file_exists($download_location.$filename)) {
						$download_item = pathinfo($download_location.$filename);

						$output .= "<p class=\"download-item ".htmlspecialchars($name)."\">";
						$output .= "Download: <a href=\"/".$download_location.$filename."\" class=\"matomo_download\">".$download_item['basename']."</a><br />";
						$output .= "<small><strong>File:</strong> ".$download_item['extension']." file / <strong>Size:</strong> ".$this->pretty_filesize($download_location.$filename)." / <strong>Uploaded:</strong> ".date("F d Y", filectime($download_location.$filename))."</small>";
						$output .= "</p>";
					} else {
						$output .= "<p>File error: '".$filename."' not found!</p>";
					}
				}
            } else {
	            $page_title = $page->getHtml("titleContent");
                $output .= "<p style=\"color:#F00;\">Syntax error: No file name provided!</p>";
            }
        }
        return $output;
    }
    
    private function pretty_filesize($file) {
		$filesize = filesize($file);
		if($filesize < 1024) { 
			$filesize = $filesize." Bytes"; 
		} elseif(($filesize < 1048576) && ($filesize > 1023)) {
			$filesize=round($filesize / 1024, 1)." KB";
		} elseif(($filesize < 1073741824) && ($filesize > 1048575)) {
			$filesize=round($filesize / 1048576, 1)." MB";
		} else {
			$filesize=round($filesize / 1073741824, 1)." GB";
		}
	
		return $filesize;
	}

}
?>