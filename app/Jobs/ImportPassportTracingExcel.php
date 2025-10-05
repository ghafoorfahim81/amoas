<?php

namespace App\Jobs;

use App\Models\Tracing\Passport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportPassportTracingExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $passportsArr;

    public $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($passportsArr, $request)
    {
        $this->passportsArr = $passportsArr;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // session(['totalCount' => count($passportsArr)]);
        // $this->impProgressTotalCount = count($passportsArr[0]);
        //Get the uids that already exist
        $alreadyExist = Passport::whereIn('uid', array_column($this->passportsArr, 'id'))->get();
        $alreadyExist = optional($alreadyExist)->pluck('uid')->toArray();

        foreach ($this->passportsArr as $passport) {
            if (! in_array($passport['id'], $alreadyExist)) {
                if ($passport['id'] != null) {
                    $pass = Passport::create([
                        'uid' => $passport['id'],
                        'family_name' => $passport['family_name'],
                        'given_name' => $passport['given_names'],
                        'passport_no' => $passport['passport_no'],
                        'department_id' => array_key_exists('department_id', $this->request) ? $this->request['department_id'] : null,
                        'status' => $passport['status'],
                        'date' => ! $passport['date'] ?: \Carbon\Carbon::createFromFormat('d-M-Y', $passport['date'])->format('Y-m-d'),
                    ]);

                    $pass->trace()->create([
                        'department_id' => array_key_exists('department_id', $this->request) ? $this->request['department_id'] : null,
                        'uid' => $passport['id'],
                        'status' => $passport['status'],
                        'is_public' => array_key_exists('is_public', $this->request) ? $this->request['is_public'] : null,
                        'note' => array_key_exists('note', $this->request) ? $this->request['note'] : null,
                        'registrar_id' => auth()->id(),
                        'applicant' => $passport['given_names'].' '.$passport['family_name'],
                    ]);
                }
            }
            // session(['progressCount' => session('progressCount', -1) + 1]);
        }
    }
}
