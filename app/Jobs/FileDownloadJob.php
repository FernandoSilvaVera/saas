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

	public function __construct($fileName, $templateId, $userId)
	{
		$this->downloadController = new DownloadController();
		$this->fileName = $fileName;
		$this->templateId = $templateId;
		$this->userId = $userId;
	}

	public function handle()
	{
		\Log::info('Download Start ' . $this->fileName . " " . $this->templateId . " " . $this->userId);
		$this->downloadController->download($this->fileName, $this->templateId, $this->userId);
	}

}
