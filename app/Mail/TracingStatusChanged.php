<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TracingStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $doc;

    public $lang;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($doc, $lang)
    {
        $this->doc = $doc;
        $this->lang = $lang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $docDep = null;

        if ($this->lang == 'dr') {
            $docDep = optional($this->doc->department)->name_dr;
        } elseif ($this->lang == 'ps') {
            $docDep = optional($this->doc->department)->name_pa;
        } else {
            $docDep = optional($this->doc->department)->name_en;
        }

        $this->subject(__('emails.adots', [], $this->lang).': '.__('emails.tracing_status_changed', [], $this->lang));

        $template = 'emails.tracing-doc-status-changed-ltr';

        if ($this->lang == 'dr' || $this->lang == 'ps' || $this->lang == 'ar') {
            $template = 'emails.tracing-doc-status-changed-rtl';
        }

        return $this->view($template, compact('docDep'));
    }
}
