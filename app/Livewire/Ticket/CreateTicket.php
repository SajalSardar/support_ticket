<?php

namespace App\Livewire\Ticket;

use App\Enums\Bucket;
use App\Livewire\Forms\TicketCreateRequest;
use App\LocaleStorage\Fileupload;
use App\Mail\TicketEmail;
use App\Models\Category;
use App\Models\Department;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\TicketStatus;
use App\Services\Ticket\TicketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateTicket extends Component {
    use WithFileUploads;

    /**
     * Define public form object TicketCreateRequest $form
     */
    public TicketCreateRequest $form;

    /**
     * Define public property $requester_type;
     * @var array|object
     */
    public $requester_type;

    /**
     * Define public property $sources;
     * @var array|object
     */
    public $sources;

    /**
     * Define public property $categories;
     * @var array|object
     */
    public $categories;

    /**
     * Define public property $teams;
     * @var array|object
     */
    public $teams;

    /**
     * Define public property $ticket_status;
     * @var array|object
     */
    public $ticket_status;

    /**
     * Define public property $agents;
     * @var array|object
     */
    public $teamAgent;

    public $departments;

    public $subCategory;

    /**
     * Define public method mount() to load the resources
     */
    public function mount(): void {
        $this->requester_type = RequesterType::query()->get();
        $this->sources        = Source::query()->get();
        $this->teams          = [];
        $this->categories     = Category::where('parent_id', null)->get();
        $this->ticket_status  = TicketStatus::query()->get();
        $this->teamAgent      = [];
        $this->departments    = Department::where('status', true)->get();
        $this->subCategory    = [];
    }

    /**
     * Define public method selectTeamAgent() to select category and agent with the
     * change of Team.
     * @return void
     */
    public function selectTeamAgent(): void {
        $teams = Team::query()->with('agents')->where('id', $this->form?->team_id)->first();

        $this->teamAgent = $teams->agents;
    }
    public function selectDepartemntTeam(): void {
        $this->teams = Team::where('department_id', $this->form?->department_id)->get();
    }

    public function selectChildeCategory(): void {

        $this->subCategory = Category::where('parent_id', $this->form?->category_id)->get();
    }

    /**
     * Define public method save() to store the resources
     * @param TicketService $service
     * @return void
     */
    public function save(TicketService $service) {
        $this->validate(rules: $this->form->rules(), attributes: $this->form->attributes());
        $isCreate = $service->store($this->form);
        $isUpload = $this->form->request_attachment ? Fileupload::uploadFiles($this->form, Bucket::TICKET, $isCreate->getKey(), Ticket::class) : '';
        $response = $isCreate ? 'Data has been Save successfully' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('dashboard/request-list');
    }

    public function requesterSave() {
        $this->validate([
            'form.request_title' => ['required'],
            'form.category_id'   => ['required'],
        ]);
        $status   = TicketStatus::where('slug', 'open')->first();
        $response = Ticket::create(
            [
                'user_id'          => Auth::id(),
                'category_id'      => $this->form->category_id,
                'sub_category_id'  => $this->form->sub_category_id,
                'ticket_status_id' => $status->id,
                'source_id'        => 1,
                'title'            => $this->form->request_title,
                'description'      => $this->form->request_description,
                'priority'         => 'low',
                'ticket_type'      => 'customer',
                'created_by'       => Auth::id(),
            ]
        );
        $isUpload = $this->form->request_attachment ? Fileupload::uploadFile($this->form, Bucket::TICKET, $response->getKey(), Ticket::class) : '';

        $ticket_notes = TicketNote::create([
            'ticket_id'  => $response->getKey(),
            'note_type'  => 'initiated',
            'note'       => $this->form->request_description,
            'new_status' => 'open',
            'created_by' => Auth::user()->id,
        ]);

        $ticket_logs = TicketLog::create([
            'ticket_id'     => $response->getKey(),
            'ticket_status' => 'open',
            'comment'       => json_encode($response),
            'status'        => 'create',
            'created_by'    => Auth::user()->id,
            'updated_by'    => Auth::user()->id,
        ]);

        Mail::to(Auth::user()->email)->queue(new TicketEmail($response));

        flash()->success('Data has been Save successfully');

        return redirect()->to('dashboard/request-list');
    }

    public function render() {
        if (Auth::user()->hasRole(['requester', 'Requester'])) {
            return view('livewire.ticket.create-requester');
        } else {
            return view('livewire.ticket.create-ticket');
        }
    }
}
