<?php

namespace App\Enums;

enum ImporterStatuses: string
{
    case QUEUED = 'queued';
    case RUNNING = 'running';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
