<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:expire-pending-transactions')->everyMinute();