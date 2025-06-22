<?php

namespace App\Livewire\Ticket;

use App\Enums\Bucket;
use App\Livewire\Forms\TicketUpdateRequest;
use App\LocaleStorage\Fileupload;
use App\Models\Category;
use App\Models\Department;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Services\Ticket\TicketService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UpdateTicket extends Component {
    use WithFileUploads;

    /**
     * Define public form object TicketUpdateRequest $form
     */
    public TicketUpdateRequest $form;

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
    public $teamAgent = [];

    /**
     * Define public property $ticket
     */
    public $ticket;

    public $departments;

    public $subCategory;

    /**
     * Define public method mount() to load the resources
     */
    public function mount(): void {
        /**
         * Old value set to the input field
         */
        $this->ticket                    = Ticket::query()->with('user', 'source', 'image', 'owners', 'ticket_status')->where('id', $this->ticket->id)->first();
        $this->form->request_title       = $this->ticket?->title;
        $this->form->request_description = $this->ticket?->description;
        $this->form->requester_name      = $this->ticket->user->name;
        $this->form->requester_email     = $this->ticket->user->email;
        $this->form->requester_phone     = $this->ticket->user->phone;
        $this->form->requester_type_id   = $this->ticket->user->requester_type_id;
        $this->form->requester_id        = $this->ticket->user->requester_id;
        $this->form->priority            = $this->ticket->priority;
        $this->form->due_date            = $this->ticket->due_date ? date('Y-m-d', strtotime($this->ticket->due_date)) : '';
        $this->form->source_id           = $this->ticket->source_id;
        $this->form->team_id             = $this->ticket->team_id;
        $this->form->category_id         = $this->ticket->category_id;
        $this->form->ticket_status_id    = $this->ticket->ticket_status_id;
        $this->form->owner_id            = $this->ticket->owners->pluck('id')->toArray();
        $this->form->department_id       = $this->ticket->department_id;
        $this->form->sub_category_id     = $this->ticket->sub_category_id;

        /**
         * Select box dynamic value set.
         */
        $teams = Team::with('agents')->where('id', $this->ticket->team_id)->first();

        $this->requester_type = RequesterType::query()->get();
        $this->sources        = Source::query()->get();
        $this->teams          = Team::where('department_id', $this->ticket->department_id)->get();
        $this->categories     = Category::where('parent_id', null)->get();
        $this->ticket_status  = TicketStatus::query()->get();
        $this->teamAgent      = $teams->agents ?? [];
        $this->departments    = Department::where('status', true)->get();
        $this->subCategory    = Category::where('id', $this->ticket->sub_category_id)->get();
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
        $this->form->sub_category_id = null;
        $this->subCategory           = Category::where('parent_id', $this->form?->category_id)->get();

    }
    /**
     * Define public method update() to update the resources
     */
    public function update(TicketService $service) {
        // dd($this->form);
        $this->validate(rules: $this->form->rules(), attributes: $this->form->attributes());
        $isCreate = $service->update($this->ticket, $this->form);
        $isUpload = $this->form->request_attachment ? Fileupload::uploadFiles($this->form, Bucket::TICKET, $isCreate->getKey(), Ticket::class) : '';
        $response = $isCreate ? 'Data has been update successfully' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('dashboard/request-list');
    }

    public function requesterUpdate() {
        $this->validate([
            'form.request_title' => ['required'],
            'form.category_id'   => ['required'],
        ]);

        $this->ticket->update(
            [
                'category_id'     => $this->form->category_id,
                'sub_category_id' => $this->form->sub_category_id,
                'title'           => $this->form->request_title,
                'description'     => $this->form->request_description,
                'updated_by'      => Auth::id(),
            ]
        );
        $isUpload = $this->form->request_attachment ? Fileupload::uploadFile($this->form, Bucket::TICKET, $this->ticket->getKey(), Ticket::class) : '';

        TicketService::createTicketNote($this->ticket->getKey(), $this->ticket->ticket_status->name, $this->ticket->ticket_status->name, 'title_desc_updated', 'Update title or description!');

        TicketService::createTicketLog($this->ticket->getKey(), $this->ticket->ticket_status->name, 'title_desc_updated', json_encode($this->ticket));

        flash()->success('Data has been Save successfully');

        return redirect()->to('dashboard/request-list');
    }

    public function render() {
        if (Auth::user()->hasRole(['requester', 'Requester'])) {
            return view('livewire.ticket.update-requester');
        } else {
            return view('livewire.ticket.update-ticket');
        }

    }
}