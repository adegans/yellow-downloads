<?php
// Downloads extension, https://github.com/adegans/yellow-downloads

class YellowDownloads {
	const VERSION = "1.0.1";
	public $yellow; // access to API

	// Handle initialisation
	public function onLoad($yellow) {
		$this->yellow = $yellow;
		$this->yellow->language->setDefault("downloadLabel", "Download", "en");
		$this->yellow->language->setDefault("filetypeLabel", "Filetype", "en");
		$this->yellow->language->setDefault("sizeLabel", "Size", "en");
		$this->yellow->language->setDefault("uploadedLabel", "Uploaded", "en");
		$this->yellow->language->setDefault("errorLabel", "Error", "en");
		$this->yellow->language->setDefault("errornotfound", "File not found!", "en");
		$this->yellow->language->setDefault("errornofile", "No file name provided!", "en");
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
						$output .= $this->yellow->language->getTextHtml("downloadLabel").": <a href=\"/".$download_location.$filename."\" class=\"matomo_download\">".$download_item['basename']."</a><br />";
						$output .= "<small><strong>".$this->yellow->language->getTextHtml("filetypeLabel").":</strong> ".$download_item['extension']." / <strong>".$this->yellow->language->getTextHtml("sizeLabel").":</strong> ".$this->pretty_filesize($download_location.$filename)." / <strong>".$this->yellow->language->getTextHtml("uploadedLabel").":</strong> ".date("F d Y", filectime($download_location.$filename))."</small>";
						$output .= "</p>";
					} else {
						$output .= "<p>".$this->yellow->language->getTextHtml("errorLabel").": '".$filename."' ".$this->yellow->language->getTextHtml("errornotfound")."</p>";
					}
				}
			} else {
				$page_title = $page->getHtml("titleContent");
				$output .= "<p style=\"color:#F00;\">".$this->yellow->language->getTextHtml("errorLabel").": ".$this->yellow->language->getTextHtml("errornofile")."</p>";
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
