<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

use App\Http\Controllers\DownloadController;

class FileDownloadJob implements ShouldQueue{

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $downloadController;

	protected $fileName;
	protected $templateId;
	protected $userId;
	protected $language;

	protected $summaryOptionDownload;
	protected $generateQuestionsDownload;
	protected $generateConceptMapDownload;
	protected $useNaturalVoiceDownload;

	public function __construct($fileName, $templateId, $userId, $language, $summaryOptionDownload, $generateQuestionsDownload, $generateConceptMapDownload, $useNaturalVoiceDownload)
	{
		$this->downloadController = new DownloadController();
		$this->fileName = $fileName;
		$this->templateId = $templateId;
		$this->userId = $userId;
		$this->language = $language;
		$this->summaryOptionDownload = $summaryOptionDownload;
		$this->generateQuestionsDownload = $generateQuestionsDownload;
		$this->generateConceptMapDownload = $generateConceptMapDownload;
		$this->useNaturalVoiceDownload = $useNaturalVoiceDownload;
	}

	public function handle()
	{
		\Log::info('Download Start ' . $this->fileName . " " . $this->templateId . " " . $this->userId . " " . $this->language);
		$this->downloadController->download(
			$this->fileName, 
			$this->templateId, 
			$this->userId,
			$this->language, 
			$this->summaryOptionDownload, 
			$this->generateQuestionsDownload, 
			$this->generateConceptMapDownload, 
			$this->useNaturalVoiceDownload
		);
	}

}
