<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

use App\Http\Controllers\DownloadController;

class QuestionsDownloadJob implements ShouldQueue{

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $downloadController;

	protected $fileName;
	protected $userId;
	protected $language;

	protected $generateQuestionsDownload;
	protected $isPdf;

	public function __construct($fileName, $userId, $language, $generateQuestionsDownload, $isPdf)
	{
		$this->downloadController = new DownloadController();
		$this->fileName = $fileName;
		$this->userId = $userId;
		$this->language = $language;
		$this->generateQuestionsDownload = $generateQuestionsDownload;
		$this->isPdf = $isPdf;
	}

	public function handle()
	{
		\Log::info('Download questions start');

		$this->downloadController->downloadQuestions(
			$this->fileName, 
			$this->userId,
			$this->language, 
			$this->generateQuestionsDownload, 
			$this->isPdf
		);
	}

}
