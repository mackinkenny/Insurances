<?php

namespace App\Jobs;

use App\Exports\TestExport;
use App\Models\Company;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class SendReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * param $type - (type of report **daily ** weekly ** monthly)
     * param $id - id of company
     * @return void
     */
    public $type;
    public $id;
    public function __construct($type, $id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $user = \Auth::user();
        $company = Company::find($this->id);
        $from = $this->type == 1 ? Carbon::now()->subDay(1)->format('d M Y') : ($this->type == 2 ? Carbon::now()->subWeek(1)->format('d M Y') : Carbon::now()->subMonth(1)->format('d M Y'));
        $to = Carbon::now()->format('d M Y');
        if ($company->type == 1){
            $contracts = Contract::where('company_id', $company->id)->where('created_at', '>', $from)->get();
        }
        else
        {
            $contracts = Contract::where('upload_id', $company->id)->where('created_at', '>', $from)->get();
        }
        $path = public_path("storage/excel/".$company->title.'.xlsx');
        Excel::store(new TestExport($contracts, $company, $from, $to), 'public/excel/'.$company->title.'.xlsx');

        $data["email"] = Auth::user()->email;
        $data["title"] = "Message from POLIZZACERTA";
        $data["body"] = "New report from ".$from." to ".$to;
        Mail::send('mail.test_mail', $data, function($message)use($data, $path) {
            $message->to($data["email"])
                ->subject($data["title"]);

            $message->attach($path);
        });
    }
}
